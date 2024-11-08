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
            'statusTrabalho'=> "Solicitação",
            'numOs'         => sanitize_text_field($dados['numOs']),
            'numOrcamento'  => sanitize_text_field($dados['numOrcamento']),
            'titulo'        => sanitize_text_field($dados['titulo']),
            'vendedor'      => sanitize_text_field($dados['vendedor']),
            'observacoes'   => sanitize_textarea_field($dados['observacoes']),
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

    public static function registrarHora($dados) {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_trabalhos';
        // Verifica se os campos necessários estão presentes
        if (!isset($dados['idTrabalho']) || !isset($dados['horasGastas'])) {
            error_log("Erro: 'idTrabalho' ou 'horasGastas' não foram passados no array 'dados'");
            $dados['horasGastas'] ;
            return;
        }
    
        // Obtém o valor atual de horasGastas no formato de uma única variável
        $horasAtuais = $wpdb->get_var($wpdb->prepare("SELECT horasGastas FROM $tabela WHERE idTrabalho = %d", $dados['idTrabalho']));
        
        // Soma as novas horas às existentes, lidando com o caso em que horasAtuais pode ser nulo
        $horasGastasTotal = floatval($horasAtuais) + floatval($dados['horasGastas']);
    
        // Atualiza o campo horasGastas na tabela
        $wpdb->update($tabela, 
            [
                'horasGastas' => $horasGastasTotal,
                'statusTrabalho' => "Em andamento"
        ],
            ['idTrabalho' => $dados['idTrabalho']]
        );
    }

    
    

    public static function deletarTrabalho($idTrabalho) {
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_trabalhos';

        $wpdb->delete($tabela, ['idTrabalho' => intval($idTrabalho)]);
    }
}
?>
