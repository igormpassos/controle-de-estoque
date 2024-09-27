<?php
require_once '../vendor/autoload.php';
use Laudis\Neo4j\ClientBuilder;

$client = ClientBuilder::create()
    ->withDriver('bolt', 'bolt://neo4j:controle-de-estoque@localhost:7687') // Bolt connection
    ->build();

$query = $_GET['query'];

// Buscar correspondências em equipamentos
$queryEquipamentos = "MATCH (e:Equipamento) WHERE toLower(e.tipo) CONTAINS toLower(\$query) OR toLower(e.fabricante) CONTAINS toLower(\$query) RETURN e";
$params = ['query' => $query];
$resultEquipamentos = $client->run($queryEquipamentos, $params);

// Buscar correspondências em manutenções
$queryManutencoes = "MATCH (m:Manutencao) WHERE toLower(m.tipo) CONTAINS toLower(\$query) OR toLower(m.descricao) CONTAINS toLower(\$query) RETURN m";
$resultManutencoes = $client->run($queryManutencoes, $params);

// Buscar correspondências em localizações
$queryLocalizacoes = "MATCH (l:Localizacao) WHERE toLower(l.nome) CONTAINS toLower(\$query) OR toLower(l.departamento) CONTAINS toLower(\$query) RETURN l";
$resultLocalizacoes = $client->run($queryLocalizacoes, $params);

?>

<div class="row">
    <!-- Equipamentos -->
    <?php if ($resultEquipamentos->count() > 0): ?>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Equipamentos</h4>
                <p class="card-description">Lista de equipamentos correspondentes</p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tipo</th>
                                <th>Fabricante</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($resultEquipamentos as $record) {
                                $equipamento = $record->get('e');
                                $id = $equipamento->getProperty('id');
                                $tipo = $equipamento->getProperty('tipo');
                                $fabricante = $equipamento->getProperty('fabricante');
                                echo "<tr>";
                                echo "<td>{$id}</td>";
                                echo "<td>{$tipo}</td>";
                                echo "<td>{$fabricante}</td>";
                                echo "<td><a href='/controle-de-estoque/dist/pages/equipamento/edit.php?id={$id}' class='btn btn-primary btn-sm'>Editar</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Manutenções -->
    <?php if ($resultManutencoes->count() > 0): ?>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manutenções</h4>
                <p class="card-description">Lista de manutenções correspondentes</p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tipo</th>
                                <th>Descrição</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($resultManutencoes as $record) {
                                $manutencao = $record->get('m');
                                $id = $manutencao->getProperty('id');
                                $tipo = $manutencao->getProperty('tipo');
                                $descricao = $manutencao->getProperty('descricao');
                                echo "<tr>";
                                echo "<td>{$id}</td>";
                                echo "<td>{$tipo}</td>";
                                echo "<td>{$descricao}</td>";
                                echo "<td><a href='/controle-de-estoque/dist/pages/manutencao/edit.php?id={$id}' class='btn btn-primary btn-sm'>Editar</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Localizações -->
    <?php if ($resultLocalizacoes->count() > 0): ?>
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Localizações</h4>
                <p class="card-description">Lista de localizações correspondentes</p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Departamento</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($resultLocalizacoes as $record) {
                                $localizacao = $record->get('l');
                                $id = $localizacao->getProperty('id');
                                $nome = $localizacao->getProperty('nome');
                                $departamento = $localizacao->getProperty('departamento');
                                echo "<tr>";
                                echo "<td>{$id}</td>";
                                echo "<td>{$nome}</td>";
                                echo "<td>{$departamento}</td>";
                                echo "<td><a href='/controle-de-estoque/dist/pages/localizacao/edit.php?id={$id}' class='btn btn-primary btn-sm'>Editar</a></td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
