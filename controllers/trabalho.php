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

        $arquivo_url = '';
        if (!empty($_FILES['arquivo']) && $_FILES['arquivo']['error'] === UPLOAD_ERR_OK) {
             // Inclui a biblioteca de upload do WordPress
            if (!function_exists('wp_handle_upload')) {
                require_once(ABSPATH . 'wp-admin/includes/file.php');
            }
            
            // Usa a função de upload do WordPress para armazenar o arquivo
            $upload = wp_handle_upload($_FILES['arquivo'], ['test_form' => false]);
    
            if (isset($upload['url'])) {
                $arquivo_url = $upload['url'];
            } else {
                return false; // Retorna false se o upload falhar
            }
        }

        $horasEstimadas = str_replace(',', '.', $dados['horasEstimadas']); // Substitui vírgulas por pontos
        $horasEstimadas = floatval($horasEstimadas); // Converte para número decimal

        $numOs = sanitize_text_field($dados['numOs']);
        $numOrcamento = sanitize_text_field($dados['numOrcamento']);

        $existente = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT idTrabalho FROM $tabela WHERE numOs = %s OR numOrcamento = %s",
                $numOs,
                $numOrcamento
            )
        );  

        if ($existente) {
            return new WP_Error('duplicate_entry', 'Já existe um trabalho com o mesmo número de OS ou orçamento.');
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
            'horasEstimadas' => $horasEstimadas,
            'dataCriacao'   => current_time('mysql'),
            'arquivo'        => $arquivo_url
        ]);

        error_log("Horas estimadas recebidas: " . print_r($dados['horasEstimadas'], true));

       
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

    public static function ajax_finalizar_trabalho(){
        global $wpdb;
        $tabela = $wpdb->prefix . 'timesheet_trabalhos';

        

        // Verifique se o ID do trabalho foi fornecido
        if (!isset($_POST['id_trabalho'])) {
            wp_send_json_error(array('message' => 'ID do trabalho não informado'));
        }

        $idTrabalho = intval($_POST['id_trabalho']);
        $horasGastas = $wpdb->get_var($wpdb->prepare("SELECT horasGastas FROM $tabela WHERE idTrabalho = %d", $idTrabalho));

        // Verifique se o ID do trabalho é válido
        if ($idTrabalho <= 0) {
            wp_send_json_error(array('message' => 'ID do trabalho inválido'));
        }else if ($horasGastas == 0){
            wp_send_json_error(array('message' => 'trabalho não iniciado'));
        }

        // Atualize o status do trabalho para 'finalizado'
        $resultado = $wpdb->update(
            $tabela,
            ['statusTrabalho' => 'finalizado'],  // O status que você deseja definir
            ['idTrabalho' => $idTrabalho],       // Condição para o trabalho específico
            ['%s'],  // Tipo de dado para o status (string)
            ['%d']   // Tipo de dado para o ID do trabalho (inteiro)
        );

        // Verifique se a atualização foi bem-sucedida
        if ($resultado !== false) {
            wp_send_json_success(array('message' => 'Trabalho finalizado com sucesso'));
        } else {
            wp_send_json_error(array('message' => 'Erro ao finalizar o trabalho'));
        }
        }
}
?>
