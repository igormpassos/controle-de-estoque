<?php
ob_start();
include('../../components/header.php');

// Conexão com o Neo4j
include('../../bd.php'); 
$id = $_GET['id']; // Pega o ID do equipamento a ser editado

// Inicializando mensagem de feedback
$message = '';

// Query para buscar as localizações
$queryLocalizacoes = 'MATCH (l:Localizacao) RETURN l';
$resultLocalizacoes = $client->run($queryLocalizacoes);

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST['tipo'];
    $fabricante = $_POST['fabricante'];
    $numeroSerie = $_POST['numeroSerie'];
    $status = $_POST['status'];
    $localizacaoId = $_POST['localizacao']; // Nova localização selecionada

    if (!empty($tipo) && !empty($fabricante) && !empty($numeroSerie) && !empty($status) && !empty($localizacaoId)) {
        // Query para atualizar o equipamento e associá-lo a nova localização
        $query = 'MATCH (e:Equipamento {id: $id})
                  OPTIONAL MATCH (e)-[r:LOCATED_IN]->() // Remove o relacionamento atual de localização
                  DELETE r
                  SET e.tipo = $tipo, e.fabricante = $fabricante, e.numeroSerie = $numeroSerie, e.status = $status
                  WITH e
                  MATCH (l:Localizacao {id: $localizacaoId}) // Associa nova localização
                  CREATE (e)-[:LOCATED_IN]->(l)';
        
        $params = [
            'id' => $id,
            'tipo' => $tipo,
            'fabricante' => $fabricante,
            'numeroSerie' => $numeroSerie,
            'status' => $status,
            'localizacaoId' => $localizacaoId
        ];

        // Executa a query no banco de dados Neo4j
        $client->run($query, $params);

        $message = "Equipamento atualizado e associado à nova localização com sucesso!";
    } else {
        $message = "Por favor, preencha todos os campos!";
    }
}

// Query para buscar os detalhes do equipamento
$query = 'MATCH (e:Equipamento {id: $id})-[:LOCATED_IN]->(l:Localizacao) RETURN e, l';
$params = ['id' => $id];
$result = $client->run($query, $params);

// Acessa os valores do equipamento e localização atuais
$equipamento = $result->first()->get('e');
$localizacaoAtual = $result->first()->get('l');

$tipo = $equipamento->getProperty('tipo');
$fabricante = $equipamento->getProperty('fabricante');
$numeroSerie = $equipamento->getProperty('numeroSerie');
$status = $equipamento->getProperty('status');
$localizacaoAtualId = $localizacaoAtual->getProperty('id');
?>

<div class="main-panel">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Editar Equipamento: <?php echo $tipo; ?></h4>

            <?php if ($message) : ?>
                <div class="alert alert-info">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <!-- Formulário de edição -->
            <form class="forms-sample" method="POST" action="">
              <input type="hidden" name="id" value="<?php echo $id; ?>" />

              <div class="form-group">
                <label for="tipo">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo $tipo; ?>" placeholder="Tipo" required>
              </div>
              <div class="form-group">
                <label for="fabricante">Fabricante</label>
                <input type="text" class="form-control" id="fabricante" name="fabricante" value="<?php echo $fabricante; ?>" placeholder="Fabricante" required>
              </div>
              <div class="form-group">
                <label for="numeroSerie">Número de Série</label>
                <input type="text" class="form-control" id="numeroSerie" name="numeroSerie" value="<?php echo $numeroSerie; ?>" placeholder="Número de Série" required>
              </div>
              <div class="form-group">
                <label for="status">Status</label>
                <select class="form-select" id="status" name="status" required>
                  <option value="Disponível" <?php if ($status === 'Disponível') echo 'selected'; ?>>Disponível</option>
                  <option value="Indisponível" <?php if ($status === 'Indisponível') echo 'selected'; ?>>Indisponível</option>
                  <option value="Manutenção" <?php if ($status === 'Manutenção') echo 'selected'; ?>>Manutenção</option>
                </select>
              </div>

              <!-- Campo de seleção para localização -->
              <div class="form-group">
                <label for="localizacao">Localização</label>
                <select class="form-control" id="localizacao" name="localizacao" required>
                  <option value="" disabled>Selecione a localização</option>
                  <?php
                  // Itera pelas localizações e cria as opções do select
                  foreach ($resultLocalizacoes as $record) {
                      $localizacao = $record->get('l');
                      $localizacaoId = $localizacao->getProperty('id');
                      $nomeLocalizacao = $localizacao->getProperty('nome');
                      $andarLocalizacao = $localizacao->getProperty('andar');
                      $departamentoLocalizacao = $localizacao->getProperty('departamento');

                      $selected = $localizacaoId === $localizacaoAtualId ? 'selected' : '';
                      echo "<option value='{$localizacaoId}' {$selected}>{$nomeLocalizacao} - {$departamentoLocalizacao} (Andar: {$andarLocalizacao}, ID: {$localizacaoId})</option>";
                  }
                  ?>
                </select>
              </div>

              <button type="submit" class="btn btn-primary me-2">Atualizar</button>
              <a class="btn btn-light" href="/controle-de-estoque/dist">Cancelar</a>
            </form>

            <form class="mt-4" method="POST" action="delete.php">
                <input type="hidden" name="id" value="<?php echo $id; ?>" />
                <button type="submit" class="btn btn-danger"
                  onclick="return confirm('Tem certeza que deseja excluir este equipamento?');">
                  Excluir
                </button>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php
ob_end_flush();
include('../../components/footer.php');
?>
