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
        saving: 'Saving',
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
        loading: 'Loading...',
        russian: 'Russian',
        english: 'English',
    },
    company: {
        about: {
            eyebrow: 'ABOUT US',

            title: 'NDT technologies engineered for real-world applications',

            description:
                'TECHNOVOTUM develops and manufactures non-destructive testing equipment. We create instruments, automated systems and specialized solutions for industry, transport, energy and other sectors where quality and safety are critical.',

            stats: {
                products: 'Equipment models',
                methods: 'Testing methods',
                industries: 'Application industries',
            },
        },

        manufacturing: {
            eyebrow: 'MANUFACTURING',

            title: 'From engineering concept to finished system',

            description:
                'We combine electronics, software, mechanics and measurement technologies into a single engineering and manufacturing process.',

            items: {
                engineering: {
                    title: 'Engineering & Design',
                    description:
                        'Design of specialized NDT systems and equipment for specific inspection requirements.',
                },

                electronics: {
                    title: 'Electronics & Measurement',
                    description:
                        'Development and integration of electronic modules, sensors, measurement channels and signal processing systems.',
                },

                software: {
                    title: 'Software & Control',
                    description:
                        'Development of control software, inspection visualization, measurement automation and data processing.',
                },

                testing: {
                    title: 'Testing & Calibration',
                    description:
                        'Performance verification, equipment configuration and functional testing before delivery.',
                },
            },
        },

        quality: {
            eyebrow: 'QUALITY',

            title: 'From requirements to operational deployment',

            description:
                'Every solution goes through a structured process of engineering, manufacturing, testing and preparation for operation.',

            steps: {
                requirements: {
                    title: 'Requirements',
                    description:
                        'We define the inspection object, operating conditions and required NDT methods.',
                },

                design: {
                    title: 'Design',
                    description: 'We develop the technical solution and equipment configuration.',
                },

                manufacturing: {
                    title: 'Manufacturing',
                    description:
                        'Components are manufactured, assembled and integrated into the system.',
                },

                testing: {
                    title: 'Testing',
                    description:
                        'Key characteristics and compliance with applicable requirements are verified.',
                },

                delivery: {
                    title: 'Deployment',
                    description: 'Equipment is delivered with the required technical support.',
                },
            },
        },

        certifications: {
            eyebrow: 'CERTIFICATIONS',

            title: 'Compliance with requirements and standards',

            description:
                'Certificates, documentation and test results demonstrate compliance with applicable requirements.',

            items: {
                quality: {
                    title: 'Quality',
                    description: 'Quality control throughout development and manufacturing.',
                },

                safety: {
                    title: 'Safety',
                    description: 'Equipment safety and operational requirements.',
                },

                metrology: {
                    title: 'Metrology',
                    description: 'Control of metrological characteristics of measurement systems.',
                },

                ndt: {
                    title: 'NDT',
                    description: 'Requirements for NDT equipment and inspection methods.',
                },

                production: {
                    title: 'Manufacturing',
                    description: 'Production process and finished product quality control.',
                },

                international: {
                    title: 'International',
                    description: 'Preparing products for use across different markets.',
                },
            },
        },

        global: {
            eyebrow: 'GLOBAL PRESENCE',

            title: 'Technologies designed for multiple industries',

            description:
                'TECHNOVOTUM equipment is designed for use in industry, transportation, energy, mechanical engineering and other demanding applications.',

            mapLabel: 'Application geography',

            locations: {
                europe: 'Europe',
                centralAsia: 'Central Asia',
                middleEast: 'Middle East',
                asia: 'Asia',
                cis: 'CIS',
                headquarters: 'TECHNOVOTUM',
            },
        },

        getStarted: {
            eyebrow: 'GET STARTED',

            title: 'Let us find the right inspection solution',

            description:
                'Tell us about your inspection object, operating conditions and required method. TECHNOVOTUM specialists will help define the optimal equipment configuration.',

            products: 'View equipment',
            contact: 'Contact us',
        },

        contact: {
            eyebrow: 'CONTACT US',

            title: 'Let’s discuss your project',

            description:
                'Contact the TECHNOVOTUM team for advice on equipment, technical solutions and cooperation opportunities.',

            items: {
                address: {
                    label: 'Address',
                },

                phone: {
                    label: 'Phone',
                },

                email: {
                    label: 'E-mail',
                },

                hours: {
                    label: 'Working hours',
                },
            },

            loadError: 'Failed to load contacts. Please refresh the page.',
        },
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
        cta: {
            eyebrow: 'Need assistance?',
            title: 'Need help choosing the right equipment?',
            description:
                'Our specialists will help you select the right equipment configuration for your specific inspection task.',
            button: 'Contact a specialist',
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

        form: {
            createTitle: 'Add Product',
            editTitle: 'Edit Product',

            createDescription: 'Fill in the details to add a new product to the catalog.',

            editDescription: 'Edit the product details and save your changes.',

            errors: {
                save: 'Failed to save the product.',
                delete: 'Failed to delete the product.',
            },

            basic: {
                title: 'Basic Information',
                description: 'Basic product information and units of measurement.',
            },

            article: 'Article',
            unit: 'Unit',

            name: {
                title: 'Name',
                ru: 'Name in Russian',
                en: 'Name in English',
            },

            shortDescription: {
                title: 'Short Description',
                ru: 'Short description in Russian',
                en: 'Short description in English',
            },

            fullDescription: {
                title: 'Full Description',
                ru: 'Full description in Russian',
                en: 'Full description in English',
            },

            classification: {
                title: 'Classification',
            },

            category: 'Category',
            group: 'Primary Group',
            brand: 'Brand',
            additionalGroups: 'Additional Groups',

            product: {
                title: 'Product Data',
            },

            price: 'Price',
            quantity: 'Quantity',
            image: 'Image',
            video: 'Video',

            note: {
                title: 'Additional Information',
                frequency: 'Frequency Range',
                display: 'Display',
            },

            status: 'Product is available',

            method: {
                title: 'Testing Methods',
                description: 'Select the available non-destructive testing methods.',
            },

            sector: {
                title: 'Application Sectors',
                description: 'Select the industries where the product is used.',
            },

            certificates: {
                title: 'Certificates',
                empty: 'No certificates available',
            },

            compatible: {
                title: 'Compatible Products',
            },

            gallery: {
                title: 'Gallery',
                add: 'Add Image',
                image: 'Image',
                titleRu: 'Title in Russian',
                titleEn: 'Title in English',
                descriptionRu: 'Description in Russian',
                descriptionEn: 'Description in English',
            },

            features: {
                title: 'Functional Features',
                ru: 'Functional features in Russian',
                en: 'Functional features in English',
            },

            featuresGallery: {
                title: 'Functional Features Gallery',
                add: 'Add Image',
                image: 'Image',
                titleRu: 'Title in Russian',
                titleEn: 'Title in English',
            },

            specifications: {
                title: 'Technical Specifications',
                add: 'Add Specification',
                nameRu: 'Name in Russian',
                nameEn: 'Name in English',
                valueRu: 'Value in Russian',
                valueEn: 'Value in English',
            },

            methods: {
                ut: 'Ultrasonic Testing (UT)',
                et: 'Eddy Current Testing (ET)',
                mia: 'Magnetic Induction Analysis (MIA)',
                iet: 'Impedance Testing (IET)',
                mt: 'Magnetic Particle Testing (MT)',
                vt: 'Visual Testing (VT)',
            },

            sectors: {
                railway: 'Railway Industry',
                aerospace: 'Aerospace Industry',
                oil: 'Oil & Gas Industry',
            },

            media: {
                title: 'Media',
                description: 'Product image and video.',
            },

            file: {
                choose: 'Choose file',
                placeholder: 'Select a file',
                current: 'Current file',
            },
        },

        management: {
            edit: 'Edit Product',
            delete: 'Delete Product',
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
            rateLimited: 'Too many attempts. Please wait a few minutes and try again.',
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
    trustedBy: {
        eyebrow: 'INDUSTRIES',
        title: 'Trusted by industry leaders worldwide',
        industries: {
            aerospace: 'Aerospace',
            railway: 'Railway',
            composites: 'Composites',
            wind: 'Wind Energy',
            shipbuilding: 'Shipbuilding',
            oilGas: 'Oil & Gas',
        },
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
