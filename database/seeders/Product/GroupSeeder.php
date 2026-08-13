<?php

namespace Database\Seeders\Product;

use App\Models\Product\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'group' => [
                    'ru' => 'Ультразвуковые',
                    'en' => 'Ultrasonic',
                ],
                'slug' => 'ultrasonic',
                'description' => [
                    'ru' => 'Методы неразрушающего контроля, основанные на распространении ультразвуковых волн в материале. Применяются для обнаружения внутренних дефектов, измерения толщины и оценки качества сварных соединений.',
                    'en' => 'Non-destructive testing methods based on the propagation of ultrasonic waves through a material. Used for detecting internal defects, measuring thickness, and evaluating weld quality.',
                ],
                'image_url' => null,
            ],
            [
                'group' => [
                    'ru' => 'ЭМА',
                    'en' => 'EMA',
                ],
                'slug' => 'ema',
                'description' => [
                    'ru' => 'Электромагнитно-акустический контроль использует электромагнитное возбуждение ультразвуковых волн без применения контактной жидкости. Подходит для контроля горячих, окрашенных и шероховатых поверхностей.',
                    'en' => 'Electromagnetic Acoustic Testing (EMAT) generates ultrasonic waves electromagnetically without requiring a couplant. Suitable for inspecting hot, coated, or rough surfaces.',
                ],
                'image_url' => null,
            ],
            [
                'group' => [
                    'ru' => 'Вихретоковые',
                    'en' => 'Eddy current',
                ],
                'slug' => 'eddy-current',
                'description' => [
                    'ru' => 'Метод контроля, основанный на анализе вихревых токов, индуцируемых в проводящих материалах. Используется для выявления поверхностных и приповерхностных дефектов, измерения толщины покрытий и сортировки материалов.',
                    'en' => 'A testing method based on the analysis of eddy currents induced in conductive materials. Used for detecting surface and near-surface defects, measuring coating thickness, and material sorting.',
                ],
                'image_url' => null,
            ],
            [
                'group' => [
                    'ru' => 'Резонансные',
                    'en' => 'Resonant',
                ],
                'slug' => 'resonant',
                'description' => [
                    'ru' => 'Методы контроля, основанные на анализе резонансных частот объекта. Применяются для определения толщины изделий, оценки структуры материала и выявления внутренних дефектов.',
                    'en' => 'Testing methods based on analyzing the resonant frequencies of an object. Used for thickness measurement, material characterization, and detection of internal defects.',
                ],
                'image_url' => null,
            ],
            [
                'group' => [
                    'ru' => 'Импедансные',
                    'en' => 'Impedance',
                ],
                'slug' => 'impedance',
                'description' => [
                    'ru' => 'Методы контроля, использующие изменение механического или электрического импеданса для обнаружения дефектов, нарушения сцепления и оценки состояния конструкций.',
                    'en' => 'Testing methods that utilize changes in mechanical or electrical impedance to detect defects, bond failures, and assess structural integrity.',
                ],
                'image_url' => null,
            ],
            [
                'group' => [
                    'ru' => 'Ударные',
                    'en' => 'Impact',
                ],
                'slug' => 'impact',
                'description' => [
                    'ru' => 'Методы, основанные на возбуждении механического удара и анализе отклика материала. Используются для поиска пустот, расслоений, оценки прочности и целостности конструкций.',
                    'en' => 'Methods based on applying a mechanical impact and analyzing the material response. Used to detect voids, delaminations, and evaluate structural integrity.',
                ],
                'image_url' => null,
            ],
            [
                'group' => [
                    'ru' => 'Специализированные ЖД',
                    'en' => 'Specialized Rail',
                ],
                'slug' => 'specialized-railroad',
                'description' => [
                    'ru' => 'Специализированные системы контроля железнодорожной инфраструктуры, предназначенные для диагностики рельсов, сварных стыков и элементов пути с целью своевременного выявления дефектов.',
                    'en' => 'Specialized inspection systems for railway infrastructure designed to examine rails, welds, and track components for early defect detection.',
                ],
                'image_url' => null,
            ],
            [
                'group' => [
                    'ru' => 'На фазированных решетках',
                    'en' => 'Phased Array',
                ],
                'slug' => 'phased-array',
                'description' => [
                    'ru' => 'Современный ультразвуковой метод, использующий многоэлементные преобразователи с электронным управлением лучом. Обеспечивает высокую скорость контроля и детальное изображение внутренних дефектов.',
                    'en' => 'An advanced ultrasonic testing technique using multi-element probes with electronically controlled beam steering. Provides fast inspections and detailed imaging of internal defects.',
                ],
                'image_url' => null,
            ],
            [
                'group' => [
                    'ru' => 'Иммерсионные',
                    'en' => 'Immersion',
                ],
                'slug' => 'immersion',
                'description' => [
                    'ru' => 'Методы ультразвукового контроля, при которых объект и преобразователь разделены слоем жидкости. Обеспечивают высокую точность и стабильность измерений сложных изделий.',
                    'en' => 'Ultrasonic testing methods where the probe and the test object are separated by a liquid couplant. Provide high accuracy and repeatability for complex components.',
                ],
                'image_url' => null,
            ],
            [
                'group' => [
                    'ru' => 'Электроемкостные',
                    'en' => 'Capacitive',
                ],
                'slug' => 'electric-capacity',
                'description' => [
                    'ru' => 'Методы контроля, основанные на измерении изменений электрической емкости. Используются для бесконтактного контроля диэлектрических материалов, толщины и положения объектов.',
                    'en' => 'Testing methods based on measuring changes in electrical capacitance. Used for non-contact inspection of dielectric materials, thickness measurement, and position sensing.',
                ],
                'image_url' => null,
            ],
            [
                'group' => [
                    'ru' => 'Акустические',
                    'en' => 'Acoustic',
                ],
                'slug' => 'acoustic',
                'description' => [
                    'ru' => 'Методы контроля, основанные на регистрации и анализе акустических сигналов, возникающих в материале. Применяются для мониторинга состояния конструкций, обнаружения трещин и процессов разрушения.',
                    'en' => 'Testing methods based on the detection and analysis of acoustic signals generated within a material. Used for structural health monitoring, crack detection, and failure analysis.',
                ],
                'image_url' => null,
            ],
            [
                'group' => [
                    'ru' => 'Промышленные установки',
                    'en' => 'Industrial installations',
                ],
                'slug' => 'industrial-installations',
                'description' => [
                    'ru' => '',
                    'en' => '',
                ],
                'image_url' => null,
            ],
            [
                'group' => [
                    'ru' => 'Дефектоскопы',
                    'en' => 'Flaw detectors',
                ],
                'slug' => 'flaw-detectors',
                'description' => [
                    'ru' => '',
                    'en' => '',
                ],
                'image_url' => null,
            ],
            [
                'group' => [
                    'ru' => 'Сканирующие устройства',
                    'en' => 'Scanning devices',
                ],
                'slug' => 'scanning-devices',
                'description' => [
                    'ru' => '',
                    'en' => '',
                ],
                'image_url' => null,
            ],
            [
                'group' => [
                    'ru' => 'Авиакосмическая отрасль',
                    'en' => 'Aerospace sector',
                ],
                'slug' => 'aerospace-sector',
                'description' => [
                    'ru' => 'Решения для контроля авиационных конструкций, композитов и ответственных элементов летательных аппаратов.',
                    'en' => 'Solutions for inspecting aircraft structures, composites, and critical aerospace components.',
                ],
                'image_url' => null,
            ],
            [
                'group' => [
                    'ru' => 'Железнодорожная отрасль',
                    'en' => 'Railway sector',
                ],
                'slug' => 'railway-sector',
                'description' => [
                    'ru' => 'Неразрушающий контроль рельсов, сварных соединений и элементов железнодорожной инфраструктуры.',
                    'en' => 'Non-destructive testing of rails, welds, and railway infrastructure components.',
                ],
                'image_url' => null,
            ],
            [
                'group' => [
                    'ru' => 'Промышленность',
                    'en' => 'Industrial sector',
                ],
                'slug' => 'industrial-sector',
                'description' => [
                    'ru' => 'Промышленные решения для диагностики конструкций, проверки качества и контроля производственных процессов.',
                    'en' => 'Industrial solutions for structural diagnostics, quality verification, and manufacturing process control.',
                ],
                'image_url' => null,
            ],
        ];

        foreach ($groups as $item) {
            Group::query()->create([
                'group' => $item['group'],
                'description' => $item['description'],
                'slug' => $item['slug'],
                'image_url' => $item['image_url'],
            ]);
        }
    }
}
