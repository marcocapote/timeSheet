<<<<<<< HEAD
<?php
if (!defined('ABSPATH'))
    exit; // Impede acesso direto

class TimeSheetController
{

    public static function inserir_trabalho_timesheet($idTrabalho, $idCliente)
    {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_timeSheet';

        $wpdb->insert($tabela, [
            'idCliente' => $idCliente,
            'idTrabalho' => $idTrabalho
        ]);

        return $wpdb->insert_id;
    }

    public static function inserir_alteracao_timesheet($idAlteracao, $dados)
    {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_timeSheet';


        $wpdb->insert($tabela, [
            'idTrabalho' => intval($dados['idTrabalho']),
            'idCliente' => intval($dados['idCliente']),
            'idAlteracao' => $idAlteracao
        ]);


    }

    public static function buscar_dados_timesheet()
    {
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
    public static function buscar_alteracao_timesheet()
    {
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
        ORDER BY ts.idAlteracao DESC 
        ";

        return $wpdb->get_results($query);
    }

    public static function buscar_trabalho_timesheet()
    {
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
            t.horasEstimadas AS horasEstimadasComp,
            t.horasGastas AS horasGastasComp,
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
         ORDER BY ts.idTrabalho DESC
        ";

        return $wpdb->get_results($query);
    }

    public static function buscar_trabalho_finalizado_timesheet()
    {
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
            t.horasEstimadas AS horasEstimadasComp,
            t.horasGastas AS horasGastasComp,
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
        ORDER BY t.idTrabalho DESC
        ";

        return $wpdb->get_results($query);
    }

    public static function buscar_solicitacao_timesheet()
    {
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

    public static function buscar_alteracoes_por_trabalho()
    {
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
            t.observacoes,
            t.titulo AS tituloTrabalho,
            t.horasEstimadas,
            t.vendedor,
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

    public static function buscar_trabalho_por_cliente() {
        if (!isset($_POST['id_cliente'])) {
            wp_send_json_error(['message' => 'ID do cliente não encontrado']);
            wp_die();
        }
        $id_cliente = intval($_POST['id_cliente']);
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
                IFNULL(
                                CASE 
                                    WHEN CHAR_LENGTH(t.observacoes) > 100 
                                    THEN CONCAT(LEFT(t.observacoes, 100), '...')
                                    ELSE t.observacoes
                                END, 
                                'Sem observações'
                            ) AS observacoes,
                t.titulo AS tituloTrabalho,
                t.horasEstimadas,
                        CONCAT(
                        FLOOR(t.horasEstimadas), 'h',
                        ROUND((t.horasEstimadas - FLOOR(t.horasEstimadas)) * 60), 'min'
                    ) AS horasEstimadas,
                    CONCAT(
                        FLOOR(t.horasGastas), 'h',
                        ROUND((t.horasGastas - FLOOR(t.horasGastas)) * 60), 'min'
                    ) AS horasGastas,
                t.vendedor,
                IFNULL(t.horasGastas, 0) AS horasGastas,
                IFNULL(a.descricao, 'Trabalho solicitado') AS descricao,
                a.inicio AS inicioAlteracao,
                a.fim AS fimAlteracao,
                IFNULL(TIMESTAMPDIFF(HOUR, a.inicio, a.fim), 'Trabalho não iniciado') AS horasDiferenca,
                IF(ts.idAlteracao = 0, t.dataCriacao, a.inicio) AS inicioReal, 
                IF(ts.idAlteracao = 0, t.dataCriacao, a.fim) AS fimReal
            FROM 
                $tabela_timesheet AS ts
            JOIN 
                $tabela_trabalhos AS t ON ts.idTrabalho = t.idTrabalho
            LEFT JOIN 
                $tabela_clientes AS c ON ts.idCliente = c.idCliente
            LEFT JOIN 
                $tabela_alteracoes AS a ON ts.idAlteracao = a.idAlteracao
            WHERE ts.idCliente = %d AND ts.idAlteracao = 0
        ";
    
        $trabalhos = $wpdb->get_results(
            $wpdb->prepare($query, $id_cliente)
        );
    
        if (empty($trabalhos)) {
            wp_send_json_error(['message' => 'Nenhum trabalho encontrado para esse cliente']);
        } else {
            wp_send_json_success($trabalhos);
        }
    
        wp_die();
    }

    public static function buscar_trabalho_por_vendedor() {
        if (!isset($_POST['vendedor'])) {
            wp_send_json_error(['message' => 'Vendedor não encontrado']);
            wp_die();
        }
        $vendedor = sanitize_text_field($_POST['vendedor']);
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
                            IFNULL(
                                CASE 
                                    WHEN CHAR_LENGTH(t.observacoes) > 100 
                                    THEN CONCAT(LEFT(t.observacoes, 100), '...')
                                    ELSE t.observacoes
                                END, 
                                'Sem observações'
                            ) AS observacoes,
                            t.titulo AS tituloTrabalho,
                            t.horasEstimadas,
                            CONCAT(
                                    FLOOR(t.horasEstimadas), 'h',
                                    ROUND((t.horasEstimadas - FLOOR(t.horasEstimadas)) * 60), 'min'
                                ) AS horasEstimadas,
                                CONCAT(
                                    FLOOR(t.horasGastas), 'h',
                                    ROUND((t.horasGastas - FLOOR(t.horasGastas)) * 60), 'min'
                                ) AS horasGastas,
                            t.vendedor,
                            IFNULL(t.horasGastas, 0) AS horasGastas,
                            IFNULL(a.descricao, 'Trabalho solicitado') AS descricao,
                            a.inicio AS inicioAlteracao,
                            a.fim AS fimAlteracao,
                            IFNULL(TIMESTAMPDIFF(HOUR, a.inicio, a.fim), 'Trabalho não iniciado') AS horasDiferenca,
                            IF(ts.idAlteracao = 0, t.dataCriacao, a.inicio) AS inicioReal, 
                            IF(ts.idAlteracao = 0, t.dataCriacao, a.fim) AS fimReal
                        FROM 
                            $tabela_timesheet AS ts
                        LEFT JOIN 
                            $tabela_trabalhos AS t ON ts.idTrabalho = t.idTrabalho
                        LEFT JOIN 
                            $tabela_clientes AS c ON ts.idCliente = c.idCliente
                        LEFT JOIN 
                            $tabela_alteracoes AS a ON ts.idAlteracao = a.idAlteracao
                        WHERE t.vendedor = %s
                    ";
    
        $trabalhos = $wpdb->get_results(
            $wpdb->prepare($query, $vendedor)
        );
    
        if (empty($trabalhos)) {
            wp_send_json_error(['message' => 'Nenhum trabalho encontrado para esse vendedor']);
        } else {
            wp_send_json_success($trabalhos);
        }
        wp_die();
    }



}