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

if (isset($_GET['ic'])) {
    $id_compra = isset($_GET['ic']) ? $_GET['ic'] : null;
} else {
    exit();
}

if (!empty($id_compra)) {
    $sql_vendas = "SELECT * FROM vendas WHERE id_compra = '$id_compra'";
    $result_vendas = $mysqli->query($sql_vendas);

    if ($result_vendas->num_rows == 1) {
        $row_vendas = $result_vendas->fetch_assoc();
        $od = $row_vendas['od'];
        $oe = $row_vendas['oe'];
        $medico = $row_vendas['medico'];
        $valor = $row_vendas['valor'];
        $obs = $row_vendas['obs'];
    } else {
        exit();
    }
} else {
    exit();
}


if (isset($_GET['id'])) {
    $cliente_id = $_GET['id'];

    $sql_cliente = "SELECT * FROM clientes WHERE id_cliente = '$cliente_id'";
    $result_cliente = $mysqli->query($sql_cliente);

    if ($result_cliente->num_rows == 1) {
        $row_cliente = $result_cliente->fetch_assoc();
        $nome_cliente = $row_cliente['nome_cliente'];
        $email = $row_cliente['email'];
        $cpf = $row_cliente['cpf'];
        $cidade = $row_cliente['cidade'];
        $usuario_responsavel = $row_cliente['usuario_responsavel'];
        $email = $row_cliente['email'];
        $celular = $row_cliente['celular'];
        $telefone = $row_cliente['telefone'];
    } else {
        exit();
    }

    $sql_vendas = "SELECT * FROM vendas WHERE id_cliente = '$cliente_id'";
    $result_vendas = $mysqli->query($sql_vendas);
} else {
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $editedOD = $_POST['od'];
    $editedOE = $_POST['oe'];
    $editedMedico = $_POST['medico'];
    $editedValor = $_POST['valor'];
    $editedObservacoes = $_POST['obs'];

    $sql_update = "UPDATE vendas SET od = '$editedOD', oe = '$editedOE', medico = '$editedMedico', valor = '$editedValor', observacoes = '$editedObservacoes' WHERE id_compra = '$id_compra'";
    if ($mysqli->query($sql_update)) {
        header("Location: /Cliente/cliente.php?id=$cliente_id");
        exit();
    } else {
        echo "Erro ao atualizar os dados da compra: " . $mysqli->error;
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
    <div class="box">
        <div id="edit-client">
            <a href="/cad_edit/cad_edit.php"><img class="edit-img" src="/Img/edit.svg" alt="Editar"></a>
        </div>
        <div class="box-client">
            <div id="direita">
                <span style="float: right; margin: 5px;">
                    Usuario Responsavel :
                    <span class="tbold">
                        <?php echo $usuario_responsavel; ?>
                    </span><br>
                    Email :
                    <span class="tbold">
                        <?php echo $email; ?>
                    </span><br>
                    Celular :
                    <span class="tbold">
                        <?php echo $celular; ?>
                    </span><br>
                    Telefone :
                    <span class="tbold">
                        <?php echo $telefone; ?>
                    </span><br>
                </span>
            </div>
            <div id="esquerda" style="margin: 5px;">
                Cliente ID :
                <span class="tbold">
                    <?php echo $cliente_id; ?>
                </span><br>
                Nome Cliente :
                <span class="tbold">
                    <?php echo $nome_cliente; ?>
                </span><br>
                CPF/CNPJ :
                <span class="tbold">
                    <?php echo $cpf; ?>
                </span><br>
                Cidade :
                <span class="tbold">
                    <?php echo $cidade; ?>
                </span><br>
            </div>
        </div>
    </div>


    <section class="header">

        <div class="form-container">
            <h2>ID Compra</h2>
            <form method="POST" action="\Cliente\cliente.php?id=<?php echo $cliente_id; ?>">
                <div class="returnb">
                    <button type="submit" name="return">Retornar</button>
                </div>
                <div class="row">
                    <div class="left">
                        <label for="od">OD</label>
                        <input type="text" id="od" name="od" value="<?php echo $od; ?>" required>

                        <label for="medico">Médico</label>
                        <input type="text" id="medico" name="medico" value="<?php echo $medico; ?>" required>
                    </div>

                    <div class="right">
                        <label for="ed">OE</label>
                        <input type="text" id="ed" name="ed" value="<?php echo $oe; ?>" required>

                        <label for="valor">Valor</label>
                        <input type="number" id="valor" name="valor" step="0.01" class="valor"
                            value="<?php echo $valor; ?>" required>
                    </div>
                </div>

                <label for="obs">Observações</label>
                <textarea id="obs" name="obs"><?php echo $obs; ?></textarea>
            </form>
        </div>
    </section>
</body>

</html>