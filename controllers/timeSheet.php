<?php
if (!defined('ABSPATH')) exit; // Impede acesso direto

class TimeSheetController{
    public static function buscar_dados_timesheet() {
        global $wpdb;
        
        // Nome das tabelas no banco de dados
        $tabela_timesheet = $wpdb->prefix . 'timesheet_timeSheet';
        $tabela_clientes = $wpdb->prefix . 'timesheet_clientes';
        $tabela_trabalhos = $wpdb->prefix . 'timesheet_trabalhos';
        $tabela_alteracoes = $wpdb->prefix . 'timesheet_alteracoes';
    
        // Consulta para buscar os dados combinados entre as tabelas
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
            INNER JOIN 
                $tabela_clientes AS c ON ts.idCliente = c.idCliente
            INNER JOIN 
                $tabela_trabalhos AS t ON ts.idTrabalho = t.idTrabalho
            INNER JOIN 
                $tabela_alteracoes AS a ON ts.idAlteracao = a.idAlteracao
        ";
    
        return $wpdb->get_results($query);
    }
}
?>