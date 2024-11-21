<?php
if (!defined('ABSPATH')) exit; // Impede acesso direto

class TimeSheetController {

    public static function inserir_trabalho_timesheet($idTrabalho, $idCliente){
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_timeSheet';

        $wpdb->insert($tabela, [
            'idCliente'     => $idCliente,
            'idTrabalho'    => $idTrabalho
        ]);

        return $wpdb->insert_id;
    }

    public static function inserir_alteracao_timesheet($idAlteracao, $dados){
        global $wpdb;
        $tabela =$wpdb->prefix . 'timesheet_timeSheet';
        

        $wpdb->insert($tabela, [
            'idTrabalho'     => intval($dados['idTrabalho']),
            'idCliente'     => intval($dados['idCliente']),
            'idAlteracao'    => $idAlteracao
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
                t.statusTrabalho,
                t.arquivo,
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
    public static function buscar_alteracao_timesheet(){
        global $wpdb;

        $tabela_timesheet = $wpdb->prefix . 'timesheet_timeSheet';
        $tabela_clientes = $wpdb->prefix . 'timesheet_clientes';
        $tabela_trabalhos = $wpdb->prefix . 'timesheet_trabalhos';
        $tabela_alteracoes = $wpdb->prefix . 'timesheet_alteracoes';

        $query = "
        SELECT
            ts.idTimeSheet,
            ts.idAlteracao,
            c.nome AS nomeCliente,
            t.statusTrabalho,
            t.numOs,
            t.numOrcamento,
            t.titulo AS tituloTrabalho,
            t.horasEstimadas,
            a.descricao AS descricaoAlteracao,
            a.inicio AS inicioAlteracao,
            a.fim AS fimAlteracao,
            TIMESTAMPDIFF(MINUTE, a.inicio, a.fim) AS totalMinutos,
            FLOOR(TIMESTAMPDIFF(MINUTE, a.inicio, a.fim) / 60) AS horasGastasHoras,
            MOD(TIMESTAMPDIFF(MINUTE, a.inicio, a.fim), 60) AS horasGastasMinutos,
            CONCAT(
            FLOOR(TIMESTAMPDIFF(MINUTE, a.inicio, a.fim) / 60), 'h', 
            MOD(TIMESTAMPDIFF(MINUTE, a.inicio, a.fim), 60), 'min'
        ) AS horasGastas
        FROM 
            $tabela_timesheet AS ts
        LEFT JOIN 
            $tabela_clientes AS c ON ts.idCliente = c.idCliente
        LEFT JOIN 
            $tabela_trabalhos AS t ON ts.idTrabalho = t.idTrabalho
        LEFT JOIN 
            $tabela_alteracoes AS a ON ts.idAlteracao = a.idAlteracao
        WHERE ts.idAlteracao <> 0
        ";

        return $wpdb->get_results($query);
    }

    public static function buscar_trabalho_timesheet(){
        global $wpdb;

        $tabela_timesheet = $wpdb->prefix . 'timesheet_timeSheet';
        $tabela_clientes = $wpdb->prefix . 'timesheet_clientes';
        $tabela_trabalhos = $wpdb->prefix . 'timesheet_trabalhos';
        $tabela_alteracoes = $wpdb->prefix . 'timesheet_alteracoes';

        $query = "
        SELECT
            c.nome AS nomeCliente,
            t.idTrabalho,
            t.statusTrabalho,
            t.numOs,
            t.idTrabalho,
            t.numOrcamento,
            t.arquivo,
            t.titulo AS tituloTrabalho,
            CONCAT(
                FLOOR(t.horasEstimadas), 'h',
                ROUND((t.horasEstimadas - FLOOR(t.horasEstimadas)) * 60), 'min'
            ) AS horasEstimadas,
            CONCAT(
                FLOOR(t.horasGastas), 'h',
                ROUND((t.horasGastas - FLOOR(t.horasGastas)) * 60), 'min'
            ) AS horasGastas
        FROM 
            $tabela_timesheet AS ts
        LEFT JOIN 
            $tabela_clientes AS c ON ts.idCliente = c.idCliente
        LEFT JOIN 
            $tabela_trabalhos AS t ON ts.idTrabalho = t.idTrabalho
        LEFT JOIN 
            $tabela_alteracoes AS a ON ts.idAlteracao = a.idAlteracao
        WHERE ts.idAlteracao = 0 AND t.statusTrabalho <> 'finalizado' AND t.statusTrabalho <> 'Solicitação'
        ";

        return $wpdb->get_results($query);
    }

    public static function buscar_trabalho_finalizado_timesheet(){
        global $wpdb;

        $tabela_timesheet = $wpdb->prefix . 'timesheet_timeSheet';
        $tabela_clientes = $wpdb->prefix . 'timesheet_clientes';
        $tabela_trabalhos = $wpdb->prefix . 'timesheet_trabalhos';
        $tabela_alteracoes = $wpdb->prefix . 'timesheet_alteracoes';

        $query = "
        SELECT
            c.nome AS nomeCliente,
            t.idTrabalho,
            t.statusTrabalho,
            t.numOs,
            t.idTrabalho,
            t.numOrcamento,
            t.titulo AS tituloTrabalho,
            CONCAT(
                FLOOR(t.horasEstimadas), 'h',
                ROUND((t.horasEstimadas - FLOOR(t.horasEstimadas)) * 60), 'min'
            ) AS horasEstimadas,
            CONCAT(
                FLOOR(t.horasGastas), 'h',
                ROUND((t.horasGastas - FLOOR(t.horasGastas)) * 60), 'min'
            ) AS horasGastas
        FROM 
            $tabela_timesheet AS ts
        LEFT JOIN 
            $tabela_clientes AS c ON ts.idCliente = c.idCliente
        LEFT JOIN 
            $tabela_trabalhos AS t ON ts.idTrabalho = t.idTrabalho
        LEFT JOIN 
            $tabela_alteracoes AS a ON ts.idAlteracao = a.idAlteracao
        WHERE ts.idAlteracao = 0 AND t.statusTrabalho = 'finalizado'
        ";

        return $wpdb->get_results($query);
    }

    public static function buscar_solicitacao_timesheet(){
        global $wpdb;

        $tabela_timesheet = $wpdb->prefix . 'timesheet_timeSheet';
        $tabela_clientes = $wpdb->prefix . 'timesheet_clientes';
        $tabela_trabalhos = $wpdb->prefix . 'timesheet_trabalhos';
        $tabela_alteracoes = $wpdb->prefix . 'timesheet_alteracoes';

        $query = "
        SELECT
            c.nome AS nomeCliente,
            t.statusTrabalho,
            t.numOs,
            t.idTrabalho,
            t.arquivo,
            t.numOrcamento,
            t.titulo AS tituloTrabalho,
            CONCAT(
                FLOOR(t.horasEstimadas), 'h',
                ROUND((t.horasEstimadas - FLOOR(t.horasEstimadas)) * 60), 'min'
            ) AS horasEstimadas
 
        FROM 
            $tabela_timesheet AS ts
        LEFT JOIN 
            $tabela_clientes AS c ON ts.idCliente = c.idCliente
        LEFT JOIN 
            $tabela_trabalhos AS t ON ts.idTrabalho = t.idTrabalho
        LEFT JOIN 
            $tabela_alteracoes AS a ON ts.idAlteracao = a.idAlteracao
        WHERE ts.idAlteracao = 0 AND t.statusTrabalho = 'Solicitação'
        ";

        return $wpdb->get_results($query);
    }

    // controllers/timeSheet.php

public static function buscar_alteracoes_por_trabalho() {
    if (!isset($_POST['id_trabalho'])) {
        wp_send_json_error(['message' => 'ID do trabalho não fornecido']);
        wp_die();
    }

    $id_trabalho = intval($_POST['id_trabalho']);
    global $wpdb;
    $tabela_timesheet = $wpdb->prefix . 'timesheet_timeSheet';
    $tabela_clientes = $wpdb->prefix . 'timesheet_clientes';
    $tabela_trabalhos = $wpdb->prefix . 'timesheet_trabalhos';
    $tabela_alteracoes = $wpdb->prefix . 'timesheet_alteracoes';

    $query = "
        SELECT
            c.nome AS nomeCliente,
            t.statusTrabalho,
            t.numOs,
            t.idTrabalho,
            t.numOrcamento,
            t.titulo AS tituloTrabalho,
            t.horasEstimadas,
            IFNULL(t.horasGastas, '0'),
            IFNULL(a.descricao, 'Trabalho solicitado') AS descricao,
            a.inicio AS inicioAlteracao,
            a.fim AS fimAlteracao,
            IFNULL(TIMESTAMPDIFF(HOUR, a.inicio, a.fim), 'Trabalho não iniciado') AS horasGastas,
            IF(ts.idAlteracao = 0, t.dataCriacao, a.inicio) AS inicioAlteracao, 
            IF(ts.idAlteracao = 0, t.dataCriacao, a.fim) AS fimAlteracao
        FROM 
            $tabela_timesheet AS ts
        LEFT JOIN 
            $tabela_clientes AS c ON ts.idCliente = c.idCliente
        LEFT JOIN 
            $tabela_trabalhos AS t ON ts.idTrabalho = t.idTrabalho
        LEFT JOIN 
            $tabela_alteracoes AS a ON ts.idAlteracao = a.idAlteracao
        WHERE ts.idtrabalho = $id_trabalho
        ";

    $alteracoes = $wpdb->get_results(
        $wpdb->prepare($query)
    );

    if (empty($alteracoes)) {
        wp_send_json_error(['message' => 'Nenhuma alteração encontrada para esse trabalho']);
    } else {
        wp_send_json_success($alteracoes);
    }


    wp_die();
}



}
?>
