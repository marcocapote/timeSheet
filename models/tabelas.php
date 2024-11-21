<?php
function create_tables() {
create_table_clientes();
create_table_trabalhos();   
create_table_alteracoes();
create_table_timeSheet();
}

function drop_tables() {
    global $wpdb;

    $tables = [
        $wpdb->prefix . 'timesheet_clientes',
        $wpdb->prefix . 'timesheet_trabalhos',
        $wpdb->prefix . 'timesheet_alteracoes',
        $wpdb->prefix . 'timesheet_timeSheet',
    ];

    foreach ($tables as $table) {
        $wpdb->query("DROP TABLE IF EXISTS $table");
    }
}

function create_table_clientes() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $nome_tabela = $wpdb->prefix . 'timesheet_clientes';

    $sql = "CREATE TABLE $nome_tabela (
    idCliente INT NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    PRIMARY KEY (idCLiente)
    ) $charset_collate;
     ";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

}

function create_table_trabalhos() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $nome_tabela = $wpdb->prefix . 'timesheet_trabalhos';

    $sql = "CREATE TABLE $nome_tabela (
    idTrabalho INT NOT NULL AUTO_INCREMENT,
    idCliente INT NOT NULL,
    statusTrabalho VARCHAR(20),
    numOs VARCHAR(6),
    numOrcamento VARCHAR(10),
    titulo VARCHAR(40),
    arquivo VARCHAR(150),
    FOREIGN KEY (idCliente) REFERENCES {$wpdb->prefix}timesheet_clientes (idCliente),
    vendedor VARCHAR(100),
    observacoes TEXT,
    horasEstimadas DECIMAL(5,2) NOT NULL,
    horasGastas DECIMAL(5,2) NOT NULL,
    dataCriacao DATETIME,
    PRIMARY KEY (idTrabalho)

    

    ) $charset_collate;
    "; 

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
function create_table_alteracoes() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $nome_tabela = $wpdb->prefix . 'timesheet_alteracoes';

    $sql = "CREATE TABLE $nome_tabela (
    idAlteracao INT NOT NULL AUTO_INCREMENT,
    idTrabalho INT NOT NULL,
    editor VARCHAR(50),
    inicio DATETIME NOT NULL,
    fim DATETIME NOT NULL,
    descricao TEXT NOT NULL,
    PRIMARY KEY (idAlteracao),
    FOREIGN KEY (idTrabalho) REFERENCES {$wpdb->prefix}timesheet_trabalhos (idTrabalho)

    ) $charset_collate;
    ";
    
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function create_table_timeSheet(){
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $nome_tabela = $wpdb->prefix . 'timesheet_timeSheet';

    $sql = "CREATE TABLE $nome_tabela (
    idTimeSheet INT NOT NULL AUTO_INCREMENT,
    idCliente INT NOT NULL,
    idTrabalho INT NOT NULL,
    idAlteracao INT NOT NULL,

    PRIMARY KEY (idTimeSheet),
    FOREIGN KEY (idCliente) REFERENCES {$wpdb->prefix}timesheet_clientes (idCliente),
    FOREIGN KEY (idTrabalho) REFERENCES {$wpdb->prefix}timesheet_trabalhos (idTrabalho),
    FOREIGN KEY (idAlteracao) REFERENCES {$wpdb->prefix}timesheet_alteracoes (idAlteracao)

    ) $charset_collate;
    ";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
    

?>
