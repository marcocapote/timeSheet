<?php 
if (!defined('ABSPATH')) exit; // Impede acesso direto

class TrabalhoController {
    
    public static function listarClientes() {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_clientes';

        $query = "SELECT * FROM $tabela";
        return $wpdb->get_results($query);
    }

    public static function adicionarCliente($nome) {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_clientes';

        $wpdb->insert($tabela, ['nome' => sanitize_text_field($nome)]);
        return $wpdb->insert_id; // Retorna o ID do novo cliente
    }
    
    public static function listarTrabalhos() {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_trabalhos';
        
        $query = "SELECT * FROM $tabela";
        return $wpdb->get_results($query);
    }

    public static function inserirTrabalho($dados) {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_trabalhos';

        // Verifica se foi inserido um novo cliente
        $idCliente = intval($dados['idCliente']);
        if ($idCliente === 0 && !empty($dados['novoCliente'])) {
            $idCliente = self::adicionarCliente($dados['novoCliente']);
        }

        if ($idCliente === 0) {
            return false;
        }

        // Insere o trabalho na tabela 'trabalhos'
        $wpdb->insert($tabela, [
            'idCliente'     => $idCliente,
            'numOs'         => sanitize_text_field($dados['numOs']),
            'numOrcamento'  => sanitize_text_field($dados['numOrcamento']),
            'titulo'        => sanitize_text_field($dados['titulo']),
            'vendedor'      => sanitize_text_field($dados['vendedor']),
            'observacoes'   => sanitize_textarea_field($dados['observacoes']),
            'arquivo'       => sanitize_text_field($dados['arquivo']),
            'horasEstimadas' => intval($dados['horasEstimadas']),
        ]);
       
        $idTrabalho = $wpdb->insert_id;

        if ($idTrabalho) {
            TimeSheetController::inserir_trabalho_timesheet($idTrabalho, $idCliente);
            return $idTrabalho;
        } else {
            return false;
        }
    }

    public static function deletarTrabalho($idTrabalho) {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_trabalhos';

        $wpdb->delete($tabela, ['idTrabalho' => intval($idTrabalho)]);
    }
}
?>
