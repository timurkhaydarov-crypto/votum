// navigation.data.js

// ======================================================
// MAIN MENU
// ======================================================

export const mainMenu = [
    {
        title: 'menu.home',
        href: '/',
        icon: 'bi-house-door'
    },
    {
        title: 'menu.about',
        href: '/about',
        icon: 'bi-person'
    },
    {
        title: 'menu.contacts',
        href: '/contacts',
        icon: 'bi-geo-alt'
    },
    {
        title: 'menu.cart',
        href: '/cart',
        icon: 'bi-cart3'
    }
]


// ======================================================
// PRODUCTS
// ======================================================
//
// Все товары находятся здесь один раз.
//
// Группы используют productIds.
// Один товар может находиться в нескольких группах.
//

export const products = [

    // ==================================================
    // ПРОМЫШЛЕННЫЕ УСТАНОВКИ
    // ==================================================

    {
        id: 'vtm-5000-orbita',
        title: 'РОБОСКОП ВТМ-5000/ОРБИТА',
        href: '/products/vtm-5000-orbita'
    },
    {
        id: 'vtm-5000-composite',
        title: 'РОБОСКОП ВТМ-5000/КОМПОЗИТ',
        href: '/products/vtm-5000-composite'
    },
    {
        id: 'vtm-5000-disk',
        title: 'РОБОСКОП ВТМ-5000/ДИСК',
        href: '/products/vtm-5000-disk'
    },

    {
        id: 'vtm-5000-kp',
        title: 'РОБОСКОП ВТМ-5000/КП',
        href: '/products/vtm-5000-kp'
    },
    {
        id: 'vtm-5000-as',
        title: 'РОБОСКОП ВТМ-5000/АС',
        href: '/products/vtm-5000-as'
    },
    {
        id: 'vtm-5000-rsp',
        title: 'РОБОСКОП ВТМ-5000/РСП',
        href: '/products/vtm-5000-rsp'
    },
    {
        id: 'vtm-5000-or',
        title: 'РОБОСКОП ВТМ-5000/ОР',
        href: '/products/vtm-5000-or'
    },
    {
        id: 'vtm-5000-rt',
        title: 'РОБОСКОП ВТМ-5000/РТ',
        href: '/products/vtm-5000-rt'
    },
    {
        id: 'vtm-5000-rd',
        title: 'РОБОСКОП ВТМ-5000/РД',
        href: '/products/vtm-5000-rd'
    },
    {
        id: 'vtm-5000-pv',
        title: 'РОБОСКОП ВТМ-5000/ПВ',
        href: '/products/vtm-5000-pv'
    },
    {
        id: 'vtm-5000-ls',
        title: 'РОБОСКОП ВТМ-5000/ЛС',
        href: '/products/vtm-5000-ls'
    },

    {
        id: 'vtm-5000-frame',
        title: 'РОБОСКОП ВТМ-5000/ФРЕЙМ',
        href: '/products/vtm-5000-frame'
    },
    {
        id: 'vtm-5000-faust',
        title: 'РОБОСКОП ВТМ-5000/ФАУСТ',
        href: '/products/vtm-5000-faust'
    },
    {
        id: 'vtm-5000-sfera',
        title: 'РОБОСКОП ВТМ-5000/СФЕРА',
        href: '/products/vtm-5000-sfera'
    },
    {
        id: 'vikhri-2k',
        title: 'ВИХРЬ 2К',
        href: '/products/vikhri-2k'
    },
    {
        id: 'foton-1200',
        title: 'ФОТОН 1200',
        href: '/products/foton-1200'
    },


    // ==================================================
    // ДЕФЕКТОСКОПЫ
    // ==================================================

    {
        id: 'chameleon-32-plus-32-64',
        title: 'ХАМЕЛЕОН 32+ (32/64)',
        href: '/products/chameleon-32-plus-32-64'
    },
    {
        id: 'chameleon-32-plus',
        title: 'ХАМЕЛЕОН 32+',
        href: '/products/chameleon-32-plus'
    },
    {
        id: 'kalmаr-32-plus',
        title: 'КАЛЬМАР 32+',
        href: '/products/kalmar-32-plus'
    },
    {
        id: 'fazar-32-plus',
        title: 'ФАЗАР 32+',
        href: '/products/fazar-32-plus'
    },
    {
        id: 'tomographic-5m',
        title: 'ТОМОГРАФИК 5М',
        href: '/products/tomographic-5m'
    },
    {
        id: 'tomographic-ud4-tm-269',
        title: 'ТОМОГРАФИК УД4-ТМ (2.69)',
        href: '/products/tomographic-ud4-tm-269'
    },
    {
        id: 'dami-c09',
        title: 'ДАМИ-C09',
        href: '/products/dami-c09'
    },
    {
        id: 'teri',
        title: 'ТЭРИ',
        href: '/products/teri'
    },
    {
        id: 'wizard',
        title: 'Блендоскоп WIZARD',
        href: '/products/wizard'
    },
    {
        id: 'video-endoscope',
        title: 'ВИДЕО ЭНДОСКОП',
        href: '/products/video-endoscope'
    },
    {
        id: 'trak',
        title: 'ТРАК',
        href: '/products/trak'
    },


    // ==================================================
    // СКАНИРУЮЩИЕ УСТРОЙСТВА
    // ==================================================

    {
        id: 'uso-1tm',
        title: 'УСО-1ТМ',
        href: '/products/uso-1tm'
    },
    {
        id: 'tandem',
        title: 'ТАНДЕМ',
        href: '/products/tandem'
    },
    {
        id: 'slider-m1',
        title: 'СЛАЙДЕР М1',
        href: '/products/slider-m1'
    },
    {
        id: 'slider-m3',
        title: 'СЛАЙДЕР М3',
        href: '/products/slider-m3'
    },
    {
        id: 'usk-4t',
        title: 'УСК-4Т',
        href: '/products/usk-4t'
    },
    {
        id: 'usk-5tm',
        title: 'УСК-5ТМ',
        href: '/products/usk-5tm'
    },
    {
        id: 'usk-tl',
        title: 'УСК-ТЛ',
        href: '/products/usk-tl'
    },
    {
        id: 'videoscanner',
        title: 'ВИДЕОСКАНЕР',
        href: '/products/videoscanner'
    },
    {
        id: 'axis-270',
        title: 'ОСЬ-270',
        href: '/products/axis-270'
    },
    {
        id: 'uoo-1t',
        title: 'УОО-1Т',
        href: '/products/uoo-1t'
    },
    {
        id: 'videoscanner-video-recorder',
        title: 'ВИДЕОСКАНЕР видеорегистратор',
        href: '/products/videoscanner-video-recorder'
    },


    // ==================================================
    // ПРЕОБРАЗОВАТЕЛИ
    // ==================================================

    {
        id: 'ultrasonic-angle-combined',
        title: 'НАКЛОННЫЕ СОВМЕЩЕННЫЕ',
        href: '/products/ultrasonic-angle-combined'
    },
    {
        id: 'ultrasonic-direct-combined',
        title: 'ПРЯМЫЕ СОВМЕЩЕННЫЕ',
        href: '/products/ultrasonic-direct-combined'
    },
    {
        id: 'ultrasonic-direct-separate-combined',
        title: 'ПРЯМЫЕ РАЗДЕЛЬНО-СОВМЕЩЕННЫЕ',
        href: '/products/ultrasonic-direct-separate-combined'
    },
    {
        id: 'ultrasonic-fitted',
        title: 'ПРИТЕРТЫЕ',
        href: '/products/ultrasonic-fitted'
    },
    {
        id: 'ultrasonic-chord',
        title: 'ХОРДОВЫЕ',
        href: '/products/ultrasonic-chord'
    },

    {
        id: 'e411-3-0-k18',
        title: 'E411-3,0-K18',
        href: '/products/e411-3-0-k18'
    },
    {
        id: 'e411-5-0-k12-001',
        title: 'E411-5,0-K12-001',
        href: '/products/e411-5-0-k12-001'
    },

    {
        id: 'vtp-1',
        title: 'ВТП-1',
        href: '/products/vtp-1'
    },
    {
        id: 'vtp-2',
        title: 'ВТП-2',
        href: '/products/vtp-2'
    },
    {
        id: 'vtp-2t',
        title: 'ВТП-2Т',
        href: '/products/vtp-2t'
    },
    {
        id: 'vtp-3',
        title: 'ВТП-3',
        href: '/products/vtp-3'
    },
    {
        id: 'vtp-3t',
        title: 'ВТП-3Т',
        href: '/products/vtp-3t'
    },

    {
        id: 'p111-0-2',
        title: 'П111-0.2',
        href: '/products/p111-0-2'
    },
    {
        id: 'p111-0-3',
        title: 'П111-0.3',
        href: '/products/p111-0-3'
    },

    {
        id: 'padi-40-rs',
        title: 'ПАДИ-40-РС',
        href: '/products/padi-40-rs'
    },
    {
        id: 'padi-8-su',
        title: 'ПАДИ-8 СУ',
        href: '/products/padi-8-su'
    },

    {
        id: 'udp-10-02',
        title: 'УДП-10-02',
        href: '/products/udp-10-02'
    },

    {
        id: 'p121-1-25-90-usk',
        title: 'П121-1,25-90-УСК',
        href: '/products/p121-1-25-90-usk'
    },
    {
        id: 'p121-2-5-40-usk',
        title: 'П121-2,5-40-УСК',
        href: '/products/p121-2-5-40-usk'
    },
    {
        id: 'p121-2-5-50-usk',
        title: 'П121-2,5-50-УСК',
        href: '/products/p121-2-5-50-usk'
    },
    {
        id: 'p111-2-5-k12-005',
        title: 'П111-2,5-К12-005',
        href: '/products/p111-2-5-k12-005'
    },
    {
        id: 'p112-2-5-12-2-005',
        title: 'П112-2,5-12/2-005',
        href: '/products/p112-2-5-12-2-005'
    },
    {
        id: 'p131-2-5-0-18',
        title: 'П131-2,5-0/18',
        href: '/products/p131-2-5-0-18'
    },
    {
        id: 'p131-2-5-0-20',
        title: 'П131-2,5-0/20',
        href: '/products/p131-2-5-0-20'
    },
    {
        id: 'p131-2-5-0-27',
        title: 'П131-2,5-0/27',
        href: '/products/p131-2-5-0-27'
    },
    {
        id: 'p121-0-4-90',
        title: 'П121-0,4-90',
        href: '/products/p121-0-4-90'
    },
    {
        id: 'p121-1-25-90-003',
        title: 'П121-1,25-90-003',
        href: '/products/p121-1-25-90-003'
    },
    {
        id: 'p122-2-5-90-k',
        title: 'П122-2,5-90-К',
        href: '/products/p122-2-5-90-k'
    },
    {
        id: 'p122-2-5-90-sh',
        title: 'П122-2,5-90-Ш',
        href: '/products/p122-2-5-90-sh'
    },
    {
        id: 'p121-2-5-19-uso',
        title: 'П121-2,5-19-УСО',
        href: '/products/p121-2-5-19-uso'
    },
    {
        id: 'p121-2-5-43-uso',
        title: 'П121-2,5-43-УСО',
        href: '/products/p121-2-5-43-uso'
    },
    {
        id: 'p121-2-5-55-uso',
        title: 'П121-2,5-55-УСО',
        href: '/products/p121-2-5-55-uso'
    },
    {
        id: 'p121-5-65-uso',
        title: 'П121-5-65-УСО',
        href: '/products/p121-5-65-uso'
    },
    {
        id: 'p121-2-5-45-m3',
        title: 'П121-2,5-45-М3',
        href: '/products/p121-2-5-45-m3'
    },
    {
        id: 'p121-2-5-50-m3',
        title: 'П121-2,5-50-М3',
        href: '/products/p121-2-5-50-m3'
    },
    {
        id: 'p121-2-5-65-m3',
        title: 'П121-2,5-65-М3',
        href: '/products/p121-2-5-65-m3'
    },
    {
        id: 'p121-2-5-70-m3',
        title: 'П121-2,5-70-М3',
        href: '/products/p121-2-5-70-m3'
    },
    {
        id: 'p112-2-5-12-2-m3',
        title: 'П112-2,5-12/2-М3',
        href: '/products/p112-2-5-12-2-m3'
    },

    {
        id: 'pa2-5l16-1-0x10-17',
        title: 'PA2.5L16-1.0×10-17',
        href: '/products/pa2-5l16-1-0x10-17'
    },
    {
        id: 'n55s-t1-17',
        title: 'N55S-T1-17',
        href: '/products/n55s-t1-17'
    },

    {
        id: '4cd-1-p211f-5-0',
        title: '4CD-1 П211Ф-5.0',
        href: '/products/4cd-1-p211f-5-0'
    },
    {
        id: '4wm-1-p211f-5-0',
        title: '4WM-1 П211Ф-5.0',
        href: '/products/4wm-1-p211f-5-0'
    },

    {
        id: 'emk-4-02',
        title: 'Электроёмкостный датчик ЭМК-4-02 для поиска влаги в сотовых конструкциях',
        href: '/products/emk-4-02'
    },


    // ==================================================
    // МЕРЫ ДЕФЕКТОВ
    // ==================================================

    {
        id: 'on-3',
        title: 'ОН-3',
        href: '/products/on-3'
    },
    {
        id: 'so-3r',
        title: 'СО-3Р',
        href: '/products/so-3r'
    },
    {
        id: 'sop-28-3-0',
        title: 'СОП Ø28×3,0',
        href: '/products/sop-28-3-0'
    },
    {
        id: 'sop-57-3-5',
        title: 'СОП Ø57×3,5',
        href: '/products/sop-57-3-5'
    },
    {
        id: 'on-fr-a',
        title: 'ОН-ФР(А)',
        href: '/products/on-fr-a'
    },

    {
        id: 'on-4',
        title: 'ОН-4',
        href: '/products/on-4'
    },
    {
        id: 'on-5',
        title: 'ОН-5',
        href: '/products/on-5'
    },
    {
        id: 'rsa-0-2-0-5-1',
        title: 'RSA-0,2-0,5-1',
        href: '/products/rsa-0-2-0-5-1'
    },
    {
        id: 'rss-0-2-0-5-1',
        title: 'RSS-0,2-0,5-1',
        href: '/products/rss-0-2-0-5-1'
    },
    {
        id: 'rs-ss-0-2-0-5-1',
        title: 'RS-SS-0,2-0,5-1',
        href: '/products/rs-ss-0-2-0-5-1'
    },
    {
        id: 'rst-0-2-0-5-1',
        title: 'RST-0,2-0,5-1',
        href: '/products/rst-0-2-0-5-1'
    },

    {
        id: 'ts-2',
        title: 'TS-2',
        href: '/products/ts-2'
    },

    {
        id: 'oso-32-006-2002',
        title: 'OCO 32.006-2002 (OCO 32.006-2002 РВ2Ш)',
        href: '/products/oso-32-006-2002'
    },
    {
        id: 'oso32-008-2009',
        title: 'OCO32.008-2009 (№1, №2)',
        href: '/products/oso32-008-2009'
    },
    {
        id: 'on-6-st45',
        title: 'ОН-6-СТ45',
        href: '/products/on-6-st45'
    },
    {
        id: 'on-7-st20',
        title: 'ОН-7-СТ20',
        href: '/products/on-7-st20'
    }
]


