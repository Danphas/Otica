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

if (isset($_GET['id']) && isset($_GET['ic'])) {
    $sql_venda = "SELECT * FROM vendas WHERE id_cliente = '$id_cliente' AND id_compra = '$id_compra'";
    $result_venda = $mysqli->query($sql_venda);

    if ($result_venda->num_rows == 1) {
        $row_venda = $result_venda->fetch_assoc();
        $data_compra = $row_venda['data_compra'];
        $data_consulta = $row_venda['data_consulta'];
        $oe = $row_venda['oe'];
        $dnp_oe = $row_venda['dnp_oe'];
        $altura_oe = $row_venda['altura_oe'];
        $medico = $row_venda['medico'];
        $od = $row_venda['od'];
        $dnp_od = $row_venda['dnp_od'];
        $altura_od = $row_venda['altura_od'];
        $adicao = $row_venda['adicao'];
        $lente = $row_venda['lente'];
        $armacao = $row_venda['armacao'];
        $responsavel = $row_venda['responsavel'];
        $nr_pedido = $row_venda['nr_pedido'];
        $valor = $row_venda['valor'];
        $observacao = $row_venda['observacao'];
    } else {
        echo "Venda não encontrada.";
        exit();
    }
} else {
    echo "ID do cliente e ID da compra não fornecidos.";
    exit();
}

if (isset($_GET['id'])) {
    $cliente_id = $_GET['id'];

    $sql_cliente = "SELECT * FROM clientes WHERE id_cliente = '$cliente_id'";
    $result_cliente = $mysqli->query($sql_cliente);

    if ($result_cliente->num_rows == 1) {
        $row_cliente = $result_cliente->fetch_assoc();
        $nome_cliente = $row_cliente['nome_cliente'];
        $cpf = $row_cliente['cpf'];
        $data_cadastro = $row_cliente['data_cadastro'];
        $cidade = $row_cliente['cidade'];
        $responsavel = $row_cliente['responsavel'];
        $celular = $row_cliente['celular'];
        $telefone = $row_cliente['telefone'];
    } else {
        echo "Cliente não encontrado.";
        exit();
    }
}

if (isset($_POST['outras_submit'])) {
    $data_consulta = $_POST['data_consulta'];
    $oe = $_POST['oe'];
    $dnp_oe = $_POST['dnp_oe'];
    $altura_oe = $_POST['altura_oe'];
    $medico = $_POST['medico'];
    $od = $_POST['od'];
    $dnp_od = $_POST['dnp_od'];
    $altura_od = $_POST['altura_od'];
    $adicao = $_POST['adicao'];
    $lente = $_POST['lente'];
    $armacao = $_POST['armacao'];
    $responsavel = $_POST['responsavel'];
    $nr_pedido = $_POST['nr_pedido'];
    $valor = $_POST['valor'];
    $observacao = $_POST['observacao'];

    $sql_update = "UPDATE vendas SET data_consulta = '$data_consulta', oe = '$oe', dnp_oe = '$dnp_oe', altura_oe = '$altura_oe', medico = '$medico', od = '$od', dnp_od = '$dnp_od', altura_od = '$altura_od', adicao = '$adicao', lente = '$lente', armacao = '$armacao', responsavel = '$responsavel', nr_pedido = '$nr_pedido', valor = '$valor', observacao = '$observacao' WHERE id_compra = '$id_compra'";


    if ($mysqli->query($sql_update)) {
        header("Location: /Cliente/cliente.php?id=" . $cliente_id);
    } else {
        echo "Erro ao atualizar os dados: " . $mysqli->error;
    }
}

