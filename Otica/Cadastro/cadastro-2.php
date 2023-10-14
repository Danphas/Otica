<!-- <?php
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
?> -->




<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="\Img\favicon.ico" type="image/x-icon">

  <link rel="stylesheet" href="cadastro.css">
  <title>Cadastros - Cliente e consulta</title>
</head>
<body>
  <div class="container">
    <div class="title">Cliente</div>

    <form method="POST">
      <div class="user-details">
        <div class="input-box">
          <span class="details">Nome Completo</span>
          <input type="text" id="nome_cliente" name="nome_cliente" placeholder="Nome completo" required>
        </div>

        <div class="input-box">
          <span class="details">CPF</span>
          <input type="text" placeholder="Digite o CPF">
        </div>

        <div class="input-box">
          <span class="details">Telefone</span>
          <input type="text" placeholder="Digite o telefone">
        </div>

        <div class="input-box">
          <span class="details">Celular</span>
          <input type="text" id="cidade" name="cidade" placeholder="Digite o celular">
        </div>

        <div class="input-box">
          <span class="details">Data de nascimento</span>
          <input type="date" placeholder="Digite a data de nascimento">
        </div>

        <div class="input-box">
          <span class="details">Cidade</span>
          <input type="text" id="cidade" name="cidade" placeholder="Digite a cidade">
        </div>


      </div>

       <div class="b-cadcan button">
          <div id="cad">
            <button type="submit" name="outras_submit" value="Enviar">Enviar</button>
       </div>
        <div id="cancel">
          <a href="/Index/index.php"><button type="button">Cancelar</button></a>
        </div>
      </div>

    </form>

  </div>

</body>
</html>
