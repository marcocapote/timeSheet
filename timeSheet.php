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
add_action('wp_ajax_buscar_trabalho', [$controller, 'buscar_trabalho_ajax']);
add_action('wp_ajax_nopriv_buscar_trabalho', [$controller, 'buscar_trabalho_ajax']);
add_action('wp_ajax_alteracoes_especificas', [$controllerTimesheet, 'buscar_alteracoes_por_trabalho']);
add_action('wp_ajax_nopriv_alteracoes_especificas', [$controllerTimesheet, 'buscar_alteracoes_por_trabalho']);
add_action('wp_ajax_finalizar_trabalho', [$controllerTrabalho, 'ajax_finalizar_trabalho']);


function timeSheetPanel_shortcode() {
    // Obtém o valor da página a partir do parâmetro GET (ou usa "alteracao" como padrão)
    $pagina = isset($_GET['pagina']) ? sanitize_text_field($_GET['pagina']) : 'timeSheet';

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




?>