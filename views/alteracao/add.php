<?php 
//if (!defined('ABSPATH')) exit; // Impede acesso direto

// Verifica se foi enviado um número de OS ou Orçamento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_alteracao'])) {
    $idAlteracao = AlteracaoController::inserirAlteracao($_POST);
}

if (isset($_GET['idTrabalho'])){
    $idTrabalho = $_GET['idTrabalho'];
} else{
    $idTrabalho = null;
}

//$idTrabalho = isset($_GET['idTrabalho']) ? intval($_GET['idTrabalho']) : null;
include( plugin_dir_path( __FILE__ ) .'../header.php');

?>

<link rel="stylesheet" href="../src/styles/style.css">


<nav class="navbar fixed-top bg-secondary border-secondary border-top-0 border-bottom-0 navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav w-100 text-white me-auto">
            <li class="nav-item m-1 mt-1"><h4>Painel Timesheet</h4></li>
                <li class="nav-item m-1 mt-0">
                    <a href="?pagina=timeSheet" class=" btn text-white m-0 p-2">
                        Painel TimeSheet
                    </a>
                </li>
                <li class="nav-item m-0 mb-0 mt-0">
                    <a href="?pagina=trabalho" class="btn text-white rounded  m-0 p-2">
                        Adicionar Trabalho
                    </a>
                </li>
                <li class="nav-item m-5 mb-0 mt-0"></li>
            </ul>
        </div>
    </div>
</nav>
<div class="row mt-5"></div>
<div class="container rounded bg-light mt-5 shadow-lg pt-3">
    <div class="container bg-dark rounded text-white shadow-lg">
        <div class="row"><div class="col-12 text-center mb-2 mt-4"><h2>Adicionar Alteração</h2></div></div>
        


    </div>
    


<!-- Formulário e conteúdo da página de alteração -->



<form method="post" action="" id="formAtualizar" class="form-group p-3 mt-3">
    <h5>Buscar Trabalho:</h5>
    <div class="row mt-4">
        <div class="col-5">
            <label for="numOs" class="form-label">Número da OS:</label>
            <input type="text" id="numOs" class="form-control border-0" name="numOs" placeholder="Digite o numero da OS" required>
            <br>
        </div>
        <div class="col-1 text-center pt-4">OU</div>
        <div class="col-5">
            <label for="numOrcamento" class="form-label">Número do Orçamento:</label>
            <input type="text" id="numOrcamento" name="numOrcamento" class="border-0" placeholder="Digite o numero do orçamento" required>
            <br>
        </div>
    </div>
    
    
    
    <input type="text" id="idTrabalho" name="idTrabalho" value="<?= $idTrabalho ?>" hidden>

    <button type="button" id="buscarTrabalho" class="mt-3 mb-4">Buscar Trabalho</button>

    <input type="text" id="idCliente" name="idCliente" hidden></input>

    <div class="esconder" id="esconder" style="display: none;">

    <br>
    <div class="row border mb-4"></div>
    <h5>Detalhes:</h5>

    <div class="row mt-4">
        <div class="col">
            <label for="titulo" class="form-label">Título do Trabalho</label>
            <input type="text" id="titulo" name="titulo" class="form-control border-0" readonly required>
            <br>
        </div>
        <div class="col">
            <label for="nome">Cliente:</label>
            <input type="text" id="nome" name="nome" class="form-control border-0" readonly required>
            <br>
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <label for="vendedor" class="form-label">Vendedor:</label>
            <input type="text" id="vendedor" name="vendedor" class="form-control border-0" readonly required>
            <br>
        </div>
        <div class="col">
            <label for="editor" class="form-label">Editor:</label>
            <input type="text" name="editor" value="<?php echo wp_get_current_user()->user_login; ?>" class="form-control border-0" readonly>
            <br>
        </div>
    </div>
    
    
    <label for="observacoes" class="form-label">Observações</label>
    <textarea id="observacoes" name="observacoes" class="form-control border-0" required> </textarea>
    <br>
    <div class="row border"></div>
    <br>
    <h5>Registrar Alteração:</h5>
    <br>
    <label for="descricao" class="form-label">Descrição da alteração</label>
    <input type="textarea" id="descricao" name="descricao" class="form-control border-0" placeholder="Descreva o que foi feito" required>
    <br>
    <br>    
    <div class="row">
        <div class="col">
        <label for="inicio" class="form-label">Início:</label>
        <input type="datetime-local" id="inicio" name="inicio" class="form-control border-0" required>
        </div>
        <div class="col">
        <label for="fim" class="form-label">Fim:</label>
        <input type="datetime-local" id="fim" name="fim" class="form-control border-0" required>
        </div>
    </div>
    <br>
    
    <input type="text" id="horasGastas" class="form-control border-0" name="horasGastas" readonly hidden>

    <input type="text" id="horasGastasShow" class="form-control border-0" name="horasGastasShow" readonly>

    <button type="submit" name="submit_alteracao" class="mb-3 mt-4">Salvar</button>

    </div>
