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
    }
]


// ======================================================
// PRODUCT MENU
// ======================================================

export const products = []

export const resolveProductById = (id) => {
    const cached = products.find(item => item.id === id)

    if (cached) {
        return cached
    }

    const safeId = String(id)

    return {
        id: safeId,
        title: safeId
            .replace(/[-_]+/g, ' ')
            .replace(/\s+/g, ' ')
            .trim() || 'Продукция',
        href: `/products/item/${safeId}`
    }
}

export const fetchProductCategories = async (locale = 'ru') => {
    const response = await fetch(`/api/products/menu?lang=${encodeURIComponent(locale)}`)

    if (!response.ok) {
        throw new Error('Failed to load product menu')
    }

    return response.json()
}


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
