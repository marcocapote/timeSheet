<?php
if (!defined('ABSPATH'))
    exit;


$dados_timesheet = TimeSheetController::buscar_dados_timesheet();
$dados_alteracao = TimeSheetController::buscar_alteracao_timesheet();
$dados_trabalho = TimeSheetController::buscar_trabalho_timesheet();
$dados_trabalho_finalizado = TimeSheetController::buscar_trabalho_finalizado_timesheet();
$dados_solicitacao = TimeSheetController::buscar_solicitacao_timesheet();

include(plugin_dir_path(__FILE__) . '../header.php');



?>
<nav
    class="navbar fixed-top bg-secondary border-secondary border-top-0 border-bottom-0 navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav w-100 text-white me-auto">
                <li class="nav-item m-1 mt-1">
                    <h4>Painel Timesheet</h4>
                </li>
                <li class="nav-item m-1 mt-0">
                    <a href="?pagina=alteracao" class=" btn text-white m-0 p-2">
                        Adicionar Alteração
                    </a>
                </li>
                <li class="nav-item m-0 mb-0 mt-0">
                    <a href="?pagina=trabalho" class="btn text-white rounded  m-0 p-2">
                        Adicionar Trabalho
                    </a>
                </li>
                <li class="nav-item m-5 mb-0 mt-0"></li>





                <!-- Botão dropdown alinhado à direita -->
                <li class="nav-item dropdown ms-auto me-5 m-1 mt-0">

                    <a class="nav-link btn btn-dark text-white dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Selecione a tabela
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li>
                            <a class="dropdown-item text-white alternar-tabela" data-tabela="tabela-alteracoes">Mostrar
                                Alterações</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-white alternar-tabela" data-tabela="tabela-trabalhos">Mostrar
                                todos os Trabalhos</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-white alternar-tabela"
                                data-tabela="tabela-solicitacoes">Mostrar todas as Solicitações</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-white alternar-tabela"
                                data-tabela="tabela-trabalhos-finalizados">Mostrar Trabalhos finalizados</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="row d-flex justify-content-center mt-5 mb-5"></div>

<div class="row mt-5">
    <div class="col-12">
        <div class="container rounded text-white text-center bg-dark pb-3 pt-3 shadow-lg"><h2>TimeSheet</h2></div>
    </div>
</div>



