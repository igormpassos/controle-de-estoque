<?php
ob_start();
include('../../components/header.php');

// Conexão com o Neo4j
include('../../bd.php'); 

// Inicializando mensagem de feedback
$message = '';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $andar = $_POST['andar'];
    $departamento = $_POST['departamento'];

    if (!empty($nome) && !empty($andar) && !empty($departamento)) {
        // Cria um ID único para a localização
        $id = uniqid();

        // Query para adicionar a nova localização
        $query = 'CREATE (l:Localizacao {id: $id, nome: $nome, andar: $andar, departamento: $departamento})';
        $params = [
            'id' => $id,
            'nome' => $nome,
            'andar' => $andar,
            'departamento' => $departamento
        ];

        // Executa a query no banco de dados Neo4j
        $client->run($query, $params);

        $message = "Localização adicionada com sucesso!";
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
                        <h4 class="card-title">Adicionar Localização</h4>
                        <p class="card-description">Insira as informações da nova localização</p>

                        <?php if ($message) : ?>
                            <div class="alert alert-info">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>

                        <form class="forms-sample" method="POST" action="">
                            <div class="form-group">
                                <label for="nome">Nome da Sala/Localização</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome da Localização" required>
                            </div>
                            <div class="form-group">
                                <label for="andar">Andar</label>
                                <input type="text" class="form-control" id="andar" name="andar" placeholder="Andar" required>
                            </div>
                            <div class="form-group">
                                <label for="departamento">Departamento</label>
                                <input type="text" class="form-control" id="departamento" name="departamento" placeholder="Departamento" required>
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
