<?php

// Define a URL base para ser usada em links ou outras partes do sistema, se necessário
$BASE_URL = 'http://localhost/controle-de-estoque';

// O require_once precisa do caminho físico do sistema de arquivos
require_once '/Applications/MAMP/htdocs/controle-de-estoque/vendor/autoload.php'; // Caminho absoluto para o autoload

use Laudis\Neo4j\ClientBuilder;

$client = ClientBuilder::create()
    ->withDriver('bolt', 'bolt://neo4j:controle-de-estoque@localhost:7687') // Conexão Bolt
    ->build();

?>
