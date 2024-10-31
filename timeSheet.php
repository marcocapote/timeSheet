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
add_action('wp_ajax_buscar_trabalho', [$controller, 'buscar_trabalho_ajax']);
add_action('wp_ajax_nopriv_buscar_trabalho', [$controller, 'buscar_trabalho_ajax']);


add_shortcode('timeSheetPanel', 'timeSheetPanel_shortcode');

function timeSheetPanel_shortcode (){
    ob_start();
    include plugin_dir_path(__FILE__) . 'views/timeSheet/view.php';
    return ob_get_clean();
}

?>