</form>
</div>
<script>


    document.addEventListener('DOMContentLoaded', () => {
        const idTrabalho = document.getElementById('idTrabalho').value;

        if (idTrabalho) {
            buscarTrabalhoComId(idTrabalho);
        }
    });

    function buscarTrabalhoComId(idTrabalho) {
        fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                action: 'buscar_trabalho',
                idTrabalho: idTrabalho
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                preencherCampos(data.data);
                document.getElementById('esconder').style.display = "block";
            } else {
                console.error('Trabalho não encontrado');
            }
        })
        .catch(error => console.error('Erro na requisição:', error));
    }

    function buscarTrabalho(){
    const numOs = document.getElementById('numOs').value;
    const numOrcamento = document.getElementById('numOrcamento').value;

    // Verifica se pelo menos um campo foi preenchido


    fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'buscar_trabalho',
            numOs: numOs,
            numOrcamento: numOrcamento
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            preencherCampos(data.data);
            document.getElementById('esconder').style.display = "block";
        } else {
            console.error('Trabalho não encontrado');
            document.getElementById('esconder').style.display = "none";
            alert('Trabalho não encontrado.');
            
        }
    })
    .catch(error => console.error('Erro na requisição:', error));
    }
    
document.getElementById('buscarTrabalho').addEventListener('click', () => {
    buscarTrabalho();
});

function preencherCampos(trabalho) {
    document.getElementById('idTrabalho').value =trabalho.idTrabalho || '';
    document.getElementById('idCliente').value =trabalho.idCliente || '';
    document.getElementById('titulo').value = trabalho.titulo || '';
    document.getElementById('nome').value = trabalho.nome || '';
    document.getElementById('vendedor').value = trabalho.vendedor || '';
    document.getElementById('observacoes').value = trabalho.observacoes || '';
    document.getElementById('numOrcamento').value = trabalho.numOrcamento || '';
    if (document.getElementById('numOrcamento').value != trabalho.numOrcamento){
        document.getElementById('numOrcamento').value = trabalho.numOrcamento || '';
    } else if (document.getElementById('numOs').value != trabalho.numOs){
        document.getElementById('numOs').value = trabalho.numOs || '';
    }


    
}


// Função para calcular horas gastas
document.getElementById('fim').addEventListener('input', calcularHorasGastas);
document.getElementById('inicio').addEventListener('input', calcularHorasGastas);

function calcularHorasGastas() {
    const inicio = document.getElementById('inicio').value;
    const fim = document.getElementById('fim').value;

    if (inicio && fim) {
        const diff = (new Date(fim) - new Date(inicio)) / 3600000; // Diferença em horas decimais
        const diffFormatado = formatarHorasDecimais(diff); // Converte para o formato 00h00min

        // Atualiza os campos com os valores
        document.getElementById('horasGastas').value = diff.toFixed(2); // Decimal
        document.getElementById('horasGastasShow').value = diffFormatado; // Formatado
    }
}

function formatarHorasDecimais(horasDecimais) {
    // Converte o valor decimal em horas e minutos
    const horas = Math.floor(horasDecimais);
    const minutos = Math.round((horasDecimais - horas) * 60);
    
    // Formata para 00h00min
    const horasFormatadas = horas.toString().padStart(2, '0');
    const minutosFormatados = minutos.toString().padStart(2, '0');
    
    return `${horasFormatadas}h${minutosFormatados}min`;
}

</script>

