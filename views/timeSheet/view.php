<?php
if (!defined('ABSPATH')) exit;


$dados_timesheet = TimeSheetController::buscar_dados_timesheet();

$teste = "teste123";
?>


<h2>Painel de Timesheets</h2>

<!-- Tabela HTML para exibir os dados -->
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>ID Timesheet</th>
            <th>Nome do Cliente</th>
            <th>Número OS</th>
            <th>Número Orçamento</th>
            <th>Título do Trabalho</th>
            <th>Descrição da Alteração</th>
            <th>Início Alteração</th>
            <th>Fim Alteração</th>
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

