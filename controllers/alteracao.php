<?php
if (!defined('ABSPATH')) exit; // Impede acesso direto

class AlteracaoController {

    
    public static function inserirAlteracao($dados) {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_alteracoes';
        $tabelaTrabalho = $wpdb->prefix . 'timesheet_trabalhos';
    
        
    
        // Insere a alteração na tabela
        $wpdb->insert($tabela, [
           // 'idTrabalho' => intval($idTrabalho),
            'editor'     => sanitize_text_field($dados['editor']),
            'inicio'     => $dados['inicio'],
            'fim'        => $dados['fim'],
            'descricao'  => sanitize_textarea_field($dados['descricao']),
        ]);
    
        // Retorna o ID da inserção ou false em caso de falha
        return $wpdb->insert_id ? $wpdb->insert_id : false;
    }

    public static function buscar_trabalho($numOs) {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_trabalhos';

        $query = $wpdb->prepare(
            "SELECT * FROM $tabela WHERE numOs = %s", 
            $numOs
        );

        return $wpdb->get_row($query);
    }
}


?>