<div class="container bg-white shadow-lg w-100 pb-2">


    <!-- Tabela e conteúdo da página -->
    <!-- Tabela HTML para exibir os dados -->
    <div class="row pt-3">
        <div class="col-12 text-center">
            <div id="tabela-principal" style="display: none;">
                <table class="table" border="1" cellpadding="10" cellspacing="0"
                    style="width: 100%; border-collapse: collapse;">
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
                                    <td><a class="btn btn-primary p-0 rounded text-white"
                                            href="<?php echo esc_html($linha->arquivo); ?>">Baixar Arquivo</a></td>
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


            <div id="tabela-alteracoes" style="display: block">
                <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                    <thead>
                         <tr>
                            <th colspan="8">
                                <h4>Alterações feitas em todos os trabalhos:</h4>
                            </th>
                        </tr>
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

                          <tr>
                            <th colspan="8">
                                <h4>Lista de trabalhos em andamento:</h4>
                            </th>
                        </tr>

                        <tr style="background-color: #f2f2f2;">
                            <th>Nome do Cliente</th>
                            <th>Número OS</th>
                            <th>Número Orçamento</th>
                            <th>Título do Trabalho</th>
                            <th>Horas Gastas</th>
                            <th>Horas Estimadas</th>
                            <th>Status:</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($dados_trabalho)): ?>
                            <?php foreach ($dados_trabalho as $linha): ?>
                                <?php $classeVermelha = $linha->horasGastasComp > $linha->horasEstimadasComp ? 'classe-vermelha' : ''; ?>
                                <tr>
                                    <td><?php echo esc_html($linha->nomeCliente); ?></td>
                                    <td><?php echo esc_html($linha->numOs); ?></td>
                                    <td><?php echo esc_html($linha->numOrcamento); ?></td>
                                    <td><?php echo esc_html($linha->tituloTrabalho); ?></td>
                                    <td class="<?php echo $classeVermelha; ?>"><?php echo esc_html($linha->horasGastas); ?>
                                    </td>
                                    <td class="<?php echo $classeVermelha; ?>">
                                        <?php echo esc_html($linha->horasEstimadas); ?>
                                    </td>
                                    <td><?php echo esc_html($linha->statusTrabalho); ?></td>
                                    <td class="pl-3"><button class="mais-info-btn alternar-tabela mb-2 btn btn-outline-primary"
                                            data-tabela="tabela-alteracoes-especifica"
                                            value="<?php echo esc_html($linha->idTrabalho); ?>">Mais Informações</button>
                                        <button class="finalizar-trabalho mb-2 btn btn-outline-danger"
                                            value="<?php echo esc_html($linha->idTrabalho); ?>">Finalizar Trabalho</button>
                                        <br>
                                        <a class="btn btn-outline-primary rounded"
                                            href="<?php echo esc_html($linha->arquivo); ?>">Ver Arquivo</a>
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
                        <tr>
                            <th colspan="8">
                                <h4>Trabalhos finalizados:</h4>
                            </th>
                        </tr>

                        <tr style="background-color: #f2f2f2;">
                            <th>Nome do Cliente</th>
                            <th>Número OS</th>
                            <th>Número Orçamento</th>
                            <th>Título do Trabalho</th>
                            <th>Horas Gastas</th>
                            <th>Horas Estimadas</th>
                            <th>Status:</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($dados_trabalho_finalizado)): ?>
                            <?php foreach ($dados_trabalho_finalizado as $linha): ?>
                                <?php $classeVermelha = $linha->horasGastasComp > $linha->horasEstimadasComp ? 'classe-vermelha' : ''; ?>
                                <tr>
                                    <td><?php echo esc_html($linha->nomeCliente); ?></td>
                                    <td><?php echo esc_html($linha->numOs); ?></td>
                                    <td><?php echo esc_html($linha->numOrcamento); ?></td>
                                    <td><?php echo esc_html($linha->tituloTrabalho); ?></td>
                                    <td class="<?php echo $classeVermelha; ?>"><?php echo esc_html($linha->horasGastas); ?>
                                    </td>
                                    <td class="<?php echo $classeVermelha; ?>">
                                        <?php echo esc_html($linha->horasEstimadas); ?>
                                    </td>
                                    <td><?php echo esc_html($linha->statusTrabalho); ?></td>
                                    <td><button class="mais-info-btn alternar-tabela mb-2 btn btn-outline-primary"
                                            data-tabela="tabela-alteracoes-especifica"
                                            value="<?php echo esc_html($linha->idTrabalho); ?>">Mais Informações</button>
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


                <table border="0" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                    <thead>

                        <tr>
                            <th colspan="8">
                                <h4>Trabalhos ainda não iniciados:</h4>
                            </th>
                        </tr>
                        <tr style="background-color: #f2f2f2;">
                            <th>Nome do Cliente</th>
                            <th>Número OS</th>
                            <th>Número Orçamento</th>
                            <th>Título do Trabalho</th>
                            <th>Horas Estimadas</th>
                            <th>Status:</th>
                            <th>Ações</th>
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
                                    <td><?php echo esc_html($linha->horasEstimadas); ?></td>
                                    <td><?php echo esc_html($linha->statusTrabalho); ?></td>
                                    <td><button class="mais-info-btn alternar-tabela btn btn-outline-primary"
                                            data-tabela="tabela-alteracoes-especifica"
                                            value="<?php echo esc_html($linha->idTrabalho); ?>">Mais Informações</button>
                                        <a class="btn btn-outline-primary rounded"
                                            href="<?php echo esc_html($linha->arquivo); ?>">Ver Arquivo</a>
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
        </div>


    </div>



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
    document.addEventListener('DOMContentLoaded', function () {
        // Delegação de eventos para os botões alternar-tabela
        document.body.addEventListener('click', function (event) {
            if (event.target.classList.contains('alternar-tabela')) {
                const tabelaId = event.target.getAttribute('data-tabela');

                // Ocultar todas as tabelas
                document.querySelectorAll('div[id^="tabela-"]').forEach(function (tabela) {
                    tabela.style.display = 'none';
                });

                // Mostrar a tabela correspondente
                if (tabelaId) {
                    const tabela = document.getElementById(tabelaId);
                    if (tabela) {
                        tabela.style.display = 'block';
                    }
                }
            }
        });

        // Delegação de eventos para botões "mais-info"
        document.body.addEventListener('click', function (event) {
            if (event.target.classList.contains('mais-info-btn')) {
                const tabelaId = event.target.getAttribute('data-tabela');
                const idTrabalho = event.target.value;

                if (tabelaId && idTrabalho) {
                    // Aqui você pode adicionar lógica adicional se necessário, como buscar dados via AJAX
                    const tabela = document.getElementById(tabelaId);
                    if (tabela) {
                        document.querySelectorAll('div[id^="tabela-"]').forEach(function (tabela) {
                            tabela.style.display = 'none';
                        });
                        tabela.style.display = 'block';
                    }
                }
            }
        });
    });



    document.querySelectorAll('.finalizar-trabalho').forEach(button => {
        button.addEventListener('click', function () {
            var id_trabalho = this.value;


            fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
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
                        alert('Falha ao finalizar trabalho. Um trabalho deve ser iniciado antes de ser finalizado');
                    }
                })
                .catch(error => console.error('Erro:', error));
        });
    });




    document.querySelectorAll('.mais-info-btn').forEach(button => {
        button.addEventListener('click', function () {

            var id_trabalho = this.value;

            fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
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
                                        <tr> <th colspan="8" class="text-start"><div class="row"> <div class="col-9"><h4>Histórico do trabalho ${alteracao.tituloTrabalho}</h4></div> <div class="col"> <a href="?pagina=alteracao&idTrabalho=${alteracao.idTrabalho}" class="btn btn-success">Adicionar Alteração</a> </div>  </div>
                                        <h5>Vendedor: ${alteracao.vendedor} <h5>  
                                        <h5>Descrição do trabalho:</h5> ${alteracao.observacoes}
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
                        // document.getElementById('tabela-alteracoes-especifica').style.display = "block";
                        // mostrarTabela('tabela-alteracoes-especifica');
                        // <button class="btn alternar-tabela" data-tabela="tabela-alteracoes-especifica">Mais informações</button>
                    } else {
                        alert(data.data.message || 'Erro ao buscar alterações.');
                    }
                });
        });
    });

</script>