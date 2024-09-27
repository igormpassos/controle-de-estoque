<?php
// Conexão com o Neo4j
include('../../bd.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    
    // Primeiro, busca o equipamento relacionado à manutenção
    $queryEquipamento = 'MATCH (e:Equipamento)-[:HAS_MAINTENANCE]->(m:Manutencao {id: $id}) RETURN e';
    $resultEquipamento = $client->run($queryEquipamento, ['id' => $id]);
    
    if ($resultEquipamento->count() > 0) {
        $equipamentoId = $resultEquipamento->first()->get('e')->getProperty('id');

        // Query para deletar a manutenção
        $queryDelete = 'MATCH (m:Manutencao {id: $id}) DETACH DELETE m';
        $client->run($queryDelete, ['id' => $id]);

        // Atualiza o status do equipamento para "Disponível"
        $queryUpdateStatus = 'MATCH (e:Equipamento {id: $equipamentoId}) SET e.status = "Disponível"';
        $client->run($queryUpdateStatus, ['equipamentoId' => $equipamentoId]);

        // Redireciona após a exclusão
        header('Location: /controle-de-estoque/dist/pages/manutencao/index.php');
        exit;
    }
}
?>
