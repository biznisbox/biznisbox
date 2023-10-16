<?php

return [
    // Auth responses
    'login' => [
        'success' => 'ログインに成功しました',
        'failed' => 'ログインに失敗しました',
    ],
    'logout' => [
        'success' => 'ログアウトに成功しました',
        'failed' => 'ログアウトに失敗しました',
    ],
    'auth' => [
        'failed' => '認証に失敗しました',
    ],
    'reset' => [
        'success' => 'パスワードのリセットに成功しました',
        'failed' => 'パスワードのリセットに失敗しました',
    ],

    // Product responses
    'product' => [
        'not_found' => '商品が見つかりません',
        'get_success' => '製品が正常に取得されました',
        'get_failed' => '商品を取得できませんでした',
        'create_success' => '製品が正常に作成されました',
        'create_failed' => '商品を作成できませんでした',
        'update_success' => '商品が正常に更新されました',
        'update_failed' => '製品を更新できませんでした',
        'delete_success' => '製品が正常に削除されました',
        'delete_failed' => '製品を削除できませんでした',
    ],

    // Partner responses
    'partner' => [
        'not_found' => 'パートナーが見つかりません',
        'get_success' => 'パートナーが正常に取得されました',
        'get_failed' => 'パートナーを取得できませんでした',
        'create_success' => 'パートナーが作成されました',
        'create_failed' => 'パートナーを作成できませんでした',
        'update_success' => 'パートナーが正常に更新されました',
        'update_failed' => 'パートナーを更新できませんでした',
        'delete_success' => 'パートナーが正常に削除されました',
        'delete_failed' => 'パートナーを削除できませんでした',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'トランザクションが見つかりません',
        'get_success' => 'トランザクションが正常に取得されました',
        'get_failed' => 'トランザクションを取得できませんでした',
        'create_success' => '取引が正常に作成されました',
        'create_failed' => 'トランザクションを作成できませんでした',
        'update_success' => '取引が正常に更新されました',
        'update_failed' => 'トランザクションを更新できませんでした',
        'delete_success' => '取引が正常に削除されました',
        'delete_failed' => '取引を削除できませんでした',
    ],

    //Account responses
    'accounts' => [
        'get_success' => '正常に取得されたアカウント',
        'get_failed' => 'アカウントを取得できませんでした',
        'not_found' => 'アカウントが見つかりませんでした',
        'create_success' => 'アカウントが正常に作成されました',
        'create_error' => 'アカウントを作成できませんでした',
        'update_success' => 'アカウントが正常に更新されました',
        'update_error' => 'アカウントを更新できませんでした',
        'delete_success' => 'アカウントが正常に削除されました',
        'delete_error' => 'アカウントを削除できませんでした',
        'get_success' => 'アカウントが正常に取得されました',
        'get_error' => 'アカウントを取得できませんでした',
        'delete_default_account' => 'Default account cannot be deleted',
    ],

    //Bill responses
    'bill' => [
        'get_success' => '請求書の取得に成功しました',
        'get_error' => '請求書を取得できませんでした',
        'create_success' => '請求書の作成に成功しました',
        'create_error' => '請求書を作成できませんでした',
        'update_success' => '請求書が正常に更新されました',
        'update_error' => '請求書を更新できませんでした',
        'delete_success' => '請求書が正常に削除されました',
        'delete_error' => '請求書を正常に削除できませんでした',
    ],

    //Document responses
    'document' => [
        'get_success' => 'ドキュメントが正常に取得されました',
        'get_error' => 'ドキュメントを取得できませんでした',
        'not_found' => 'ドキュメントが見つかりませんでした',
        'create_failed' => 'ドキュメントを作成できませんでした',
        'create_success' => 'ドキュメントが正常に作成されました',
        'update_success' => 'ドキュメントが正常に更新されました',
        'update_error' => 'ドキュメントを更新できませんでした',
        'delete_failed' => 'ドキュメントを正常に削除できませんでした',
        'delete_success' => 'ドキュメントが正常に削除されました',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'ファイルが正常に取得されました',
        'get_error' => 'ファイルを取得できませんでした',
        'not_found' => 'ファイルが見つかりませんでした',
        'create_failed' => 'ファイルを作成できませんでした',
        'create_success' => 'ファイルが正常に作成されました',
        'update_success' => 'ファイルが正常に更新されました',
        'update_failed' => 'ファイルを更新できませんでした',
        'delete_failed' => 'ファイルを正常に削除できませんでした',
        'delete_success' => 'ファイルを正常に削除しました',
        'get_success_folder' => 'フォルダが正常に取得されました',
        'get_error_folder' => 'フォルダを取得できませんでした',
        'not_found_folder' => 'フォルダが見つかりませんでした',
        'create_failed_folder' => 'フォルダを作成できませんでした',
        'create_success_folder' => 'フォルダが正常に作成されました',
        'update_success_folder' => 'フォルダが正常に更新されました',
        'update_failed_folder' => 'フォルダを更新できませんでした',
        'delete_failed_folder' => 'フォルダを正常に削除できませんでした',
        'delete_success_folder' => 'フォルダが正常に削除されました',
    ],

    //Quote responses
    'quote' => [
        'get_success' => '引用符が正常に取得されました',
        'get_failed' => '見積もりを取得できませんでした',
        'not_found' => '見積書が見つかりませんでした',
        'create_failed' => '見積書を作成できませんでした',
        'create_success' => '見積書が正常に作成されました',
        'convert_success' => '見積書は正常に請求書に変換されました',
        'update_success' => '見積書は正常に更新されました',
        'delete_success' => '見積書は正常に削除されました',
        'delete_failed' => '見積書を削除できませんでした',
        'update_failed' => '見積書を更新できませんでした',
        'share_success' => '見積書は正常に共有されました',
        'share_failed' => '見積書を共有できませんでした',
        'accept_reject_success' => '見積書が正常に却下されました',
        'send_success' => '見積書が正常に送信されました',
        'send_failed' => '見積書を送信できませんでした',
        'pdf_failed' => 'PDFの生成に失敗しました',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => '請求書の取得に成功しました',
        'get_failed' => '請求書を取得できませんでした',
        'not_found' => '請求書が見つかりません',
        'create_failed' => '請求書を作成できませんでした',
        'create_success' => '請求書が正常に作成されました',
        'delete_success' => '請求書は正常に削除されました',
        'update_success' => '請求書が正常に更新されました',
        'share_success' => '請求書は正常に共有されました',
        'share_failed' => '見積書を共有できませんでした',
        'send_success' => '請求書が正常に送信されました',
        'pdf_failed' => 'PDFの生成に失敗しました',
        'send_failed' => '請求書を送信できませんでした',
        'update_failed' => '請求書を更新できませんでした',
        'delete_failed' => '請求書を削除できませんでした',
        'transaction_success' => 'Transaction was added successfully',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'ストライプは利用できません',
        'already_paid' => '請求書は既に支払われています',
        'invalid_key' => '無効な API キー',
        'not_found' => '支払いが見つかりませんでした',
        'success' => 'お支払いが完了しました',
        'failed' => '支払いに失敗しました',
        'paypal_not_available' => 'Paypalは利用できません',
        'invoice' => '請求書',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'ユーザーが見つかりませんでした',
        'update_success' => 'ユーザーが正常に更新されました',
        'password_updated' => 'パスワードが正常に更新されました',
        'password_not_match' => 'パスワードが一致しません',
        'password_empty' => 'パスワードフィールドが空です',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => '国が必要です',
        'not_enabled' => 'オープンバンキングは有効ではありません',
        'not_found' => 'オープンバンキングが見つかりません',
        'id_required' => 'ID is required',
        'not_provided_infos' => '提供されていません',
        'requisition_success' => '請求成功',
        'requisition_failed' => '請求失敗',
        'session_id_required' => 'セッションIDが必要です',
        'account_id_required' => 'アカウントIDが必要です',
    ],

    'calendar' => [
        'get_success' => 'イベントが正常に取得されました',
        'get_error' => 'イベントを取得できませんでした',
        'not_found' => 'イベントが見つかりませんでした',
        'create_failed' => 'イベントを作成できませんでした',
        'create_success' => 'イベントが正常に作成されました',
        'update_success' => 'イベントは正常に更新されました',
        'update_failed' => 'イベントを更新できませんでした',
        'delete_failed' => 'イベントを正常に削除できませんでした',
        'delete_success' => 'イベントが正常に削除されました',
    ],

    // Email responses
    'email' => [
        'invoice_subject' => '請求書',
    ],

    'dashboard' => [
        'income' => '収入',
        'expense' => '費用',
    ],

    'months' => [
        'january' => '1月',
        'february' => '2月',
        'march' => '3月',
        'april' => '4月',
        'may' => 'Maj',
        'june' => '6月',
        'july' => '7月',
        'august' => '8月',
        'september' => '9月',
        'october' => '10月',
        'november' => '11月',
        'december' => '12月',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'ロールが見つかりませんでした',
            'create_failed' => 'ロールを作成できませんでした',
            'create_success' => 'ロールが正常に作成されました',
            'update_success' => 'ロールが正常に更新されました',
            'delete_success' => 'ロールは正常に削除されました',
            'delete_failed' => 'ロールを削除できませんでした',
            'super_admin_cannot_be_created' => 'スーパー管理者ロールを作成できません',
            'super_admin_cannot_be_updated' => 'スーパー管理者権限を更新できません',
            'super_admin_cannot_be_deleted' => 'スーパー管理者権限は削除できません',
        ],
        'company_logo' => [
            'upload_success' => '会社のロゴが正常にアップロードされました',
            'upload_failed' => '会社のロゴをアップロードできませんでした',
            'remove_success' => '会社のロゴが削除されました',
            'remove_failed' => '会社のロゴを削除できませんでした',
        ],
        'settings' => [
            'update_success' => '設定は正常に更新されました',
            'update_failed' => '設定を更新できませんでした',
        ],
        'currency' => [
            'not_found' => '通貨が見つかりませんでした',
            'create_failed' => '通貨を作成できませんでした',
            'create_success' => '通貨は正常に作成されました',
            'update_success' => '通貨が正常に更新されました',
            'delete_success' => '通貨は正常に削除されました',
            'delete_failed' => '通貨を削除できませんでした',
            'rates_updated' => '料金が正常に更新されました',
        ],
        'taxes' => [
            'not_found' => '税が見つかりませんでした',
            'create_failed' => '税金を作成できませんでした',
            'create_success' => '税金が正常に作成されました',
            'update_success' => '税金が正常に更新されました',
            'delete_success' => '税金が正常に削除されました',
            'delete_failed' => '税を削除できませんでした',
        ],

        'user' => [
            'not_found' => 'ユーザーが見つかりませんでした',
            'create_failed' => 'ユーザーを作成できませんでした',
            'create_success' => 'ユーザーが正常に作成されました',
            'update_success' => 'ユーザーが正常に更新されました',
            'update_failed' => 'ユーザーを更新できませんでした',
            'delete_success' => 'ユーザーが正常に削除されました',
            'delete_failed' => 'ユーザーを削除できませんでした',
            'password_reset_success' => 'パスワードが正常にリセットされました',
            'password_reset_failed' => 'パスワードをリセットできませんでした',
            'delete_failed_self_account' => '自分のアカウントを削除することはできません',
        ],
    ],
];
