<?php

return [
    // Auth responses
    'login' => [
        'success' => 'Вы успешно вошли в систему',
        'failed' => 'Вход не удался',
    ],
    'logout' => [
        'success' => 'Вы успешно вышли',
        'failed' => 'Не удалось выйти',
    ],
    'auth' => [
        'failed' => 'Аутентификация не удалась',
    ],
    'reset' => [
        'success' => 'Пароль успешно сброшен',
        'failed' => 'Не удалось сбросить пароль',
    ],

    // Product responses
    'product' => [
        'not_found' => 'Товар не найден',
        'get_success' => 'Товары получены успешно',
        'get_failed' => 'Продукты не могут быть получены',
        'create_success' => 'Продукт успешно создан',
        'create_failed' => 'Продукт не может быть создан',
        'update_success' => 'Продукт успешно обновлен',
        'update_failed' => 'Не удалось обновить продукт',
        'delete_success' => 'Товар успешно удален',
        'delete_failed' => 'Товар не может быть удален',
    ],

    // Vendor responses
    'vendor' => [
        'not_found' => 'Поставщик не найден',
        'get_success' => 'Поставщики успешно извлечены',
        'get_failed' => 'Не удалось извлечь поставщиков',
        'create_success' => 'Поставщик успешно создан',
        'create_failed' => 'Не удалось создать поставщика',
        'update_success' => 'Поставщик успешно обновлен',
        'update_failed' => 'Не удалось обновить поставщика',
        'delete_success' => 'Поставщик успешно удален',
        'delete_failed' => 'Не удалось удалить поставщика',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'Транзакция не найдена',
        'get_success' => 'Транзакции успешно восстановлены',
        'get_failed' => 'Не удалось получить транзакции',
        'create_success' => 'Транзакция успешно создана',
        'create_failed' => 'Транзакция не может быть создана',
        'update_success' => 'Транзакция успешно обновлена',
        'update_failed' => 'Транзакция не может быть обновлена',
        'delete_success' => 'Транзакция успешно удалена',
        'delete_failed' => 'Операция не может быть удалена',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'Аккаунты успешно получены',
        'get_failed' => 'Не удалось получить аккаунты',
        'not_found' => 'Аккаунт не найден',
        'create_success' => 'Учетная запись успешно создана',
        'create_error' => 'Аккаунт не может быть создан',
        'update_success' => 'Аккаунт успешно обновлен',
        'update_error' => 'Не удалось обновить аккаунт',
        'delete_success' => 'Учетная запись успешно удалена',
        'delete_error' => 'Аккаунт не может быть удален',
        'get_success' => 'Аккаунт успешно получен',
        'get_error' => 'Аккаунт не может быть получен',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'Счет успешно получен',
        'get_error' => 'Счет не может быть получен',
        'create_success' => 'Счёт успешно создан',
        'create_error' => 'Счет не может быть создан',
        'update_success' => 'Счёт успешно обновлен',
        'update_error' => 'Счет не может быть обновлен',
        'delete_success' => 'Счет успешно удален',
        'delete_error' => 'Счет не может быть удалён',
    ],

    //Customer responses
    'customer' => [
        'get_success' => 'Клиенты успешно извлечены',
        'get_failed' => 'Не удалось получить покупателей',
        'not_found' => 'Клиент не найден',
        'create_failed' => 'Клиент не может быть создан',
        'create_success' => 'Клиент успешно создан',
        'update_success' => 'Клиент успешно обновлен',
        'delete_success' => 'Клиент успешно удален',
    ],

    //Document responses
    'document' => [
        'get_success' => 'Документы успешно восстановлены',
        'get_error' => 'Документы не могут быть получены',
        'not_found' => 'Документ не найден',
        'create_failed' => 'Не удалось создать документ',
        'create_success' => 'Документ был успешно создан',
        'update_success' => 'Документ был успешно обновлен',
        'update_error' => 'Не удалось обновить документ',
        'delete_failed' => 'Документ не может быть успешно удален',
        'delete_success' => 'Документ успешно удален',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'Файл успешно получен',
        'get_error' => 'Не удалось получить файл',
        'not_found' => 'Файл не найден',
        'create_failed' => 'Файл не может быть создан',
        'create_success' => 'Файл успешно создан',
        'update_success' => 'Файл был успешно обновлен',
        'update_failed' => 'Не удалось обновить файл',
        'delete_failed' => 'Файл не может быть успешно удален',
        'delete_success' => 'Файл успешно удален',
        'get_success_folder' => 'Папка успешно восстановлена',
        'get_error_folder' => 'Не удалось получить папки',
        'not_found_folder' => 'Папка не найдена',
        'create_failed_folder' => 'Папка не может быть создана',
        'create_success_folder' => 'Папка успешно создана',
        'update_success_folder' => 'Папка успешно обновлена',
        'update_failed_folder' => 'Папка не может быть обновлена',
        'delete_failed_folder' => 'Папка не может быть удалена',
        'delete_success_folder' => 'Папка успешно удалена',
    ],

    //Estimate responses
    'estimate' => [
        'get_success' => 'Оценки получены успешно',
        'get_failed' => 'Смета не может быть получена',
        'not_found' => 'Оценка не найдена',
        'create_failed' => 'Не удалось создать оценку',
        'create_success' => 'Оценка была успешно создана',
        'convert_success' => 'Оценка была успешно преобразована в счет',
        'update_success' => 'Оценка была успешно обновлена',
        'delete_success' => 'Оценка успешно удалена',
        'delete_failed' => 'Оценка не может быть удалена',
        'update_failed' => 'Не удалось обновить оценку',
        'share_success' => 'Оценки успешно поделились',
        'share_failed' => 'Не удалось поделиться оценкой',
        'accept_reject_success' => 'Оценка была отклонена',
        'send_success' => 'Оценка была успешно отправлена',
        'send_failed' => 'Не удалось отправить расчет',
        'pdf_failed' => 'Создание PDF не удалось',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'Счета получены успешно',
        'get_failed' => 'Счета не могут быть получены',
        'not_found' => 'Счет не найден',
        'create_failed' => 'Счет не может быть создан',
        'create_success' => 'Счет был успешно создан',
        'delete_success' => 'Счёт был успешно удален',
        'update_success' => 'Счет был успешно обновлен',
        'share_success' => 'Счёт успешно поделился',
        'share_failed' => 'Не удалось поделиться оценкой',
        'send_success' => 'Счет успешно отправлен',
        'pdf_failed' => 'Создание PDF не удалось',
        'send_failed' => 'Счет не может быть отправлен',
        'update_failed' => 'Счет не может быть обновлен',
        'delete_failed' => 'Счет не может быть удален',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Stripe не доступен',
        'already_paid' => 'Счет уже оплачен',
        'invalid_key' => 'Неверный ключ API',
        'not_found' => 'Платёж не найден',
        'success' => 'Платеж выполнен успешно',
        'failed' => 'Платеж не удался',
        'paypal_not_available' => 'Paypal недоступен',
        'invoice' => 'Счет',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'Пользователь не найден',
        'update_success' => 'Пользователь успешно обновлен',
        'password_updated' => 'Пароль успешно обновлен',
        'password_not_match' => 'Пароль не совпадает',
        'password_empty' => 'Поле пароля не заполнено',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'Необходимо указать страну',
        'not_enabled' => 'Открытый банкинг не включен',
        'not_found' => 'Открытые банковские операции не найдены',
        'id_required' => 'Требуется ID',
        'not_provided_infos' => 'Не предоставлена информация',
        'requisition_success' => 'Требование выполнено',
        'requisition_failed' => 'Требование не удалось',
        'session_id_required' => 'Требуется ID сессии',
        'account_id_required' => 'Требуется ID аккаунта',
    ],

    'calendar' => [
        'get_success' => 'Событие успешно получено',
        'get_error' => 'Не удалось получить событие',
        'not_found' => 'Событие не найдено',
        'create_failed' => 'Событие не может быть создано',
        'create_success' => 'Событие успешно создано',
        'update_success' => 'Событие было успешно обновлено',
        'update_failed' => 'Событие не может быть обновлено',
        'delete_failed' => 'Событие не может быть удалено',
        'delete_success' => 'Событие успешно удалено',
    ],

    // Email responses
    'email' => [
        'invoice_subject' => 'Счет',
    ],

    'dashboard' => [
        'income' => 'Поступления',
        'expense' => 'Расходы',
    ],

    'months' => [
        'january' => 'Январь',
        'february' => 'Февраль',
        'march' => 'Март',
        'april' => 'Апрель',
        'may' => 'Maj',
        'june' => 'Июнь',
        'july' => 'Июль',
        'august' => 'Август',
        'september' => 'Сентябрь',
        'october' => 'Октябрь',
        'november' => 'Ноябрь',
        'december' => 'Декабрь',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'Роль не найдена',
            'create_failed' => 'Роль не может быть создана',
            'create_success' => 'Роль была успешно создана',
            'update_success' => 'Роль была успешно обновлена',
            'delete_success' => 'Роль успешно удалена',
            'delete_failed' => 'Роль не может быть удалена',
            'super_admin_cannot_be_created' => 'Роль Супер Администратора не может быть создана',
            'super_admin_cannot_be_updated' => 'Роль Супер Администратора не может быть обновлена',
            'super_admin_cannot_be_deleted' => 'Роль Супер Администратора не может быть удалена',
        ],
        'company_logo' => [
            'upload_success' => 'Логотип компании был успешно загружен',
            'upload_failed' => 'Не удалось загрузить логотип компании',
            'remove_success' => 'Логотип компании успешно удален',
            'remove_failed' => 'Логотип компании не может быть удален',
        ],
        'settings' => [
            'update_success' => 'Настройки были успешно обновлены',
            'update_failed' => 'Настройки не могут быть обновлены',
        ],
        'currency' => [
            'not_found' => 'Валюта не найдена',
            'create_failed' => 'Валюта не может быть создана',
            'create_success' => 'Валюта успешно создана',
            'update_success' => 'Валюта успешно обновлена',
            'delete_success' => 'Валюта успешно удалена',
            'delete_failed' => 'Валюты не могут быть удалены',
            'rates_updated' => 'Цены были успешно обновлены',
        ],
        'taxes' => [
            'not_found' => 'Налог не найден',
            'create_failed' => 'Налог не может быть создан',
            'create_success' => 'Налог успешно создан',
            'update_success' => 'Налог был успешно обновлен',
            'delete_success' => 'Налог был успешно удален',
            'delete_failed' => 'Налог не может быть удален',
        ],

        'user' => [
            'not_found' => 'Пользователь не найден',
            'create_failed' => 'Пользователь не может быть создан',
            'create_success' => 'Пользователь успешно создан',
            'update_success' => 'Пользователь успешно обновлен',
            'update_failed' => 'Пользователь не может быть обновлён',
            'delete_success' => 'Пользователь успешно удален',
            'delete_failed' => 'Пользователь не может быть удален',
            'password_reset_success' => 'Пароль успешно сброшен',
            'password_reset_failed' => 'Пароль не может быть сброшен',
            'delete_failed_self_account' => 'Вы не можете удалить свою собственную учетную запись',
        ],
    ],
];