// ======================================================
// PRODUCT CATEGORIES
// ======================================================

export const productCategories = [

    // ==================================================
    // 1. ПРОМЫШЛЕННЫЕ УСТАНОВКИ
    // ==================================================

    {
        id: 'industrial-ndt',
        title: 'Промышленные установки неразрушающего контроля',
        shortTitle: 'Промышленные установки',
        icon: 'bi-robot',
        href: '/products/industrial-ndt',

        groups: [

            {
                id: 'aerospace-industry',
                title: 'Авиакосмическая отрасль',
                href: '/products/industrial-ndt/aerospace-industry',
                icon: 'bi-airplane',
                productIds: [
                    'vtm-5000-orbita',
                    'vtm-5000-composite',
                    'vtm-5000-disk'
                ]
            },

            {
                id: 'railway-industry',
                title: 'Железнодорожная отрасль',
                href: '/products/industrial-ndt/railway-industry',
                icon: 'bi-train-front',
                productIds: [
                    'vtm-5000-kp',
                    'vtm-5000-as',
                    'vtm-5000-rsp',
                    'vtm-5000-or',
                    'vtm-5000-rt',
                    'vtm-5000-rd',
                    'vtm-5000-pv',
                    'vtm-5000-ls'
                ]
            },

            {
                id: 'industrial-sector',
                title: 'Промышленность',
                href: '/products/industrial-ndt/industrial-sector',
                icon: 'bi-buildings',
                productIds: [
                    'vtm-5000-frame',
                    'vtm-5000-faust',
                    'vtm-5000-sfera',
                    'vikhri-2k',
                    'foton-1200'
                ]
            }

        ]
    },


    // ==================================================
    // 2. ДЕФЕКТОСКОПЫ
    // ==================================================

    {
        id: 'flaw-detectors',
        title: 'Дефектоскопы',
        shortTitle: 'Дефектоскопы',
        icon: 'bi-search',
        href: '/products/flaw-detectors',

        groups: [

            {
                id: 'aerospace-sector',
                title: 'Авиакосмическая отрасль',
                href: '/products/flaw-detectors/aerospace-sector',
                icon: 'bi-airplane',
                productIds: [
                    'chameleon-32-plus-32-64',
                    'tomographic-5m',
                    'dami-c09',
                    'teri',
                    'wizard',
                    'video-endoscope'
                ]
            },

            {
                id: 'railway-sector',
                title: 'Железнодорожная отрасль',
                href: '/products/flaw-detectors/railway-sector',
                icon: 'bi-train-front',
                productIds: [
                    'chameleon-32-plus-32-64',
                    'chameleon-32-plus',
                    'kalmar-32-plus',
                    'fazar-32-plus',
                    'tomographic-5m',
                    'tomographic-ud4-tm-269',
                    'dami-c09'
                ]
            },

            {
                id: 'industrial-sector',
                title: 'Промышленность',
                href: '/products/flaw-detectors/industrial-sector',
                icon: 'bi-buildings',
                productIds: [
                    'chameleon-32-plus-32-64',
                    'tomographic-5m',
                    'dami-c09',
                    'trak'
                ]
            }

        ]
    },


    // ==================================================
    // 3. СКАНИРУЮЩИЕ УСТРОЙСТВА
    // ==================================================

    {
        id: 'scanning-devices',
        title: 'Сканирующие устройства',
        shortTitle: 'Сканирующие устройства',
        icon: 'bi-radar',
        href: '/products/scanners',

        groups: [

            {
                id: 'aerospace-sector',
                title: 'Авиакосмическая отрасль',
                href: '/products/scanners/aerospace-sector',
                icon: 'bi-airplane',
                productIds: [
                    'slider-m1',
                    'videoscanner-video-recorder'
                ]
            },

            {
                id: 'railway-sector',
                title: 'Железнодорожная отрасль',
                href: '/products/scanners/railway-sector',
                icon: 'bi-train-front',
                productIds: [
                    'uso-1tm',
                    'tandem',
                    'slider-m1',
                    'slider-m3',
                    'usk-4t',
                    'usk-5tm',
                    'usk-tl',
                    'videoscanner',
                    'axis-270',
                    'uoo-1t'
                ]
            },

            {
                id: 'industrial-sector',
                title: 'Промышленность',
                href: '/products/scanners/industrial-sector',
                icon: 'bi-buildings',
                productIds: [
                    'slider-m1',
                    'videoscanner'
                ]
            }

        ]
    },


    // ==================================================
    // 4. ПРЕОБРАЗОВАТЕЛИ
    // ==================================================

    {
        id: 'transducers',
        title: 'Преобразователи',
        shortTitle: 'Преобразователи',
        icon: 'bi-broadcast-pin',
        href: '/products/transducers',

        groups: [

            {
                id: 'ultrasonic',
                title: 'Ультразвуковые',
                href: '/products/transducers/ultrasonic',
                icon: 'bi-soundwave',
                productIds: [
                    'ultrasonic-angle-combined',
                    'ultrasonic-direct-combined',
                    'ultrasonic-direct-separate-combined',
                    'ultrasonic-fitted',
                    'ultrasonic-chord'
                ]
            },

            {
                id: 'ema',
                title: 'ЭМА',
                href: '/products/transducers/ema',
                icon: 'bi-magnet',
                productIds: [
                    'e411-3-0-k18',
                    'e411-5-0-k12-001'
                ]
            },

            {
                id: 'eddy-current',
                title: 'Вихретоковые',
                href: '/products/transducers/eddy-current',
                icon: 'bi-arrow-repeat',
                productIds: [
                    'vtp-1',
                    'vtp-2',
                    'vtp-2t',
                    'vtp-3',
                    'vtp-3t'
                ]
            },

            {
                id: 'resonance',
                title: 'Резонансные',
                href: '/products/transducers/resonance',
                icon: 'bi-activity',
                productIds: [
                    'p111-0-2',
                    'p111-0-3'
                ]
            },

            {
                id: 'impedance',
                title: 'Импедансные',
                href: '/products/transducers/impedance',
                icon: 'bi-diagram-3',
                productIds: [
                    'padi-40-rs',
                    'padi-8-su'
                ]
            },

            {
                id: 'impact',
                title: 'Ударные',
                href: '/products/transducers/impact',
                icon: 'bi-hammer',
                productIds: [
                    'udp-10-02'
                ]
            },

            {
                id: 'specialized-railway',
                title: 'Специализированные ЖД',
                href: '/products/transducers/specialized-railway',
                icon: 'bi-train-front',
                productIds: [
                    'p121-1-25-90-usk',
                    'p121-2-5-40-usk',
                    'p121-2-5-50-usk',
                    'p111-2-5-k12-005',
                    'p112-2-5-12-2-005',
                    'p131-2-5-0-18',
                    'p131-2-5-0-20',
                    'p131-2-5-0-27',
                    'p121-0-4-90',
                    'p121-1-25-90-003',
                    'p122-2-5-90-k',
                    'p122-2-5-90-sh',
                    'p121-2-5-19-uso',
                    'p121-2-5-43-uso',
                    'p121-2-5-55-uso',
                    'p121-5-65-uso',
                    'p121-2-5-45-m3',
                    'p121-2-5-50-m3',
                    'p121-2-5-65-m3',
                    'p121-2-5-70-m3',
                    'p112-2-5-12-2-m3'
                ]
            },

            {
                id: 'phased-array',
                title: 'На фазированных решетках',
                href: '/products/transducers/phased-array',
                icon: 'bi-grid-3x3',
                productIds: [
                    'pa2-5l16-1-0x10-17',
                    'n55s-t1-17'
                ]
            },

            {
                id: 'immersion',
                title: 'Иммерсионные',
                href: '/products/transducers/immersion',
                icon: 'bi-droplet',
                productIds: [
                    '4cd-1-p211f-5-0',
                    '4wm-1-p211f-5-0'
                ]
            },

            {
                id: 'electrocapacitive',
                title: 'Электроёмкостные',
                href: '/products/transducers/electrocapacitive',
                icon: 'bi-lightning-charge',
                productIds: [
                    'emk-4-02'
                ]
            }

        ]
    },


    // ==================================================
    // 5. МЕРЫ ДЕФЕКТОВ И НАСТРОЕЧНЫЕ ОБРАЗЦЫ
    // ==================================================

    {
        id: 'reference-standards',
        title: 'Меры дефектов и настроечные образцы',
        shortTitle: 'Меры дефектов и образцы',
        icon: 'bi-rulers',
        href: '/products/reference-standards',

        groups: [

            {
                id: 'ultrasonic',
                title: 'Ультразвуковые',
                href: '/products/reference-standards/ultrasonic',
                icon: 'bi-soundwave',
                productIds: [
                    'on-3',
                    'so-3r',
                    'sop-28-3-0',
                    'sop-57-3-5',
                    'on-fr-a'
                ]
            },

            {
                id: 'eddy-current',
                title: 'Вихретоковые',
                href: '/products/reference-standards/eddy-current',
                icon: 'bi-arrow-repeat',
                productIds: [
                    'on-4',
                    'on-5',
                    'rsa-0-2-0-5-1',
                    'rss-0-2-0-5-1',
                    'rs-ss-0-2-0-5-1',
                    'rst-0-2-0-5-1'
                ]
            },

            {
                id: 'acoustic',
                title: 'Акустические',
                href: '/products/reference-standards/acoustic',
                icon: 'bi-soundwave',
                productIds: [
                    'ts-2'
                ]
            },

            {
                id: 'specialized-railway',
                title: 'Специализированные ЖД',
                href: '/products/reference-standards/specialized-railway',
                icon: 'bi-train-front',
                productIds: [
                    'oso-32-006-2002',
                    'oso32-008-2009',
                    'on-6-st45',
                    'on-7-st20'
                ]
            }

        ]
    }

]