if (isset($_POST['delete_submit'])) {
    $sql_delete = "DELETE FROM vendas WHERE id_cliente = '$id_cliente' AND id_compra = '$id_compra'";
    if ($mysqli->query($sql_delete)) {
        header("Location: /Cliente/cliente.php?id=" . $cliente_id);
        exit();
    } else {
        echo "Erro ao apagar os dados: " . $mysqli->error;
    }
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
    <title>Compra</title>
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
            <a href="/cad_edit/cad_edit.php?id=<?php echo $cliente_id; ?>">
                <img class="edit-img" src="/Img/edit.svg" alt="Editar">
            </a>
        </div>
        <div class="box-client">
            <div id="direita">
                <span style="float: right; margin: 5px;">
                    <span id="user-inf">Usuario Responsavel
                        :</span>
                    <span class="tbold">
                        <?php echo $responsavel; ?>
                    </span><br>
                    <span id="user-inf">Data Cadastro
                        :</span>
                    <span class="tbold">
                        <?php echo date('d/m/Y', strtotime($data_cadastro)); ?>
                    </span><br>
                    <span id="user-inf">Celular :</span>
                    <span class="tbold">
                        <?php echo $celular; ?>
                    </span><br>
                    <span id="user-inf">Telefone :</span>
                    <span class="tbold">
                        <?php echo $telefone; ?>
                    </span><br>
                </span>
            </div>
            <div id="esquerda" style="margin: 5px;">
                <span id="user-inf">Cliente ID :</span>
                <span class="tbold">
                    <?php echo $cliente_id; ?>
                </span><br>
                <span id="user-inf">Nome Cliente :</span>
                <span class="tbold">
                    <?php echo $nome_cliente; ?>
                </span><br>
                <span id="user-inf">CPF/CNPJ :</span>
                <span class="tbold">
                    <?php
                    echo $cpf;
                    ?>
                </span><br>
                <span id="user-inf">Cidade :</span>
                <span class="tbold">
                    <?php echo $cidade; ?>
                </span><br>
            </div>
        </div>
    </div>
    <br>

    <section class="cad-user">
        <div class="container-form center-form">
            <div class="form">
                <div class="container">
                    <form method="POST">

                        <div class="b-cadcan">
                            <div id="cad">
                                <button type="submit" name="outras_submit" value="Enviar">Enviar</button>
                            </div>
                            <div id="cancel">
                                <button type="submit" name="delete_submit" value="Apagar">Apagar</button>
                            </div>

                        </div>

                        <div class="form-section">
                            <div class="right">
                                <header class="right-header">
                                    <h1>
                                        <?php echo $nome_cliente ?>
                                    </h1>
                                    <h2>
                                        <?php echo date('d/m/Y', strtotime($data_compra)); ?>
                                    </h2>
                                </header>
                                <div class="right-column">
                                    <div class="r-left">
                                        <label for="od">OD</label>
                                        <input type="text" id="od" name="od" value="<?php echo $od; ?>">

                                        <label for="oe">OE</label>
                                        <input type="text" id="oe" name="oe" value="<?php echo $oe; ?>">

                                        <label for="altura_od">Altura OD</label>
                                        <input type="text" id="altura_od" name="altura_od" value="<?php echo $altura_od; ?>">

                                        <label for="medico">Médico</label>
                                        <input type="text" id="medico" name="medico" value="<?php echo $medico; ?>">

                                    </div>
                                    <div class="r-right">


                                        <label for="dnp_od">DNP OD</label>
                                        <input type="text" id="dnp_od" name="dnp_od" value="<?php echo $dnp_od; ?>">

                                        <label for="dnp_oe">DNP OE</label>
                                        <input type="text" id="dnp_oe" name="dnp_oe" value="<?php echo $dnp_oe; ?>">

                                        <label for="altura_oe">Altura OE</label>
                                        <input type="text" id="altura_oe" name="altura_oe" value="<?php echo $altura_oe; ?>">

                                        <label for="data_consulta">Data da Consulta</label>
                                        <input type="date" id="data_consulta" name="data_consulta" value="<?php echo $data_consulta; ?>">





                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-center">
                                <div class="center-column">
                                    <div class="c-left">
                                        <label for="adicao">Adição</label>
                                        <div class="adicao-inputs">
                                            <input type="number" id="adicao" name="adicao" step="0.05" placeholder="0.00" value="<?php echo $adicao; ?>">
                                        </div>

                                        <label for="lente">Lente (LT)</label>
                                        <input type="text" id="lente" name="lente" value="<?php echo $lente; ?>">
                                    </div>
                                    <div class="c-right">
                                        <label for="armacao">Armação (AR)</label>
                                        <input type="text" id="armacao" name="armacao" value="<?php echo $armacao; ?>">

                                        <label for="responsavel">Responsável</label>
                                        <input type="text" id="responsavel" name="responsavel" value="<?php echo $responsavel; ?>">
                                    </div>
                                    <div>
                                        <label for="nr_pedido">NR Pedido</label>
                                        <input id="nr_pedido" name="nr_pedido" style="width: 170px; padding: 8px 12px; margin-bottom: 10px; border: 1px solid rgba(0, 0, 0, 0.15); border-radius: 4px; box-sizing: border-box; box-shadow: 0px 0px 6px 2px #da60dd; border-radius: 10px;" value="<?php echo $nr_pedido; ?>"></input>

                                        <label for="valor">Valor</label>
                                        <input type="number" id="valor" name="valor" step="0.01" min="0" placeholder="0.00" style="width: 170px; padding: 8px 12px; margin-bottom: 10px; border: 1px solid rgba(0, 0, 0, 0.15); border-radius: 4px; box-sizing: border-box; box-shadow: 0px 0px 6px 2px #da60dd; border-radius: 10px;" value="<?php echo $valor; ?>" />
                                    </div>
                                </div>
                                <br>
                                <div class="obs">
                                    <label for="observacao">Observação</label>
                                    <textarea id="observacao" name="observacao"><?php echo $observacao; ?></textarea>
                                </div>
                            </div>
                        </div>

                </div>
                </form>
            </div>
        </div>
        </div>
    </section>
</body>

</html>