    <?php 
   if (!defined('ABSPATH')) exit; // Impede acesso direto

   // Inicializa variáveis para mensagens
   $erro = '';
   $sucesso = '';
   
   // Verifica se o formulário foi submetido
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_trabalho'])) {
       $resultado = TrabalhoController::inserirTrabalho($_POST);
   
       if (is_wp_error($resultado)) {
           $erro = $resultado->get_error_message(); // Captura a mensagem de erro
       } elseif ($resultado) {
           $sucesso = "Trabalho inserido com sucesso!";
       } else {
           $erro = "Ocorreu um erro ao tentar inserir o trabalho.";
       }
   }
   
   // Recupera a lista de clientes
   $clientes = TrabalhoController::listarClientes();
   include(plugin_dir_path(__FILE__) . '../header.php');
    ?>

    <div class="container bg-light shadow-lg w-100 pt-3">
    <div class="container bg-secondary rounded text-white shadow-lg">
        <div class="row"><div class="col-12 text-center mt-4"><h2>Cadastrar Novo Trabalho</h2></div></div>
        <div class="row p-3">
        <div class="col-7">
            <div class="row d-flex">
                <div class="col-5"><a href="?pagina=timeSheet" class="btn btn-outline-light rounded shadow m-0 p-2">Voltar ao Painel de Timesheets</a></div>
                <div class="col-4"><a href="?pagina=alteracao" class="btn btn-outline-light rounded shadow m-0 p-2">Adicionar alteracao</a></div>
            </div>
        </div>
    </div>
    </div>



    <?php if (!empty($erro)) : ?>
        <div class="alert alert-danger mt-3" role="alert">
            <?php echo esc_html($erro); ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($sucesso)) : ?>
        <div class="alert alert-success mt-3" role="alert">
            <?php echo esc_html($sucesso); ?>
        </div>
    <?php endif; ?>




    <form method="post" enctype="multipart/form-data" class="p-3">
        

        <label for="numOs">Número OS:</label>
        <input type="text" name="numOs" required><br><br>

        <label for="numOrcamento">Número Orçamento:</label>
        <input type="text" name="numOrcamento" required><br><br>

        <label for="titulo">Titulo do Trabalho:</label>
        <input type="text" name="titulo" required><br><br>

        <label for="idCliente">Cliente:</label>
        <select name="idCliente" id="idCliente" required onchange="toggleNovoCliente(this)">
            <option value="">Selecione um cliente</option>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?php echo $cliente->idCliente; ?>">
                    <?php echo esc_html($cliente->nome); ?>
                </option>
            <?php endforeach; ?>
            <option value="0">Outro (especificar)</option>
        </select><br>

        <div id="novoClienteContainer" style="display: none;">
            <label for="novoCliente">Nome do Novo Cliente:</label>
            <input type="text" name="novoCliente" id="novoCliente"><br><br>
        </div>

        <label for="vendedor">Vendedor:</label>
        <input type="text" name="vendedor" required><br><br>

        <label for="observacoes">Observações:</label>
        <textarea name="observacoes" required></textarea><br><br>

        <label for="arquivo">Arquivo do trabalho: </label>
        <input type="file" class="form-control" name="arquivo" required><br><br>

        <h5>Tempo estimado:</h5>

        <label for="horas">Horas:</label>
        <input type="number" name="horas" id="horas" required>

        <label for="min">Minutos</label>
        <input type="number" name="min" id="min">


        <label for="horasEstimadas">Horas:</label>
        <input type="text" name="horasEstimadas" id="horasEstimadas" required><br><br>

        <button type="submit" name="submit_trabalho" class="mb-3">Salvar</button>
    </form>
    </div>


    <script>

    function toggleNovoCliente(select) {
        const novoClienteContainer = document.getElementById('novoClienteContainer');
        if (select.value === "0") {
            novoClienteContainer.style.display = 'block';
        } else {
            novoClienteContainer.style.display = 'none';
        }
    }

    document.getElementById('horas').addEventListener('input', calcularHorasEstimadas);
    document.getElementById('min').addEventListener('input', calcularHorasEstimadas);

    function calcularHorasEstimadas() {

    // Obtém os valores dos inputs
    const horas = parseFloat(document.getElementById('horas').value) || 0;
    const minutos = parseFloat(document.getElementById('min').value) || 0;



    const horasEstimadas = horas + (minutos / 60);
    document.getElementById('horasEstimadas').value = horasEstimadas;

    // Converte minutos em formato decimal


    // Insere o valor calculado no campo oculto
   

}
    </script>
