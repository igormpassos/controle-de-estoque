<?php
ob_start();
include('../../components/header.php');

// Conexão com o Neo4j
include('../../bd.php'); 

$id = $_GET['id'];  // ID da localização a ser editada

// Inicializando mensagem de feedback
$message = '';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $andar = $_POST['andar'];
    $departamento = $_POST['departamento'];

    if (!empty($nome) && !empty($andar) && !empty($departamento)) {
        // Query para atualizar a localização
        $query = 'MATCH (l:Localizacao {id: $id})
                  SET l.nome = $nome, l.andar = $andar, l.departamento = $departamento';
        $params = [
            'id' => $id,
            'nome' => $nome,
            'andar' => $andar,
            'departamento' => $departamento
        ];

        // Executa a query no banco de dados Neo4j
        $client->run($query, $params);

        $message = "Localização atualizada com sucesso!";
    } else {
        $message = "Por favor, preencha todos os campos!";
    }
}

// Query para buscar os detalhes da localização
$query = 'MATCH (l:Localizacao {id: $id}) RETURN l';
$params = ['id' => $id];
$result = $client->run($query, $params);
$localizacao = $result->first()->get('l');

$nome = $localizacao->getProperty('nome');
$andar = $localizacao->getProperty('andar');
$departamento = $localizacao->getProperty('departamento');
?>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Editar Localização</h4>

                        <?php if ($message) : ?>
                            <div class="alert alert-info">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>

                        <form class="forms-sample" method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />

                            <div class="form-group">
                                <label for="nome">Nome da Sala/Localização</label>
                                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="andar">Andar</label>
                                <input type="text" class="form-control" id="andar" name="andar" value="<?php echo $andar; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="departamento">Departamento</label>
                                <input type="text" class="form-control" id="departamento" name="departamento" value="<?php echo $departamento; ?>" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary me-2">Atualizar</button>
                            <a class="btn btn-light" href="/controle-de-estoque/dist">Cancelar</a>
                        </form>

                        <form class="mt-4" method="POST" action="delete.php">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Tem certeza que deseja excluir esta localização?');">
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
