<?php
ob_start();
include('../../components/header.php');

// Conexão com o Neo4j
include('../../bd.php'); 

// Inicializando mensagem de feedback
$message = '';

// Busca todos os equipamentos cadastrados
$queryEquipamentos = 'MATCH (e:Equipamento) RETURN e';
$resultEquipamentos = $client->run($queryEquipamentos);

// Captura o ID do equipamento da URL, se fornecido
$equipamentoIdSelecionado = isset($_GET['equipamentoId']) ? $_GET['equipamentoId'] : '';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $equipamentoId = $_POST['equipamentoId'];  // ID do equipamento selecionado
    $tipo = $_POST['tipo'];
    $data = $_POST['data'];
    $descricao = $_POST['descricao'];

    if (!empty($equipamentoId) && !empty($tipo) && !empty($data) && !empty($descricao)) {
        // Cria um ID único para a manutenção
        $id = uniqid();

        // Query para adicionar a manutenção e vincular ao equipamento
        $query = 'MATCH (e:Equipamento {id: $equipamentoId})
                  CREATE (m:Manutencao {id: $id, tipo: $tipo, data: $data, descricao: $descricao}),
                  (e)-[:HAS_MAINTENANCE]->(m)
                  SET e.status = "Manutenção"'; // Atualiza o status para "Manutenção"
        
        $params = [
            'equipamentoId' => $equipamentoId,
            'id' => $id,
            'tipo' => $tipo,
            'data' => $data,
            'descricao' => $descricao
        ];

        // Executa a query no banco de dados Neo4j
        $client->run($query, $params);

        $message = "Manutenção adicionada e status do equipamento atualizado com sucesso!";
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
                        <h4 class="card-title">Adicionar Manutenção</h4>
                        <p class="card-description">Insira as informações da manutenção</p>

                        <?php if ($message) : ?>
                            <div class="alert alert-info">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>

                        <form class="forms-sample" method="POST" action="">
                            <div class="form-group">
                                <label for="equipamentoId">Equipamento</label>
                                <select class="form-control" id="equipamentoId" name="equipamentoId" required>
                                    <option value="" disabled selected>Selecione o equipamento</option>
                                    <?php
                                    // Itera pelos resultados e popula o select com os equipamentos
                                    foreach ($resultEquipamentos as $record) {
                                        $equipamento = $record->get('e');
                                        $id = $equipamento->getProperty('id');
                                        $tipo = $equipamento->getProperty('tipo');
                                        $fabricante = $equipamento->getProperty('fabricante');
                                        $selected = ($id === $equipamentoIdSelecionado) ? 'selected' : ''; // Pré-seleciona o equipamento
                                        echo "<option value='{$id}' {$selected}>{$tipo} - {$fabricante} (ID: {$id})</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tipo">Tipo de Manutenção</label>
                                <input type="text" class="form-control" id="tipo" name="tipo" placeholder="Tipo de Manutenção" required>
                            </div>
                            <div class="form-group">
                                <label for="data">Data</label>
                                <input type="date" class="form-control" id="data" name="data" required>
                            </div>
                            <div class="form-group">
                                <label for="descricao">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" placeholder="Descrição" required></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary me-2">Adicionar</button>
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
