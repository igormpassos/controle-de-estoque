<?php
ob_start();
include('../../components/header.php');

// Conexão com o Neo4j
include('../../bd.php'); 


// Inicializando mensagem de feedback
$message = '';

// Busca todas as localizações cadastradas
$queryLocalizacoes = 'MATCH (l:Localizacao) RETURN l';
$resultLocalizacoes = $client->run($queryLocalizacoes);

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST['tipo'];
    $fabricante = $_POST['fabricante'];
    $numeroSerie = $_POST['numeroSerie'];
    $status = $_POST['status'];
    $localizacaoId = $_POST['localizacao'];  // Localização selecionada

    if (!empty($tipo) && !empty($fabricante) && !empty($numeroSerie) && !empty($status) && !empty($localizacaoId)) {
        // Cria um ID único para o equipamento
        $id = uniqid();

        // Query para inserir o novo equipamento e associá-lo à localização
        $query = 'CREATE (e:Equipamento {id: $id, tipo: $tipo, fabricante: $fabricante, numeroSerie: $numeroSerie, status: $status})
                  WITH e
                  MATCH (l:Localizacao {id: $localizacaoId})
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

        $message = "Equipamento cadastrado e associado à localização com sucesso!";
    } else {
        $message = "Por favor, preencha todos os campos!";
    }
}
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Cadastro de Equipamento</h4>
                        <p class="card-description">Insira as informações do equipamento</p>

                        <?php if ($message) : ?>
                            <div class="alert alert-info">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>

                        <form class="forms-sample" method="POST" action="">
                            <div class="form-group">
                                <label for="tipo">Tipo</label>
                                <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Tipo do Equipamento" required>
                            </div>
                            <div class="form-group">
                                <label for="fabricante">Fabricante</label>
                                <input type="text" class="form-control" id="fabricante" name="fabricante" placeholder="Fabricante" required>
                            </div>
                            <div class="form-group">
                                <label for="numeroSerie">Número de Série</label>
                                <input type="text" class="form-control" id="numeroSerie" name="numeroSerie" placeholder="Número de Série" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="Disponível">Disponível</option>
                                    <option value="Indisponível">Indisponível</option>
                                    <option value="Manutenção">Manutenção</option>
                                </select>
                            </div>

                            <!-- Campo de seleção para localização -->
                            <div class="form-group">
                                <label for="localizacao">Localização</label>
                                <select class="form-control" id="localizacao" name="localizacao" required>
                                    <option value="" disabled selected>Selecione a localização</option>
                                    <?php
                                    // Itera pelas localizações e cria as opções do select
                                    foreach ($resultLocalizacoes as $record) {
                                        $localizacao = $record->get('l');
                                        $localizacaoId = $localizacao->getProperty('id');
                                        $nomeLocalizacao = $localizacao->getProperty('nome');
                                        $andarLocalizacao = $localizacao->getProperty('andar');
                                        $departamentoLocalizacao = $localizacao->getProperty('departamento');
                                        echo "<option value='{$localizacaoId}'>{$nomeLocalizacao} - {$departamentoLocalizacao} (Andar: {$andarLocalizacao}, ID: {$localizacaoId})</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <button type="submit" class="btn btn-primary me-2">Cadastrar</button>
                            <a class="btn btn-light" href="/controle-de-estoque/dist">Cancelar</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('../../components/footer.php');
ob_end_flush();
?>
