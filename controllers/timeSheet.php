<?php
if (!defined('ABSPATH')) exit; // Impede acesso direto

class TimeSheetController {

    public static function inserir_trabalho_timesheet($idTrabalho, $idCliente){
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_timeSheet';

        $wpdb->insert($tabela, [
            'idCliente'     => $idCliente,
            'idTrabalho'    => $idTrabalho,
            'horasTotais'   => 0
        ]);

        return $wpdb->insert_id;
    }

    public static function inserir_alteracao_timesheet($idAlteracao){
        global $wpdb;
        $tabela =$wpdb->prefix . 'timesheet_timeSheet';

        $wpdb->insert($tabela, [
            
        ]);


    }

    public static function buscar_dados_timesheet() {
        global $wpdb;
        
        $tabela_timesheet = $wpdb->prefix . 'timesheet_timeSheet';
        $tabela_clientes = $wpdb->prefix . 'timesheet_clientes';
        $tabela_trabalhos = $wpdb->prefix . 'timesheet_trabalhos';
        $tabela_alteracoes = $wpdb->prefix . 'timesheet_alteracoes';
    
        $query = "
            SELECT 
                ts.idTimeSheet,
                c.nome AS nomeCliente,
                t.numOs,
                t.numOrcamento,
                t.titulo AS tituloTrabalho,
                a.descricao AS descricaoAlteracao,
                a.inicio AS inicioAlteracao,
                a.fim AS fimAlteracao
            FROM 
                $tabela_timesheet AS ts
            LEFT JOIN 
                $tabela_clientes AS c ON ts.idCliente = c.idCliente
            LEFT JOIN 
                $tabela_trabalhos AS t ON ts.idTrabalho = t.idTrabalho
            LEFT JOIN 
                $tabela_alteracoes AS a ON ts.idAlteracao = a.idAlteracao
        ";
    
        return $wpdb->get_results($query);
    }
}
?>
