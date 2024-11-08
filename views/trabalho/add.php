<?php 
if (!defined('ABSPATH')) exit; // Impede acesso direto

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_trabalho'])) {
    $idTrabalho = TrabalhoController::inserirTrabalho($_POST);
}

// Recupera a lista de clientes
$clientes = TrabalhoController::listarClientes();
?>

<h2>Cadastrar Novo Trabalho</h2>
<a href="?pagina=alteracao" class="button">Adicionar alteracao</a>
<a href="?pagina=timeSheet" class="button">Voltar para TimeSheet</a>


<form method="post">
    <label for="idCliente">Cliente:</label>
    <select name="idCliente" id="idCliente" required onchange="toggleNovoCliente(this)">
        <option value="">Selecione um cliente</option>
        <?php foreach ($clientes as $cliente): ?>
            <option value="<?php echo $cliente->idCliente; ?>">
                <?php echo esc_html($cliente->nome); ?>
            </option>
        <?php endforeach; ?>
        <option value="0">Outro (especificar)</option>
    </select><br><br>

    <div id="novoClienteContainer" style="display: none;">
        <label for="novoCliente">Nome do Novo Cliente:</label>
        <input type="text" name="novoCliente" id="novoCliente"><br><br>
    </div>

    <label for="numOs">Número OS:</label>
    <input type="text" name="numOs" required><br><br>

    <label for="numOrcamento">Número Orçamento:</label>
    <input type="text" name="numOrcamento" required><br><br>

    <label for="titulo">Titulo do Trabalho:</label>
    <input type="titulo" name="titulo" required><br><br>

    <label for="vendedor">Vendedor:</label>
    <input type="text" name="vendedor" required><br><br>

    <label for="observacoes">Observações:</label>
    <textarea name="observacoes" required></textarea><br><br>


    <label for="horasEstimadas">Horas Estimadas:</label>
    <input type="number" name="horasEstimadas" required><br><br>

    <button type="submit" name="submit_trabalho">Salvar</button>
</form>


<script>
function toggleNovoCliente(select) {
    const novoClienteContainer = document.getElementById('novoClienteContainer');
    if (select.value === "0") {
        novoClienteContainer.style.display = 'block';
    } else {
        novoClienteContainer.style.display = 'none';
    }
}
</script>
