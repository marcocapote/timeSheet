<?php
if (!defined('ABSPATH')) exit;


$dados_timesheet = TimeSheetController::buscar_dados_timesheet();
$dados_alteracao = TimeSheetController::buscar_alteracao_timesheet();
$dados_trabalho = TimeSheetController::buscar_trabalho_timesheet();
$dados_trabalho_finalizado = TimeSheetController::buscar_trabalho_finalizado_timesheet();
$dados_solicitacao = TimeSheetController::buscar_solicitacao_timesheet();


?>


<h2>Painel de Timesheets</h2>
<a href="?pagina=alteracao" class="button" style="margin-right: 5%;">Adicionar Alteração</a>
<a href="?pagina=trabalho" class="button">Adicionar Trabalho</a>
<br><br>

<button id="mostrar-alteracoes">Mostrar Alterações</button>
<button id="mostrar-dados">Mostrar todos os dados</button>
<button id="mostrar-trabalhos">Mostrar todos os Trabalhos</button>
<button id="mostrar-solicitacoes">Mostrar todas as Solicitações</button>
<button id="mostrar-trabalhos-finalizados">Mostrar Trabalhos finalizados</button>
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
            <th>Arquivo</th>
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
                    <td><a href="<?php echo esc_html($linha->arquivo);?>">Baixar Arquivo</a></td>
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

<div id="tabela-alteracoes-especifica" style="display:none">
    
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>

        <tr style="background-color: #f2f2f2;">
            <th>Nome do Cliente</th>
            <th>Número OS</th>
            <th>Número Orçamento</th>
            <th>Título do Trabalho</th>
            <th>Descrição da Alteração</th>
            <th>Horas Gastas</th>
            <th>Início Alteração</th>
            <th>Fim Alteração</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($dados_alteracao_especifica)): ?>
            <?php foreach ($dados_alteracao_especifica as $linha): ?>
                
                <tr>
                    <td><?php echo esc_html($linha->nomeCliente); ?></td>
                    <td><?php echo esc_html($linha->numOs); ?></td>
                    <td><?php echo esc_html($linha->numOrcamento); ?></td>
                    <td><?php echo esc_html($linha->tituloTrabalho); ?></td>
                    <td><?php echo esc_html($linha->descricaoAlteracao); ?></td>
                    <td><?php echo esc_html($linha->horasGastas); ?></td>
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

<div id="tabela-trabalhos" style="display:none">
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Nome do Cliente</th>
            <th>Número OS</th>
            <th>Número Orçamento</th>
            <th>Título do Trabalho</th>
            <th>Horas Gastas</th>
            <th>Horas Estimadas</th>
            <th>Status:</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($dados_trabalho)): ?>
            <?php foreach ($dados_trabalho as $linha): ?>
                <?php $classeVermelha = $linha->horasGastas > $linha->horasEstimadas ? 'classe-vermelha' : '';?>
                <tr>
                    <td><?php echo esc_html($linha->nomeCliente); ?></td>
                    <td><?php echo esc_html($linha->numOs); ?></td>
                    <td><?php echo esc_html($linha->numOrcamento); ?></td>
                    <td><?php echo esc_html($linha->tituloTrabalho); ?></td>
                    <td class="<?php echo $classeVermelha; ?>"><?php echo esc_html($linha->horasGastas); ?></td>
                    <td class="<?php echo $classeVermelha; ?>"><?php echo esc_html($linha->horasEstimadas); ?></td>
                    <td><?php echo esc_html($linha->statusTrabalho); ?></td>
                    <td><button class="mais-info-btn" value="<?php echo esc_html($linha->idTrabalho); ?>">Mais Informações</button>
                    <button class="finalizar-trabalho" value="<?php echo esc_html($linha->idTrabalho); ?>">Finalizar Trabalho</button>
                </td>
                
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


<div id="tabela-trabalhos-finalizados" style="display:none">
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f2f2f2;">
            <th>Nome do Cliente</th>
            <th>Número OS</th>
            <th>Número Orçamento</th>
            <th>Título do Trabalho</th>
            <th>Horas Gastas</th>
            <th>Horas Estimadas</th>
            <th>Status:</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($dados_trabalho_finalizado)): ?>
            <?php foreach ($dados_trabalho_finalizado as $linha): ?>
                <?php $classeVermelha = $linha->horasGastas > $linha->horasEstimadas ? 'classe-vermelha' : '';?>
                <tr>
                    <td><?php echo esc_html($linha->nomeCliente); ?></td>
                    <td><?php echo esc_html($linha->numOs); ?></td>
                    <td><?php echo esc_html($linha->numOrcamento); ?></td>
                    <td><?php echo esc_html($linha->tituloTrabalho); ?></td>
                    <td class="<?php echo $classeVermelha; ?>"><?php echo esc_html($linha->horasGastas); ?></td>
                    <td class="<?php echo $classeVermelha; ?>"><?php echo esc_html($linha->horasEstimadas); ?></td>
                    <td><?php echo esc_html($linha->statusTrabalho); ?></td>
                    <td><button class="mais-info-btn" value="<?php echo esc_html($linha->idTrabalho); ?>">Mais Informações</button>
                    <button class="finalizar-trabalho" value="<?php echo esc_html($linha->idTrabalho); ?>">Finalizar Trabalho</button>
                </td>
                
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


