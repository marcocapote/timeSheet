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


<div class="container rounded bg-light shadow-lg pt-3">
    <div class="container bg-secondary rounded text-white shadow-lg">
        <div class="row"><div class="col-12 text-center mt-4"><h2>Adicionar Alteração</h2></div></div>
        <div class="row p-3">
        <div class="col-7">
            <div class="row d-flex">
                <div class="col-5"><a href="?pagina=timeSheet" class="btn btn-outline-light rounded shadow m-0 p-2">Voltar ao Painel de Timesheets</a></div>
                <div class="col-4"><a href="?pagina=trabalho" class="btn btn-outline-light rounded shadow m-0 p-2">Adicionar Trabalho</a></div>
            </div>
        </div>
    </div>


    </div>
    


<!-- Formulário e conteúdo da página de alteração -->



<form method="post" action="" id="formAtualizar" class="p-3 mt-3">
    <h5>Buscar Trabalho:</h5>
    <label for="numOs">Número da OS:</label>
    <input type="text" id="numOs" name="numOs" required>
    <br>
    <label for="numOrcamento">Número do Orçamento:</label>
    <input type="text" id="numOrcamento" name="numOrcamento" required>
    <br>
    
    <input type="text" id="idTrabalho" name="idTrabalho" value="<?= $idTrabalho ?>" hidden>

    <button type="button" id="buscarTrabalho" class="mt-3 mb-4">Buscar Trabalho</button>

    <input type="text" id="idCliente" name="idCliente" hidden></input>

    <div class="esconder" id="esconder" style="display: none;">

    <br>
    <h5>Detalhes:</h5>
    <label for="titulo">Título do Trabalho</label>
    <input type="text" id="titulo" name="titulo" required>
    <br>
    <label for="nome">Cliente:</label>
    <input type="text" id="nome" name="nome" required>
    <br>
    <label for="vendedor">Vendedor:</label>
    <input type="text" id="vendedor" name="vendedor" required>
    <br>
    <label for="observacoes">Observações</label>
    <input type="text" id="observacoes" name="observacoes" required>
    <br>
    <label for="editor">Editor:</label>
    <input type="text" name="editor" value="<?php echo wp_get_current_user()->user_login; ?>" readonly>
    <br>
    <br>
    <h5>Registrar Alteração:</h5>
    <label for="descricao">Descrição da alteração</label>
    <input type="text" id="descricao" name="descricao" required>
    <br>
    <br>    
    <div class="row">
        <div class="col">
        <label for="inicio">Início:</label>
        <input type="datetime-local" id="inicio" name="inicio" required>
        </div>
        <div class="col">
        <label for="fim">Fim:</label>
        <input type="datetime-local" id="fim" name="fim" required>
        </div>
    </div>
    <br>
    
    <input type="text" id="horasGastas" name="horasGastas">
    <p>Horas Gastas: <span id="horasGastas">0</span> horas</p>

    <button type="submit" name="submit_alteracao" class="mb-3">Salvar</button>

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
    const idTrabalho = document.getElementById('idTrabalho');

    // Verifica se pelo menos um campo foi preenchido


    fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({
            action: 'buscar_trabalho',
            numOs: numOs,
            numOrcamento: numOrcamento,
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
        const diff = (new Date(fim) - new Date(inicio)) / 3600000;
        document.getElementById('horasGastas').innerText = diff.toFixed(2);
        document.getElementById('horasGastas').value = diff.toFixed(2);
    }
}
</script>

