<?php
if (!defined('ABSPATH'))
    exit;


$dados_timesheet = TimeSheetController::buscar_dados_timesheet();
$dados_alteracao = TimeSheetController::buscar_alteracao_timesheet();
$dados_trabalho = TimeSheetController::buscar_trabalho_timesheet();
$dados_trabalho_finalizado = TimeSheetController::buscar_trabalho_finalizado_timesheet();
$dados_solicitacao = TimeSheetController::buscar_solicitacao_timesheet();


$clientes = TrabalhoController::listarClientes();
include(plugin_dir_path(__FILE__) . '../header.php');



?>
<nav
    class="navbar fixed-top bg-secondary border-secondary border-top-0 border-bottom-0 navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav w-100 text-white me-auto">
                <li class="nav-item m-1 mt-1">
                    <a href="?pagina=timeSheet" class="text-white">
                        <h4>Painel Timesheet</h4>
                    </a>
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
                
                

                <?php
                $current_user = wp_get_current_user();
                $roles = $current_user->roles;

                if ($roles[0] == "administrator"): ?>
                <li class="nav-item m-5 mb-0 mt-0"></li>
                    <li class="nav-item m-0 mb-0 mt-0 ms-auto me-3">
                        <button class="btn btn-outline-light rounded m-0 mt-1 p-1 alternar-tabela"
                            data-tabela="tabela-solicitacoes">Ver Solicitações</button>
                    </li>
                <?php endif; 
                if ($roles[0] != "administrator"):
                ?>
                <li class="nav-item m-5 ms-auto mb-0 mt-0"></li>
                <?php endif;?>

                <!-- Botão dropdown alinhado à direita -->
                <li class="nav-item dropdown me-5 pe-5 m-1 mt-0">
                    <a class="nav-link btn btn-dark text-white dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Selecione a tabela
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark me-5">
                        <li>
                            <a class="dropdown-item text-white alternar-tabela"
                                data-tabela="tabela-alteracoes">Histórico de alterações</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-white alternar-tabela" data-tabela="tabela-trabalhos">Trabalhos
                                em andamento</a>
                        </li>

                        <li>
                            <a class="dropdown-item text-white alternar-tabela"
                                data-tabela="tabela-trabalhos-finalizados">Trabalhos finalizados</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-white alternar-tabela"
                                data-tabela="tabela-buscar-trabalho-cliente">
                                Buscar trabalho por cliente
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-white alternar-tabela"
                                data-tabela="tabela-buscar-trabalho-vendedor">
                                Buscar trabalho por vendedor
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-white alternar-tabela"
                                data-tabela="tabela-buscar-trabalho-titulo">Buscar trabalho pelo titulo</a>
                        </li>
                    </ul>
                    </l>
            </ul>
        </div>
    </div>
</nav>
<div class="row d-flex justify-content-center mt-5 mb-5"></div>

<div class="row mt-5">
    <div class="col-12">
        <div class="container rounded text-white text-center bg-dark pb-3 pt-3 shadow-lg">
            <h2>TimeSheet</h2>
        </div>
    </div>
</div>



