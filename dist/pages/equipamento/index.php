<?php
include('../../components/header.php');

// Conexão com o Neo4j
include('../../bd.php'); 

// Query para buscar todos os equipamentos e suas localizações associadas
$query = 'MATCH (e:Equipamento)-[:LOCATED_IN]->(l:Localizacao) RETURN e, l';
$result = $client->run($query);
?>

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Equipamentos</h4>
            <p class="card-description">Listagem dos Equipamentos</p>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Fabricante</th>
                    <th>Número de Série</th>
                    <th>Status</th>
                    <th>Localização</th>
                    <th>Ações</th> <!-- Coluna de ações -->
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Itera pelos resultados e popula a tabela
                  foreach ($result as $record) {
                      $equipamento = $record->get('e');
                      $localizacao = $record->get('l');

                      $id = $equipamento->getProperty('id');
                      $tipo = $equipamento->getProperty('tipo');
                      $fabricante = $equipamento->getProperty('fabricante');
                      $numeroSerie = $equipamento->getProperty('numeroSerie');
                      $status = $equipamento->getProperty('status');
                      $nomeLocalizacao = $localizacao->getProperty('nome');
                      $andarLocalizacao = $localizacao->getProperty('andar');

                      $badgeClass = '';
                      // Define a classe da badge com base no status
                      switch ($status) {
                          case 'Manutenção':
                              $badgeClass = 'badge badge-danger';
                              break;
                          case 'Em Uso':
                              $badgeClass = 'badge badge-warning';
                              break;
                          case 'Disponível':
                              $badgeClass = 'badge badge-success';
                              break;
                          default:
                              $badgeClass = 'badge badge-secondary';
                      }

                      echo "<tr>";
                      echo "<td>{$id}</td>";
                      echo "<td>{$tipo}</td>";
                      echo "<td>{$fabricante}</td>";
                      echo "<td>{$numeroSerie}</td>";
                      echo "<td><label class='{$badgeClass}'>{$status}</label></td>";
                      echo "<td>{$nomeLocalizacao} (Andar: {$andarLocalizacao})</td>";
                      echo "<td>";
                      echo "<a href='./edit.php?id={$id}' class='btn btn-primary btn-sm'>Editar</a> ";
                      echo "<form method='POST' action='./delete.php' style='display:inline-block;'>";
                      echo "<input type='hidden' name='id' value='{$id}' />";
                      echo "<button type='submit' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir este equipamento?\");'>Excluir</button>";
                      echo "</form> ";
                      // Exibe o botão de manutenção apenas se o status não for "Manutenção"
                      if ($status !== 'Manutenção') {
                          echo "<a href='../manutencao/add.php?equipamentoId={$id}' class='btn btn-warning btn-sm'>Colocar em Manutenção</a>";
                      }
                      echo "</td>";
                      echo "</tr>";
                  }
                  ?>
                </tbody>
              </table>
              <a href="./add.php" class="btn btn-primary btn-sm">Cadastrar Novo</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php
include('../../components/footer.php');
?>
