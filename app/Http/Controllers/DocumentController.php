<?php

namespace App\Http\Controllers;
use League\Flysystem\FilesystemException;
use PhpOffice\PhpWord\IOFactory;
use Smalot\PdfParser\Parser as PdfParser;
use PhpOffice\PhpWord\IOFactory as WordReader;
use App\Models\Document;
use App\Jobs\ProcessDocumentJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Smalot\PdfParser\Parser;

class DocumentController extends Controller
{
    /**
     * Display a listing of the documents.
     */
   public function index()
{
    // بدء توقيت التنفيذ
    $startTime = microtime(true);

    // ترتيب المستندات حسب العنوان تصاعديًا
    $documents = Document::orderBy('title', 'asc')->paginate(30);

    // حساب الزمن المستغرق
    $timeTaken = microtime(true) - $startTime;
    $totalSize = Document::sum('file_size');


    // إرسال النتائج للواجهة
    return view('documents.index', compact('documents', 'timeTaken','totalSize'));
}


    
    public function create()
    {
        return view('documents.create');
    }
private function extractTitleFromContent($file, $extension)
{
    if ($extension === 'pdf') {
        try {
            $parser = new PdfParser();
            $pdf = $parser->parseFile($file->getPathname());
            $text = $pdf->getText();
            $lines = explode("\n", trim($text));
            return $lines[0] ?? 'Untitled PDF';
        } catch (\Exception $e) {
            return 'Untitled PDF';
        }
    }

    if ($extension === 'docx') {
        try {
            $phpWord = WordReader::load($file->getPathname(), 'Word2007');
            foreach ($phpWord->getSections() as $section) {
                foreach ($section->getElements() as $element) {
                    if (method_exists($element, 'getText')) {
                        $text = trim($element->getText());
                        if (!empty($text)) {
                            return $text;
                        }
                    }
                }
            }
            return 'Untitled Word';
        } catch (\Exception $e) {
            return 'Untitled Word';
        }
    }

    return 'Untitled';
}
    /**
     * Store a newly created document in storage.
     */
  public function store(Request $request)
{
    $start = microtime(true);
    // 1. التحقق من صحة الملف (مطلوب - حجمه لا يتجاوز 10MB)
    $request->validate([
    'document' => 'required|file|mimes:pdf,docx|max:10240',
    ], [
    'document.mimes' => 'Invalid document format!',
    ]);

    // 2. التقاط الملف ومعلوماته الأصلية
    $file = $request->file('document');
    $originalFilename = $file->getClientOriginalName();
    $fileSize = $file->getSize();
    $extension = $file->getClientOriginalExtension();

    // 3. توليد اسم فريد للملف (UUID) بدون إضافة مجلد 'documents' يدويًا
    $uniqueFilename = Str::uuid() . '.' . $extension;
    $localPath = $uniqueFilename; // سيتم تخزينه داخل مجلد 'documents' تلقائيًا عبر disk

    // 4. تخزين الملف فعليًا في storage/app/public/documents
    Storage::disk('dropbox')->put('documents/' . $uniqueFilename, file_get_contents($file));

    // 5. استخراج عنوان المستند من المحتوى
    $title = $this->extractTitleFromContent($file, $extension);


    // 6. إنشاء سجل في قاعدة البيانات
    $document = Document::create([
        'title' => $title,
        'original_filename' => $originalFilename,
        'file_path' => $localPath, // بدون تكرار 'documents/'
        'file_type' => $extension,
        'file_size' => $fileSize,
        'category_id' => $request->input('category_id'), // قد يتم تحديثها لاحقًا من Job
    ]);

    // 7. إرسال الملف للمعالجة في الخلفية عبر الـ Job
    ProcessDocumentJob::dispatch($document);
     $end = microtime(true);
      $duration = number_format($end - $start, 3); // الزمن المستغرق بالثواني
    // 8. إرجاع رسالة نجاح للمستخدم
 return redirect()->route('documents.create')->with([
        'success' => 'Document uploaded successfully.',
        'duration' => "Upload, classification and saving took {$duration} seconds.",
    ]);}




  


public function search(Request $request)
{
    $query = strtolower(trim($request->input('query')));
    $startTime = microtime(true);
    $results = [];

    if ($query) {
        $files = Storage::disk('dropbox')->allFiles('/');

        foreach ($files as $filePath) {
            $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $content = '';

            try {
                // تحميل الملف المؤقت من Dropbox
                $rawContent = Storage::disk('dropbox')->get($filePath);
                $tempPath = storage_path('app/temp_file.' . $extension);
                file_put_contents($tempPath, $rawContent);

                // استخراج اول سطر للعنوان
                $file = new \Symfony\Component\HttpFoundation\File\File($tempPath);
                $title = $this->extractTitleFromContent($file, $extension);


                if ($extension === 'docx') {
                    // تحليل ملف Word
                    $phpWord = IOFactory::load($tempPath);
                    foreach ($phpWord->getSections() as $section) {
                        foreach ($section->getElements() as $element) {
                            if (method_exists($element, 'getText')) {
                                $content .= $element->getText() . ' ';
                            }
                        }
                    }
                   

                } elseif ($extension === 'pdf') {
                    // تحليل ملف PDF
                    $parser = new Parser();
                    $pdf = $parser->parseFile($tempPath);
                    $content = $pdf->getText();
                    
                }


                unlink($tempPath); // حذف الملف المؤقت

                // عملية البحث داخل المحتوى
                $content = strtolower(strip_tags($content));
                $position = stripos($content, $query);
                if ($position !== false) {
                    $contextRadius = 50;
                    $start = max(0, $position - $contextRadius);
                    $length = strlen($query) + 2 * $contextRadius;
                    $snippet = substr($content, $start, $length);

                    $highlighted = str_ireplace($query, '<mark style="background-color:yellow">' . e($query) . '</mark>', e($snippet));

                    $results[] = (object) [
    'title' => $title, 
    // اسم الملف فقط
    'highlighted_content' => $highlighted,
];
                }

            } catch (\Exception $e) {
                \Log::error("Error reading $filePath: " . $e->getMessage());
            }
        }
    }

    $timeTaken = microtime(true) - $startTime;

    return view('documents.search', [
        'documents' => collect($results),
        'query' => $query,
        'timeTaken' => $timeTaken,
    ]);
}
public function searchView()
{
    return view('documents.search', [
        'documents' => collect(), // قائمة فاضية بالبداية
        'query' => '',
        'timeTaken' => 0
    ]);
}


    
}
