<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
     //   DB::table('categories')->truncate();

        $categories = [
            [
                'name' => 'Medical',
                'keywords' => null,
                'children' => [
                    [
                        'name' => 'Prescriptions',
                        'keywords' => 'prescription,prescribe,medication,medicine,drug,dose,dosage',
                        'children' => [
                            [
                                'name' => 'Chronic Medications',
                                'keywords' => 'chronic,long-term,maintenance,ongoing',
                                'children' => [
                                    [
                                        'name' => 'Diabetes Prescription',
                                        'keywords' => 'diabetes,insulin,glucose,metformin,glipizide,glyburide,januvia,jardiance'
                                    ],
                                    [
                                        'name' => 'Hypertension Prescription',
                                        'keywords' => 'hypertension,blood pressure,lisinopril,amlodipine,losartan,hydrochlorothiazide,beta blocker'
                                    ],
                                ]
                            ],
                            [
                                'name' => 'Acute Medications',
                                'keywords' => 'acute,short-term,temporary,immediate',
                                'children' => [
                                    [
                                        'name' => 'Infection Prescription',
                                        'keywords' => 'infection,antibiotic,amoxicillin,azithromycin,ciprofloxacin,penicillin,cephalexin'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        'name' => 'Medical Reports',
                        'keywords' => 'report,assessment,evaluation,findings,results',
                        'children' => [
                            [
                                'name' => 'Diagnostic Reports',
                                'keywords' => 'diagnosis,diagnostic,assessment,evaluation',
                                'children' => [
                                    [
                                        'name' => 'Hypertension Diagnosis',
                                        'keywords' => 'hypertension diagnosis,high blood pressure diagnosis,elevated blood pressure'
                                    ],
                                    [
                                        'name' => 'Chest Infection Diagnosis',
                                        'keywords' => 'chest infection,pneumonia,bronchitis,respiratory infection,lung infection'
                                    ]
                                ]
                            ],
                            [
                                'name' => 'Follow-Up Reports',
                                'keywords' => 'follow-up,follow up,subsequent,review',
                                'children' => [
                                    [
                                        'name' => 'Chronic Condition Follow-Up',
                                        'keywords' => 'chronic follow-up,long-term condition,ongoing care,maintenance visit'
                                    ]
                                ]
                            ],
                            [
                                'name' => 'Discharge Reports',
                                'keywords' => 'discharge,release,hospital discharge',
                                'children' => [
                                    [
                                        'name' => 'Hospital Discharge Summary',
                                        'keywords' => 'discharge summary,hospital release,inpatient discharge'
                                    ]
                                ]
                            ]
                        ]
                    ],
                    [
                        'name' => 'Lab Tests',
                        'keywords' => 'laboratory,lab,test,analysis,specimen,sample',
                        'children' => [
                            [
                                'name' => 'Blood Test',
                                'keywords' => 'blood test,blood sample,blood analysis,hematology',
                                'children' => [
                                    [
                                        'name' => 'CBC – Complete Blood Count',
                                        'keywords' => 'CBC,complete blood count,hemoglobin,hematocrit,white blood cell,red blood cell'
                                    ]
                                ]
                            ],
                            [
                                'name' => 'Glucose Test',
                                'keywords' => 'glucose,blood sugar,diabetes test',
                                'children' => [
                                    [
                                        'name' => 'HbA1c Analysis',
                                        'keywords' => 'HbA1c,A1c,glycated hemoglobin,glycosylated hemoglobin'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->insertCategories($categories);
    }

    private function insertCategories(array $categories, ?int $parentId = null): void
    {
        foreach ($categories as $cat) {
            $category = Category::create([
                'name' => $cat['name'],
                'parent_id' => $parentId,
                'keywords' => $cat['keywords'] ?? null,
            ]);

            if (isset($cat['children'])) {
                $this->insertCategories($cat['children'], $category->id);
            }
        }
    }
}