// ======================================================
// SERVICES
// ======================================================

export const serviceCategories = [

    {
        title: 'Обучение',
        shortTitle: 'Обучение',
        icon: 'bi-mortarboard',
        href: '/services/training',

        items: [
            {
                title: 'Обучение специалистов',
                description:
                    'Подготовка и обучение специалистов по неразрушающему контролю',
                href: '/services/training/specialists',
                icon: 'bi-person-workspace'
            },
            {
                title: 'Повышение квалификации',
                description:
                    'Повышение квалификации и профессиональная подготовка',
                href: '/services/training/qualification',
                icon: 'bi-award'
            },
            {
                title: 'Практические семинары',
                description:
                    'Практические занятия и тематические семинары',
                href: '/services/training/seminars',
                icon: 'bi-easel2'
            }
        ]
    },


    {
        title: 'Метрология',
        shortTitle: 'Метрология',
        icon: 'bi-speedometer2',
        href: '/services/metrology',

        items: [
            {
                title: 'Поверка оборудования',
                description:
                    'Поверка средств измерений и оборудования',
                href: '/services/metrology/verification',
                icon: 'bi-patch-check'
            },
            {
                title: 'Калибровка',
                description:
                    'Калибровка измерительного оборудования',
                href: '/services/metrology/calibration',
                icon: 'bi-sliders'
            },
            {
                title: 'Метрологическая экспертиза',
                description:
                    'Экспертиза технической и метрологической документации',
                href: '/services/metrology/expertise',
                icon: 'bi-file-earmark-check'
            }
        ]
    },


    {
        title: 'Диагностика',
        shortTitle: 'Диагностика',
        icon: 'bi-activity',
        href: '/services/diagnostics',

        items: [
            {
                title: 'Техническая диагностика',
                description:
                    'Определение технического состояния оборудования',
                href: '/services/diagnostics/technical',
                icon: 'bi-tools'
            },
            {
                title: 'Диагностика оборудования',
                description:
                    'Комплексная диагностика и поиск неисправностей',
                href: '/services/diagnostics/equipment',
                icon: 'bi-cpu'
            },
            {
                title: 'Экспертное обследование',
                description:
                    'Экспертная оценка технического состояния',
                href: '/services/diagnostics/expertise',
                icon: 'bi-search'
            }
        ]
    }

]
