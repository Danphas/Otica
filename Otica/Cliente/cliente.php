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

    $sql_vendas = "SELECT * FROM vendas WHERE id_cliente = '$cliente_id'";
    $result_vendas = $mysqli->query($sql_vendas);
    $next_id_compra = $result_vendas->num_rows + 1;
} else {
    echo "ID do cliente não especificado na URL.";
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Otica Cientifica</title>
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
                    <span id="user-inf" >Usuario Responsavel
                        :</span>
                    <span class="tbold">
                        <?php echo $responsavel; ?>
                    </span><br>
                    <span id="user-inf" >Data Cadastro
                        :</span>
                    <span class="tbold">
                        <?php echo date('d/m/Y', strtotime($data_cadastro)); ?>
                    </span><br>
                    <span id="user-inf" >Celular :</span>
                    <span class="tbold">
                        <?php echo $celular; ?>
                    </span><br>
                    <span id="user-inf" >Telefone :</span>
                    <span class="tbold">
                        <?php echo $telefone; ?>
                    </span><br>
                </span>
            </div>
            <div id="esquerda" style="margin: 5px;">
                <span id="user-inf" >Cliente ID :</span>
                <span class="tbold">
                    <?php echo $cliente_id; ?>
                </span><br>
                <span id="user-inf" >Nome Cliente :</span>
                <span class="tbold">
                    <?php echo $nome_cliente; ?>
                </span><br>
                <span id="user-inf" >CPF/CNPJ :</span>
                <span class="tbold">
                    <?php
                    echo $cpf;
                    ?>
                </span><br>
                <span id="user-inf" >Cidade :</span>
                <span class="tbold">
                    <?php echo $cidade; ?>
                </span><br>
            </div>
        </div>
    </div>

    <br>

    <div class="table-client">
        <div class="d-table">
            <div class="b-compra">
                <button><a
                        href="/Nova_Compra/new_compra.php?id=<?php echo $cliente_id; ?>&ic=<?php echo $next_id_compra; ?>"
                        style="text-decoration: none; color: white;">Nova Compra</a></button>
            </div>
        </div>

        <div class="activity">
        <table class="table-orders">
            <thead>
                <tr>
                    <th>
                        <div>
                            <span>ID Compra</span>
                        </div>
                    </th>
                    <th>
                        <div>
                            <span>OE</span>
                        </div>
                    </th>
                    <th>
                        <div>
                            <span>OD</span>
                        </div>
                    </th>
                    <th>
                        <div>
                            <span>Valor</span>
                        </div>
                    </th>
                    <th>
                        <div>
                            <span>Medico</span>
                        </div>
                    </th>
                    <th>
                        <div>
                            <span>Observações</span>
                        </div>
                    </th>
                    <th>
                        <div>
                            <span>Data Compra</span>
                        </div>
                    </th>
                    <th>
                        <div>
                            <span>Responsavel</span>
                        </div>
                    </th>
                </tr>
            </thead>

            <tbody>
                <?php
                while ($row_vendas = $result_vendas->fetch_assoc()) {
                    $id_compra = $row_vendas['id_compra'];
                    $oe = $row_vendas['oe'];
                    $od = $row_vendas['od'];
                    $valor = $row_vendas['valor'];
                    $medico = $row_vendas['medico'];
                    $obs = $row_vendas['observacao'];
                    $data_compra = $row_vendas['data_compra'];
                    $responsavel = $row_vendas['responsavel'];

                    echo "<tr>";
                    echo "<td><a href=\"/Informação/id_protocolo.php?id=$cliente_id&ic=$id_compra\">$id_compra</a></td>";
                    echo "<td>$oe</td>";
                    echo "<td>$od</td>";
                    echo "<td>R$ $valor</td>";
                    echo "<td>$medico</td>";
                    echo "<td>$obs</td>";
                    echo "<td><a href='/Informação/id_protocolo.php?id=" . $cliente_id . "&ic=" . $id_compra . "'>" . date("d/m/Y", strtotime($data_compra)) . "</a></td>";
                    echo "<td>$responsavel</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        </div>
    </div>
</body>

</html>