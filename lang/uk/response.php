<?php

return [
    'success' => 'Успіх',
    'failed' => 'Не вдалося',
    'not_found' => 'Не знайдено',
    'create_success' => 'Створено успішно',
    'create_failed' => 'Не вдалося створити',
    'update_success' => 'Оновлено успішно',
    'update_failed' => 'Не вдалося оновити',
    'delete_success' => 'Успішно вилучено',
    'delete_failed' => 'Не вдалося видалити',
    'get_success' => 'Успішно отримано',
    'get_failed' => 'Не може бути отримано',
    'upload_success' => 'Завантажено успішно',
    'upload_failed' => 'Не вдалося завантажити',
    'remove_success' => 'Успішно видалено',
    'remove_failed' => 'Не вдалося видалити',
    'send_success' => 'Відправлено',
    'send_failed' => 'Не вдалось відправити',
    'share_success' => 'Успішно поширено',
    'share_failed' => 'Не вдалося поділитися',
    'accept_reject_success' => 'Прийнято/відхилено',
    'convert_success' => 'Успішно перетворено',
    'pdf_failed' => 'Не вдалося згенерувати PDF',
    'notification_success' => 'Повідомлення надіслано успішно',
    'notification_failed' => 'Не вдалося надіслати повідомлення',
    'no_key_provided' => 'Немає ключа',
    'ping' => 'API працює',
    // Auth responses
    'login' => [
        'success' => 'Ви успішно увійшли в систему',
        'failed' => 'Помилка входу в систему',
    ],
    'logout' => [
        'success' => 'Ви успішно вийшли з системи',
        'failed' => 'Не вдалося вийти',
    ],
    'auth' => [
        'failed' => 'Помилка аутентифікації',
    ],
    'reset' => [
        'success' => 'Пароль успішно скинуто',
        'failed' => 'Не вдалося скинути пароль',
    ],
    // Product responses
    'product' => [
        'not_found' => 'Товар не знайдено',
        'get_success' => 'Товари успішно отримано',
        'get_failed' => 'Не вдалося отримати товари',
        'create_success' => 'Продукт успішно створено',
        'create_failed' => 'Не вдалося створити товар',
        'update_success' => 'Продукт успішно оновлено',
        'update_failed' => 'Продукт не вдалося оновити',
        'delete_success' => 'Продукт успішно видалено',
        'delete_failed' => 'Товар не може бути видалений',
    ],
    // Partner responses
    'partner' => [
        'not_found' => 'Партнер не знайдено',
        'get_success' => 'Партнери успішно отримано',
        'get_failed' => 'Партнери не можуть бути завантажені',
        'create_success' => 'Партнер успішно створено',
        'create_failed' => 'Не вдалося створити партнера',
        'update_success' => 'Партнер успішно оновлено',
        'update_failed' => 'Партнер не вдалося оновити',
        'delete_success' => 'Партнер успішно видалено',
        'delete_failed' => 'Партнер не може бути видалений',
    ],
    // Transaction responses
    'transaction' => [
        'not_found' => 'Транзакцію не знайдено',
        'get_success' => 'Транзакції успішно отримано',
        'get_failed' => 'Транзакції не можуть бути завантажені',
        'create_success' => 'Транзакція успішно створена',
        'create_failed' => 'Не вдалося створити транзакцію',
        'update_success' => 'Транзакція успішно змінена',
        'update_failed' => 'Не вдалося оновити транзакцію',
        'delete_success' => 'Транзакція успішно видалена',
        'delete_failed' => 'Операція не може бути видалена',
    ],
    //Account responses
    'accounts' => [
        'get_success' => 'Облікові записи отримано успішно',
        'get_failed' => 'Облікові записи не можуть бути завантажені',
        'not_found' => 'Аккаунт не знайдено',
        'create_success' => 'Обліковий запис успішно створено',
        'create_error' => 'Не вдалося створити обліковий запис',
        'update_success' => 'Обліковий запис успішно оновлено',
        'update_error' => 'Не вдалося оновити обліковий запис',
        'delete_success' => 'Обліковий запис видалено успішно',
        'delete_error' => 'Неможливо видалити обліковий запис',
        'get_success' => 'Обліковий запис отримано успішно',
        'get_error' => 'Не вдалося отримати рахунок',
        'delete_default_account' => 'Обліковий запис за замовчуванням не можна видалити',
    ],
    //Bill responses
    'bill' => [
        'get_success' => 'Рахунок отримано успішно',
        'get_error' => 'Рахунок не може бути відновлений',
        'create_success' => 'Рахунок успішно створений',
        'create_error' => 'Рахунок не може бути створений',
        'update_success' => 'Рахунок успішно оновлено',
        'update_error' => 'Рахунок не може бути оновлений',
        'delete_success' => 'Рахунок видалено успішно',
        'delete_error' => 'Рахунок не може бути видалений успішно',
    ],
    //Document responses
    'document' => [
        'get_success' => 'Документи успішно отримано',
        'get_error' => 'Не вдалося отримати документи',
        'not_found' => 'Документ не знайдено',
        'create_failed' => 'Документ не вдалося створити',
        'create_success' => 'Документ успішно створено',
        'update_success' => 'Документ успішно оновлено',
        'update_error' => 'Документ не вдалося оновити',
        'delete_failed' => 'Документ не вдалося видалити',
        'delete_success' => 'Документ успішно видалено',
    ],
    // Employee responses
    'employee' => [
        'not_found' => 'Співробітника не знайдено',
        'get_success' => 'Співробітники успішно отримали',
        'get_failed' => 'Співробітники не можуть бути відновлені',
        'create_success' => 'Співробітник успішно створений',
        'create_failed' => 'Не вдалося створити співробітника',
        'update_success' => 'Співробітник успішно оновлений',
        'update_failed' => 'Співробітник не зміг оновити',
        'delete_success' => 'Співробітник успішно видалено',
        'delete_failed' => 'Співробітник не може бути видалений',
    ],
    // Archive responses
    'archive' => [
        'get_success' => 'Файл отримано успішно',
        'get_error' => 'Файл не може бути отриманий',
        'not_found' => 'Файл не знайдено',
        'create_failed' => 'Створення файлу не вдалося',
        'create_success' => 'Файл був успішно створений',
        'update_success' => 'Файл успішно оновлено',
        'update_failed' => 'Не вдалося оновити файл',
        'delete_failed' => 'Файл не може бути видалений успішно',
        'delete_success' => 'Файл успішно видалено',
        'get_success_folder' => 'Папку успішно отримано',
        'get_error_folder' => 'Папки не можуть бути відновлені',
        'not_found_folder' => 'Папку не знайдено',
        'create_failed_folder' => 'Не вдалося створити папку',
        'create_success_folder' => 'Папку успішно створено',
        'update_success_folder' => 'Папка успішно оновлена',
        'update_failed_folder' => 'Не вдалося оновити папку',
        'delete_failed_folder' => 'Папка не може бути видалена успішно',
        'delete_success_folder' => 'Папка успішно видалена',
    ],
    //Quote responses
    'quote' => [
        'get_success' => 'Цитати успішно отримані',
        'get_failed' => 'Цитати не вдалося отримати',
        'not_found' => 'Цитату не знайдено',
        'create_failed' => 'Цитату не вдалося створити',
        'create_success' => 'Цитату успішно створено',
        'convert_success' => 'Котирування перетворено в рахунок успішно',
        'update_success' => 'Цитату було успішно оновлено',
        'delete_success' => 'Цитата була успішно видалена',
        'delete_failed' => 'Цитувати не вдалося видалити',
        'update_failed' => 'Цитату не вдалося оновити',
        'share_success' => 'Цитату було успішно поділено',
        'share_failed' => 'Цитувати не можна надіслати',
        'accept_reject_success' => 'Цитату успішно відхилено',
        'send_success' => 'Котирування було успішно відправлено',
        'send_failed' => 'Цитувати не вдалося відправити',
        'pdf_failed' => 'Не вдалося згенерувати PDF',
    ],
    // Support ticket message responses
    'support_ticket_message' => [
        'get_success' => 'Повідомлення про технічну підтримку отримано успішно',
        'get_failed' => 'Не вдалося отримати повідомлення заявок із підтримкою',
        'not_found' => 'Не вдалося знайти повідомлення Заявки на підтримку',
        'create_failed' => 'Не вдалося створити повідомлення тікету підтримки',
        'create_success' => 'Повідомлення тікету підтримки успішно створено',
        'update_success' => 'Повідомлення тікету підтримки успішно оновлено',
        'update_failed' => 'Не вдалося оновити повідомлення Заявки на підтримку',
        'delete_failed' => 'Повідомлення тікету підтримки не може бути успішно видаленим',
        'delete_success' => 'Повідомлення тікету підтримки успішно видалено',
    ],
    //Invoice responses
    'invoice' => [
        'get_success' => 'Рахунок отримано успішно',
        'get_failed' => 'Неможливо отримати рахунки',
        'not_found' => 'Рахунок не знайдено',
        'create_failed' => 'Не вдалося створити рахунок',
        'create_success' => 'Рахунок створено',
        'delete_success' => 'Рахунок видалено успішно',
        'update_success' => 'Рахунок був успішно оновлений',
        'share_success' => 'Рахунок було успішно поділено',
        'share_failed' => 'Цитувати не можна надіслати',
        'send_success' => 'Рахунок відправлено успішно',
        'pdf_failed' => 'Не вдалося згенерувати PDF',
        'send_failed' => 'Не можливо надіслати рахунок',
        'update_failed' => 'Неможливо оновити рахунок',
        'delete_failed' => 'Рахунок не може бути видалений',
        'transaction_success' => 'Транзакція була успішно додана',
        'notification_success' => 'Повідомлення надіслано успішно',
        'notification_failed' => 'Не вдалося надіслати повідомлення',
    ],
    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Смуга недоступна',
        'already_paid' => 'Рахунок вже сплачено',
        'invalid_key' => 'Неправильний ключ API',
        'not_found' => 'Платіж не знайдено',
        'success' => 'Успішний платіж',
        'failed' => 'Не вдалося оплатити',
        'paypal_not_available' => 'PayPal не доступний',
        'invoice' => 'Інвойс',
    ],
    //Support ticket responses
    'support_ticket' => [
        'get_success' => 'Заявки успішно отримано',
        'get_failed' => 'Не вдалося отримати квитки підтримки',
        'not_found' => 'Тікет не знайдено',
        'create_failed' => 'Не вдалося створити квиток на підтримку',
        'create_success' => 'Тікет технічної підтримки був успішно створений',
        'update_success' => 'Заявка успішно оновлена',
        'update_failed' => 'Не вдалося оновити квиток до служби підтримки',
        'delete_failed' => 'Квиток підтримки не може бути видалений',
        'delete_success' => 'Тікет технічної підтримки успішно видалено',
        'get_number_success' => 'Номер Заявки успішно отримано',
        'get_number_failed' => 'Не вдалося отримати номер квитка на підтримку',
        'send_success' => 'Повідомлення про заявку у службу підтримки успішно відправлено',
        'send_failed' => 'Не вдалося надіслати повідомлення на квиток підтримки',
        'share_success' => 'Заявку на підтримку успішно поділено',
        'share_failed' => 'Не вдалося поділитися квитком підтримки',
    ],
    //Profile responses
    'user' => [
        'not_found' => 'Користувач не знайдений',
        'update_success' => 'Користувача було успішно оновлено',
        'password_updated' => 'Пароль було успішно оновлено',
        'password_not_match' => 'Пароль не збігається',
        'password_empty' => 'Пусте поле для введення пароля',
        'avatar_deleted' => 'Аватар був успішно видалений',
        'avatar_not_found' => 'Аватар не знайдено',
        'avatar_updated' => 'Аватар був успішно оновлений',
    ],
    // Open Banking responses
    'open_banking' => [
        'country_required' => 'Країна обов\'язкова',
        'not_enabled' => 'Відкрита банківська справа не ввімкнена',
        'not_found' => 'Відкрита банківська справа не знайдена',
        'id_required' => 'ID обов\'язковий',
        'not_provided_infos' => 'Не надано відомості',
        'requisition_success' => 'Успішність у потребі',
        'requisition_failed' => 'Невдале лікування',
        'session_id_required' => 'Необхідно вказати ID сесії',
        'account_id_required' => 'Необхідно вказати ID рахунку',
    ],
    // Calendar responses
    'calendar' => [
        'get_success' => 'Подію отримано успішно',
        'get_error' => 'Подія не може бути отримана',
        'not_found' => 'Подію не знайдено',
        'create_failed' => 'Подію не вдалося створити',
        'create_success' => 'Подію успішно створено',
        'update_success' => 'Подію успішно оновлено',
        'update_failed' => 'Подію не вдалося оновити',
        'delete_failed' => 'Подія не може бути видалена успішно',
        'delete_success' => 'Подію видалено успішно',
    ],
    'department' => [
        'get_success' => 'Відділ успішно отримано',
        'get_error' => 'Не вдалося отримати відділ',
        'not_found' => 'Відділ не знайдено',
        'create_failed' => 'Не вдалося створити відділ',
        'create_success' => 'Відділ був успішно створений',
        'update_success' => 'Відділ був успішно оновлений',
        'update_failed' => 'Не вдалося оновити відділ',
        'delete_failed' => 'Відділ не може бути видалений успішно',
        'delete_success' => 'Відділ успішно видалено',
    ],
    // Email responses
    'email' => [
        'invoice_subject' => 'Інвойс',
    ],
    'dashboard' => [
        'income' => 'Дохід',
        'expense' => 'Витрати',
    ],
    // Months
    'months' => [
        'january' => 'Січень',
        'february' => 'Лютий',
        'march' => 'Березень',
        'april' => 'Квітень',
        'may' => 'Maj',
        'june' => 'Червень',
        'july' => 'Липень',
        'august' => 'Серпень',
        'september' => 'Вересні',
        'october' => 'Жовтень',
        'november' => 'Листопад',
        'december' => 'Грудень',
    ],
    //  Admin responses
    'admin' => [
        'role' => [
            'not_found' => 'Роль не знайдена',
            'create_failed' => 'Не вдалося створити роль',
            'create_success' => 'Роль була успішно створена',
            'update_success' => 'Роль була успішно оновлена',
            'delete_success' => 'Роль успішно видалена',
            'delete_failed' => 'Роль не вдалося видалити',
            'super_admin_cannot_be_created' => 'Не вдалося створити роль супер адміністратора',
            'super_admin_cannot_be_updated' => 'Неможливо оновити Супер адміністратор роль',
            'super_admin_cannot_be_deleted' => 'Неможливо видалити роль супер адміністратора',
        ],
        'company_logo' => [
            'upload_success' => 'Логотип компанії успішно завантажено',
            'upload_failed' => 'Не вдалося завантажити логотип компанії',
            'remove_success' => 'Логотип компанії успішно видалено',
            'remove_failed' => 'Логотип компанії не вдалося видалити',
        ],
        'settings' => [
            'update_success' => 'Налаштування були успішно оновлені',
            'update_failed' => 'Налаштування не вдалося оновити',
        ],
        'currency' => [
            'not_found' => 'Валюта не знайдена',
            'create_failed' => 'Неможливо створити валюту',
            'create_success' => 'Валюта була успішно створена',
            'update_success' => 'Валюту було успішно оновлено',
            'delete_success' => 'Валюту було успішно видалено',
            'delete_failed' => 'Валюта не може бути видалена',
            'rates_updated' => 'Курси було успішно оновлено',
        ],
        'taxes' => [
            'not_found' => 'Податок не знайдено',
            'create_failed' => 'Не вдалося створити податок',
            'create_success' => 'Податок створено',
            'update_success' => 'Податок було успішно оновлено',
            'delete_success' => 'Податок видалено успішно',
            'delete_failed' => 'Податок не може бути видалено',
        ],
        'user' => [
            'not_found' => 'Користувач не знайдений',
            'create_failed' => 'Не вдалося створити користувача',
            'create_success' => 'Користувача успішно створено',
            'update_success' => 'Користувача було успішно оновлено',
            'update_failed' => 'Не вдалося оновити користувача',
            'delete_success' => 'Користувач був успішно видалений',
            'delete_failed' => 'Користувач не може бути видалений',
            'password_reset_success' => 'Пароль було успішно скинуто',
            'password_reset_failed' => 'Пароль не може бути скинутий',
            'delete_failed_self_account' => 'Ви не можете видалити свій власний обліковий запис',
        ],
        'email' => [
            'test_email_sent' => 'Тестове повідомлення надіслано успішно',
            'test_email_failed' => 'Неможливо надіслати тестове повідомлення',
        ],
    ],
    'memory_used' => 'Використано пам\'яті',
    'memory_available' => 'Доступно пам’яті',
    'disk_used' => 'Використаний диск',
    'disk_available' => 'Диск доступний',
];
