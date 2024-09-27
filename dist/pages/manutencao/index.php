<?php
include('../../components/header.php');

// Conexão com o Neo4j
include('../../bd.php'); 

// Query para buscar todas as manutenções e os equipamentos relacionados
$query = 'MATCH (e:Equipamento)-[:HAS_MAINTENANCE]->(m:Manutencao) RETURN e, m';
$result = $client->run($query);
?>

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Manutenções</h4>
            <p class="card-description">Listagem das Manutenções</p>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>ID Manutenção</th>
                    <th>Equipamento</th> <!-- Ajustado para exibir o nome do equipamento e ID -->
                    <th>Tipo</th>
                    <th>Data</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Itera pelos resultados e popula a tabela
                  foreach ($result as $record) {
                      $manutencao = $record->get('m');
                      $equipamento = $record->get('e');
                      $idManutencao = $manutencao->getProperty('id');
                      $idEquipamento = $equipamento->getProperty('id');
                      $tipoEquipamento = $equipamento->getProperty('tipo');
                      $fabricanteEquipamento = $equipamento->getProperty('fabricante');
                      
                      // Exibe o nome do equipamento no formato solicitado
                      $nomeEquipamento = "{$tipoEquipamento} - {$fabricanteEquipamento} (ID: {$idEquipamento})";

                      echo "<tr>";
                      echo "<td>{$idManutencao}</td>";
                      echo "<td>{$nomeEquipamento}</td>";
                      echo "<td>{$manutencao->getProperty('tipo')}</td>";
                      echo "<td>{$manutencao->getProperty('data')}</td>";
                      echo "<td>{$manutencao->getProperty('descricao')}</td>";
                      echo "<td>";
                      echo "<a href='./edit.php?id={$idManutencao}' class='btn btn-primary btn-sm'>Editar</a> ";
                      echo "<form method='POST' action='./delete.php' style='display:inline-block;'>";
                      echo "<input type='hidden' name='id' value='{$idManutencao}' />";
                      echo "<button type='submit' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir esta manutenção?\");'>Excluir</button>";
                      echo "</form>";
                      echo "</td>";
                      echo "</tr>";
                  }
                  ?>
                </tbody>
              </table>
              <a href="./add.php" class="btn btn-primary btn-sm">Cadastrar Nova Manutenção</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php
include('../../components/footer.php');
?>
