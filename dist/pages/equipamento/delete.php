<?php

// Conexão com o Neo4j
include('../../bd.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    // Query para deletar o equipamento
    $query = 'MATCH (e:Equipamento {id: $id}) DETACH DELETE e';
    $params = ['id' => $id];

    // Executa a query de exclusão
    $client->run($query, $params);

    // Redireciona após a exclusão
    header('Location: /controle-de-estoque/dist/pages/equipamento/index.php');
    exit;
}
?>
