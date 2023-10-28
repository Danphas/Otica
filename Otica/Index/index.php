<?php
session_start();
include('protect.php');

$host = "www.otica";
$database = "db_otica";
$usuario = "root";
$senha = "";

$mysqli = new mysqli($host, $usuario, $senha, $database);
if ($mysqli->connect_errno) {
    echo "Falha ao Conectar: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;
    exit;
}

$currentDate = date("Y-m-d");

$sql = "SELECT c.id_cliente, c.nome_cliente, c.cpf, v.valor, v.oe, v.od, c.cidade, v.observacao, v.data_compra, v.responsavel, v.id_compra
        FROM Vendas v
        INNER JOIN Clientes c ON c.id_cliente = v.id_cliente
        WHERE v.data_compra = '$currentDate'";


$resultado = $mysqli->query($sql);
if (!$resultado) {
    echo "Erro na consulta: (" . $mysqli->errno . ") " . $mysqli->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <script
      defer
      src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"
    ></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="\Img\favicon.ico" type="image/x-icon">
    <title>
        Otica Cientifica
    </title>
</head>

<body>
    <nav>
        <a href="/Index/index.php"><img src="/Img/logo.png" alt="logo" class="logo"></a>
        <form action="\buscar_cliente\buscar_cliente.php" method="GET">
            <div class="search-box">
                <input type="search" class="search-txt" name="term" placeholder="Insira o nome">
                    <button type="submit" class="search-btn">
                        <a href="" class="search-btn">
                            <i class="fas fa-search"></i>
                        </a>
                    </button>
            </div>
        </form>

        <ul>
            <li><span class='user'>
                    <?php echo $_SESSION['login']; ?>
                </span></li>
            <li><a href="logout.php">Sair</a></li>
        </ul>
    </nav>
    <br>
    <div class="container">
        <button id="nc"><a href="/Cadastro/cadastro.php" style="text-decoration: none; color: white;">Novo
                Cliente </a></button>

        <button id="c"><a href="/Consultar/consultar.php" style="text-decoration: none;">Consultar (por data)</a>
        </button>
    </div>

    <div class="activity">
        <table id="table-activity">
            <thead class="table1">
                <tr role="row">
                    <th>
                        <span>ID</span>
                    </th>
                    <th>
                        <span>Cliente</span>
                    </th>
                    <th>
                        <span>CPF</span>
                    </th>
                    <th>
                        <span>Valor</span>
                    </th>
                    <th>
                        <span>OD</span>
                    </th>
                    <th>
                        <span>OE</span>
                    </th>
                    <th>
                        <span>Cidade</span>
                    </th>
                    <th>
                        <span>Observações</span>
                    </th>
                    <th>
                        <span>Data Compra</span>
                    </th>
                    <th>
                        <span>Responsavel</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>";
                    echo "<td><a href='/Cliente/cliente.php?id=" . $row['id_cliente'] . "'>" . $row['id_cliente'] . "</a></td>";
                    echo "<td><a href='/Cliente/cliente.php?id=" . $row['id_cliente'] . "'>" . $row['nome_cliente'] . "</a></td>";
                    echo "<td>" . $row['cpf'] . "</td>";
                    echo "<td>R$ " . $row['valor'] . "</td>";
                    echo "<td>" . $row['od'] . "</td>";
                    echo "<td>" . $row['oe'] . "</td>";
                    echo "<td>" . $row['cidade'] . "</td>";
                    echo "<td>" . $row['observacao'] . "</td>";
                    echo "<td><a href='/Informação/id_protocolo.php?id=" . $row['id_cliente'] . "&ic=" . $row['id_compra'] . "'>" . date("d/m/Y", strtotime($row['data_compra'])) . "</a></td>";
                    echo "<td>" . $row['responsavel'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
