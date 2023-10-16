<?php

return [
    // Auth responses
    'login' => [
        'success' => 'Você logou com sucesso',
        'failed' => 'Falha no login',
    ],
    'logout' => [
        'success' => 'Você desconectou com sucesso',
        'failed' => 'Falha ao desconectar',
    ],
    'auth' => [
        'failed' => 'Falha na autenticação',
    ],
    'reset' => [
        'success' => 'Senha redefinida com sucesso',
        'failed' => 'Falha ao redefinir senha',
    ],

    // Product responses
    'product' => [
        'not_found' => 'Produto não encontrado',
        'get_success' => 'Produtos recuperados com sucesso',
        'get_failed' => 'Os produtos não puderam ser recuperados',
        'create_success' => 'Produto criado com sucesso',
        'create_failed' => 'Um produto não pôde ser criado',
        'update_success' => 'Produto atualizado com sucesso',
        'update_failed' => 'Um produto não pôde ser atualizado',
        'delete_success' => 'Produto apagado com sucesso',
        'delete_failed' => 'Não foi possível excluir um produto',
    ],

    // Partner responses
    'partner' => [
        'not_found' => 'Parceiro não encontrado',
        'get_success' => 'Parceiros recuperados com sucesso',
        'get_failed' => 'Os parceiros não puderam ser recuperados',
        'create_success' => 'Parceiro criado com sucesso',
        'create_failed' => 'Não foi possível criar um parceiro',
        'update_success' => 'Parceiro atualizado com sucesso',
        'update_failed' => 'Não foi possível atualizar um parceiro',
        'delete_success' => 'Parceiro excluído com sucesso',
        'delete_failed' => 'Não foi possível excluir um parceiro',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'Transação não encontrada',
        'get_success' => 'Transações recuperadas com sucesso',
        'get_failed' => 'Transações não puderam ser obtidas',
        'create_success' => 'Transação criada com sucesso',
        'create_failed' => 'Uma transação não pôde ser criada',
        'update_success' => 'Transação atualizada com sucesso',
        'update_failed' => 'Uma transação não pôde ser atualizada',
        'delete_success' => 'Transação apagada com sucesso',
        'delete_failed' => 'Uma transação não pôde ser excluída',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'Contas recuperadas com sucesso',
        'get_failed' => 'Contas não puderam ser recuperadas',
        'not_found' => 'Não foi possível encontrar a conta',
        'create_success' => 'Conta criada com sucesso',
        'create_error' => 'A conta não pôde ser criada',
        'update_success' => 'Conta atualizada com sucesso',
        'update_error' => 'A conta não pôde ser atualizada',
        'delete_success' => 'Conta excluída com sucesso',
        'delete_error' => 'Não foi possível excluir a conta',
        'get_success' => 'Conta recuperada com sucesso',
        'get_error' => 'A conta não pôde ser recuperada',
        'delete_default_account' => 'Default account cannot be deleted',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'Fatura recuperada com sucesso',
        'get_error' => 'A fatura não pôde ser recuperada',
        'create_success' => 'Conta criada com sucesso',
        'create_error' => 'Conta não pôde ser criada',
        'update_success' => 'Fatura atualizada com sucesso',
        'update_error' => 'Conta não pode ser atualizada',
        'delete_success' => 'Conta excluída com sucesso',
        'delete_error' => 'Conta não pôde ser excluída com sucesso',
    ],

    //Document responses
    'document' => [
        'get_success' => 'Documentos recuperados com sucesso',
        'get_error' => 'Não foi possível obter os documentos',
        'not_found' => 'Documento não pôde ser encontrado',
        'create_failed' => 'Documento não pôde ser criado',
        'create_success' => 'Documento criado com sucesso',
        'update_success' => 'Documento foi atualizado com sucesso',
        'update_error' => 'Documento não pôde ser atualizado',
        'delete_failed' => 'Documento não pôde ser excluído com sucesso',
        'delete_success' => 'Documento excluído com sucesso',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'Arquivo recuperado com sucesso',
        'get_error' => 'O arquivo não pôde ser recuperado',
        'not_found' => 'O arquivo não pôde ser encontrado.',
        'create_failed' => 'O arquivo não pôde ser criado',
        'create_success' => 'Arquivo criado com sucesso',
        'update_success' => 'Arquivo foi atualizado com sucesso',
        'update_failed' => 'O arquivo não pôde ser atualizado',
        'delete_failed' => 'Arquivo não pôde ser excluído com sucesso',
        'delete_success' => 'Arquivo excluído com sucesso',
        'get_success_folder' => 'Pasta recuperada com sucesso',
        'get_error_folder' => 'Não foi possível obter as pastas',
        'not_found_folder' => 'A pasta não pôde ser encontrada',
        'create_failed_folder' => 'A pasta não pôde ser criada',
        'create_success_folder' => 'Pasta criada com sucesso',
        'update_success_folder' => 'Pasta atualizada com sucesso',
        'update_failed_folder' => 'A pasta não pôde ser atualizada',
        'delete_failed_folder' => 'A pasta não pôde ser excluída com sucesso',
        'delete_success_folder' => 'Pasta excluída com sucesso',
    ],

    //Quote responses
    'quote' => [
        'get_success' => 'Cotações recuperadas com sucesso',
        'get_failed' => 'Cotações não puderam ser recuperadas',
        'not_found' => 'Orçamento não pôde ser encontrado',
        'create_failed' => 'Orçamento não pôde ser criado',
        'create_success' => 'Orçamento criado com sucesso',
        'convert_success' => 'Orçamento convertido em fatura com sucesso',
        'update_success' => 'Orçamento atualizado com sucesso',
        'delete_success' => 'Orçamento excluído com sucesso',
        'delete_failed' => 'Orçamento não pode ser excluído',
        'update_failed' => 'O orçamento não pôde ser atualizado',
        'share_success' => 'Orçamento foi compartilhado com sucesso',
        'share_failed' => 'O orçamento não pôde ser compartilhado',
        'accept_reject_success' => 'Orçamento rejeitado com sucesso',
        'send_success' => 'Orçamento enviado com sucesso',
        'send_failed' => 'O orçamento não pôde ser enviado.',
        'pdf_failed' => 'Falha ao gerar PDF',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'Faturas recuperadas com sucesso',
        'get_failed' => 'Faturas não puderam ser recuperadas',
        'not_found' => 'Fatura não pôde ser encontrada',
        'create_failed' => 'Fatura não pôde ser criada',
        'create_success' => 'Fatura criada com sucesso',
        'delete_success' => 'Fatura excluída com sucesso',
        'update_success' => 'Fatura atualizada com sucesso',
        'share_success' => 'Fatura foi compartilhada com sucesso',
        'share_failed' => 'O orçamento não pôde ser compartilhado',
        'send_success' => 'Fatura enviada com sucesso',
        'pdf_failed' => 'Falha ao gerar PDF',
        'send_failed' => 'Não foi possível enviar a fatura',
        'update_failed' => 'A fatura não pôde ser atualizada',
        'delete_failed' => 'Fatura não pôde ser excluída',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Stripe não está disponível',
        'already_paid' => 'A fatura já foi paga',
        'invalid_key' => 'Chave da API inválida',
        'not_found' => 'O pagamento não pôde ser encontrado',
        'success' => 'Pagamento foi bem sucedido',
        'failed' => 'Pagamento falhou',
        'paypal_not_available' => 'Paypal indisponível',
        'invoice' => 'Fatura',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'Não foi possível encontrar o usuário',
        'update_success' => 'Usuário atualizado com sucesso',
        'password_updated' => 'Senha atualizada com sucesso',
        'password_not_match' => 'A senha não corresponde',
        'password_empty' => 'O campo de senha está vazio',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'País é obrigatório',
        'not_enabled' => 'O Open Banking não está habilitado',
        'not_found' => 'Abrir Banco não encontrado',
        'id_required' => 'O ID é obrigatório',
        'not_provided_infos' => 'Informações não fornecidas',
        'requisition_success' => 'Requisição bem sucedida',
        'requisition_failed' => 'Requisição falhou',
        'session_id_required' => 'O ID da sessão é necessário',
        'account_id_required' => 'O ID da conta é necessário',
    ],

    'calendar' => [
        'get_success' => 'Evento recuperado com sucesso',
        'get_error' => 'Evento não pôde ser recuperado',
        'not_found' => 'Evento não pôde ser encontrado',
        'create_failed' => 'O evento não pôde ser criado',
        'create_success' => 'Evento criado com sucesso',
        'update_success' => 'Evento atualizado com sucesso',
        'update_failed' => 'Evento não pode ser atualizado',
        'delete_failed' => 'Evento não pôde ser excluído com sucesso',
        'delete_success' => 'Evento excluído com sucesso',
    ],

    // Email responses
    'email' => [
        'invoice_subject' => 'Fatura',
    ],

    'dashboard' => [
        'income' => 'Rendimento',
        'expense' => 'Despesa',
    ],

    'months' => [
        'january' => 'janeiro',
        'february' => 'fevereiro',
        'march' => 'março',
        'april' => 'abril',
        'may' => 'Maj',
        'june' => 'junho',
        'july' => 'julho',
        'august' => 'agosto',
        'september' => 'setembro',
        'october' => 'outubro',
        'november' => 'novembro',
        'december' => 'dezembro',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'Não foi possível encontrar a função',
            'create_failed' => 'Cargo não pôde ser criado',
            'create_success' => 'Papel criado com sucesso',
            'update_success' => 'Papel foi atualizado com sucesso',
            'delete_success' => 'Papel foi excluído com sucesso',
            'delete_failed' => 'Papel não pôde ser excluído',
            'super_admin_cannot_be_created' => 'A função Super Administrador não pode ser criada',
            'super_admin_cannot_be_updated' => 'A função Super Administrador não pode ser atualizada',
            'super_admin_cannot_be_deleted' => 'A função Super Administrador não pode ser excluída',
        ],
        'company_logo' => [
            'upload_success' => 'Logotipo da empresa carregado com sucesso',
            'upload_failed' => 'Logotipo da empresa não pôde ser carregado',
            'remove_success' => 'Logotipo da empresa removido com sucesso',
            'remove_failed' => 'Logotipo da empresa não pôde ser removido',
        ],
        'settings' => [
            'update_success' => 'Configurações atualizadas com sucesso',
            'update_failed' => 'As configurações não puderam ser atualizadas',
        ],
        'currency' => [
            'not_found' => 'Moeda não pode ser encontrada',
            'create_failed' => 'Moeda não pode ser criada',
            'create_success' => 'Moeda foi criada com sucesso',
            'update_success' => 'Moeda atualizada com sucesso',
            'delete_success' => 'Moeda foi excluída com sucesso',
            'delete_failed' => 'Moeda não pode ser excluída',
            'rates_updated' => 'Taxas atualizadas com sucesso',
        ],
        'taxes' => [
            'not_found' => 'Não foi possível encontrar o imposto',
            'create_failed' => 'O imposto não pôde ser criado',
            'create_success' => 'Imposto criado com sucesso',
            'update_success' => 'Imposto atualizado com sucesso',
            'delete_success' => 'Imposto foi excluído com sucesso',
            'delete_failed' => 'O imposto não pode ser excluído',
        ],

        'user' => [
            'not_found' => 'Não foi possível encontrar o usuário',
            'create_failed' => 'Não foi possível criar o usuário',
            'create_success' => 'Usuário criado com sucesso',
            'update_success' => 'Usuário atualizado com sucesso',
            'update_failed' => 'Não foi possível atualizar o usuário',
            'delete_success' => 'O usuário foi excluído com sucesso',
            'delete_failed' => 'Não foi possível excluir o usuário',
            'password_reset_success' => 'Senha redefinida com sucesso',
            'password_reset_failed' => 'A senha não pode ser redefinida',
            'delete_failed_self_account' => 'Você não pode excluir sua própria conta',
        ],
    ],
];
