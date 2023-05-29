<?php
include('protect.php');

$host = "www.otica";
$database = "db_otica";
$usuario = "root";
$senha = "";

$mysqli = new mysqli($host, $usuario, $senha, $database);
if ($mysqli->connect_errno) {
    echo "Falha ao Conectar: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;
}

$sql = "SELECT c.id_cliente, c.nome_cliente, c.cpf, c.cidade, v.oe, v.od, v.valor, v.data_compra
        FROM Clientes c
        INNER JOIN Vendas v ON c.id_cliente = v.id_cliente";
$resultado = $mysqli->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Danpha's</title>
</head>

<body>
    <nav>
        <a href="/Index/index.php"><img src="/Img/logo.png" alt="logo" class="logo"></a>
        <form action="\buscar_cliente\buscar_cliente.php" method="GET">
            <div class="search-box">
                <input type="search" class="search-text" name="term" placeholder="Pesquisar...">
                <button type="submit">🔍</button>
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
        <button><a href="/Cadastro/cadastro.php" style="text-decoration: none; color: white; ">Novo
                Cliente</a></button>
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
                        <span>Cidade</span>
                    </th>
                    <th>
                        <span>OE</span>
                    </th>
                    <th>
                        <span>OD</span>
                    </th>
                    <th>
                        <span>Valor</span>
                    </th>
                    <th>
                        <span>Data</span>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($resultado)) {
                    $currentDate = date("Y-m-d");
                    if ($row['data_compra'] === $currentDate) {
                        echo "<tr>";
                        echo "<td><a href='/Cliente/cliente.php?id=" . $row['id_cliente'] . "'>" . $row['id_cliente'] . "</a></td>";
                        echo "<td><a href='/Cliente/cliente.php?id=" . $row['id_cliente'] . "'>" . $row['nome_cliente'] . "</a></td>";
                        echo "<td>" . $row['cpf'] . "</td>";
                        echo "<td>" . $row['cidade'] . "</td>";
                        echo "<td>" . $row['oe'] . "</td>";
                        echo "<td>" . $row['od'] . "</td>";
                        echo "<td>" . $row['valor'] . "</td>";
                        echo "<td>" . $row['data_compra'] . "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>