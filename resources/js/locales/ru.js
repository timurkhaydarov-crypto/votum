import diplomas from '../modules/site/constants/diplomas.js';
import about from './ru/about.js';
import services from './ru/services.js';
export default {
    ...about,
    ...services,
    actions: {
        accept: 'Принять',
        add: 'Добавить',
        approve: 'Одобрить',
        back: 'Назад',
        cancel: 'Отмена',
        close: 'Закрыть',
        confirm: 'Подтвердить',
        continue: 'Продолжить',
        copy: 'Копировать',
        create: 'Создать',
        decline: 'Отклонить',
        delete: 'Удалить',
        disable: 'Отключить',
        download: 'Скачать',
        edit: 'Изменить',
        enable: 'Включить',
        finish: 'Завершить',
        lock: 'Заблокировать',
        next: 'Далее',
        no: 'Нет',
        open: 'Открыть',
        pause: 'Пауза',
        refresh: 'Обновить',
        reject: 'Отклонить',
        remove: 'Удалить',
        reset: 'Сбросить',
        resume: 'Продолжить',
        retry: 'Повторить',
        save: 'Сохранить',
        search: 'Поиск',
        select: 'Выбрать',
        send: 'Отправить',
        start: 'Запустить',
        stop: 'Остановить',
        submit: 'Отправить',
        unlock: 'Разблокировать',
        update: 'Обновить',
        upload: 'Загрузить',
        view: 'Просмотреть',
        yes: 'Да',
    },

    cart: {
        eyebrow: 'ЗАЯВКА',
        title: 'Заявка',
        description: 'Выберите необходимое оборудование, чтобы сформировать единую заявку.',
        decrease: 'Уменьшить количество',
        increase: 'Увеличить количество',
        add: 'Добавить в заявку',
        adding: 'Добавление...',
        inCart: 'В заявке',

        selected: 'Выбранное оборудование',

        product: 'товар',
        products: 'товаров',
        items: 'позиций',

        quantity: 'Количество',
        total: 'Всего',

        remove: 'Удалить',
        removing: 'Удаление...',

        updating: 'Обновление...',

        clear: 'Очистить заявку',
        clearing: 'Очистка...',

        checkout: 'Перейти к оформлению',

        loading: 'Загрузка заявки...',
        error: 'Не удалось выполнить действие',

        item: {
            available: 'Доступно',
            maxQuantity: 'Достигнуто максимальное доступное количество',
        },

        empty: {
            title: 'Ваша заявка пока пуста',
            description: 'Выберите оборудование из каталога, чтобы добавить его в заявку.',
            viewProducts: 'Перейти к продукции',
        },

        summary: {
            label: 'ЗАЯВКА',
            title: 'Итог заявки',
            products: 'Позиций',
            quantity: 'Количество',
            total: 'Всего единиц',
            clear: 'Очистить заявку',
            clearing: 'Очистка...',
            checkout: 'Перейти к оформлению',
        },
    },

    common: {
        pcs: 'шт.',
        all: 'Все',
        more: 'Подробнее',
        less: 'Свернуть',
        showAll: 'Показать всё',
        showMore: 'Показать ещё',
        collapse: 'Свернуть',
        available: 'Доступно',
        unavailable: 'Недоступно',
        notAvailable: 'Нет данных',
        empty: 'Нет данных',
        byRequest: 'По запросу',
        close: 'Закрыть',
        copyright: 'Все права защищены.',
    },

    contacts: {
        address: 'Адрес',
        email: 'Email',
        mail: 'Почта',
        phone: 'Телефон',
        workTime: 'Время работы',
        department: 'Отдел',
        selectDepartment: 'Выберите отдел',
        socialMedia: 'Социальные сети',
        timeMask: 'ЧЧ:ММ',
        weekDay: 'День недели',
        operatingHours: 'Часы работы',
        url: 'URL',
        eyebrow: 'Контакты',
        title: 'Свяжитесь с нами',
        description:
            'Центральный офис ТЕХНОВОТУМ и официальные представители компании в разных странах мира.',
        centralOffice: {
            label: 'Центральный офис',
            title: 'Москва, Зеленоград',
            addressLabel: 'Адрес',
            address: '124489, Москва, Зеленоград, Сосновая аллея, д. 6А, стр. 1',
            phoneLabel: 'Телефоны',
            emailLabel: 'Электронная почта',
            openMap: 'Открыть на карте',
            imageAlt: 'Центральный офис ТЕХНОВОТУМ',
            caption: 'Центральный офис',
            hoursLabel: 'Время работы',
        },
        dealers: {
            eyebrow: 'Дилерская сеть',
            title: 'Наши представители',
            description:
                'Официальные представители и партнеры ТЕХНОВОТУМ в странах СНГ, Европы, Азии и Африки.',
            noInformation: 'Информация отсутствует',
            informationComingSoon: 'Контактная информация уточняется.',
            location: 'точка',
            locations: 'точек',
            countries: {
                kazakhstan: 'Казахстан',
                latvia: 'Латвия',
                uzbekistan: 'Узбекистан',
                china: 'Китай',
                estonia: 'Эстония',
                uganda: 'Уганда',
                tajikistan: 'Таджикистан',
                belarus: 'Беларусь',
                turkmenistan: 'Туркменистан',
                kyrgyzstan: 'Кыргызстан',
            },
        },

        map: {
            eyebrow: 'Мы на карте',
            title: 'Центральный офис ТЕХНОВОТУМ',
            iframeTitle: 'Центральный офис ТЕХНОВОТУМ на карте',
            openExternal: 'Открыть карту в новом окне',
        },

        cta: {
            eyebrow: 'ТЕХНОВОТУМ',
            title: 'Ищете оборудование для неразрушающего контроля?',
            description:
                'Ознакомьтесь с каталогом оборудования или отправьте заявку на интересующие вас решения.',
            button: 'Перейти к продукции',
        },
    },

    certificates: {
        eyebrow: 'СЕРТИФИКАТЫ',
        title: 'Сертификаты продукции',
        description:
            'Сертификаты и документы, подтверждающие соответствие продукции применимым стандартам.',
        empty: 'Сертификаты отсутствуют',
    },

    diplomas: {
        eyebrow: 'ДИПЛОМЫ И СЕРТИФИКАТЫ',
        title: 'Дипломы и сертификаты',
        description:
            'Документы, подтверждающие участие ТЕХНОВОТУМ в профессиональных выставках, форумах и отраслевых мероприятиях.',
        empty: 'Дипломы отсутствуют',
    },

    gallery: {
        title: 'Фотогалерея',
        description: 'Визуальный обзор оборудования.',
        empty: 'Изображения отсутствуют',
        image: 'Изображение',
        certificate: 'Сертификат',
        diploma: 'Диплом',
        document: 'Документ',
        photo: 'Фото',
    },

    compatibleProducts: {
        label: 'СОВМЕСТИМАЯ ПРОДУКЦИЯ',
        title: 'Совместимая продукция',
        description:
            'Оборудование, совместимое с данным прибором и предназначенное для работы с ним.',
        categories: {
            industrialNdt: 'Промышленный НК',
            flawDetectors: 'Дефектоскопы',
            scanningDevices: 'Сканирующие устройства',
            transducers: 'Преобразователи',
            referenceStandards: 'Стандартные образцы',
        },
        empty: {
            title: 'Совместимая продукция отсутствует',
            text: 'Для данного оборудования совместимая продукция не найдена.',
        },
        product: {
            one: 'товар',
            few: 'товара',
            many: 'товаров',
        },
    },

    productDetail: {
        subtitle: 'Подробная информация о приборе неразрушающего контроля',
        noData: 'Информация о товаре отсутствует.',
    },

    product: {
        articleFallback: 'АРТИКУЛ НЕ УКАЗАН',
        inStock: 'В наличии',
        outOfStock: 'Нет в наличии',
        noName: 'Без названия',
        defaultDescription: 'Профессиональное оборудование для неразрушающего контроля.',
        priceOnRequest: 'По запросу',
        pdf: 'PDF-документ',

        video: {
            playing: 'Воспроизведение',
            photo: 'Фото',
            video: 'Видео',
        },

        info: {
            eyebrow: 'ИНФОРМАЦИЯ',

            details: {
                title: 'Подробная информация',
            },

            features: {
                title: 'Функциональные возможности',
            },

            specifications: {
                title: 'Технические характеристики',
                value: 'Значение',
                empty: 'Технические характеристики отсутствуют',
            },

            documentation: {
                title: 'Документация',
                open: 'Открыть документ',
            },
        },

        technical: {
            frequency: 'Диапазон частот',
            display: 'Дисплей',
            channels: 'Количество каналов',
            dynamicRange: 'Динамический диапазон',
            measurementRange: 'Диапазон измерений',
            resolution: 'Разрешение',
            dimensions: 'Габариты',
            weight: 'Масса',
            power: 'Питание',
        },

        documents: {
            characteristics: 'Технические характеристики',
            certificates: 'Сертификаты',
            documentation: 'Документация',
            software: 'Программное обеспечение',
        },
    },

    productCard: {
        badgeFallback: 'Ультразвуковой контроль',
        untitledProduct: 'Без названия',
        noDescription: 'Описание отсутствует',
        inStock: 'В наличии',
        outOfStock: 'Нет в наличии',
        method: 'Метод',
        frequency: 'Частота',
        display: 'Дисплей',
        application: 'Применение',
        price: 'Цена',
        byRequest: 'По запросу',
        viewProduct: 'Подробнее',
        addToCart: 'Добавить в корзину',
        addToFavorites: 'Добавить в избранное',
    },

    productGrid: {
        all: 'Все',
    },

    productPages: {
        groupTitle: 'Группа: {group}',
        groupSubtitle: 'Товары группы в категории {category}',
    },

    hero: {
        badge: 'Производитель оборудования НК',
        titleBefore: 'Мы создаём',
        titleGradient: 'будущее НК',
        subtitle:
            'Производитель оборудования для неразрушающего контроля мирового уровня. Разработка, прототипирование и серийное производство выполняются на собственных производственных площадках — от ультразвуковых дефектоскопов до современных систем с фазированными решётками.',

        requestQuote: 'Запросить предложение',
        viewProducts: 'Смотреть продукцию',

        meta: {
            location: {
                value: 'Москва, Россия',
                label: 'Расположение',
            },
            production: {
                value: 'Собственное',
                label: 'Разработка и производство',
            },
        },

        scanner: {
            live: 'Сканирование',
            scanActive: 'Контроль НК активен',
            system: 'Ультразвуковая система контроля',
        },

        stats: {
            tests: {
                value: '18 000+',
                label: 'Сертифицированных испытаний',
            },
            industry: {
                value: 'Авиация',
                label: 'и железная дорога',
                status: 'Сертифицировано',
            },
            certificates: {
                value: '5 CE',
                label: 'Сертификатов',
            },
        },
    },

    logo: {
        title: 'ТЕХНОВОТУМ',
        subtitle: 'Технологии неразрушающего контроля',
    },

    menu: {
        home: 'Главная',
        about: 'О компании',
        services: 'Услуги',
        products: 'Продукция',
        cart: 'Корзина',
        contacts: 'Контакты',
    },

    megaMenu: {
        categories: 'Категории',
        allProducts: 'Вся продукция',
        allServices: 'Все услуги',
        chooseCategory: 'Выберите категорию',
        showAllProducts: 'Показать всю продукцию',
        showAllCategory: 'Показать всю категорию',
        showAllGroup: 'Показать всю группу',
        allCategory: 'Все категории',
        details: 'Подробнее',
        contactUs: 'Связаться с нами',
        noProducts: 'Продукция отсутствует',
        chooseDevice: 'Выберите устройство',
        deviceHint: 'Выберите устройство из списка, чтобы увидеть краткое описание.',
        deviceDefault: 'Устройство',
        deviceDescription: 'Профессиональное устройство для {product} и точного контроля качества.',
        needHelpTitle: 'Нужна помощь в выборе оборудования?',
        needHelpDescription: 'Наши специалисты помогут подобрать подходящее решение',
        allServicesInCategory: 'Все услуги {category}',
    },

    productBreadcrumbs: {
        catalog: 'Каталог',
        productFallback: 'Товар №{id}',
        backToCatalog: 'Вернуться в каталог',
        backToCategory: 'Вернуться в категорию: {category}',
        backToGroup: 'Вернуться в группу: {group}',
    },

    messages: {
        confirm: {
            delete: 'Вы уверены, что хотите удалить этот элемент? Это действие нельзя отменить.',
        },
        success: {
            update: 'Элемент успешно обновлён',
            create: 'Элемент успешно создан',
            delete: 'Элемент успешно удалён',
            default: 'Действие успешно выполнено',
        },
        fail: {
            update: 'Не удалось обновить элемент',
            create: 'Не удалось создать элемент',
            delete: 'Не удалось удалить элемент',
            default: 'Не удалось выполнить действие',
        },
    },

    request: {
        eyebrow: 'ОФОРМЛЕНИЕ ЗАЯВКИ',
        title: 'Отправить заявку',
        description:
            'Заполните контактные данные, и наши специалисты свяжутся с вами для уточнения деталей.',
        backToCart: 'Вернуться к заявке',

        form: {
            label: 'КОНТАКТНЫЕ ДАННЫЕ',
            title: 'Ваши данные',
            description: 'Укажите контактную информацию для связи с вами.',
            name: 'Имя',
            namePlaceholder: 'Введите ваше имя',
            phone: 'Телефон',
            phonePlaceholder: '+7 (___) ___-__-__',
            email: 'Email',
            emailPlaceholder: 'nameexample.com',
            comment: 'Комментарий',
            commentPlaceholder: 'Дополнительная информация, вопросы или пожелания...',
            submit: 'Отправить заявку',
            sending: 'Отправка...',
            privacy: 'Нажимая кнопку, вы соглашаетесь на обработку предоставленных данных.',
            emptyCart: 'Заявка пуста. Добавьте оборудование из каталога.',
            submitError: 'Не удалось отправить заявку. Попробуйте ещё раз.',
        },

        summary: {
            label: 'ВЫБРАННОЕ ОБОРУДОВАНИЕ',
            title: 'Состав заявки',
        },

        success: {
            title: 'Заявка отправлена',
            description:
                'Спасибо! Ваша заявка успешно отправлена. Наш специалист свяжется с вами в ближайшее время.',
            numberLabel: 'Номер заявки',
            backToProducts: 'Вернуться к продукции',
            close: 'Закрыть',
        },
    },

    periods: {
        from: 'С',
        to: 'До',
    },

    validation: {
        select: {
            required: 'Выберите значение',
        },
        input: {
            required: 'Введите значение',
        },
        email: 'Введите корректный адрес электронной почты',
        phone: 'Введите корректный номер телефона',
    },

    weekdays: {
        monday: 'пн.',
        tuesday: 'вт.',
        wednesday: 'ср.',
        thursday: 'чт.',
        friday: 'пт.',
        saturday: 'сб.',
        sunday: 'вс.',
    },
};
