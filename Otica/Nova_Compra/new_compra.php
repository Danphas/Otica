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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data_consulta = $_POST['data_consulta'];
    $medico = $_POST['medico'];
    $oe = $_POST['oe'];
    $dnp_oe = $_POST['dnp_oe'];
    $altura_oe = $_POST['altura_oe'];
    $od = $_POST['od'];
    $dnp_od = $_POST['dnp_od'];
    $altura_od = $_POST['altura_od'];
    $adicao_oe = $_POST['adicao_oe'];
    $adicao_od = $_POST['adicao_od'];
    $armacao = $_POST['armacao'];
    $nr_pedido = $_POST['nr_pedido'];
    $lente = $_POST['lente'];
    $valor = $_POST['valor'];
    $observacao = $_POST['observacao'];
    $data_compra = date('Y-m-d');
    $responsavel = $_POST['responsavel'];

    $id_geral = obterUltimoIDGeral($mysqli);

    $sql_insert = "INSERT INTO vendas (id_cliente, id_compra, id_geral, data_consulta, medico, oe, dnp_oe, altura_oe, od, dnp_od, altura_od, adicao_oe, adicao_od, armacao, nr_pedido, lente, valor, observacao, data_compra, responsavel) VALUES ('$cliente_id', '$id_compra', '$id_geral', '$data_consulta', '$medico', '$oe', '$dnp_oe', '$altura_oe', '$od', '$dnp_od', '$altura_od', '$adicao_oe', '$adicao_od', '$armacao', '$nr_pedido', '$lente', '$valor', '$observacao', '$data_compra', '$responsavel')";

    if ($mysqli->query($sql_insert)) {
        echo "Dados inseridos com sucesso.";
    } else {
        echo "Erro ao inserir dados: " . $mysqli->error;
    }

    header("Location: /Cliente/Cliente.php?id=$id_cliente");
    exit();
}

function obterUltimoIDGeral($mysqli)
{
    $query = "SELECT MAX(id_geral) AS max_id FROM vendas";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    return $row['max_id'] ? $row['max_id'] + 1 : 1;
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
    <title>Nova Compra</title>
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
                                <a href="/Index/index.php"><button type="button">Cancelar</button></a>
                            </div>

                        </div>

                        <div class="form-section">
                            <div class="right">
                                <header class="right-header">
                                    <h1>Consulta</h1>
                                </header>
                                <div class="right-column">
                                    <div class="r-left">
                                        <label for="data_consulta">Data da Consulta</label>
                                        <input type="date" id="data_consulta" name="data_consulta">

                                        <label for="oe">OE</label>
                                        <input type="text" id="oe" name="oe">

                                        <label for="dnp_oe">DNP OE</label>
                                        <input type="text" id="dnp_oe" name="dnp_oe">

                                        <label for="altura_oe">Altura OE</label>
                                        <input type="text" id="altura_oe" name="altura_oe">
                                    </div>
                                    <div class="r-right">
                                        <label for="medico">Médico</label>
                                        <input type="text" id="medico" name="medico">

                                        <label for="od">OD</label>
                                        <input type="text" id="od" name="od">

                                        <label for="dnp_od">DNP OD</label>
                                        <input type="text" id="dnp_od" name="dnp_od">

                                        <label for="altura_od">Altura OD</label>
                                        <input type="text" id="altura_od" name="altura_od">
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-center">
                                <div class="center-column">
                                    <div class="c-left">
                                        <label for="adicao">Adição</label>
                                        <div class="adicao-inputs">
                                            <input type="number" id="adicao_oe" name="adicao_oe" step="0.05" placeholder="0.00">
                                            <input type="number" id="adicao_od" name="adicao_od" step="0.05" placeholder="0.00">
                                        </div>

                                        <label for="lente">Lente (LT)</label>
                                        <input type="text" id="lente" name="lente">
                                    </div>
                                    <div class="c-right">
                                        <label for="armacao">Armação (AR)</label>
                                        <input type="text" id="armacao" name="armacao">

                                        <label for="responsavel">Responsável</label>
                                        <select id="responsavel" name="responsavel" class="custom-select">
                                            <option value="#"> </option>
                                            <option value="Edilene">Edilene</option>
                                            <option value="Aline">Aline</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="nr_pedido">NR Pedido</label>
                                        <input id="nr_pedido" name="nr_pedido" style="width: 170px;
                                        padding: 8px 12px;
                                        margin-bottom: 10px;
                                        border: 1px solid rgba(0, 0, 0, 0.15);
                                        border-radius: 4px;
                                        box-sizing: border-box;
                                        box-shadow: 0px 0px 6px 2px #da60dd;
                                        border-radius: 10px;"></input>

                                        <label for="valor">Valor</label>
                                        <input type="number" id="valor" name="valor" step="1" min="0" placeholder="0.00" style="width: 170px;
                                        padding: 8px 12px;
                                        margin-bottom: 10px;
                                        border: 1px solid rgba(0, 0, 0, 0.15);
                                        border-radius: 4px;
                                        box-sizing: border-box;
                                        box-shadow: 0px 0px 6px 2px #da60dd;
                                        border-radius: 10px;" />
                                    </div>
                                </div>
                                <br>
                                <div class="obs">
                                    <label for="observacao">Observação</label>
                                    <textarea id="observacao" name="observacao"></textarea>
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