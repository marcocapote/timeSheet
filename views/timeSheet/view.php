<?php
if (!defined('ABSPATH')) exit;


$dados_timesheet = TimeSheetController::buscar_dados_timesheet();
$dados_alteracao = TimeSheetController::buscar_alteracao_timesheet();

$teste = "teste123";
?>


<h2>Painel de Timesheets</h2>
<a href="?pagina=alteracao" class="button">Adicionar Alteração</a>
<a href="?pagina=trabalho" class="button">Adicionar Trabalho</a>

<button id="mostrar-alteracoes">Mostrar Alterações</button>
<button id="mostrar-dados">Mostrar todos os dados</button>
<!-- Tabela e conteúdo da página -->
<!-- Tabela HTML para exibir os dados -->

<div id="tabela-principal">
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>ID Timesheet</th>
            <th>Nome do Cliente</th>
            <th>Número OS</th>
            <th>Número Orçamento</th>
            <th>Título do Trabalho</th>
            <th>Descrição da Alteração</th>
            <th>Status:</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($dados_timesheet)): ?>
            <?php foreach ($dados_timesheet as $linha): ?>
                <tr>
                    <td><?php echo esc_html($linha->idTimeSheet); ?></td>
                    <td><?php echo esc_html($linha->nomeCliente); ?></td>
                    <td><?php echo esc_html($linha->numOs); ?></td>
                    <td><?php echo esc_html($linha->numOrcamento); ?></td>
                    <td><?php echo esc_html($linha->tituloTrabalho); ?></td>
                    <td><?php echo esc_html($linha->descricaoAlteracao); ?></td>
                    <td><?php echo esc_html($linha->statusTrabalho); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="text-align: center;">Nenhum registro encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>


<div id="tabela-alteracoes" style="display:none">
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Nome do Cliente</th>
            <th>Número OS</th>
            <th>Número Orçamento</th>
            <th>Título do Trabalho</th>
            <th>Descrição da Alteração</th>
            <th>Horas Gastas</th>
            <th>Status:</th>
            <th>Início Alteração</th>
            <th>Fim Alteração</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($dados_alteracao)): ?>
            <?php foreach ($dados_alteracao as $linha): ?>
                <tr>
                    <td><?php echo esc_html($linha->nomeCliente); ?></td>
                    <td><?php echo esc_html($linha->numOs); ?></td>
                    <td><?php echo esc_html($linha->numOrcamento); ?></td>
                    <td><?php echo esc_html($linha->tituloTrabalho); ?></td>
                    <td><?php echo esc_html($linha->descricaoAlteracao); ?></td>
                    <td><?php echo esc_html($linha->horasGastas); ?></td>
                    <td><?php echo esc_html($linha->statusTrabalho); ?></td>
                    <td><?php echo esc_html(date('d/m/Y H:i', strtotime($linha->inicioAlteracao))); ?></td>
                    <td><?php echo esc_html(date('d/m/Y H:i', strtotime($linha->fimAlteracao))); ?></td>
                
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="text-align: center;">Nenhum registro encontrado.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
</div>


<script>
     document.getElementById('mostrar-alteracoes').addEventListener('click', function() {
        document.getElementById('tabela-principal').style.display = 'none';
        document.getElementById('tabela-alteracoes').style.display = 'block';
    });
    document.getElementById('mostrar-dados').addEventListener('click', function() {
        document.getElementById('tabela-principal').style.display = 'block';
        document.getElementById('tabela-alteracoes').style.display = 'none';
    });
</script>