<?php

namespace Database\Seeders\Product;

use App\Models\Product\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'category' => [
                    'ru' => 'Промышленные установки неразрушающего контроля',
                    'en' => 'Industrial non-destructive testing systems',
                ],
                'slug' => 'industrial-ndt',
                'description' => [
                    'ru' => 'Стационарные комплексы для автоматизированного контроля качества сварных швов и металлических конструкций.',
                    'en' => 'Stationary systems for automated inspection of weld quality and metal structure integrity.',
                ],
                'image_url' => 'industrial_category',
            ],
            [
                'category' => [
                    'ru' => 'Дефектоскопы',
                    'en' => 'Defectoscopes',
                ],
                'slug' => 'flaw-detectors',
                'description' => [
                    'ru' => 'Портативные приборы для точного обнаружения трещин, пустот и внутренних дефектов материалов.',
                    'en' => 'Portable instruments for accurate detection of cracks, voids, and internal material defects.',
                ],
                'image_url' => 'defectoscopes_category',
            ],
            [
                'category' => [
                    'ru' => 'Сканирующие устройства',
                    'en' => 'Scanning devices',
                ],
                'slug' => 'scanning-devices',
                'description' => [
                    'ru' => 'Устройства механизированного сканирования для равномерного перемещения датчиков по контролируемой поверхности.',
                    'en' => 'Mechanized scanners ensuring uniform probe movement across the inspected surface area.',
                ],
                'image_url' => 'scanning_devices_category',
            ],
            [
                'category' => [
                    'ru' => 'Преобразователи',
                    'en' => 'Transducers',
                ],
                'slug' => 'transducers',
                'description' => [
                    'ru' => 'Высокочувствительные датчики для передачи и приема ультразвуковых сигналов в разных диапазонах частот.',
                    'en' => 'High-sensitivity probes for transmitting and receiving ultrasonic signals across frequency ranges.',
                ],
                'image_url' => 'transducers_category',
            ],
            [
                'category' => [
                    'ru' => 'Меры дефектов и настроечные образцы',
                    'en' => 'Defect standards and calibration blocks',
                ],
                'slug' => 'reference-standards',
                'description' => [
                    'ru' => 'Эталонные образцы для калибровки оборудования, проверки чувствительности и подтверждения стабильности измерений.',
                    'en' => 'Reference samples for calibration, sensitivity verification, and stable measurement confirmation procedures.',
                ],
                'image_url' => 'defect_standards_category',
            ],
        ];

        foreach ($categories as $item) {
            Category::query()->create([
                'category' => $item['category'],
                'description' => $item['description'],
                'image_url' => $item['image_url'],
            ]);
        }
    }
}
