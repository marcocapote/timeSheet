<?php
/**
 * Plugin Name: timeSheet
 * Description: Um plugin CRUD.
 * Version: 1.0
 * Author: marcocapote
 */

if (!defined('ABSPATH')) exit;

require_once __DIR__ .'/models/tabelas.php';
require_once __DIR__ . '/controllers/trabalho.php';
require_once __DIR__ .'/controllers/alteracao.php';
require_once __DIR__ . '/controllers/timeSheet.php';

// Registro do hook de ativação para criar a tabela no banco
register_activation_hook(__FILE__, 'create_tables');

register_uninstall_hook(__FILE__, 'drop_tables');

$controller = new AlteracaoController();
$controllerTimesheet = new TimeSheetController();
$controllerTrabalho = new TrabalhoController();



//Registro aquisições AJAX

//buscar trabalho para alteração
add_action('wp_ajax_buscar_trabalho', [$controller, 'buscar_trabalho_ajax']);
add_action('wp_ajax_nopriv_buscar_trabalho', [$controller, 'buscar_trabalho_ajax']);

//buscar alterações de um trabalho especifico
add_action('wp_ajax_alteracoes_especificas', [$controllerTimesheet, 'buscar_alteracoes_por_trabalho']);
add_action('wp_ajax_nopriv_alteracoes_especificas', [$controllerTimesheet, 'buscar_alteracoes_por_trabalho']);

//Finalizar trabalho
add_action('wp_ajax_finalizar_trabalho', [$controllerTrabalho, 'ajax_finalizar_trabalho']);


//buscar trabalho por clientes
add_action('wp_ajax_buscar_trabalho_cliente', [$controllerTimesheet, 'buscar_trabalho_por_cliente']);
add_action('wp_ajax_nopriv_buscar_trabalho_cliente', [$controllerTimesheet, 'buscar_trabalho_por_cliente']);


//buscar trabalho por vendedor
add_action('wp_ajax_buscar_trabalho_vendedor', [$controllerTimesheet, 'buscar_trabalho_por_vendedor']);
add_action('wp_ajax_nopriv_buscar_trabalho_vendedor', [$controllerTimesheet, 'buscar_trabalho_por_vendedor']);

//buscar trabalho por titulo
add_action('wp_ajax_buscar_trabalho_titulo', [$controllerTimesheet, 'buscar_trabalho_por_titulo']);
add_action('wp_ajax_nopriv_buscar_trabalho_titulo', [$controllerTimesheet, 'buscar_trabalho_por_titulo']);


//esconder barra de admin
add_filter('show_admin_bar', '__return_false');

function timeSheetPanel_shortcode() {
    // Obtém o valor da página a partir do parâmetro GET (ou usa "alteracao" como padrão)
    $pagina = isset($_GET['pagina']) ? sanitize_text_field($_GET['pagina']) : 'trabalho';

    ob_start();
    if ($pagina === "alteracao") {
        include plugin_dir_path(__FILE__) . 'views/alteracao/add.php';
    } elseif ($pagina === "timeSheet") {
        include plugin_dir_path(__FILE__) . 'views/timeSheet/view.php';
    } elseif ($pagina === "trabalho"){
        include plugin_dir_path( __FILE__ ) . 'views/trabalho/add.php';
    }
    return ob_get_clean();
}
add_shortcode('timeSheetPanel', 'timeSheetPanel_shortcode');


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
            update_option('timesheet_pagina_id', $pagina_id);
        }
    }
}

// Hook para rodar a função acima ao ativar o plugin
register_activation_hook(__FILE__, 'criar_pagina_timesheet');


function adicionar_link_menu_crud() {
    // URL da página onde o shortcode está
    $pagina_crud = site_url('/timesheetmaxi/');

    add_menu_page(
        'Meu CRUD', // Título da página
        'Meu CRUD', // Nome do menu
        'manage_options', // Permissão necessária
        $pagina_crud, // URL da página
        '', // Função não necessária (só redireciona)
        'dashicons-list-view', // Ícone do menu (opcional)
        6 // Posição no menu
    );
}
add_action('admin_menu', 'adicionar_link_menu_crud');



?>