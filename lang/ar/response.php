<?php

return [
    // Auth responses
    'login' => [
        'success' => 'لقد قمت بتسجيل الدخول بنجاح',
        'failed' => 'فشل تسجيل الدخول',
    ],
    'logout' => [
        'success' => 'لقد قمت بتسجيل الخروج بنجاح',
        'failed' => 'فشل تسجيل الخروج',
    ],
    'auth' => [
        'failed' => 'فشل المصادقة',
    ],
    'reset' => [
        'success' => 'تم إعادة تعيين كلمة المرور بنجاح',
        'failed' => 'فشل إعادة تعيين كلمة المرور',
    ],

    // Product responses
    'product' => [
        'not_found' => 'لم يتم العثور على المنتج',
        'get_success' => 'تم استرداد المنتجات بنجاح',
        'get_failed' => 'تعذر استرداد المنتجات',
        'create_success' => 'تم إنشاء المنتج بنجاح',
        'create_failed' => 'تعذر إنشاء منتج',
        'update_success' => 'تم تحديث المنتج بنجاح',
        'update_failed' => 'لا يمكن تحديث المنتج',
        'delete_success' => 'تم حذف المنتج بنجاح',
        'delete_failed' => 'لا يمكن حذف منتج',
    ],

    // Partner responses
    'partner' => [
        'not_found' => 'لم يتم العثور على شريك',
        'get_success' => 'تم استرجاع الشركاء بنجاح',
        'get_failed' => 'لا يمكن استرجاع الشركاء',
        'create_success' => 'تم إنشاء الشريك بنجاح',
        'create_failed' => 'لا يمكن إنشاء شريك',
        'update_success' => 'تم تحديث الشريك بنجاح',
        'update_failed' => 'تعذر تحديث شريك',
        'delete_success' => 'تم حذف الشريك بنجاح',
        'delete_failed' => 'لا يمكن حذف شريك',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'لم يتم العثور على المعاملة',
        'get_success' => 'تم استرداد المعاملات بنجاح',
        'get_failed' => 'لا يمكن استرداد المعاملات',
        'create_success' => 'تم إنشاء المعاملة بنجاح',
        'create_failed' => 'لا يمكن إنشاء معاملة',
        'update_success' => 'تم تحديث المعاملة بنجاح',
        'update_failed' => 'لا يمكن تحديث المعاملة',
        'delete_success' => 'تم حذف المعاملة بنجاح',
        'delete_failed' => 'لا يمكن حذف المعاملة',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'تم استرداد الحسابات بنجاح',
        'get_failed' => 'تعذر استرداد الحسابات',
        'not_found' => 'تعذر العثور على الحساب',
        'create_success' => 'تم إنشاء الحساب بنجاح',
        'create_error' => 'تعذر إنشاء الحساب',
        'update_success' => 'تم تحديث الحساب بنجاح',
        'update_error' => 'تعذر تحديث الحساب',
        'delete_success' => 'تم حذف الحساب بنجاح',
        'delete_error' => 'لا يمكن حذف الحساب',
        'get_success' => 'تم استرداد الحساب بنجاح',
        'get_error' => 'تعذر استرداد الحساب',
        'delete_default_account' => 'لا يمكن حذف الحساب الافتراضي',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'تم استرجاع بيل بنجاح',
        'get_error' => 'تعذر استرداد الفاتورة',
        'create_success' => 'تم إنشاء بيل بنجاح',
        'create_error' => 'لا يمكن إنشاء بيل',
        'update_success' => 'تم تحديث بيل بنجاح',
        'update_error' => 'تعذر تحديث مشروع القانون',
        'delete_success' => 'تم حذف بيل بنجاح',
        'delete_error' => 'لا يمكن حذف الفاتورة بنجاح',
    ],

    //Document responses
    'document' => [
        'get_success' => 'تم استرجاع المستندات بنجاح',
        'get_error' => 'تعذر استرجاع الوثائق',
        'not_found' => 'تعذر العثور على المستند',
        'create_failed' => 'لا يمكن إنشاء المستند',
        'create_success' => 'تم إنشاء المستند بنجاح',
        'update_success' => 'تم تحديث المستند بنجاح',
        'update_error' => 'تعذر تحديث الوثيقة',
        'delete_failed' => 'تعذر حذف المستند بنجاح',
        'delete_success' => 'تم حذف المستند بنجاح',
    ],

    // Employee responses
    'employee' => [
        'not_found' => 'الموظف غير موجود',
        'get_success' => 'تم استرجاع الموظفين بنجاح',
        'get_failed' => 'تعذر استرجاع الموظفين',
        'create_success' => 'تم إنشاء الموظف بنجاح',
        'create_failed' => 'تعذر إنشاء موظف',
        'update_success' => 'تم تحديث الموظف بنجاح',
        'update_failed' => 'تعذر تحديث الموظف',
        'delete_success' => 'تم حذف الموظف بنجاح',
        'delete_failed' => 'لا يمكن حذف موظف',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'تم استرداد الملف بنجاح',
        'get_error' => 'تعذر استرداد الملف',
        'not_found' => 'تعذر العثور على الملف',
        'create_failed' => 'تعذر إنشاء الملف',
        'create_success' => 'تم إنشاء الملف بنجاح',
        'update_success' => 'تم تحديث الملف بنجاح',
        'update_failed' => 'تعذر تحديث الملف',
        'delete_failed' => 'تعذر حذف الملف بنجاح',
        'delete_success' => 'تم حذف الملف بنجاح',
        'get_success_folder' => 'تم استرداد المجلد بنجاح',
        'get_error_folder' => 'تعذر استرداد المجلدات',
        'not_found_folder' => 'تعذر العثور على المجلد',
        'create_failed_folder' => 'تعذر إنشاء المجلد',
        'create_success_folder' => 'تم إنشاء المجلد بنجاح',
        'update_success_folder' => 'تم تحديث المجلد بنجاح',
        'update_failed_folder' => 'تعذر تحديث المجلد',
        'delete_failed_folder' => 'تعذر حذف المجلد بنجاح',
        'delete_success_folder' => 'تم حذف المجلد بنجاح',
    ],

    //Quote responses
    'quote' => [
        'get_success' => 'تم استرداد الأسعار بنجاح',
        'get_failed' => 'تعذر استرداد الأسعار',
        'not_found' => 'تعذر العثور على عرض الأسعار',
        'create_failed' => 'تعذر إنشاء عرض الأسعار',
        'create_success' => 'تم إنشاء عرض الأسعار بنجاح',
        'convert_success' => 'تم تحويل عرض الأسعار إلى فاتورة بنجاح',
        'update_success' => 'تم تحديث الاقتباس بنجاح',
        'delete_success' => 'تم حذف الاقتباس بنجاح',
        'delete_failed' => 'لا يمكن حذف الاقتباس',
        'update_failed' => 'تعذر تحديث عرض الأسعار',
        'share_success' => 'تم مشاركة عرض الأسعار بنجاح',
        'share_failed' => 'لا يمكن مشاركة الاقتباس',
        'accept_reject_success' => 'تم رفض الاقتباس بنجاح',
        'send_success' => 'تم إرسال عرض الأسعار بنجاح',
        'send_failed' => 'تعذر إرسال عرض الأسعار',
        'pdf_failed' => 'فشل توليد PDF',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'الفواتير المستردة بنجاح',
        'get_failed' => 'تعذر استرداد الفواتير',
        'not_found' => 'تعذر العثور على الفاتورة',
        'create_failed' => 'تعذر إنشاء الفاتورة',
        'create_success' => 'تم إنشاء الفاتورة بنجاح',
        'delete_success' => 'تم حذف الفاتورة بنجاح',
        'update_success' => 'تم تحديث الفاتورة بنجاح',
        'share_success' => 'تم مشاركة الفاتورة بنجاح',
        'share_failed' => 'لا يمكن مشاركة الاقتباس',
        'send_success' => 'تم إرسال الفاتورة بنجاح',
        'pdf_failed' => 'فشل توليد PDF',
        'send_failed' => 'تعذر إرسال الفاتورة',
        'update_failed' => 'تعذر تحديث الفاتورة',
        'delete_failed' => 'لا يمكن حذف الفاتورة',
        'transaction_success' => 'تمت إضافة المعاملة بنجاح',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'الشريط غير متوفر',
        'already_paid' => 'تم دفع الفاتورة مسبقاً',
        'invalid_key' => 'مفتاح API غير صالح',
        'not_found' => 'تعذر العثور على الدفع',
        'success' => 'تم الدفع بنجاح',
        'failed' => 'فشل الدفع',
        'paypal_not_available' => 'باي بال غير متوفر',
        'invoice' => 'فاتورة',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'تعذر العثور على المستخدم',
        'update_success' => 'تم تحديث المستخدم بنجاح',
        'password_updated' => 'تم تحديث كلمة المرور بنجاح',
        'password_not_match' => 'كلمة المرور غير متطابقة',
        'password_empty' => 'حقل كلمة المرور فارغ',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'البلد مطلوب',
        'not_enabled' => 'فتح البنك غير مفعل',
        'not_found' => 'لم يتم العثور على فتح البنك',
        'id_required' => 'الهوية مطلوبة',
        'not_provided_infos' => 'المعلومات غير المقدمة',
        'requisition_success' => 'نجاح الطلب',
        'requisition_failed' => 'فشل طلب الشراء',
        'session_id_required' => 'معرف الجلسة مطلوب',
        'account_id_required' => 'معرف الحساب مطلوب',
    ],

    'calendar' => [
        'get_success' => 'تم استرداد الحدث بنجاح',
        'get_error' => 'لا يمكن استرداد الحدث',
        'not_found' => 'تعذر العثور على الحدث',
        'create_failed' => 'لا يمكن إنشاء الحدث',
        'create_success' => 'تم إنشاء الحدث بنجاح',
        'update_success' => 'تم تحديث الحدث بنجاح',
        'update_failed' => 'تعذر تحديث الحدث',
        'delete_failed' => 'لا يمكن حذف الحدث بنجاح',
        'delete_success' => 'تم حذف الحدث بنجاح',
    ],
    'department' => [
        'get_success' => 'تم استرجاع الوزارة بنجاح',
        'get_error' => 'تعذر استرجاع الإدارة',
        'not_found' => 'تعذر العثور على الإدارة',
        'create_failed' => 'لا يمكن إنشاء إدارة',
        'create_success' => 'تم إنشاء القسم بنجاح',
        'update_success' => 'تم تحديث الإدارة بنجاح',
        'update_failed' => 'تعذر تحديث الإدارة',
        'delete_failed' => 'لا يمكن حذف القسم بنجاح',
        'delete_success' => 'تم حذف القسم بنجاح',
    ],
    // Email responses
    'email' => [
        'invoice_subject' => 'فاتورة',
    ],

    'dashboard' => [
        'income' => 'الدخل',
        'expense' => 'المصروفات',
    ],

    'months' => [
        'january' => 'يناير',
        'february' => 'فبراير',
        'march' => 'الزحف',
        'april' => 'إبريل',
        'may' => 'Maj',
        'june' => 'يونيو',
        'july' => 'يوليو',
        'august' => 'أغسطس',
        'september' => 'أيلول/سبتمبر',
        'october' => 'اكتوبر',
        'november' => 'تشرين',
        'december' => 'ديسمبر',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'تعذر العثور على الدور',
            'create_failed' => 'لا يمكن إنشاء الدور',
            'create_success' => 'تم إنشاء الدور بنجاح',
            'update_success' => 'تم تحديث الدور بنجاح',
            'delete_success' => 'تم حذف الدور بنجاح',
            'delete_failed' => 'لا يمكن حذف الدور',
            'super_admin_cannot_be_created' => 'لا يمكن إنشاء دور المدير الممتاز',
            'super_admin_cannot_be_updated' => 'لا يمكن تحديث دور المدير الممتاز',
            'super_admin_cannot_be_deleted' => 'لا يمكن حذف دور المدير الممتاز',
        ],
        'company_logo' => [
            'upload_success' => 'تم تحميل شعار الشركة بنجاح',
            'upload_failed' => 'لا يمكن رفع شعار الشركة',
            'remove_success' => 'تم إزالة شعار الشركة بنجاح',
            'remove_failed' => 'لا يمكن إزالة شعار الشركة',
        ],
        'settings' => [
            'update_success' => 'تم تحديث الإعدادات بنجاح',
            'update_failed' => 'تعذر تحديث الإعدادات',
        ],
        'currency' => [
            'not_found' => 'تعذر العثور على العملة',
            'create_failed' => 'لا يمكن إنشاء العملة',
            'create_success' => 'تم إنشاء العملة بنجاح',
            'update_success' => 'تم تحديث العملة بنجاح',
            'delete_success' => 'تم حذف العملة بنجاح',
            'delete_failed' => 'لا يمكن حذف العملة',
            'rates_updated' => 'تم تحديث المعدلات بنجاح',
        ],
        'taxes' => [
            'not_found' => 'تعذر العثور على الضريبة',
            'create_failed' => 'لا يمكن إنشاء الضريبة',
            'create_success' => 'تم إنشاء الضريبة بنجاح',
            'update_success' => 'تم تحديث الضريبة بنجاح',
            'delete_success' => 'تم حذف الضريبة بنجاح',
            'delete_failed' => 'لا يمكن حذف الضريبة',
        ],

        'user' => [
            'not_found' => 'تعذر العثور على المستخدم',
            'create_failed' => 'تعذر إنشاء المستخدم',
            'create_success' => 'تم إنشاء المستخدم بنجاح',
            'update_success' => 'تم تحديث المستخدم بنجاح',
            'update_failed' => 'تعذر تحديث المستخدم',
            'delete_success' => 'تم حذف المستخدم بنجاح',
            'delete_failed' => 'لا يمكن حذف المستخدم',
            'password_reset_success' => 'تم إعادة تعيين كلمة المرور بنجاح',
            'password_reset_failed' => 'لا يمكن إعادة تعيين كلمة المرور',
            'delete_failed_self_account' => 'لا يمكنك حذف حسابك الخاص',
        ],
    ],
    'memory_used' => 'الذاكرة المستخدمة',
    'memory_available' => 'الذاكرة المتوفرة',
    'disk_used' => 'القرص المستخدم',
    'disk_available' => 'القرص متاح',
];