<div class="container bg-white shadow-lg w-100 pb-2 mb-5">


    <!-- Tabela e conteúdo da página -->
    <!-- Tabela HTML para exibir os dados -->
    <div class="row pt-3 ">
        <div class="col-12 text-center ">
            <div id="tabela-alteracoes" style="display: none">
                <table border="1" class="table" cellpadding="10" cellspacing="0"
                    style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th colspan="8">
                                <h4>Histórico de alterações:</h4>
                            </th>
                        </tr>
                        <tr style="background-color: #f2f2f2;">
                            <th>Nome do Cliente</th>

                            <th>Número Os</th>
                            <th>Título do Trabalho</th>
                            <th class="text-start">Descrição da Alteração</th>
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
                                    <td><?php echo esc_html($linha->tituloTrabalho); ?></td>
                                    <td class="text-start"><?php echo esc_html($linha->descricaoAlteracao); ?></td>
                                    <td><?php echo esc_html($linha->horasGastas); ?></td>
                                    <td class="text-start">
                                        <?php echo esc_html(date('d/m/Y H:i', strtotime($linha->inicioAlteracao))); ?>
                                    </td>
                                    <td class="text-start">
                                        <?php echo esc_html(date('d/m/Y H:i', strtotime($linha->fimAlteracao))); ?>
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

            <div id="tabela-alteracoes-especifica" style="display:none">

                <table border="1" cellpadding="10" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f2f2f2;">
                            <th>Nome do Cliente</th>
                            <th>Número OS</th>
                            <th>Número Orçamento</th>
                            <th>Título do Trabalho</th>
                            <th class="text-start">Descrição da Alteração</th>
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
                                    <td class="text-start"><?php echo esc_html($linha->descricaoAlteracao); ?></td>
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

            <div id="tabela-buscar-trabalho-cliente" style="display:none">
                <div class="container w-75 mb-3">

                    <div class="d-flex">
                        <select name="idCliente" id="idCliente" class="form-control text-muted" required>
                            <option value="">Selecione um cliente</option>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?php echo $cliente->idCliente; ?>">
                                    <?php echo esc_html($cliente->nome); ?>
                                </option>
                            <?php endforeach; ?>
                        </select><br>
                        <button class="btn btn-outline-success btn-buscar-trabalho-cliente"
                            id="btn-buscar-trabalho-cliente">Buscar trabalhos</button>
                    </div>
                </div>

                <table border="1" class="table" cellpadding="10" cellspacing="0"
                    style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th colspan="8">
                                <h5>Nenhum cliente selecionado</h5>
                            </th>
                        </tr>
                        <tr>
                            <th> Numero da OS </th>
                            <th> Titulo do Trabalho </th>
                            <th class="align-middle"> Cliente </th>
                            <th class="text-start align-middle"> Descrição </th>

                            <th> Horas Gastas </th>
                            <th> Horas Estimadas </th>
                            <th class="align-middle"> Status </th>
                            <th class="align-middle"> Mais Ações </th>
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
                                    <td></td>
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

            <div id="tabela-buscar-trabalho-vendedor" style="display:none">

                <div class="container w-75 mb-3">

                    <div class="d-flex">

                        <select name="vendedor" id="vendedor" class="form-control  text-muted">
                            <option value="">Nenhum vendedor selecionado</option>
                            <option value="Vendedor1">Vendedor1</option>
                            <option value="Vendedor2">Vendedor2</option>
                            <option value="Vendedor3">Vendedor3</option>
                        </select>
                        <button class="btn btn-outline-success btn-buscar-trabalho-vendedor"
                            id="btn-buscar-trabalho-vendedor">Buscar trabalhos</button>

                    </div>

                </div>

                <table border="1" class="table" cellpadding="10" cellspacing="0"
                    style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th colspan="8">
                                <h5>Selecione um vendedor</h5>
                            </th>
                        </tr>
                        <tr>
                            <th> Numero da OS </th>
                            <th> Titulo do Trabalho </th>
                            <th class="align-middle"> Cliente </th>
                            <th class="text-start align-middle"> Descrição </th>
                            <th> Horas Gastas </th>
                            <th> Horas Estimadas </th>
                            <th class="align-middle"> Status </th>
                            <th class="align-middle"> Mais Ações </th>
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

            <div id="tabela-buscar-trabalho-titulo" style="display:none">

                <div class="container w-75 mb-3">

                    <div class="d-flex">

                        <input class="form-control me-2" type="search" placeholder="Digite o titulo ou palavras-chave"
                            aria-label="Search" id="titulo">
                        <button class="btn btn-outline-success btn-buscar-trabalho-titulo"
                            id="btn-buscar-trabalho-titulo">Buscar trabalhos</button>

                    </div>

                </div>

                <table border="1" class="table" cellpadding="10" cellspacing="0"
                    style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th> Numero da OS </th>
                            <th> Titulo do Trabalho </th>
                            <th class="align-middle"> Cliente </th>
                            <th class="text-start align-middle"> Descrição </th>
                            <th> Horas Gastas </th>
                            <th> Horas Estimadas </th>
                            <th class="align-middle"> Status </th>
                            <th class="align-middle"> Mais Ações </th>
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

            <div id="tabela-trabalhos" style="display:block">
                <table border="1" class="table" cellspacing="0" style="width: 100%; border-collapse: collapse;">
                    <thead>

                        <tr>
                            <th colspan="8">
                                <h4>Lista de trabalhos em andamento:</h4>
                            </th>
                        </tr>

                        <tr style="background-color: #f2f2f2;">
                            <th>Nome do Cliente</th>
                            <th>Número Os</th>
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
                                    <td><?php echo esc_html($linha->tituloTrabalho); ?></td>
                                    <td class="<?php echo $classeVermelha; ?>"><?php echo esc_html($linha->horasGastas); ?>
                                    </td>
                                    <td class="<?php echo $classeVermelha; ?>">
                                        <?php echo esc_html($linha->horasEstimadas); ?>
                                    </td>
                                    <td><?php echo esc_html($linha->statusTrabalho); ?></td>
                                    <td class="pl-0"><button
                                            class="mais-info-btn p-0 m-0 alternar-tabela mb-2 btn btn-outline-primary"
                                            data-tabela="tabela-alteracoes-especifica" style="width:150px;"
                                            value="<?php echo esc_html($linha->idTrabalho); ?>">Mais Informações</button>

                                        <br>
                                        <a class="btn btn-outline-primary p-0 m-0 rounded" style="width:150px;"
                                            href="<?php echo esc_html($linha->arquivo); ?>">Ver Arquivo</a>
                                        <br>
                                        <button class="finalizar-trabalho p-0 m-0 mt-2 btn btn-outline-danger"
                                            style="width:150px" value="<?php echo esc_html($linha->idTrabalho); ?>">Finalizar
                                            Trabalho</button>
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
                <table border="1" class="table" cellpadding="10" cellspacing="0"
                    style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th colspan="8">
                                <h4>Trabalhos finalizados:</h4>
                            </th>
                        </tr>

                        <tr style="background-color: #f2f2f2;">
                            <th>Nome do Cliente</th>
                            <th>Número Os</th>
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
                                    <td><?php echo esc_html($linha->tituloTrabalho); ?></td>
                                    <td class="<?php echo $classeVermelha; ?>"><?php echo esc_html($linha->horasGastas); ?>
                                    </td>
                                    <td class="<?php echo $classeVermelha; ?>">
                                        <?php echo esc_html($linha->horasEstimadas); ?>
                                    </td>
                                    <td><?php echo esc_html($linha->statusTrabalho); ?></td>
                                    <td><button class="mais-info-btn alternar-tabela m-0 p-0 mb-2 btn btn-outline-primary"
                                            data-tabela="tabela-alteracoes-especifica" style="width: 150px;"
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


                <table border="0" class="table" cellpadding="10" cellspacing="0"
                    style="width: 100%; border-collapse: collapse;">
                    <thead>

                        <tr>
                            <th colspan="8">
                                <h4>Trabalhos ainda não iniciados:</h4>
                            </th>
                        </tr>
                        <tr style="background-color: #f2f2f2;">
                            <th>Nome do Cliente</th>
                            <th>Número Os</th>
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
                                    <td><?php echo esc_html($linha->tituloTrabalho); ?></td>
                                    <td><?php echo esc_html($linha->horasEstimadas); ?></td>
                                    <td><?php echo esc_html($linha->statusTrabalho); ?></td>
                                    <td><button class="mais-info-btn alternar-tabela p-0 m-0 btn btn-outline-primary"
                                            data-tabela="tabela-alteracoes-especifica" style="width: 150px;"
                                            value="<?php echo esc_html($linha->idTrabalho); ?>">Mais Informações</button>
                                        <br>
                                        <a class="btn btn-outline-primary p-0 m-0 rounded mt-2" style="width: 150px;"
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

        // Delegação de eventos para botões "mais-info"
        document.body.addEventListener('click', function (event) {

            if (event.target.classList.contains('finalizar-trabalho')) {
                var id_trabalho = event.target.value;


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
            }

            if (event.target.classList.contains('btn-buscar-trabalho-cliente')) {
                var id_cliente = document.getElementById('idCliente').value;

                fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        action: 'buscar_trabalho_cliente',
                        id_cliente: id_cliente
                    })
                })

                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const tbody = document.querySelector('#tabela-buscar-trabalho-cliente tbody');
                            tbody.innerHTML = '';
                            const thead = document.querySelector('#tabela-buscar-trabalho-cliente thead');
                            thead.innerHTML = '';

                            data.data.forEach(trabalho => {
                                const row = `<tr>
                                                <td>${trabalho.numOs}</td>
                                                <td>${trabalho.tituloTrabalho}</td>
                                                <td>${trabalho.vendedor}</td>
                                                <td class="text-start">${trabalho.observacoes}</td>
                                                <td>${trabalho.horasGastas}</td>
                                                <td>${trabalho.horasEstimadas}</td>
                                                <td>${trabalho.statusTrabalho}</td>
                                                <td class="pl-3">
                                                <button class="mais-info-btn alternar-tabela p-0 m-0 mb-2 btn btn-outline-primary"
                                                data-tabela="tabela-alteracoes-especifica" style="width: 150px"
                                                value="${trabalho.idTrabalho}">Mais Informações</button>
                                                <br>    
                                                <a class="btn btn-outline-primary p-0 m-0 rounded" style="width: 150px;" href="${trabalho.arquivo}">Ver Arquivo</a>
                                                <br>
                                                <button class="finalizar-trabalho p-0 m-0 mt-2 btn btn-outline-danger" style="width:150px;"
                                                value="${trabalho.idTrabalho}">Finalizar Trabalho</button>
                                                </td>
                                            </tr>`;

                                tbody.innerHTML += row;
                                thead.innerHTML = ` 
                                <tr>
                                    <th colspan="8">
                                      <h5>Exibindo trabalhos de: ${trabalho.nomeCliente}</h5>
                                    </th>
                                </tr>

                                <tr> 
                                    <th> Numero da OS </th>
                                    <th> Titulo do Trabalho </th>
                                    <th class="align-middle"> Vendedor </th>
                                    <th class="text-start align-middle"> Descrição </th>
                                    <th> Horas Gastas </th>
                                    <th> Horas Estimadas </th>
                                    <th class="align-middle"> Status </th>
                                    <th class="align-middle"> Mais Ações </th>
                                </tr>
            `;
                            })
                        } else {
                            alert(data.data.message || 'Erro ao buscar trabalhos.');
                        }
                    })
            }


            if (event.target.classList.contains('btn-buscar-trabalho-vendedor')) {
                var vendedor = document.getElementById('vendedor').value;

                fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        action: 'buscar_trabalho_vendedor',
                        vendedor: vendedor
                    })
                })

                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const tbody = document.querySelector('#tabela-buscar-trabalho-vendedor tbody');
                            tbody.innerHTML = '';
                            const thead = document.querySelector('#tabela-buscar-trabalho-vendedor thead');
                            thead.innerHTML = '';

                            data.data.forEach(trabalho => {
                                const row = `<tr>
                                                <td>${trabalho.numOs}</td>
                                                <td class="text-start">${trabalho.tituloTrabalho}</td>
                                                <td>${trabalho.nomeCliente}</td>
                                                <td class="text-start">${trabalho.observacoes}</td>
                                                <td >${trabalho.horasGastas}</td>
                                                <td >${trabalho.horasEstimadas}</td>
                                                <td >${trabalho.statusTrabalho}</td>
                                                <td class="pl-3">
                                                <button class="mais-info-btn alternar-tabela mb-2 p-0 m-0 btn btn-outline-primary"
                                                data-tabela="tabela-alteracoes-especifica"
                                                value="${trabalho.idTrabalho}" style="width: 150px;">Mais Informações</button>
                                                <br>
                                                <a class="btn btn-outline-primary p-0 m-0 rounded" style="width:150px;"
                                                                            href="${trabalho.arquivo}">Ver Arquivo</a>
                                                    <br>
                                                <button class="finalizar-trabalho p-0 m-0 mt-2 btn btn-outline-danger"
                                                value="${trabalho.idTrabalho}" style="width: 150px;">Finalizar Trabalho</button>
                                                </td>
                                            </tr>`;

                                tbody.innerHTML += row;
                                thead.innerHTML = `
                                            <tr>
                                                <th colspan="8">
                                                <h5>Exibindo trabalhos de: ${trabalho.vendedor}</h5>
                                                </th>
                                                </tr>
                                            <tr> 
                                                <th> Numero da OS </th>
                                                <th> Titulo do Trabalho </th>
                                                <th class="align-middle"> Cliente </th>
                                                <th class="text-start align-middle"> Descrição </th>
                                                <th> Horas Gastas </th>
                                                <th> Horas Estimadas </th>
                                                <th class="align-middle"> Status </th>
                                                <th class="align-middle"> Mais Ações </th>
                                            </tr>
                                        `;
                            })
                        } else {
                            alert(data.data.message || 'Erro ao buscar trabalhos.');
                        }
                    })
            }

            if (event.target.classList.contains('btn-buscar-trabalho-titulo')) {
                var titulo = document.getElementById('titulo').value;

                fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({
                        action: 'buscar_trabalho_titulo',
                        titulo: titulo
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const tbody = document.querySelector('#tabela-buscar-trabalho-titulo tbody');
                            tbody.innerHTML = '';
                            const thead = document.querySelector('#tabela-buscar-trabalho-titulo thead');
                            thead.innerHTML = '';

                            data.data.forEach(trabalho => {
                                const row = `<tr>
                                                <td>${trabalho.numOs}</td>
                                                <td class="text-start">${trabalho.tituloTrabalho}</td>
                                                <td>${trabalho.nomeCliente}</td>
                                                <td class="text-start">${trabalho.observacoes}</td>
                                                <td >${trabalho.horasGastas}</td>
                                                <td >${trabalho.horasEstimadas}</td>
                                                <td >${trabalho.statusTrabalho}</td>
                                                <td class="pl-3">
                                                <button class="mais-info-btn alternar-tabela mb-2 p-0 m-0 btn btn-outline-primary"
                                                data-tabela="tabela-alteracoes-especifica"
                                                value="${trabalho.idTrabalho}" style="width: 150px;">Mais Informações</button>
                                                <br>
                                                <a class="btn btn-outline-primary p-0 m-0 rounded" style="width:150px;"
                                                                            href="${trabalho.arquivo}">Ver Arquivo</a>
                                                    <br>
                                                <button class="finalizar-trabalho p-0 m-0 mt-2 btn btn-outline-danger"
                                                value="${trabalho.idTrabalho}" style="width: 150px;">Finalizar Trabalho</button>
                                                </td>
                                            </tr>`;

                                tbody.innerHTML += row;
                                thead.innerHTML = `
                                            <tr> 
                                                <th> Numero da OS </th>
                                                <th> Titulo do Trabalho </th>
                                                <th class="align-middle"> Cliente </th>
                                                <th class="text-start align-middle"> Descrição </th>
                                                <th> Horas Gastas </th>
                                                <th> Horas Estimadas </th>
                                                <th class="align-middle"> Status </th>
                                                <th class="align-middle"> Mais Ações </th>
                                            </tr>
                                        `;
                            })
                        } else {
                            alert(data.data.message || 'Erro ao buscar trabalhos.');
                        }
                    })
            }



            if (event.target.classList.contains('mais-info-btn')) {
                var id_trabalho = event.target.value;

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
                                    <td class="text-start">${alteracao.descricao}</td>
                                    <td>${alteracao.horasGastas}</td>
                                    <td class="text-start">${new Date(alteracao.inicioAlteracao).toLocaleString()}</td>
                                    <td class="text-start">${new Date(alteracao.fimAlteracao).toLocaleString()}</td>
                                </tr>`;
                                tbody.innerHTML += row;
                                thead.innerHTML = ` 
                                        <tr> <th colspan="8" class="text-start"><div class="row"> <div class="col-9"><h4>Histórico do trabalho ${alteracao.tituloTrabalho}</h4></div> <div class="col"> <a href="?pagina=alteracao&idTrabalho=${alteracao.idTrabalho}" class="btn btn-success ms-5">Adicionar Alteração</a> </div>  </div>
                                        <h5>Vendedor: ${alteracao.vendedor} <h5>  
                                        <h5>Descrição do trabalho:</h5> ${alteracao.observacoes}
                                        </th> </tr>                   
                                        <tr style="background-color: #f2f2f2;">
                                        <th>Nome do Cliente</th>
                                        <th>Número OS</th>
                                        <th>Número Orçamento</th>
                                        <th>Título do Trabalho</th>
                                        <th class="text-start">Descrição da Alteração</th>
                                        <th>Horas Gastas</th>
                                        <th class="text-start">Início Alteração</th>
                                        <th class="text-start">Fim Alteração</th>
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
            }
        });
    });

</script>