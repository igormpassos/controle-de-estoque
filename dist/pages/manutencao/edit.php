<?php
ob_start();
include('../../components/header.php');

// Conexão com o Neo4j
include('../../bd.php'); 

$id = $_GET['id'];  // ID da manutenção a ser editada

// Inicializando mensagem de feedback
$message = '';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipo = $_POST['tipo'];
    $data = $_POST['data'];
    $descricao = $_POST['descricao'];

    if (!empty($tipo) && !empty($data) && !empty($descricao)) {
        // Query para atualizar a manutenção
        $query = 'MATCH (m:Manutencao {id: $id})
                  SET m.tipo = $tipo, m.data = $data, m.descricao = $descricao';
        $params = [
            'id' => $id,
            'tipo' => $tipo,
            'data' => $data,
            'descricao' => $descricao
        ];

        // Executa a query no banco de dados Neo4j
        $client->run($query, $params);

        $message = "Manutenção atualizada com sucesso!";
    } else {
        $message = "Por favor, preencha todos os campos!";
    }
}

// Query para buscar os detalhes da manutenção
$query = 'MATCH (m:Manutencao {id: $id}) RETURN m';
$params = ['id' => $id];
$result = $client->run($query, $params);
$manutencao = $result->first()->get('m');

$tipo = $manutencao->getProperty('tipo');
$data = $manutencao->getProperty('data');
$descricao = $manutencao->getProperty('descricao');
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Editar Manutenção</h4>

                        <?php if ($message) : ?>
                            <div class="alert alert-info">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>

                        <form class="forms-sample" method="POST" action="">
                            <div class="form-group">
                                <label for="tipo">Tipo de Manutenção</label>
                                <input type="text" class="form-control" id="tipo" name="tipo" value="<?php echo $tipo; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="data">Data</label>
                                <input type="date" class="form-control" id="data" name="data" value="<?php echo $data; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="descricao">Descrição</label>
                                <textarea class="form-control" id="descricao" name="descricao" required><?php echo $descricao; ?></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-primary me-2">Atualizar</button>
                            <a class="btn btn-light" href="/controle-de-estoque/dist">Cancelar</a>
                        </form>

                        <form class="mt-4" method="POST" action="delete.php">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Tem certeza que deseja excluir esta manutenção?');">
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
