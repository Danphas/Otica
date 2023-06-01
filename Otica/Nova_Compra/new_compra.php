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
}

$id_cliente = isset($_GET['id']) ? $_GET['id'] : '';
$id_compra = isset($_GET['ic']) ? $_GET['ic'] : '';

if (isset($_POST['submit'])) {
    $od = $_POST['od'];
    $oe = $_POST['oe'];
    $valor = $_POST['valor'];
    $medico = $_POST['medico'];
    $obs = $_POST['obs'];
    $data_compra = date('Y-m-d');
    $usuario_responsavel = $_SESSION['login'];

    $sql = "INSERT INTO vendas (id_cliente, id_compra, od, oe, valor, medico, obs, data_compra, usuario_responsavel) VALUES ('$id_cliente', '$id_compra', '$od', '$oe', '$valor', '$medico', '$obs', '$data_compra', '$usuario_responsavel')";

    if ($mysqli->query($sql)) {
        header("Location: /Index/index.php");
        exit;
    } else {
        echo "Erro ao adicionar venda: " . $mysqli->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Nova Compra</title>
    <link rel="icon" type="image/x-icon" href="/Img/favico.ico">
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
    <header>
        <div class="form-container">
            <h2>Nova Compra</h2>
            <form method="POST">
                <div class="row">
                    <div class="left">
                        <label for="od" style="font-weight: bold">OD</label>
                        <input type="text" id="od" name="od" required>

                        <label for="medico" style="font-weight: bold">Médico</label>
                        <input type="text" id="medico" name="medico" required>
                    </div>

                    <div class="right">
                        <label for="oe" style="font-weight: bold">OE</label>
                        <input type="text" id="oe" name="oe" required>

                        <label for="valor" style="font-weight: bold">Valor</label>
                        <input type="number" id="valor" name="valor" step="0.01" class="valor" required>
                    </div>
                </div>
                <label for="obs" style="font-weight: bold">Observações</label>
                <textarea id="obs" name="obs"></textarea>

                <button type="submit" name="submit">Enviar</button>
            </form>
        </div>
    </header>
</body>

</html>