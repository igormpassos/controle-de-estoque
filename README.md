
# Controle de Estoque - Elab

## Descrição

O **Controle de Estoque - Elab** é um sistema desenvolvido para gerenciar o inventário de equipamentos, manutenções e localizações em um ambiente hospitalar. Utiliza o banco de dados **Neo4j** para armazenar e manipular os dados, com uma interface web construída em PHP.

## Funcionalidades

- Cadastro de Equipamentos.
- Gerenciamento de Manutenções de Equipamentos.
- Cadastro de Localizações.
- Dashboard para visualização do estado do inventário.
- Pesquisa dinâmica por equipamentos, manutenções e localizações.

## Tecnologias Utilizadas

- **PHP**: Linguagem backend para manipulação e controle do sistema.
- **Neo4j**: Banco de dados gráfico usado para armazenamento de dados.
- **Bootstrap**: Framework CSS utilizado para estilizar a interface do usuário.
- **JavaScript**: Para interações dinâmicas na página.
- **Laudis Neo4j PHP Client**: Biblioteca PHP usada para se conectar ao banco de dados Neo4j.

---

## Pré-requisitos

Certifique-se de ter as seguintes ferramentas instaladas no seu sistema:

- **PHP** >= 7.4
- **Neo4j** >= 4.x
- **Composer** (para gerenciar dependências do PHP)

---

## Instruções de Configuração

### 1. Clone o Repositório

```bash
git clone https://github.com/seu-usuario/controle-de-estoque-elab.git
cd controle-de-estoque-elab
```

### 2. Instale as Dependências

Instale as dependências do PHP com o **Composer**:

```bash
composer install
```

### 3. Configure o Neo4j

1. Certifique-se de que o **Neo4j** está rodando no seu servidor local ou remoto.
2. No arquivo `db.php` (localizado no diretório principal), atualize a string de conexão para o Neo4j se necessário:

```php
$client = ClientBuilder::create()
    ->withDriver('bolt', 'bolt://neo4j:controle-de-estoque@localhost:7687') // Atualize com a URL e credenciais corretas
    ->build();
```

### 4. Configuração do Servidor Web

Para rodar o projeto localmente, utilize um servidor PHP embutido ou configure um servidor como Apache ou Nginx.

#### Usando o servidor PHP embutido:

```bash
php -S localhost:8000
```

