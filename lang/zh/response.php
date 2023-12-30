<?php

return [
    'success' => 'Success',
    'failed' => 'Failed',
    'not_found' => 'Not found',
    'create_success' => 'Created successfully',
    'create_failed' => 'Could not be created',
    'update_success' => 'Updated successfully',
    'update_failed' => 'Could not be updated',
    'delete_success' => 'Deleted successfully',
    'delete_failed' => 'Could not be deleted',
    'get_success' => 'Retrieved successfully',
    'get_failed' => 'Could not be retrieved',
    'upload_success' => 'Uploaded successfully',
    'upload_failed' => 'Could not be uploaded',
    'remove_success' => 'Removed successfully',
    'remove_failed' => 'Could not be removed',
    'send_success' => 'Sent successfully',
    'send_failed' => 'Could not be sent',
    'share_success' => 'Shared successfully',
    'share_failed' => 'Could not be shared',
    'accept_reject_success' => 'Accepted/rejected successfully',
    'convert_success' => 'Converted successfully',
    // Auth responses
    'login' => [
        'success' => '您已成功登录',
        'failed' => '登录失败',
    ],
    'logout' => [
        'success' => '您已成功登出',
        'failed' => '注销失败',
    ],
    'auth' => [
        'failed' => '身份验证失败',
    ],
    'reset' => [
        'success' => '密码重置成功',
        'failed' => '密码重置失败',
    ],

    // Product responses
    'product' => [
        'not_found' => '找不到产品',
        'get_success' => '产品检索成功',
        'get_failed' => '无法检索产品',
        'create_success' => '产品创建成功',
        'create_failed' => '无法创建产品',
        'update_success' => '产品更新成功',
        'update_failed' => '产品无法更新',
        'delete_success' => '商品删除成功',
        'delete_failed' => '无法删除产品',
    ],

    // Partner responses
    'partner' => [
        'not_found' => '找不到合作伙伴',
        'get_success' => '成功检索到合作伙伴',
        'get_failed' => '无法检索合作伙伴',
        'create_success' => '合作伙伴创建成功',
        'create_failed' => '无法创建合作伙伴',
        'update_success' => '合作伙伴更新成功',
        'update_failed' => '合作伙伴无法更新',
        'delete_success' => '合作伙伴删除成功',
        'delete_failed' => '合作伙伴无法删除',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => '未找到交易记录',
        'get_success' => '交易检索成功',
        'get_failed' => '无法检索交易',
        'create_success' => '交易创建成功',
        'create_failed' => '无法创建交易',
        'update_success' => '交易已成功更新',
        'update_failed' => '无法更新交易',
        'delete_success' => '交易删除成功',
        'delete_failed' => '无法删除交易',
    ],

    //Account responses
    'accounts' => [
        'get_success' => '已成功获取账户',
        'get_failed' => '无法检索账户',
        'not_found' => '找不到帐户',
        'create_success' => '帐户创建成功',
        'create_error' => '无法创建帐户',
        'update_success' => '帐户更新成功',
        'update_error' => '帐户无法更新',
        'delete_success' => '帐户删除成功',
        'delete_error' => '帐户无法删除',
        'get_success' => '已成功获取帐户',
        'get_error' => '无法获取帐户',
        'delete_default_account' => '不能删除默认账户',
    ],

    //Bill responses
    'bill' => [
        'get_success' => '帐单已成功获取',
        'get_error' => '无法检索账单',
        'create_success' => '帐单创建成功',
        'create_error' => '账单无法创建',
        'update_success' => '账单更新成功',
        'update_error' => '账单无法更新',
        'delete_success' => '账单已成功删除',
        'delete_error' => '账单无法成功删除',
    ],

    //Document responses
    'document' => [
        'get_success' => '文档检索成功',
        'get_error' => '无法检索文档',
        'not_found' => '找不到文档',
        'create_failed' => '无法创建文档',
        'create_success' => '文档已成功创建',
        'update_success' => '文档已成功更新',
        'update_error' => '无法更新文档',
        'delete_failed' => '文档无法成功删除',
        'delete_success' => '文档删除成功',
    ],

    // Employee responses
    'employee' => [
        'not_found' => '找不到工作人员',
        'get_success' => '员工检索成功',
        'get_failed' => '无法检索员工信息',
        'create_success' => '员工创建成功',
        'create_failed' => '无法创建员工信息',
        'update_success' => '员工更新成功',
        'update_failed' => '无法更新员工信息',
        'delete_success' => '员工删除成功',
        'delete_failed' => '无法删除员工信息',
    ],

    // Archive responses
    'archive' => [
        'get_success' => '文件检索成功',
        'get_error' => '无法检索文件',
        'not_found' => '找不到文件',
        'create_failed' => '无法创建文件',
        'create_success' => '文件已成功创建',
        'update_success' => '文件已成功更新',
        'update_failed' => '无法更新文件',
        'delete_failed' => '无法成功删除文件',
        'delete_success' => '文件删除成功',
        'get_success_folder' => '已成功获取文件夹',
        'get_error_folder' => '无法检索文件夹',
        'not_found_folder' => '找不到文件夹',
        'create_failed_folder' => '无法创建文件夹',
        'create_success_folder' => '文件夹已成功创建',
        'update_success_folder' => '文件夹已成功更新',
        'update_failed_folder' => '无法更新文件夹',
        'delete_failed_folder' => '文件夹无法成功删除',
        'delete_success_folder' => '文件夹删除成功',
    ],

    //Quote responses
    'quote' => [
        'get_success' => '已成功获取引用',
        'get_failed' => '无法检索报价',
        'not_found' => '找不到报价',
        'create_failed' => '无法创建报价单',
        'create_success' => '报价已成功创建',
        'convert_success' => '报价已成功转换为发票',
        'update_success' => '报价已成功更新',
        'delete_success' => '报价已成功删除',
        'delete_failed' => '报价无法删除',
        'update_failed' => '报价无法更新',
        'share_success' => '报价已成功共享',
        'share_failed' => '报价无法共享',
        'accept_reject_success' => '报价已被拒绝',
        'send_success' => '报价已成功发送',
        'send_failed' => '报价无法发送',
        'pdf_failed' => '生成 PDF 失败',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => '已成功获取发票',
        'get_failed' => '无法检索发票',
        'not_found' => '找不到发票',
        'create_failed' => '无法创建发票',
        'create_success' => '发票已成功创建',
        'delete_success' => '发票已成功删除',
        'update_success' => '发票已成功更新',
        'share_success' => '发票已成功共享',
        'share_failed' => '报价无法共享',
        'send_success' => '发票已成功发送',
        'pdf_failed' => '生成 PDF 失败',
        'send_failed' => '发票无法发送',
        'update_failed' => '发票无法更新',
        'delete_failed' => '发票无法删除',
        'transaction_success' => '交易已成功添加',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Stripe不可用',
        'already_paid' => '发票已支付',
        'invalid_key' => '无效的 API 密钥',
        'not_found' => '找不到付款',
        'success' => '付款成功',
        'failed' => '付款失败',
        'paypal_not_available' => 'Paypal 不可用',
        'invoice' => '发票',
    ],

    //Profile responses
    'user' => [
        'not_found' => '找不到用户',
        'update_success' => '用户已成功更新',
        'password_updated' => '密码已成功更新',
        'password_not_match' => '密码不匹配',
        'password_empty' => '密码字段为空',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => '需要国家',
        'not_enabled' => '打开银行业务未启用',
        'not_found' => '未找到打开的银行',
        'id_required' => '必须填写ID',
        'not_provided_infos' => '未提供信息',
        'requisition_success' => '申请成功',
        'requisition_failed' => '请购失败',
        'session_id_required' => '需要会话ID',
        'account_id_required' => '必须输入帐户 ID',
    ],

    'calendar' => [
        'get_success' => '事件检索成功',
        'get_error' => '无法检索事件',
        'not_found' => '找不到事件',
        'create_failed' => '事件无法创建',
        'create_success' => '事件已成功创建',
        'update_success' => '事件已成功更新',
        'update_failed' => '事件无法更新',
        'delete_failed' => '事件无法成功删除',
        'delete_success' => '事件删除成功',
    ],
    'department' => [
        'get_success' => '部门检索成功',
        'get_error' => '无法检索部门',
        'not_found' => '找不到部门',
        'create_failed' => '无法创建部门',
        'create_success' => '部门已成功创建',
        'update_success' => '部门更新成功',
        'update_failed' => '无法更新部门',
        'delete_failed' => '不能成功删除部门',
        'delete_success' => '部门删除成功',
    ],
    // Email responses
    'email' => [
        'invoice_subject' => '发票',
    ],

    'dashboard' => [
        'income' => '收入',
        'expense' => '支出',
    ],

    'months' => [
        'january' => '1 月',
        'february' => '2 月',
        'march' => '3 月',
        'april' => '4 月',
        'may' => 'Maj',
        'june' => '6 月',
        'july' => '7 月',
        'august' => '8 月',
        'september' => '9 月',
        'october' => '10 月',
        'november' => '11 月',
        'december' => '十二月',
    ],

    'admin' => [
        'role' => [
            'not_found' => '找不到角色',
            'create_failed' => '无法创建角色',
            'create_success' => '角色创建成功',
            'update_success' => '角色更新成功',
            'delete_success' => '角色删除成功',
            'delete_failed' => '无法删除角色',
            'super_admin_cannot_be_created' => '超级管理员角色无法创建',
            'super_admin_cannot_be_updated' => '超级管理员角色无法更新',
            'super_admin_cannot_be_deleted' => '超级管理员角色不能被删除',
        ],
        'company_logo' => [
            'upload_success' => '公司徽标上传成功',
            'upload_failed' => '公司徽标无法上传',
            'remove_success' => '公司徽标已成功删除',
            'remove_failed' => '无法删除公司徽标',
        ],
        'settings' => [
            'update_success' => '设置已成功更新',
            'update_failed' => '无法更新设置',
        ],
        'currency' => [
            'not_found' => '找不到货币',
            'create_failed' => '无法创建货币',
            'create_success' => '已成功创建货币',
            'update_success' => '货币已成功更新',
            'delete_success' => '货币已成功删除',
            'delete_failed' => '无法删除货币',
            'rates_updated' => '费率更新成功',
        ],
        'taxes' => [
            'not_found' => '找不到税',
            'create_failed' => '无法创建税',
            'create_success' => '已成功创建税',
            'update_success' => '已成功更新税',
            'delete_success' => '税已成功删除',
            'delete_failed' => '无法删除税',
        ],

        'user' => [
            'not_found' => '找不到用户',
            'create_failed' => '无法创建用户',
            'create_success' => '用户已成功创建',
            'update_success' => '用户已成功更新',
            'update_failed' => '用户无法更新',
            'delete_success' => '用户已成功删除',
            'delete_failed' => '用户不能被删除',
            'password_reset_success' => '密码重置成功',
            'password_reset_failed' => '无法重置密码',
            'delete_failed_self_account' => '您不能删除您自己的帐户',
        ],
    ],
    'memory_used' => '内存已使用',
    'memory_available' => '可用内存',
    'disk_used' => '磁盘已使用',
    'disk_available' => '磁盘可用',
];
