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
        $email = $row_cliente['email'];
        $cpf = $row_cliente['cpf'];
        $cidade = $row_cliente['cidade'];
        $usuario_responsavel = $row_cliente['usuario_responsavel'];
        $email = $row_cliente['email'];
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
            <a href="/cad_edit/cad_edit.php?id=<?php echo $cliente_id; ?>">
                <img class="edit-img" src="/Img/edit.svg" alt="Editar">
            </a>
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

    <br>

    <div class="table-client">
        <div class="d-table">
            <div class="b-compra">
                <button><a
                        href="/Nova_Compra/new_compra.php?id=<?php echo $cliente_id; ?>&ic=<?php echo $next_id_compra; ?>"
                        style="text-decoration: none; color: white;">Nova Compra</a></button>
            </div>
            <div class="data-table" style="float: right; margin: 5px;">
                <label for="filtro">Filtro</label>
                <select id="filtro" name="filtro">
                    <option value="id-filtro">ID Compra</option>
                    <option value="oe">OE</option>
                    <option value="od">OD</option>
                    <option value="valor">Valor</option>
                    <option value="dia">Dia</option>
                    <option value="responsavel">Responsável</option>
                </select>
            </div>
        </div>

        <table class="table-orders">
            <thead>
                <tr role="row" style="border-top: 1px solid;">
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
                            <span>Dia</span>
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
                    $obs = $row_vendas['obs'];
                    $data_compra = $row_vendas['data_compra'];
                    $responsavel = $row_vendas['usuario_responsavel'];

                    echo "<tr>";
                    echo "<td><a href=\"/Informação/id_protocolo.php?id=$cliente_id&ic=$id_compra\">$id_compra</a></td>";
                    echo "<td>$oe</td>";
                    echo "<td>$od</td>";
                    echo "<td>R$ $valor</td>";
                    echo "<td>$medico</td>";
                    echo "<td>$obs</td>";
                    echo "<td>$data_compra</td>";
                    echo "<td>$responsavel</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>


</body>

</html>