<?php 
if (!defined('ABSPATH')) exit; // Impede acesso direto

// Verifica se foi enviado um número de OS ou Orçamento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_trabalho'])) {
    $idTrabalho = TrabalhoController::inserirTrabalho($_POST);
    if ($idTrabalho) {
        echo "<p>Trabalho adicionado com sucesso! ID: $idTrabalho</p>";
    } else {
        echo "<p>Erro ao adicionar o trabalho.</p>";
    }
}
?>

<h2>Registrar Alteração</h2>

<form method="post" action="">
    <label for="numOs">Numero da OS:</label>
    <input type="text" id="numOs" name="numOs">

    <label for="numOrcamento">Numero do Orçamento:</label>
    <input type="text" id="numOrcamento" name="numOrcamento" required>

    <label for="nomeCliente">Cliente:</label>
    <input type="text" id="nomeCliente" name="nomeCliente">

    <label for="vendedor">Vendedor:</label>
    <input type="text" id="vendedor" name="vendedor">

    <label for="observacoes">Observações</label>
    <input type="text" id="observacoes" name="observacoes">

    <label for="editor">Editor:</label>
    <input type="text" name="editor" value="<?php echo wp_get_current_user()->user_login; ?>" readonly>

    <label for="inicio">Início:</label>
    <input type="datetime-local" id="inicio" name="inicio" required>

    <label for="fim">Fim:</label>
    <input type="datetime-local" id="fim" name="fim" required>

</form>


<script>
    // Função para calcular horas gastas
    document.getElementById('fim').addEventListener('input', calcularHorasGastas);
    document.getElementById('inicio').addEventListener('input', calcularHorasGastas);

    function calcularHorasGastas() {
        const inicio = document.getElementById('inicio').value;
        const fim = document.getElementById('fim').value;

        if (inicio && fim) {
            const diff = (new Date(fim) - new Date(inicio)) / 3600000;
            document.getElementById('horasGastas').innerText = diff.toFixed(2);
        }
    }
</script>
