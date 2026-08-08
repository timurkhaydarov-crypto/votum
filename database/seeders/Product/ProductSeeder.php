<?php

namespace Database\Seeders\Product;

use App\Models\Product\Brand;
use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Product\Group;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brandIds = Brand::query()->orderBy('id')->pluck('id')->values();

        $products = [
            [
                'article' => 'VTM-5000-ORBITA',
                'name' => ['ru' => 'РОБОСКОП ВТМ-5000/ОРБИТА', 'en' => 'ROBOSCOP VTM-5000/ORBITA'],
                'category_ru' => 'Промышленные установки неразрушающего контроля',
                'group_ru' => 'Промышленные установки',
                'short_description' => [
                    'ru' => 'Роботизированная установка для автоматизированного контроля протяженных сварных соединений.',
                    'en' => 'Robotic system for automated inspection of long welded joints.',
                ],
                'full_description' => [
                    'ru' => 'Комплекс выполняет точное сканирование крупных объектов, поддерживает серийный контроль и снижает влияние человеческого фактора.',
                    'en' => 'The system performs precise scanning of large objects, supports serial inspection, and reduces human-factor impact.',
                ],
                'note' => [
                    'ru' => 'Подходит для круглосуточной работы на производственных линиях.',
                    'en' => 'Suitable for continuous operation on production lines.',
                ],
                'unit' => 'pcs',
                'price' => 0,
                'quantity' => 10,
                'status' => true,
                'image_url' => 'roboscop-vtm-5000-orbita.jpg',
                'video_url' => 'roboscop-vtm-5000-orbita.mp4',
            ],
            [
                'article' => 'CHAMELEON-32-64',
                'name' => ['ru' => 'ХАМЕЛЕОН 32+ (32/64)', 'en' => 'CHAMELEON 32+ (32/64)'],
                'category_ru' => 'Дефектоскопы',
                'group_ru' => 'Дефектоскопы',
                'short_description' => [
                    'ru' => 'Многоканальный дефектоскоп для оперативной проверки сварных швов и металлических деталей.',
                    'en' => 'Multichannel flaw detector for fast inspection of welds and metal parts.',
                ],
                'full_description' => [
                    'ru' => 'Прибор поддерживает гибкие схемы подключения преобразователей и обеспечивает стабильные результаты в сложных производственных условиях.',
                    'en' => 'The device supports flexible probe connection schemes and delivers stable results in demanding production environments.',
                ],
                'note' => [
                    'ru' => 'Оптимален для мобильных бригад технического контроля.',
                    'en' => 'Well suited for mobile technical inspection teams.',
                ],
                'unit' => 'pcs',
                'price' => 0,
                'quantity' => 10,
                'status' => true,
                'image_url' => 'chameleon-32-64.jpg',
                'video_url' => 'chameleon-32-64.mp4',
            ],
            [
                'article' => 'TANDEM',
                'name' => ['ru' => 'ТАНДЕМ', 'en' => 'TANDEM'],
                'category_ru' => 'Сканирующие устройства',
                'group_ru' => 'Сканирующие устройства',
                'short_description' => [
                    'ru' => 'Сканирующая система для синхронного перемещения нескольких датчиков по поверхности.',
                    'en' => 'Scanning system for synchronized movement of multiple probes across surfaces.',
                ],
                'full_description' => [
                    'ru' => 'Устройство повышает повторяемость контроля, ускоряет обследование объектов и упрощает работу оператора на крупных участках.',
                    'en' => 'The device improves repeatability, accelerates inspections, and simplifies operator work on large areas.',
                ],
                'note' => [
                    'ru' => 'Совместимо с различными типами держателей преобразователей.',
                    'en' => 'Compatible with multiple transducer holder types.',
                ],
                'unit' => 'pcs',
                'price' => 0,
                'quantity' => 10,
                'status' => true,
                'image_url' => 'tandem.jpg',
                'video_url' => 'tandem.mp4',
            ],
            [
                'article' => 'PADI-8-SU',
                'name' => ['ru' => 'ПАДИ-8 СУ', 'en' => 'PADI-8 SU'],
                'category_ru' => 'Преобразователи',
                'group_ru' => 'Импедансные',
                'short_description' => [
                    'ru' => 'Ультразвуковой преобразователь для надежной передачи импульсов в контролируемый материал.',
                    'en' => 'Ultrasonic transducer for reliable pulse transmission into inspected materials.',
                ],
                'full_description' => [
                    'ru' => 'Преобразователь обеспечивает высокую чувствительность, устойчивую работу и качественный прием отраженных сигналов при диагностике.',
                    'en' => 'The transducer provides high sensitivity, stable operation, and quality reflected-signal reception during diagnostics.',
                ],
                'note' => [
                    'ru' => 'Подходит для серийного контроля и лабораторных задач.',
                    'en' => 'Suitable for serial inspections and laboratory tasks.',
                ],
                'unit' => 'pcs',
                'price' => 0,
                'quantity' => 10,
                'status' => true,
                'image_url' => 'padi-8-su.jpg',
                'video_url' => 'padi-8-su.mp4',
            ],
            [
                'article' => 'OH-3',
                'name' => ['ru' => 'OH-3', 'en' => 'ON-3'],
                'category_ru' => 'Меры дефектов и настроечные образцы',
                'group_ru' => 'Ультразвуковые',
                'short_description' => [
                    'ru' => 'Калибровочный образец для настройки оборудования и проверки чувствительности контроля.',
                    'en' => 'Calibration block for equipment setup and inspection sensitivity verification.',
                ],
                'full_description' => [
                    'ru' => 'Образец помогает стандартизировать измерения, подтверждать точность результатов и контролировать стабильность настроек оборудования.',
                    'en' => 'The block helps standardize measurements, validate result accuracy, and control setup stability.',
                ],
                'note' => [
                    'ru' => 'Рекомендуется для периодической метрологической проверки.',
                    'en' => 'Recommended for periodic metrological verification.',
                ],
                'unit' => 'pcs',
                'price' => 0,
                'quantity' => 10,
                'status' => true,
                'image_url' => 'oh-3.jpg',
                'video_url' => 'oh-3.mp4',
            ],
        ];

        foreach ($products as $index => $item) {
            $categoryId = Category::query()
                ->where('category->ru', $item['category_ru'])
                ->value('id');
            $groupId = Group::query()
                ->where('group->ru', $item['group_ru'])
                ->value('id');    

            $brandId = $brandIds->get($index) ?? $brandIds->first() ?? 1;
            

            Product::query()->create([
                'article' => $item['article'],
                'name' => $item['name'],
                'short_description' => $item['short_description'],
                'full_description' => $item['full_description'],
                'category_id' => $categoryId ?? 1,
                'group_id' => $groupId ?? null,
                'brand_id' => $brandId,
                'unit' => $item['unit'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'status' => $item['status'],
                'note' => $item['note'],
                'image_url' => $item['image_url'],
                'video_url' => $item['video_url'],
            ]);
        }
    }
}
