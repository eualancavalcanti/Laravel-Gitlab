<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Variáveis Globais da Aplicação
    |--------------------------------------------------------------------------
    |
    | Aqui você centraliza valores que serão usados em todo o projeto.
    | Use env() sempre que precisar variar por ambiente.
    |
    */

    // URL base do site
    'site_url'        => env('APP_URL', 'https://hotboys.io'),

    // E-mail de contato/suporte
    'support_email'   => env('SUPPORT_EMAIL', 'suporte@hotboys.io'),

    // Tamanho máximo de upload (bytes)
    'max_upload_size' => env('MAX_UPLOAD_SIZE', 5 * 1024 * 1024),

    // Quantidade de itens por página (paginação)
    'per_page'        => env('PAGINATION_PER_PAGE', 20),
];
