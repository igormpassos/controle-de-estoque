<?php
include('../../components/header.php');

// Conexão com o Neo4j
include('../../bd.php'); 

// Query para buscar todas as localizações
$query = 'MATCH (l:Localizacao) RETURN l';
$result = $client->run($query);
?>

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Localizações</h4>
            <p class="card-description">Listagem das Localizações</p>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Andar</th>
                    <th>Departamento</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // Itera pelos resultados e popula a tabela
                  foreach ($result as $record) {
                      $localizacao = $record->get('l');
                      $id = $localizacao->getProperty('id');
                      $nome = $localizacao->getProperty('nome');
                      $andar = $localizacao->getProperty('andar');
                      $departamento = $localizacao->getProperty('departamento');
                      echo "<tr>";
                      echo "<td>{$id}</td>";
                      echo "<td>{$nome}</td>";
                      echo "<td>{$andar}</td>";
                      echo "<td>{$departamento}</td>";
                      echo "<td>";
                      echo "<a href='./edit.php?id={$id}' class='btn btn-primary btn-sm'>Editar</a> ";
                      echo "<form method='POST' action='./delete.php' style='display:inline-block;'>";
                      echo "<input type='hidden' name='id' value='{$id}' />";
                      echo "<button type='submit' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja excluir esta localização?\");'>Excluir</button>";
                      echo "</form>";
                      echo "</td>";
                      echo "</tr>";
                  }
                  ?>
                </tbody>
              </table>
              <a href="./add.php" class="btn btn-primary btn-sm">Cadastrar Nova Localização</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<?php
include('../../components/footer.php');
?>
