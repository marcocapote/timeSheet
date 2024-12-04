<?php 

// Função chamada na ativação do plugin
function criar_pagina_timesheet() {
    // Verifica se a página já existe
    $slug = 'timesheetmaxi';
    $pagina = get_page_by_path($slug);

    if (!$pagina) {
        // Cria a página com o shortcode
        $pagina_id = wp_insert_post(array(
            'post_title'   => 'timeSheetMaxi', // Título da página
            'post_name'    => $slug, // Slug da página
            'post_content' => '[timeSheetPanel]', // Shortcode da página
            'post_status'  => 'publish', // Publica a página
            'post_type'    => 'page', // Define como uma página
        ));

        // Você pode salvar o ID da página em uma opção se precisar referenciá-la mais tarde
        if ($pagina_id && !is_wp_error($pagina_id)) {
            // Define o modelo do Elementor (Canvas ou Tela do Elementor)
            update_post_meta($pagina_id, '_wp_page_template', 'elementor_canvas');

            update_option('timesheet_pagina_id', $pagina_id);
        }
    }
}

// Hook para rodar a função acima ao ativar o plugin



function adicionar_link_menu_crud() {
    // URL da página onde o shortcode está
    $pagina_crud = site_url('/timesheetmaxi/');

    add_menu_page(
        'TimeSheet', // Título da página
        'TimeSheet', // Nome do menu
        'manage_options', // Permissão necessária
        $pagina_crud, // URL da página
        '', // Função não necessária (só redireciona)
        'dashicons-list-view', // Ícone do menu (opcional)
        6 // Posição no menu
    );
}

function apagar_pagina() {
    // Recupera o ID da página salva na opção
    $pagina_id = get_option('timesheet_pagina_id');

    // Exclui a página se ela existir
    if ($pagina_id) {
        wp_delete_post($pagina_id, true); // Deleta permanentemente
        delete_option('timesheet_pagina_id'); // Remove a opção do banco
    }
}

