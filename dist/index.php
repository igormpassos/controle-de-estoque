<?php
include('./components/header.php');

// Conexão com o Neo4j
include('./bd.php'); 

// Consulta para contar o total de equipamentos
$queryTotalEquipamentos = 'MATCH (e:Equipamento) RETURN count(e) as totalEquipamentos';
$resultTotalEquipamentos = $client->run($queryTotalEquipamentos);
$totalEquipamentos = $resultTotalEquipamentos->first()->get('totalEquipamentos');

// Consulta para contar os equipamentos por status
$queryEquipamentosDisponiveis = 'MATCH (e:Equipamento {status: "Disponível"}) RETURN e';
$resultEquipamentosDisponiveis = $client->run($queryEquipamentosDisponiveis);
$totalDisponiveis = $resultEquipamentosDisponiveis->count();

$queryEquipamentosEmUso = 'MATCH (e:Equipamento {status: "Em Uso"}) RETURN e';
$resultEquipamentosEmUso = $client->run($queryEquipamentosEmUso);
$totalEmUso = $resultEquipamentosEmUso->count();

$queryEquipamentosManutencao = 'MATCH (e:Equipamento {status: "Manutenção"}) RETURN count(e) as manutencao';
$resultEquipamentosManutencao = $client->run($queryEquipamentosManutencao);
$totalManutencao = $resultEquipamentosManutencao->first()->get('manutencao');

// Consulta para contar o total de manutenções
$queryTotalManutencoes = 'MATCH (m:Manutencao) RETURN count(m) as totalManutencoes';
$resultTotalManutencoes = $client->run($queryTotalManutencoes);
$totalManutencoes = $resultTotalManutencoes->first()->get('totalManutencoes');
?>

<style>
  a{text-decoration: none;}
</style>

<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <!-- Cards com cores personalizadas -->
            <div class="col-md-3 grid-margin stretch-card">
                <a href="/controle-de-estoque/dist/pages/equipamento/index.php">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h4 class="card-title">Total de Equipamentos</h4>
                            <p class="card-text"><?php echo $totalEquipamentos; ?></p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 grid-margin stretch-card">
                <a href="/controle-de-estoque/dist/pages/equipamento/index.php?status=disponivel">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h4 class="card-title">Equipamentos Disponíveis</h4>
                            <p class="card-text"><?php echo $totalDisponiveis; ?></p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 grid-margin stretch-card">
                <a href="/controle-de-estoque/dist/pages/equipamento/index.php?status=em_uso">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h4 class="card-title">Equipamentos em Uso</h4>
                            <p class="card-text"><?php echo $totalEmUso; ?></p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 grid-margin stretch-card">
                <a href="/controle-de-estoque/dist/pages/equipamento/index.php?status=manutencao">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h4 class="card-title">Equipamentos em Manutenção</h4>
                            <p class="card-text"><?php echo $totalManutencao; ?></p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 grid-margin stretch-card">
                <a href="/controle-de-estoque/dist/pages/manutencao/index.php">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <h4 class="card-title">Total de Manutenções</h4>
                            <p class="card-text"><?php echo $totalManutencoes; ?></p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Tabelas com Equipamentos Disponíveis e Em Uso -->
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Equipamentos Disponíveis</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo</th>
                                        <th>Fabricante</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($resultEquipamentosDisponiveis as $record) {
                                        $equipamento = $record->get('e');
                                        echo "<tr>";
                                        echo "<td>" . $equipamento->getProperty('id') . "</td>";
                                        echo "<td>" . $equipamento->getProperty('tipo') . "</td>";
                                        echo "<td>" . $equipamento->getProperty('fabricante') . "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Equipamentos em Uso</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tipo</th>
                                        <th>Fabricante</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($resultEquipamentosEmUso as $record) {
                                        $equipamento = $record->get('e');
                                        echo "<tr>";
                                        echo "<td>" . $equipamento->getProperty('id') . "</td>";
                                        echo "<td>" . $equipamento->getProperty('tipo') . "</td>";
                                        echo "<td>" . $equipamento->getProperty('fabricante') . "</td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('./components/footer.php');
?>
