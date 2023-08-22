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

$dataCompra = isset($_GET['data_compra']) ? $_GET['data_compra'] : '';

if (!empty($dataCompra)) {
    $sql = "SELECT v.valor, v.responsavel, v.id_cliente, c.nome_cliente, v.id_compra
            FROM vendas AS v
            INNER JOIN clientes AS c ON v.id_cliente = c.id_cliente
            WHERE v.data_compra = '$dataCompra'";

    $result = $mysqli->query($sql);

    if (!$result) {
        echo "Erro na consulta: " . $mysqli->error;
        exit;
    }

    $rows = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $rows = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="\Img\favicon.ico" type="image/x-icon">
    <title>Consultar (POR DATA)</title>
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

    <br><br>

    <div class="search">
        <form id="search-form" method="GET" action="">
            <div>
                <label for="data_compra">Data Compra</label>
                <input type="date" id="data_compra" name="data_compra" value="<?php echo $dataCompra; ?>">
            </div>
            <div>
                <button type="submit" class="pesquisar">Pesquisar</button>
            </div>
        </form>
    </div>

    <section class="container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Data Compra</th>
                    <th>Valor</th>
                    <th>Responsável</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td>
                            <a href="/Cliente/cliente.php?id=<?php echo $row['id_cliente']; ?>">
                                <?php echo $row['id_cliente']; ?>
                            </a>
                        </td>
                        <td>
                            <a href="/Cliente/cliente.php?id=<?php echo $row['id_cliente']; ?>">
                                <?php echo $row['nome_cliente']; ?>
                            </a>
                        </td>
                        <td>
                            <a
                                href="/Informação/id_protocolo.php?id=<?php echo $row['id_cliente']; ?>&ic=<?php echo $row['id_compra']; ?>">
                                <?php echo isset($dataCompra) ? date('d/m/Y', strtotime($dataCompra)) : ''; ?>
                            </a>
                        </td>
                        <td>
                            <?php echo "R$ " . $row['valor']; ?>
                        </td>
                        <td>
                            <?php echo $row['responsavel']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($rows)): ?>
                    <tr>
                        <td colspan="5">Insira a Data Desejada</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</body>

</html>
