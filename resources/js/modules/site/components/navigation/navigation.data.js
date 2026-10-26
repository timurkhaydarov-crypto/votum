// navigation.data.js

// ======================================================
// MAIN MENU
// ======================================================

export const mainMenu = [
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

export const resolveProductById = (id, t) => {
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
            .trim() || t('productCard.untitledProduct'),
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

export const getServiceCategories = (t) => [
    {
        title: t('about.competence.training.title'),
        shortTitle: t('about.competence.training.title'),
        icon: 'bi-mortarboard',
        href: '/services/training',

        items: [
            {
                title: t('about.competence.training.items.specialists.title'),
                description: t('about.competence.training.items.specialists.description'),
                href: '/services/training/specialists',
                icon: 'bi-person-workspace'
            },
            {
                title: t('about.competence.training.items.qualification.title'),
                description: t('about.competence.training.items.qualification.description'),
                href: '/services/training/qualification',
                icon: 'bi-award'
            },
            {
                title: t('about.competence.training.items.seminars.title'),
                description: t('about.competence.training.items.seminars.description'),
                href: '/services/training/seminars',
                icon: 'bi-easel2'
            }
        ]
    },


    {
        title: t('about.competence.metrology.title'),
        shortTitle: t('about.competence.metrology.title'),
        icon: 'bi-speedometer2',
        href: '/services/metrology',

        items: [
            {
                title: t('about.competence.metrology.items.verification.title'),
                description: t('about.competence.metrology.items.verification.description'),
                href: '/services/metrology/verification',
                icon: 'bi-patch-check'
            },
            {
                title: t('about.competence.metrology.items.calibration.title'),
                description: t('about.competence.metrology.items.calibration.description'),
                href: '/services/metrology/calibration',
                icon: 'bi-sliders'
            },
            {
                title: t('about.competence.metrology.items.expertise.title'),
                description: t('about.competence.metrology.items.expertise.description'),
                href: '/services/metrology/expertise',
                icon: 'bi-file-earmark-check'
            }
        ]
    },


    {
        title: t('about.competence.diagnostics.title'),
        shortTitle: t('about.competence.diagnostics.title'),
        icon: 'bi-activity',
        href: '/services/diagnostics',

        items: [
            {
                title: t('about.competence.diagnostics.items.technical.title'),
                description: t('about.competence.diagnostics.items.technical.description'),
                href: '/services/diagnostics/technical',
                icon: 'bi-tools'
            },
            {
                title: t('about.competence.diagnostics.items.equipment.title'),
                description: t('about.competence.diagnostics.items.equipment.description'),
                href: '/services/diagnostics/equipment',
                icon: 'bi-cpu'
            },
            {
                title: t('about.competence.diagnostics.items.expertise.title'),
                description: t('about.competence.diagnostics.items.expertise.description'),
                href: '/services/diagnostics/expertise',
                icon: 'bi-search'
            }
        ]
    },

    {
        title: t('siteUi.services.projects.title'),
        shortTitle: t('siteUi.services.projects.shortTitle'),
        icon: 'bi-diagram-3',
        href: '/services/individual-projects',

        items: [
            {
                title: t('siteUi.services.projects.items.discuss.title'),
                description: t('siteUi.services.projects.items.discuss.description'),
                href: '/services/individual-projects',
                icon: 'bi-chat-dots'
            }
        ]
    }

]