Em seguida, acesse o sistema em [http://localhost:8000](http://localhost:8000).

#### Usando Apache/Nginx:

Certifique-se de configurar o **document root** para apontar para o diretório `dist`.

### 5. Estrutura do Banco de Dados

Utilize o seguinte script no **Neo4j** para configurar o banco de dados inicial:

```cypher
CREATE 
    (e1:Equipamento {id: "1", tipo: "Ventilador", fabricante: "MedTech", numeroSerie: "A12345", dataAquisicao: "2022-01-01", status: "Disponível"}),
    (l1:Localizacao {id: "L1", nome: "Sala 1", andar: 2, departamento: "UTI"}),
    (m1:Manutencao {id: "M1", data: "2023-08-01", tipo: "Preventiva", descricao: "Verificação geral"}),
    
    (e1)-[:LOCATED_IN]->(l1),              
    (e1)-[:HAS_MAINTENANCE]->(m1);

CREATE 
    (e2:Equipamento {id: "2", tipo: "Monitor Cardíaco", fabricante: "BioCare", numeroSerie: "MC20234", dataAquisicao: "2021-07-10", status: "Em Uso"}),
    (e3:Equipamento {id: "3", tipo: "Bomba de Infusão", fabricante: "InfuMed", numeroSerie: "BI30234", dataAquisicao: "2020-05-15", status: "Manutenção"}),
    (l2:Localizacao {id: "L2", nome: "Sala 2", andar: 3, departamento: "Emergência"}),
    (m2:Manutencao {id: "M2", data: "2023-07-10", tipo: "Corretiva", descricao: "Troca de peças"}),
    
    (e2)-[:LOCATED_IN]->(l2),
    (e3)-[:HAS_MAINTENANCE]->(m2);

CREATE 
    (e4:Equipamento {id: "4", tipo: "Eletrocardiógrafo", fabricante: "CardioMed", numeroSerie: "ECG54321", dataAquisicao: "2019-11-23", status: "Disponível"}),
    (e5:Equipamento {id: "5", tipo: "Ventilador", fabricante: "MedTech", numeroSerie: "V78910", dataAquisicao: "2020-03-15", status: "Em Uso"}),
    (e6:Equipamento {id: "6", tipo: "Monitor Cardíaco", fabricante: "BioCare", numeroSerie: "MC98765", dataAquisicao: "2021-04-20", status: "Manutenção"}),
    (l3:Localizacao {id: "L3", nome: "Sala 3", andar: 1, departamento: "Centro Cirúrgico"}),
    (m3:Manutencao {id: "M3", data: "2023-06-01", tipo: "Preventiva", descricao: "Teste de funcionamento"}),
    (m4:Manutencao {id: "M4", data: "2022-12-12", tipo: "Corretiva", descricao: "Substituição de baterias"}),
    
    (e4)-[:LOCATED_IN]->(l3),
    (e4)-[:HAS_MAINTENANCE]->(m3),
    (e5)-[:LOCATED_IN]->(l3),
    (e6)-[:HAS_MAINTENANCE]->(m4);

CREATE 
    (e7:Equipamento {id: "7", tipo: "Oxímetro", fabricante: "OxiHealth", numeroSerie: "OX89012", dataAquisicao: "2020-09-10", status: "Disponível"}),
    (e8:Equipamento {id: "8", tipo: "Ventilador", fabricante: "VentCare", numeroSerie: "V12389", dataAquisicao: "2021-01-30", status: "Em Uso"}),
    (e9:Equipamento {id: "9", tipo: "Bomba de Infusão", fabricante: "InfuMed", numeroSerie: "BI45678", dataAquisicao: "2019-05-12", status: "Manutenção"}),
    (l4:Localizacao {id: "L4", nome: "Sala 4", andar: 2, departamento: "UTI Neonatal"}),
    (m5:Manutencao {id: "M5", data: "2023-03-22", tipo: "Corretiva", descricao: "Substituição de cabos"}),
    (m6:Manutencao {id: "M6", data: "2023-04-18", tipo: "Preventiva", descricao: "Limpeza interna"}),
    
    (e7)-[:LOCATED_IN]->(l4),
    (e8)-[:LOCATED_IN]->(l4),
    (e9)-[:HAS_MAINTENANCE]->(m5),
    (e9)-[:HAS_MAINTENANCE]->(m6);

CREATE 
    (e10:Equipamento {id: "10", tipo: "Monitor Cardíaco", fabricante: "BioCare", numeroSerie: "MC12390", dataAquisicao: "2022-02-14", status: "Em Uso"}),
    (e11:Equipamento {id: "11", tipo: "Bomba de Infusão", fabricante: "InfuMed", numeroSerie: "BI23456", dataAquisicao: "2020-06-20", status: "Disponível"}),
    (l5:Localizacao {id: "L5", nome: "Sala 5", andar: 3, departamento: "Emergência"}),
    (m7:Manutencao {id: "M7", data: "2023-07-15", tipo: "Preventiva", descricao: "Verificação de sensores"}),
    
    (e10)-[:LOCATED_IN]->(l5),
    (e11)-[:LOCATED_IN]->(l5),
    (e11)-[:HAS_MAINTENANCE]->(m7);

CREATE 
    (e12:Equipamento {id: "12", tipo: "Eletrocardiógrafo", fabricante: "CardioMed", numeroSerie: "ECG56789", dataAquisicao: "2021-05-25", status: "Manutenção"}),
    (e13:Equipamento {id: "13", tipo: "Ventilador", fabricante: "MedTech", numeroSerie: "V54321", dataAquisicao: "2019-12-01", status: "Disponível"}),
    (e14:Equipamento {id: "14", tipo: "Monitor Cardíaco", fabricante: "BioCare", numeroSerie: "MC56789", dataAquisicao: "2021-10-10", status: "Em Uso"}),
    (l6:Localizacao {id: "L6", nome: "Sala 6", andar: 4, departamento: "Pediatria"}),
    (m8:Manutencao {id: "M8", data: "2023-02-10", tipo: "Corretiva", descricao: "Troca de componentes eletrônicos"}),
    (m9:Manutencao {id: "M9", data: "2023-06-05", tipo: "Preventiva", descricao: "Limpeza e teste de cabos"}),
    
    (e12)-[:LOCATED_IN]->(l6),
    (e13)-[:LOCATED_IN]->(l6),
    (e13)-[:HAS_MAINTENANCE]->(m8),
    (e14)-[:HAS_MAINTENANCE]->(m9);

CREATE 
    (e15:Equipamento {id: "15", tipo: "Bomba de Infusão", fabricante: "InfuMed", numeroSerie: "BI78901", dataAquisicao: "2022-08-12", status: "Disponível"}),
    (e16:Equipamento {id: "16", tipo: "Oxímetro", fabricante: "OxiHealth", numeroSerie: "OX67890", dataAquisicao: "2021-03-01", status: "Em Uso"}),
    (l7:Localizacao {id: "L7", nome: "Sala 7", andar: 5, departamento: "Oncologia"}),
    (m10:Manutencao {id: "M10", data: "2023-05-18", tipo: "Corretiva", descricao: "Reparo de circuitos"}),
    
    (e15)-[:LOCATED_IN]->(l7),
    (e16)-[:LOCATED_IN]->(l7),
    (e16)-[:HAS_MAINTENANCE]->(m10);

```

Esse exemplo cria um equipamento, sua localização e uma manutenção relacionada. Adapte conforme a necessidade.

---

## Funcionalidades Futuras

- Relatórios detalhados de uso de equipamentos e manutenção.
- Notificações automáticas para manutenções pendentes.
- Sistema de autenticação de usuários.

---

## Feito por

Igor Marques Passos 22.2.8118
UFOP

- **Email**: igor.passos@aluno.ufop.edu.br
