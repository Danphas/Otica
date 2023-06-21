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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome_cliente = $_POST['nome_cliente'];
    $cpf = formatarCPF($_POST['cpf']);
    $cidade = $_POST['cidade'];
    $telefone = $_POST['telefone'];
    $celular = $_POST['celular'];
    $data_nascimento = $_POST['data_nascimento'];
    $data_cadastro = date("Y/m/d", strtotime("now"));
    $responsavelLogin = $_SESSION['login'];

    $sql = "SELECT MAX(id_cliente) AS ultimo_id FROM clientes";
    $resultado = $mysqli->query($sql);
    if ($resultado) {
        $row = $resultado->fetch_assoc();
        $ultimoIdCliente = $row['ultimo_id'];
        $novoIdCliente = $ultimoIdCliente + 1;

        $query = "INSERT INTO clientes (id_cliente, nome_cliente, cpf, cidade, telefone, celular, data_nascimento, data_cadastro, responsavel)
              VALUES ('$novoIdCliente', '$nome_cliente', '$cpf', '$cidade', '$telefone', '$celular', '$data_nascimento', '$data_cadastro', '$responsavelLogin')";
        $mysqli->query($query);

        $id_cliente = $mysqli->insert_id;
        $id_compra = obterUltimoIDVendas($mysqli, $id_cliente);
        $id_geral = obterUltimoIDGeral($mysqli);
        $data_consulta = $_POST['data_consulta'];
        $medico = $_POST['medico'];
        $oe = $_POST['oe'];
        $dnp_oe = $_POST['dnp_oe'];
        $altura_oe = $_POST['altura_oe'];
        $od = $_POST['od'];
        $dnp_od = $_POST['dnp_od'];
        $altura_od = $_POST['altura_od'];
        $adicao = $_POST['adicao'];
        $armacao = $_POST['armacao'];
        $nr_pedido = $_POST['nr_pedido'];
        $lente = $_POST['lente'];
        $valor = $_POST['valor'];
        $observacao = $_POST['observacao'];
        $data_compra = date("Y/m/d", strtotime("now"));
        $responsavel = $_POST['responsavel'];

        $query = "INSERT INTO vendas (id_cliente, id_compra, id_geral, data_consulta, medico, oe, dnp_oe, altura_oe, od, dnp_od, altura_od, adicao, armacao, nr_pedido, lente, valor, observacao, data_compra, responsavel)
              VALUES ($novoIdCliente, $id_compra, $id_geral, '$data_consulta', '$medico', '$oe', '$dnp_oe', '$altura_oe', '$od', '$dnp_od', '$altura_od', '$adicao', '$armacao', '$nr_pedido', '$lente', $valor, '$observacao', '$data_compra', '$responsavel')";
        $mysqli->query($query);

        if (!$resultado) {
            echo "Erro na consulta: " . $mysqli->error;
        } else {
            header("Location: /Cliente/cliente.php?id=$novoIdCliente");
            exit();
        }
    }
}

function formatarCPF($cpf)
{
    $cpf = preg_replace("/[^0-9]/", "", $cpf);
    $cpf = str_pad($cpf, 11, "0", STR_PAD_LEFT);
    return substr($cpf, 0, 3) . "." . substr($cpf, 3, 3) . "." . substr($cpf, 6, 3) . "-" . substr($cpf, 9);
}

function obterUltimoIDVendas($mysqli, $id_cliente)
{
    $query = "SELECT MAX(id_compra) AS max_id FROM vendas WHERE id_cliente = $id_cliente";
    $result = $mysqli->query($query);
    $row = $result->fetch_assoc();
    return $row['max_id'] ? $row['max_id'] + 1 : 1;
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
    <title>Cadastro</title>
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
                            <div class="left">
                                <header class="left-header">
                                    <h1>Cliente</h1>
                                </header>
                                <div class="left-column">
                                    <div class="l-left">
                                        <label for="nome_cliente">Nome</label>
                                        <input type="text" id="nome_cliente" name="nome_cliente" required>

                                        <label for="telefone">Telefone</label>
                                        <input type="text" id="telefone" name="telefone">

                                        <label for="celular">Celular</label>
                                        <input type="text" id="celular" name="celular">
                                    </div>
                                    <div class="r-left">
                                        <label for="cpf">CPF</label>
                                        <input type="text" id="cpf" name="cpf">

                                        <label for="cidade">Cidade</label>
                                        <input type="text" id="cidade" name="cidade">

                                        <label for="data_nascimento">Data de Nascimento</label>
                                        <input type="date" id="data_nascimento" name="data_nascimento">
                                    </div>
                                </div>
                            </div>

                            <div class="right">
                                <header class="right-header">
                                    <h1>Consulta</h1>
                                </header>
                                <div class="right-column">
                                    <div class="r-left">
                                        <label for="data_consulta">Data da Consulta</label>
                                        <input type="date" id="data_consulta" name="data_consulta">

                                        <label for="od">OD</label>
                                        <input type="text" id="od" name="od">

                                        <label for="adicao">Adição</label>
                                        <div class="adicao-inputs">
                                            <input type="number" id="adicao" name="adicao" step="0.05" placeholder="0.00">
                                        </div>

                                        <label for="dnp_od">DNP OD</label>
                                        <input type="text" id="dnp_od" name="dnp_od">

                                        <label for="altura_od">Altura OD</label>
                                        <input type="text" id="altura_od" name="altura_od">
                                    </div>
                                    <div class="r-right">
                                        <label for="medico">Médico</label>
                                        <input type="text" id="medico" name="medico">

                                        <label for="oe">OE</label>
                                        <input type="text" id="oe" name="oe">

                                        <label for="dnp_oe">DNP OE</label>
                                        <input type="text" id="dnp_oe" name="dnp_oe">

                                        <label for="altura_oe">Altura OE</label>
                                        <input type="text" id="altura_oe" name="altura_oe">
                                    </div>
                                </div>
                            </div>
                            <br><br>
                            <div class="form-center">
                                <div class="center-column">
                                    <div class="c-left">
                                        <label for="lente">Lente (LT)</label>
                                        <input type="text" id="lente" name="lente">
                                    </div>
                                    <div class="c-right">
                                        <label for="armacao">Armação (AR)</label>
                                        <input type="text" id="armacao" name="armacao">

                                        <label for="responsavel">Responsável</label>
                                        <input type="text" id="responsavel" name="responsavel" style="margin-left: 15px;">
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
                                        <input type="number" id="valor" name="valor" step="0.01" placeholder="0.00" style="width: 170px;
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
                    </form>
                </div>
            </div>
    </section>
</body>

</html>