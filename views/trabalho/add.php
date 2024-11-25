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


<nav class="navbar fixed-top bg-secondary border-secondary border-top-0 border-bottom-0 navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav w-100 text-white me-auto">
            <li class="nav-item m-1 mt-1"><h4>Painel de Timesheets</h4></li>
                <li class="nav-item m-1 mt-0">
                    <a href="?pagina=timeSheet" class=" btn text-white m-0 p-2">
                        Painel TimeSheet
                    </a>
                </li>
                <li class="nav-item m-0 mb-0 mt-0">
                    <a href="?pagina=alteracao" class="btn text-white rounded  m-0 p-2">
                        Adicionar Alteração
                    </a>
                </li>
                <li class="nav-item m-5 mb-0 mt-0"></li>
            </ul>
        </div>
    </div>
</nav>
<div class="row mt-5 mb-5"></div>
    <div class="container bg-light shadow-lg w-100 pt-3">
    <div class="container bg-secondary rounded text-white shadow-lg">
        <div class="row"><div class="col-12 text-center mt-4 mb-3"><h2>Cadastrar Novo Trabalho</h2></div></div>
        
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




    <form method="post" enctype="multipart/form-data" class="p-5 form-gorup">

    <h4>Solicitar um trabalho:</h4>
    <br>
        

    <div class="row">

        <div class="col-6">
        <label for="numOs" class="form-label">Número OS:</label>
        <input type="text" name="numOs" class="form-control border-0" placeholder="Digite o numero da OS" required><br><br>
        </div>
        <div class="col-6">
        <label for="numOrcamento" class="form-label">Número Orçamento:</label>
        <input type="text" name="numOrcamento" class="form-control border-0" placeholder="Digite o Número do Orçamento" required><br><br>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
        <label for="idCliente" class="form-label">Cliente:</label>
        <select name="idCliente" id="idCliente" class="form-control border-light text-muted" required onchange="toggleNovoCliente(this)">
            <option value="" >Selecione um cliente</option>
            <?php foreach ($clientes as $cliente): ?>
                <option value="<?php echo $cliente->idCliente; ?>">
                    <?php echo esc_html($cliente->nome); ?>
                </option>
            <?php endforeach; ?>
            <option value="0">Outro (especificar)</option>
        </select><br>

        <div id="novoClienteContainer" style="display: none;">
            <label for="novoCliente" class="form-label">Nome do Novo Cliente:</label>
            <input type="text" name="novoCliente" id="novoCliente" class="form-control border-0" placeholder="Digite o nome do novo cliente"><br><br>
        </div>
        </div>


        <div class="col-6">
        <label for="vendedor" class="form-label">Vendedor:</label>
        <select name="vendedor" id="vendedor" class="form-control border-0 text-muted">
            <option value="">Selecione um vendedor</option>
            <option value="Vendedor1">Vendedor1</option>
            <option value="Vendedor2">Vendedor2</option>
            <option value="Vendedor3">Vendedor3</option>
        </select><br><br>
        </div>
    </div>

    <div class="row">
        <div class="col-6">
        <label for="titulo" class="form-label">Titulo do Trabalho:</label> 
        <input type="text" name="titulo" class="form-control border-0" placeholder="Digite o titulo do trabalho" required><br><br>
        </div>
        

        <div class="col">
        <label for="observacoes" class="form-label">Descrição do trabalho:</label>
        <textarea name="observacoes" class="form-control" placeholder="Digite a descrição do trabalho" required></textarea><br><br>
        </div>

        
    </div>
        

        <label for="arquivo" class="form-label">Arquivo do trabalho: </label>
        <input type="file" class="form-control" name="arquivo" required><br><br>

        <h5     >Tempo estimado:</h5>

        <div class="row">
        
        <div class="col-2">
        <input type="number" name="horas" id="horas" class="w-50 border-0" placeholder="00" required> Horas
        </div>
        <div class="col-2">
        <input type="number" name="min" id="min" class="w-50 border-0" value="0" placeholder="00" max="59"> Minutos
        </div>
        </div>

        <input type="text" name="horasEstimadas" id="horasEstimadas" required hidden><br><br>

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
