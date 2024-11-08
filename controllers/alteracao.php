<?php
if (!defined('ABSPATH')) exit; // Impede acesso direto



class AlteracaoController {


    public static function inserirAlteracao($dados) {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_alteracoes';

        // Insere a alteração na tabela
        $wpdb->insert($tabela, [
            'idTrabalho' => intval($dados['idTrabalho']),
            'editor'     => sanitize_text_field($dados['editor']),
            'inicio'     => $dados['inicio'],
            'fim'        => $dados['fim'],
            'descricao'  => sanitize_textarea_field($dados['descricao'])
        ]);
        
        $idAlteracao = $wpdb->insert_id;

        if ($idAlteracao){
            TimeSheetController::inserir_alteracao_timesheet($idAlteracao, $dados); 
            TrabalhoController::registrarHora($dados);
            $wpdb->update($tabela, [
                ['statusTrabalho' => "Trabalho em andamento"]
            ]);
            
        }
        // Retorna o ID da inserção ou false em caso de falha
        return $wpdb->insert_id ? $wpdb->insert_id : false;

        
    }

    function buscar_trabalho_ajax() {
        global $wpdb;

        $numOs = sanitize_text_field($_POST['numOs']);
        $numOrcamento = sanitize_text_field($_POST['numOrcamento']);
        $tabela = $wpdb->prefix . 'timesheet_trabalhos';
        $tabelaCliente = $wpdb->prefix . 'timesheet_clientes';
        $trabalho = null;
        $cliente = null;
    
        // Verifica se o número da OS foi preenchido
        if (!empty($numOs)) {
            $queryOs = $wpdb->prepare("SELECT * FROM $tabela WHERE numOs = %s", $numOs);
            $trabalho = $wpdb->get_row($queryOs);
        }
    
        // Verifica se o número do orçamento foi preenchido
        if (!$trabalho && !empty($numOrcamento)) {
            $queryOrcamento = $wpdb->prepare("SELECT * FROM $tabela WHERE numOrcamento = %s", $numOrcamento);
            $trabalho = $wpdb->get_row($queryOrcamento);
        }
    
        if ($trabalho) {
            // Retorna os dados em formato JSON
            $queryNome = $wpdb->prepare("SELECT nome FROM $tabelaCliente WHERE idCliente = %s", $trabalho->idCliente);
            $cliente = $wpdb->get_row($queryNome);
            wp_send_json_success([
                'numOrcamento' => $trabalho->numOrcamento,
                'numOs' => $trabalho->numOs,
                'idTrabalho' => $trabalho->idTrabalho,
                'idCliente' => $trabalho->idCliente,
                'titulo' => $trabalho->titulo,
                'nome' => $cliente->nome,
                'vendedor' => $trabalho->vendedor,
                'observacoes' => $trabalho->observacoes
            ]);
        } else {
            wp_send_json_error('Trabalho não encontrado.');
        }
    }
}


?>