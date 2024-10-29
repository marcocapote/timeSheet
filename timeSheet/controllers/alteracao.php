<?php
if (!defined('ABSPATH')) exit; // Impede acesso direto

class AlteracaoController {
    public static function processarFormulario() {
        if (isset($_POST['inserirAlteracao'])) {
            global $wpdb;
            $tabela = $wpdb->prefix . 'timesheet_alteracoes';

            // Coleta e sanitiza os dados do formulário
            $dados = [
                'idTrabalho' => intval($_POST['idTrabalho']),
                'editor'     => sanitize_text_field($_POST['editor']),
                'inicio'     => $_POST['inicio'],
                'fim'        => $_POST['fim'],
                'descricao'  => sanitize_textarea_field($_POST['descricao']),
            ];

            // Calcula as horas gastas
            $dados['horasGastas'] = (strtotime($dados['fim']) - strtotime($dados['inicio'])) / 3600;

            // Insere no banco de dados
            $resultado = $wpdb->insert($tabela, $dados);

            if ($resultado) {
                wp_redirect(home_url('/pagina-de-sucesso')); // Redireciona em caso de sucesso
                exit;
            } else {
                echo "<p>Erro ao salvar a alteração.</p>";
            }
        }
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