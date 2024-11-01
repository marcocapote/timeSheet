<?php 
//if (!defined('ABSPATH')) exit; // Impede acesso direto

// Verifica se foi enviado um número de OS ou Orçamento
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_alteracao'])) {
    $idAlteracao = AlteracaoController::inserirAlteracao($_POST);
}


?>

<h2>Adicionar Alteração</h2>
<a href="?pagina=timeSheet" class="button">Voltar ao Painel de Timesheets</a>
<a href="?pagina=trabalho" class="button">Adicionar Trabalho</a>
<!-- Formulário e conteúdo da página de alteração -->


<h2>Registrar Alteração</h2>

<form method="post" action="" id="formAtualizar">
    <h5>Buscar Trabalho:</h5>
    <label for="numOs">Número da OS:</label>
    <input type="text" id="numOs" name="numOs" required>
    <br>
    <label for="numOrcamento">Número do Orçamento:</label>
    <input type="text" id="numOrcamento" name="numOrcamento" required>
    <br>

    <button type="button" id="buscarTrabalho">Buscar Trabalho</button>

    <input type="text" id="idTrabalho" name="idTrabalho" hidden></input>
    <br>
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
    <label for="descricao">Descrição da alteração</label>
    <input type="text" id="descricao" name="descricao" required>
    <br>
    <label for="inicio">Início:</label>
    <input type="datetime-local" id="inicio" name="inicio" required>
    <br>
    <label for="fim">Fim:</label>
    <input type="datetime-local" id="fim" name="fim" required>
    <br>
    <p>Horas Gastas: <span id="horasGastas">0</span> horas</p>

    <button type="submit" name="submit_alteracao">Salvar</button>
</form>

<script>

document.getElementById('buscarTrabalho').addEventListener('click', () => {
    const numOs = document.getElementById('numOs').value;
    const numOrcamento = document.getElementById('numOrcamento').value;

    // Verifica se pelo menos um campo foi preenchido
    if (!numOs && !numOrcamento) {
        alert('Por favor, preencha pelo menos um dos campos: Número da OS ou Número do Orçamento.');
        return;
    }

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
        } else {
            console.error('Trabalho não encontrado');
            alert('Trabalho não encontrado.');
        }
    })
    .catch(error => console.error('Erro na requisição:', error));
});

function preencherCampos(trabalho) {
    document.getElementById('idTrabalho').value =trabalho.idTrabalho || '';
    document.getElementById('titulo').value = trabalho.titulo || '';
    document.getElementById('nome').value = trabalho.nome || '';
    document.getElementById('vendedor').value = trabalho.vendedor || '';
    document.getElementById('observacoes').value = trabalho.observacoes || '';
    if (!document.getElementById('numOrcamento').value){
        document.getElementById('numOrcamento').value = trabalho.numOrcamento || '';
    }
    if (!document.getElementById('numOs').value){
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
    }
}
</script>