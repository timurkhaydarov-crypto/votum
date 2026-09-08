import diplomas from '../modules/site/constants/diplomas.js';
import about from './en/about.js';
import services from './en/services.js';
export default {
    ...about,
    ...services,
    actions: {
        accept: 'Accept',
        add: 'Add',
        approve: 'Approve',
        back: 'Back',
        cancel: 'Cancel',
        close: 'Close',
        confirm: 'Confirm',
        continue: 'Continue',
        copy: 'Copy',
        create: 'Create',
        decline: 'Decline',
        delete: 'Delete',
        disable: 'Disable',
        download: 'Download',
        edit: 'Edit',
        enable: 'Enable',
        finish: 'Finish',
        lock: 'Lock',
        next: 'Next',
        no: 'No',
        open: 'Open',
        pause: 'Pause',
        refresh: 'Refresh',
        reject: 'Reject',
        remove: 'Remove',
        reset: 'Reset',
        resume: 'Resume',
        retry: 'Retry',
        save: 'Save',
        search: 'Search',
        select: 'Select',
        send: 'Send',
        start: 'Start',
        stop: 'Stop',
        submit: 'Submit',
        unlock: 'Unlock',
        update: 'Update',
        upload: 'Upload',
        view: 'View',
        yes: 'Yes',
    },

    cart: {
        eyebrow: 'REQUEST',
        title: 'Request',
        description: 'Select the equipment you need to create a single request.',
        decrease: 'Decrease quantity',
        increase: 'Increase quantity',
        add: 'Add to request',
        adding: 'Adding...',
        inCart: 'In request',

        selected: 'Selected equipment',

        product: 'product',
        products: 'products',
        items: 'items',

        quantity: 'Quantity',
        total: 'Total',

        remove: 'Remove',
        removing: 'Removing...',

        updating: 'Updating...',

        clear: 'Clear request',
        clearing: 'Clearing...',

        checkout: 'Proceed to request',

        loading: 'Loading request...',
        error: 'Failed to perform the action',

        item: {
            available: 'Available',
            maxQuantity: 'Maximum available quantity reached',
        },

        empty: {
            title: 'Your request is empty',
            description: 'Select equipment from the catalog to add it to your request.',
            viewProducts: 'View products',
        },

        summary: {
            label: 'REQUEST',
            title: 'Request summary',
            products: 'Items',
            quantity: 'Quantity',
            total: 'Total units',
            clear: 'Clear request',
            clearing: 'Clearing...',
            checkout: 'Proceed to request',
        },
    },

    common: {
        pcs: 'pcs.',
        all: 'All',
        more: 'More',
        less: 'Collapse',
        showAll: 'Show all',
        showMore: 'Show more',
        collapse: 'Collapse',
        available: 'Available',
        unavailable: 'Unavailable',
        notAvailable: 'No data',
        empty: 'No data',
        byRequest: 'On request',
        close: 'Close',
        copyright: 'All Rights Reserved.',
    },

    contacts: {
        address: 'Address',
        email: 'Email',
        mail: 'Mail',
        phone: 'Phone',
        workTime: 'Working hours',
        department: 'Department',
        selectDepartment: 'Select department',
        socialMedia: 'Social media',
        timeMask: 'HH:MM',
        weekDay: 'Weekday',
        operatingHours: 'Operating hours',
        url: 'URL',
        eyebrow: 'Contacts',
        title: 'Get in touch',
        description:
            'TECHNOVOTUM headquarters and official representatives of the company in different countries around the world.',

        centralOffice: {
            label: 'Head office',
            title: 'Moscow, Zelenograd',
            addressLabel: 'Address',
            address: '124489, Moscow, Zelenograd, Sosnovaya Alley, 6A, Building 1',
            phoneLabel: 'Phones',
            emailLabel: 'Email',
            openMap: 'Open on map',
            imageAlt: 'TECHNOVOTUM central office',
            caption: 'Central office',
            hoursLabel: 'Operating hours',
        },

        dealers: {
            eyebrow: 'Dealer network',
            title: 'Our representatives',
            description:
                'Official TECHNOVOTUM representatives and partners across the CIS, Europe, Asia and Africa.',
            noInformation: 'No information',
            informationComingSoon: 'Contact information is being updated.',
            location: 'location',
            locations: 'locations',
            countries: {
                kazakhstan: 'Kazakhstan',
                latvia: 'Latvia',
                uzbekistan: 'Uzbekistan',
                china: 'China',
                estonia: 'Estonia',
                uganda: 'Uganda',
                tajikistan: 'Tajikistan',
                belarus: 'Belarus',
                turkmenistan: 'Turkmenistan',
                kyrgyzstan: 'Kyrgyzstan',
            },
        },

        map: {
            eyebrow: 'Find us',
            title: 'TECHNOVOTUM central office',
            iframeTitle: 'TECHNOVOTUM central office on the map',
            openExternal: 'Open map in new window',
        },

        cta: {
            eyebrow: 'TECHNOVOTUM',
            title: 'Looking for non-destructive testing equipment?',
            description:
                'Explore our equipment catalog or submit a request for the solutions you are interested in.',
            button: 'View products',
        },
    },

    certificates: {
        eyebrow: 'CERTIFICATES',
        title: 'Product certificates',
        description: 'Certificates and documents confirming compliance with applicable standards.',
        empty: 'No certificates available',
    },

    diplomas: {
        eyebrow: 'DIPLOMAS AND CERTIFICATES',
        title: 'Diplomas and Certificates',
        description:
            'Documents recognizing TECHNOVOTUM’s participation in professional exhibitions, forums and industry events.',
        empty: 'No diplomas available',
    },

    gallery: {
        title: 'Photo gallery',
        description: 'Visual overview of the equipment.',
        empty: 'No images available',
        image: 'Image',
        certificate: 'Certificate',
        diploma: 'Diploma',
        document: 'Document',
        photo: 'Photo',
    },

    compatibleProducts: {
        label: 'COMPATIBLE PRODUCTS',
        title: 'Compatible products',
        description: 'Equipment compatible with this device and designed to work with it.',
        categories: {
            industrialNdt: 'Industrial NDT',
            flawDetectors: 'Flaw detectors',
            scanningDevices: 'Scanning devices',
            transducers: 'Transducers',
            referenceStandards: 'Reference standards',
        },
        empty: {
            title: 'No compatible products',
            text: 'No compatible products were found for this equipment.',
        },
        product: {
            one: 'product',
            few: 'products',
            many: 'products',
        },
    },

    productDetail: {
        subtitle: 'Detailed information about the non-destructive testing equipment',
        noData: 'Product information is unavailable.',
    },

    product: {
        articleFallback: 'ARTICLE NOT SPECIFIED',
        inStock: 'In stock',
        outOfStock: 'Out of stock',
        noName: 'Unnamed product',
        defaultDescription: 'Professional non-destructive testing equipment.',
        priceOnRequest: 'On request',
        pdf: 'PDF document',

        video: {
            playing: 'Playing',
            photo: 'Photo',
            video: 'Video',
        },

        info: {
            eyebrow: 'INFORMATION',

            details: {
                title: 'Detailed information',
            },

            features: {
                title: 'Features',
            },

            specifications: {
                title: 'Technical specifications',
                value: 'Value',
                empty: 'No technical specifications available',
            },

            documentation: {
                title: 'Documentation',
                open: 'Open document',
            },
        },

        technical: {
            frequency: 'Frequency range',
            display: 'Display',
            channels: 'Number of channels',
            dynamicRange: 'Dynamic range',
            measurementRange: 'Measurement range',
            resolution: 'Resolution',
            dimensions: 'Dimensions',
            weight: 'Weight',
            power: 'Power supply',
        },

        documents: {
            characteristics: 'Technical specifications',
            certificates: 'Certificates',
            documentation: 'Documentation',
            software: 'Software',
        },
    },

    productCard: {
        badgeFallback: 'Ultrasonic testing',
        untitledProduct: 'Unnamed product',
        noDescription: 'No description available',
        inStock: 'In stock',
        outOfStock: 'Out of stock',
        method: 'Method',
        frequency: 'Frequency',
        display: 'Display',
        application: 'Application',
        price: 'Price',
        byRequest: 'On request',
        viewProduct: 'View product',
        addToCart: 'Add to cart',
        addToFavorites: 'Add to favorites',
    },

    productGrid: {
        all: 'All',
    },

    productPages: {
        groupTitle: 'Group: {group}',
        groupSubtitle: 'Products in the {category} category',
    },

    hero: {
        badge: 'NDT Equipment Manufacturer',
        titleBefore: 'We create the',
        titleGradient: 'future of NDT',
        subtitle:
            'A world-class manufacturer of non-destructive testing equipment. Development, prototyping and serial production are carried out at our own facilities — from ultrasonic flaw detectors to advanced phased array systems.',

        requestQuote: 'Request a quote',
        viewProducts: 'View products',

        meta: {
            location: {
                value: 'Moscow, Russia',
                label: 'Location',
            },
            production: {
                value: 'In-house',
                label: 'Development & production',
            },
        },

        scanner: {
            live: 'Scanning',
            scanActive: 'NDT inspection active',
            system: 'Ultrasonic testing system',
        },

        stats: {
            tests: {
                value: '18,000+',
                label: 'Certified tests',
            },
            industry: {
                value: 'Aviation',
                label: 'and railway',
                status: 'Certified',
            },
            certificates: {
                value: '5 CE',
                label: 'Certificates',
            },
        },
    },

    logo: {
        title: 'TECHNOVOTUM',
        subtitle: 'Non-destructive testing technologies',
    },

    menu: {
        home: 'Home',
        about: 'About us',
        services: 'Services',
        products: 'Products',
        cart: 'Request',
        contacts: 'Contacts',
    },

    megaMenu: {
        categories: 'Categories',
        allProducts: 'All products',
        allServices: 'All services',
        chooseCategory: 'Choose a category',
        showAllProducts: 'Show all products',
        showAllCategory: 'Show all category',
        showAllGroup: 'Show all group',
        allCategory: 'All categories',
        details: 'Details',
        contactUs: 'Contact us',
        noProducts: 'No products available',
        chooseDevice: 'Choose a device',
        deviceHint: 'Select a device from the list to see a short description.',
        deviceDefault: 'Device',
        deviceDescription: 'Professional equipment for {product} and precise quality control.',
        needHelpTitle: 'Need help choosing equipment?',
        needHelpDescription: 'Our specialists will help you choose the right solution',
        allServicesInCategory: 'All {category} services',
    },

    productBreadcrumbs: {
        catalog: 'Catalog',
        productFallback: 'Product #{id}',
        backToCatalog: 'Back to catalog',
        backToCategory: 'Back to category: {category}',
        backToGroup: 'Back to group: {group}',
    },

    messages: {
        confirm: {
            delete: 'Are you sure you want to delete this item? This action cannot be undone.',
        },
        success: {
            update: 'Item updated successfully',
            create: 'Item created successfully',
            delete: 'Item deleted successfully',
            default: 'Action completed successfully',
        },
        fail: {
            update: 'Failed to update item',
            create: 'Failed to create item',
            delete: 'Failed to delete item',
            default: 'Failed to perform the action',
        },
    },

    request: {
        eyebrow: 'REQUEST SUBMISSION',
        title: 'Submit a request',
        description:
            'Enter your contact details and our specialists will contact you to discuss the details.',
        backToCart: 'Back to request',

        form: {
            label: 'CONTACT DETAILS',
            title: 'Your details',
            description: 'Provide your contact information so we can get in touch with you.',
            name: 'Name',
            namePlaceholder: 'Enter your name',
            phone: 'Phone',
            phonePlaceholder: '+1 (___) ___-____',
            email: 'Email',
            emailPlaceholder: 'nameexample.com',
            comment: 'Comment',
            commentPlaceholder: 'Additional information, questions or requests...',
            submit: 'Submit request',
            sending: 'Sending...',
            privacy: 'By clicking the button, you agree to the processing of the provided data.',
            emptyCart: 'Your request is empty. Add equipment from the catalog.',
            submitError: 'Failed to submit the request. Please try again.',
        },

        summary: {
            label: 'SELECTED EQUIPMENT',
            title: 'Request summary',
        },

        success: {
            title: 'Request submitted',
            description:
                'Thank you! Your request has been successfully submitted. Our specialist will contact you shortly.',
            numberLabel: 'Request number',
            backToProducts: 'Back to products',
            close: 'Close',
        },
    },

    periods: {
        from: 'From',
        to: 'To',
    },

    validation: {
        select: {
            required: 'Please select a value',
        },
        input: {
            required: 'Please enter a value',
        },
        email: 'Please enter a valid email address',
        phone: 'Please enter a valid phone number',
    },

    weekdays: {
        monday: 'Mon.',
        tuesday: 'Tue.',
        wednesday: 'Wed.',
        thursday: 'Thu.',
        friday: 'Fri.',
        saturday: 'Sat.',
        sunday: 'Sun.',
    },
};
