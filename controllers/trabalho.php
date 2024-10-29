<?php 
if (!defined('ABSPATH')) exit; // Impede acesso direto

class TrabalhoController {

       // Função para listar todos os clientes
    public static function listarClientes() {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_clientes';

        $query = "SELECT * FROM $tabela";
        return $wpdb->get_results($query);
    }

    // Função para adicionar um cliente novo
    public static function adicionarCliente($nome) {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_clientes';

        $wpdb->insert($tabela, ['nome' => sanitize_text_field($nome)]);

        return $wpdb->insert_id; // Retorna o ID do novo cliente
    }
    
    // Função para listar todos os trabalhos
    public static function listarTrabalhos() {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_trabalhos';
        
        $query = "SELECT * FROM $tabela";
        $resultados = $wpdb->get_results($query);
        
        return $resultados;
    }

    // Função para inserir um novo trabalho
    public static function inserirTrabalho($dados) {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_trabalhos';

        // Verifica se foi inserido um novo cliente
        $idCliente = intval($dados['idCliente']);
        if ($idCliente === 0 && !empty($dados['novoCliente'])) {
            $idCliente = self::adicionarCliente($dados['novoCliente']);
        }

        // Se o ID do cliente ainda for 0, interrompe a inserção
        if ($idCliente === 0) {
            return false;
        }

        // Insere o trabalho na tabela 'trabalhos'
        $wpdb->insert($tabela, [
            'idCliente'     => $idCliente,
            'numOs'         => sanitize_text_field($dados['numOs']),
            'numOrcamento'  => sanitize_text_field($dados['numOrcamento']),
            'vendedor'      => sanitize_text_field($dados['vendedor']),
            'observacoes'   => sanitize_textarea_field($dados['observacoes']),
            'arquivo'       => sanitize_text_field($dados['arquivo']),
            'horasEstimadas' => intval($dados['horasEstimadas']),
        ]);

        return $wpdb->insert_id;
    }

    // Função para deletar um trabalho
    public static function deletarTrabalho($idTrabalho) {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_trabalhos';

        $wpdb->delete($tabela, ['idTrabalho' => intval($idTrabalho)]);
    }
}
?>