<div id="tabela-solicitacoes" style="display:none">
<table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
    <thead>
        <h4>Trabalhos ainda não iniciados:</h4>
        <tr style="background-color: #f2f2f2;">
            <th>Nome do Cliente</th>
            <th>Número OS</th>
            <th>Número Orçamento</th>
            <th>Título do Trabalho</th>
            <th>Horas Gastas</th>
            <th>Horas Estimadas</th>
            <th>Status:</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($dados_solicitacao)): ?>
            <?php foreach ($dados_solicitacao as $linha): ?>
                <tr>
                    <td><?php echo esc_html($linha->nomeCliente); ?></td>
                    <td><?php echo esc_html($linha->numOs); ?></td>
                    <td><?php echo esc_html($linha->numOrcamento); ?></td>
                    <td><?php echo esc_html($linha->tituloTrabalho); ?></td>
                    <td><?php echo esc_html($linha->horasGastas); ?></td>
                    <td><?php echo esc_html($linha->horasEstimadas); ?></td>
                    <td><?php echo esc_html($linha->statusTrabalho); ?></td>
                    <td><button id="mais-info-btn" value="<?php echo esc_html($linha->idTrabalho); ?>">Mais Informações</button></td>
                
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

<style>
    /* Define a cor vermelha para as linhas com a classe "classe-vermelha" */
    .classe-vermelha {
        color: red;
        font-weight: bold;
    }
    .classe-verde {
        color: green;
        font-weight: bold;
    }
</style>

<script>
     function mostrarTabela(tabelaId) {
        const tabelas = ['tabela-principal', 'tabela-alteracoes', 'tabela-trabalhos', 'tabela-trabalhos-finalizados','tabela-solicitacoes', 'tabela-alteracoes-especifica'];
        
        tabelas.forEach(id => {
            document.getElementById(id).style.display = id === tabelaId ? 'block' : 'none';
        });
    }

    // Eventos de clique para exibir as tabelas desejadas
    document.getElementById('mostrar-alteracoes').addEventListener('click', function() {
        mostrarTabela('tabela-alteracoes');
    });
    document.getElementById('mostrar-dados').addEventListener('click', function() {
        mostrarTabela('tabela-principal');
    });
    document.getElementById('mostrar-trabalhos').addEventListener('click', function() {
        mostrarTabela('tabela-trabalhos');
    });
    document.getElementById('mostrar-solicitacoes').addEventListener('click', function() {
        mostrarTabela('tabela-solicitacoes');
    });
    document.getElementById('mostrar-trabalhos-finalizados').addEventListener('click', function(){
        mostrarTabela('tabela-trabalhos-finalizados');
    });
    

    
    
    
    document.querySelectorAll('.finalizar-trabalho').forEach(button => {
    button.addEventListener('click', function() {
        var id_trabalho = this.value;

        alert(id_trabalho);

       
        fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({
                action: 'finalizar_trabalho',
                id_trabalho: id_trabalho
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Trabalho finalizado com sucesso!');
                // Atualizar a tabela ou realizar qualquer outra ação necessária
            } else {
                alert('Falha ao finalizar trabalho.');
            }
        })
        .catch(error => console.error('Erro:', error));
    });
});

    

    
    document.querySelectorAll('.mais-info-btn').forEach(button => {
    button.addEventListener('click', function() {

        var id_trabalho = this.value;

        fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: new URLSearchParams({
                action: 'alteracoes_especificas',
                id_trabalho: id_trabalho
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tbody = document.querySelector('#tabela-alteracoes-especifica tbody');
                tbody.innerHTML = '';
                const thead = document.querySelector('#tabela-alteracoes-especifica thead');
                thead.innerHTML = '';

                data.data.forEach(alteracao => {
                    const title = '<h4> Titulo </h4>';
                    const row = `<tr>
                        <td>${alteracao.nomeCliente}</td>
                        <td>${alteracao.numOs}</td>
                        <td>${alteracao.numOrcamento}</td>
                        <td>${alteracao.tituloTrabalho}</td>
                        <td>${alteracao.descricao}</td>
                        <td>${alteracao.horasGastas}</td>
                        <td>${new Date(alteracao.inicioAlteracao).toLocaleString()}</td>
                        <td>${new Date(alteracao.fimAlteracao).toLocaleString()}</td>
                    </tr>`;
                    tbody.innerHTML += row;
                    thead.innerHTML = ` 
                                        <tr> <th colspan="8"> <p>Histórico do trabalho: ${alteracao.tituloTrabalho}</p>
                                           
                                        </th> </tr>
                                        
                                        <tr style="background-color: #f2f2f2;">
                                        <th>Nome do Cliente</th>
                                        <th>Número OS</th>
                                        <th>Número Orçamento</th>
                                        <th>Título do Trabalho</th>
                                        <th>Descrição da Alteração</th>
                                        <th>Horas Gastas</th>
                                        <th>Início Alteração</th>
                                        <th>Fim Alteração</th>
                                    </tr>

                                    `;
                });

                mostrarTabela('tabela-alteracoes-especifica');
            } else {
                alert(data.data.message || 'Erro ao buscar alterações.');
            }
        });
    });
});

</script>