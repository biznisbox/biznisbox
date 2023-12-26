<?php

return [
    // Auth responses
    'login' => [
        'success' => 'Has iniciado sesión correctamente',
        'failed' => 'Error al iniciar sesión',
    ],
    'logout' => [
        'success' => 'Has cerrado sesión con éxito',
        'failed' => 'Fallo al cerrar sesión',
    ],
    'auth' => [
        'failed' => 'Autenticación fallida',
    ],
    'reset' => [
        'success' => 'Contraseña restablecida correctamente',
        'failed' => 'Error al restablecer la contraseña',
    ],

    // Product responses
    'product' => [
        'not_found' => 'Producto no encontrado',
        'get_success' => 'Productos recuperados con éxito',
        'get_failed' => 'No se han podido recuperar los productos',
        'create_success' => 'Producto creado con éxito',
        'create_failed' => 'No se pudo crear un producto',
        'update_success' => 'Producto actualizado correctamente',
        'update_failed' => 'No se ha podido actualizar un producto',
        'delete_success' => 'Producto eliminado correctamente',
        'delete_failed' => 'No se ha podido eliminar un producto',
    ],

    // Partner responses
    'partner' => [
        'not_found' => 'Socio no encontrado',
        'get_success' => 'Socios recuperados con éxito',
        'get_failed' => 'Socios no pudieron ser recuperados',
        'create_success' => 'Socio creado correctamente',
        'create_failed' => 'No se pudo crear un socio',
        'update_success' => 'Socio actualizado correctamente',
        'update_failed' => 'No se ha podido actualizar un socio',
        'delete_success' => 'Socio eliminado correctamente',
        'delete_failed' => 'No se ha podido eliminar un socio',
    ],

    // Transaction responses
    'transaction' => [
        'not_found' => 'Transacción no encontrada',
        'get_success' => 'Transacciones recuperadas con éxito',
        'get_failed' => 'No se pudieron recuperar las transacciones',
        'create_success' => 'Transacción creada con éxito',
        'create_failed' => 'No se pudo crear una transacción',
        'update_success' => 'Transacción actualizada correctamente',
        'update_failed' => 'No se pudo actualizar una transacción',
        'delete_success' => 'Transacción eliminada correctamente',
        'delete_failed' => 'No se ha podido eliminar una transacción',
    ],

    //Account responses
    'accounts' => [
        'get_success' => 'Cuentas recuperadas con éxito',
        'get_failed' => 'No se pudieron recuperar las cuentas',
        'not_found' => 'No se pudo encontrar la cuenta',
        'create_success' => 'Cuenta creada con éxito',
        'create_error' => 'No se pudo crear la cuenta',
        'update_success' => 'Cuenta actualizada correctamente',
        'update_error' => 'No se pudo actualizar la cuenta',
        'delete_success' => 'Cuenta eliminada correctamente',
        'delete_error' => 'No se ha podido eliminar la cuenta',
        'get_success' => 'Cuenta recuperada con éxito',
        'get_error' => 'No se pudo recuperar la cuenta',
        'delete_default_account' => 'La cuenta por defecto no puede ser eliminada',
    ],

    //Bill responses
    'bill' => [
        'get_success' => 'Factura recuperada con éxito',
        'get_error' => 'No se pudo recuperar la factura',
        'create_success' => 'Factura creada correctamente',
        'create_error' => 'No se pudo crear la factura',
        'update_success' => 'Factura actualizada correctamente',
        'update_error' => 'No se pudo actualizar la factura',
        'delete_success' => 'Factura eliminada correctamente',
        'delete_error' => 'La factura no se pudo eliminar correctamente',
    ],

    //Document responses
    'document' => [
        'get_success' => 'Documentos recuperados con éxito',
        'get_error' => 'No se pudieron recuperar los documentos',
        'not_found' => 'No se pudo encontrar el documento',
        'create_failed' => 'No se pudo crear el documento',
        'create_success' => 'El documento se ha creado correctamente',
        'update_success' => 'El documento se ha actualizado correctamente',
        'update_error' => 'El documento no pudo ser actualizado',
        'delete_failed' => 'El documento no se pudo eliminar correctamente',
        'delete_success' => 'Documento eliminado correctamente',
    ],

    // Employee responses
    'employee' => [
        'not_found' => 'Empleado no encontrado',
        'get_success' => 'Empleados recuperados con éxito',
        'get_failed' => 'No se pudo recuperar a los empleados',
        'create_success' => 'Empleado creado correctamente',
        'create_failed' => 'No se pudo crear un empleado',
        'update_success' => 'Empleado actualizado correctamente',
        'update_failed' => 'Un empleado no pudo ser actualizado',
        'delete_success' => 'Empleado eliminado correctamente',
        'delete_failed' => 'Un empleado no pudo ser eliminado',
    ],

    // Archive responses
    'archive' => [
        'get_success' => 'Archivo recuperado con éxito',
        'get_error' => 'No se pudo recuperar el archivo',
        'not_found' => 'No se pudo encontrar el archivo',
        'create_failed' => 'No se pudo crear el archivo',
        'create_success' => 'El archivo se ha creado correctamente',
        'update_success' => 'El archivo se ha actualizado correctamente',
        'update_failed' => 'No se pudo actualizar el archivo',
        'delete_failed' => 'El archivo no se pudo eliminar correctamente',
        'delete_success' => 'Archivo eliminado correctamente',
        'get_success_folder' => 'Carpeta recuperada correctamente',
        'get_error_folder' => 'No se pudieron recuperar las carpetas',
        'not_found_folder' => 'No se pudo encontrar la carpeta',
        'create_failed_folder' => 'No se pudo crear la carpeta',
        'create_success_folder' => 'La carpeta se ha creado correctamente',
        'update_success_folder' => 'La carpeta se ha actualizado correctamente',
        'update_failed_folder' => 'No se pudo actualizar la carpeta',
        'delete_failed_folder' => 'La carpeta no se ha podido eliminar correctamente',
        'delete_success_folder' => 'Carpeta eliminada correctamente',
    ],

    //Quote responses
    'quote' => [
        'get_success' => 'Citas recuperadas con éxito',
        'get_failed' => 'No se pudieron recuperar las cotizaciones',
        'not_found' => 'No se pudo encontrar la cotización',
        'create_failed' => 'No se pudo crear el presupuesto',
        'create_success' => 'La cotización se ha creado correctamente',
        'convert_success' => 'El presupuesto se ha convertido a la factura con éxito',
        'update_success' => 'La cotización se ha actualizado correctamente',
        'delete_success' => 'La cotización se ha eliminado correctamente',
        'delete_failed' => 'No se pudo eliminar la cotización',
        'update_failed' => 'No se pudo actualizar la cotización',
        'share_success' => 'La cotización se ha compartido correctamente',
        'share_failed' => 'No se pudo compartir la cotización',
        'accept_reject_success' => 'La cotización fue rechazada con éxito',
        'send_success' => 'El presupuesto se ha enviado correctamente',
        'send_failed' => 'No se pudo enviar el presupuesto',
        'pdf_failed' => 'Error al generar PDF',
    ],

    //Invoice responses
    'invoice' => [
        'get_success' => 'Facturas obtenidas con éxito',
        'get_failed' => 'No se pudieron recuperar las facturas',
        'not_found' => 'No se pudo encontrar la factura',
        'create_failed' => 'No se pudo crear la factura',
        'create_success' => 'La factura se ha creado correctamente',
        'delete_success' => 'Factura eliminada correctamente',
        'update_success' => 'Factura actualizada correctamente',
        'share_success' => 'Factura compartida correctamente',
        'share_failed' => 'No se pudo compartir la cotización',
        'send_success' => 'Factura enviada correctamente',
        'pdf_failed' => 'Error al generar PDF',
        'send_failed' => 'No se pudo enviar la factura',
        'update_failed' => 'No se pudo actualizar la factura',
        'delete_failed' => 'No se ha podido eliminar la factura',
        'transaction_success' => 'La transacción se ha añadido correctamente',
    ],

    //Online payment responses
    'payment' => [
        'stripe_not_available' => 'Stripe no está disponible',
        'already_paid' => 'La factura ya fue pagada',
        'invalid_key' => 'Clave API no válida',
        'not_found' => 'No se pudo encontrar el pago',
        'success' => 'El pago fue exitoso',
        'failed' => 'Pago fallido',
        'paypal_not_available' => 'Paypal no disponible',
        'invoice' => 'Factura',
    ],

    //Profile responses
    'user' => [
        'not_found' => 'Usuario no encontrado',
        'update_success' => 'Usuario actualizado correctamente',
        'password_updated' => 'Contraseña actualizada correctamente',
        'password_not_match' => 'La contraseña no coincide',
        'password_empty' => 'El campo contraseña está vacío',
    ],

    // Open Banking responses
    'open_banking' => [
        'country_required' => 'El país es obligatorio',
        'not_enabled' => 'Open Banking no está activado',
        'not_found' => 'Open Banking no encontrado',
        'id_required' => 'Se requiere ID',
        'not_provided_infos' => 'Info no proporcionada',
        'requisition_success' => 'Solicitud exitosa',
        'requisition_failed' => 'Solicitud fallida',
        'session_id_required' => 'El ID de sesión es obligatorio',
        'account_id_required' => 'ID de cuenta es requerido',
    ],

    'calendar' => [
        'get_success' => 'Evento recuperado con éxito',
        'get_error' => 'El evento no pudo ser recuperado',
        'not_found' => 'No se pudo encontrar el evento',
        'create_failed' => 'No se pudo crear el evento',
        'create_success' => 'El evento se ha creado correctamente',
        'update_success' => 'El evento se ha actualizado correctamente',
        'update_failed' => 'No se pudo actualizar el evento',
        'delete_failed' => 'El evento no se pudo eliminar correctamente',
        'delete_success' => 'Evento eliminado correctamente',
    ],
    'department' => [
        'get_success' => 'Departamento recuperado con éxito',
        'get_error' => 'No se pudo recuperar el departamento',
        'not_found' => 'No se pudo encontrar el departamento',
        'create_failed' => 'No se pudo crear el departamento',
        'create_success' => 'Departamento creado con éxito',
        'update_success' => 'Departamento se ha actualizado correctamente',
        'update_failed' => 'No se pudo actualizar el departamento',
        'delete_failed' => 'No se pudo eliminar correctamente el departamento',
        'delete_success' => 'Departamento eliminado correctamente',
    ],
    // Email responses
    'email' => [
        'invoice_subject' => 'Factura',
    ],

    'dashboard' => [
        'income' => 'Ingresos',
        'expense' => 'Gastos',
    ],

    'months' => [
        'january' => 'Enero',
        'february' => 'Febrero',
        'march' => 'Marzo',
        'april' => 'Abril',
        'may' => 'Maj',
        'june' => 'Junio',
        'july' => 'Julio',
        'august' => 'Agosto',
        'september' => 'Septiembre',
        'october' => 'Octubre',
        'november' => 'Noviembre',
        'december' => 'Diciembre',
    ],

    'admin' => [
        'role' => [
            'not_found' => 'No se pudo encontrar el rol',
            'create_failed' => 'No se pudo crear el rol',
            'create_success' => 'El rol se ha creado correctamente',
            'update_success' => 'El rol se ha actualizado correctamente',
            'delete_success' => 'El rol se ha eliminado correctamente',
            'delete_failed' => 'No se pudo eliminar el rol',
            'super_admin_cannot_be_created' => 'No se puede crear el rol Super Admin',
            'super_admin_cannot_be_updated' => 'El rol Super Admin no puede ser actualizado',
            'super_admin_cannot_be_deleted' => 'El rol Super Admin no puede ser eliminado',
        ],
        'company_logo' => [
            'upload_success' => 'El logo de la empresa se ha subido correctamente',
            'upload_failed' => 'No se pudo subir el logo de la empresa',
            'remove_success' => 'El logotipo de la empresa se ha eliminado correctamente',
            'remove_failed' => 'No se pudo eliminar el logotipo de la empresa',
        ],
        'settings' => [
            'update_success' => 'Los ajustes se han actualizado correctamente',
            'update_failed' => 'No se pudo actualizar la configuración',
        ],
        'currency' => [
            'not_found' => 'No se pudo encontrar la moneda',
            'create_failed' => 'No se pudo crear la moneda',
            'create_success' => 'La moneda se ha creado correctamente',
            'update_success' => 'La moneda se ha actualizado correctamente',
            'delete_success' => 'Moneda eliminada correctamente',
            'delete_failed' => 'No se pudo eliminar la moneda',
            'rates_updated' => 'Las tarifas se actualizaron correctamente',
        ],
        'taxes' => [
            'not_found' => 'Impuesto no encontrado',
            'create_failed' => 'Impuesto no pudo ser creado',
            'create_success' => 'El impuesto se ha creado correctamente',
            'update_success' => 'El impuesto se ha actualizado correctamente',
            'delete_success' => 'Impuesto eliminado correctamente',
            'delete_failed' => 'Impuesto no se pudo eliminar',
        ],

        'user' => [
            'not_found' => 'Usuario no encontrado',
            'create_failed' => 'El usuario no pudo ser creado',
            'create_success' => 'El usuario se ha creado correctamente',
            'update_success' => 'Usuario actualizado correctamente',
            'update_failed' => 'El usuario no pudo ser actualizado',
            'delete_success' => 'Usuario eliminado correctamente',
            'delete_failed' => 'El usuario no pudo ser eliminado',
            'password_reset_success' => 'Contraseña restablecida correctamente',
            'password_reset_failed' => 'No se pudo restablecer la contraseña',
            'delete_failed_self_account' => 'No puedes eliminar tu propia cuenta',
        ],
    ],
    'memory_used' => 'Memoria usada',
    'memory_available' => 'Memoria disponible',
    'disk_used' => 'Disco usado',
    'disk_available' => 'Disco disponible',
];
