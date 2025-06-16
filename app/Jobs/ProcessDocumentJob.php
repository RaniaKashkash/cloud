<?php

namespace App\Jobs;

use App\Models\Document;
use App\Models\Category;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory as WordReader;
use Str;

class ProcessDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function handle(): void
    {
        try {
            $extension = pathinfo($this->document->file_path, PATHINFO_EXTENSION);
            $tempPath = storage_path('app/' . Str::uuid() . '.' . $extension); // ملف مؤقت فريد

            // 🟡 تحميل الملف من Dropbox
            $dropboxPath = 'documents/' . $this->document->file_path;
            if (!Storage::disk('dropbox')->exists($dropboxPath)) {
                Log::error("⚠️ الملف غير موجود في Dropbox: " . $dropboxPath);
                return;
            }

            $raw = Storage::disk('dropbox')->get($dropboxPath);
            file_put_contents($tempPath, $raw);

            $text = '';

            if ($extension === 'pdf') {
                $parser = new PdfParser();
                $pdf = $parser->parseFile($tempPath);
                $text = $pdf->getText();
            } elseif ($extension === 'docx') {
                $phpWord = WordReader::load($tempPath, 'Word2007');
                foreach ($phpWord->getSections() as $section) {
                    foreach ($section->getElements() as $element) {
                        if (method_exists($element, 'getText')) {
                            $text .= ' ' . $element->getText();
                        }
                    }
                }
            } else {
                Log::warning("📂 نوع الملف غير مدعوم: .$extension");
                return;
            }

            // 🧹 تنظيف النص
            $text = strtolower($text);
            $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);

            // 🧾 معاينة أول 200 حرف
            Log::info('🧾 Extracted text (first 200 chars): ' . substr($text, 0, 200));

            // 🧠 تصنيف المستند
            $category = $this->matchCategory($text);

            // 📝 تحديث السجل
            $this->document->update([
                'category_id' => optional($category)->id,
                'content_preview' => $text,
            ]);

            if ($category) {
                Log::info('🎯 Matched category: ' . $category->name);
            } else {
                Log::warning('❌ No matching category found for document ID ' . $this->document->id);
            }

        } catch (\Exception $e) {
            Log::error('🚨 Document processing failed', [
                'document_id' => $this->document->id,
                'error' => $e->getMessage()
            ]);
        } finally {
            // 🧹 حذف الملف المؤقت لو تم إنشاؤه
            if (isset($tempPath) && file_exists($tempPath)) {
                unlink($tempPath);
            }
        }
    }

    private function matchCategory(string $text): ?Category
    {
        $categories = Category::withTrashed()->get();
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);

        $bestMatch = null;
        $maxMatches = 0;

        foreach ($categories as $category) {
            $keywords = explode(',', strtolower($category->keywords ?? ''));
            $matches = 0;

            foreach ($keywords as $keyword) {
                $cleanKeyword = trim($keyword);
                if (!empty($cleanKeyword) && str_contains($text, $cleanKeyword)) {
                    $matches++;
                }
            }

            if ($matches > $maxMatches) {
                $maxMatches = $matches;
                $bestMatch = $category;
            }
        }

        return $bestMatch;
    }
}
