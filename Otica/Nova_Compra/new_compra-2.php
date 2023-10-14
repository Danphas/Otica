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
    $adicao = $_POST['adicao'];
    $armacao = $_POST['armacao'];
    $nr_pedido = $_POST['nr_pedido'];
    $lente = $_POST['lente'];
    $valor = $_POST['valor'];
    $observacao = $_POST['observacao'];
    $data_compra = date('Y-m-d');
    $responsavel = $_POST['responsavel'];

    $id_geral = obterUltimoIDGeral($mysqli);

    $sql_insert = "INSERT INTO vendas (id_cliente, id_compra, id_geral, data_consulta, medico, oe, dnp_oe, altura_oe, od, dnp_od, altura_od, adicao, armacao, nr_pedido, lente, valor, observacao, data_compra, responsavel) VALUES ('$cliente_id', '$id_compra', '$id_geral', '$data_consulta', '$medico', '$oe', '$dnp_oe', '$altura_oe', '$od', '$dnp_od', '$altura_od', '$adicao', '$armacao', '$nr_pedido', '$lente', '$valor', '$observacao', '$data_compra', '$responsavel')";

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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="\Img\favicon.ico" type="image/x-icon">

  <link rel="stylesheet" href="cadastro.css">
  <title>Nova compra</title>
</head>
<body>

  <div class="container">
    <div class="title">Consulta</div>

    <form method="POST">
      <div class="user-details">
        <div class="input-box">
          <span class="details">OD</span>
          <input class="input" type="text" id="od" name="od" placeholder="Grau OD">
        </div>

        <div class="input-box">
          <span class="details">DNP OD</span>
          <input type="text" id="dnp_od" name="dnp_od" placeholder="Insira o DNP">
        </div>

        <div class="input-box">
          <span class="details">Altura OD</span>
          <input type="text" placeholder="Digite a altura">
        </div>

        <div class="input-box">
          <span class="details">OE</span>
          <input class="input" type="text" id="oe" name="oe" placeholder="Grau OE">
        </div>

        <div class="input-box">
          <span class="details">DNP OE</span>
          <input type="text" id="dnp_oe" name="dnp_oe"  placeholder="Insira o DNP">
        </div>

        <div class="input-box">
          <span class="details">Altura OE</span>
          <input type="text" id="altura_oe" name="altura_oe" placeholder="Digite a altura">
        </div>

        <div class="input-box">
          <span class="details">Adição</span>
          <input type="number" id="adicao" name="adicao" step="0.05" placeholder="0.00" placeholder="Digite a adição">
        </div>

        <div class="input-box">
          <span class="details">Data da consulta</span>
          <input type="date" placeholder="Digite a data de nascimento">
        </div>

        <div class="input-box">
          <span class="details">Médico</span>
          <input type="text" id="medico" name="medico" placeholder="Nome do médico">
        </div>

        <div class="input-box">
          <span class="details">Responsável</span>
          <input type="text" id="responsavel" name="responsavel" placeholder="Resp atendimento">
        </div>

        <div class="input-box">
          <span class="details">NR Pedido</span>
          <input id="nr_pedido" name="nr_pedido" placeholder="Ex. 234567">
        </div>

        <div class="input-box">
          <span class="details">Armação (AR)</span>
          <input type="text" id="armacao" name="armacao" placeholder="Insira o AR">
        </div>

        <div class="input-box">
          <span class="details">Lente (LT)</span>
          <input type="text" id="lente" name="lente" placeholder="Ex. policarbonato">
        </div>

        <div class="input-box">
          <span class="details">Valor</span>
          <input type="number" id="valor" name="valor" placeholder="R$0.00">
        </div>


        <div class="input-box">
          <span class="details">Observação</span>
          <input type="text" id="observacao" name="observacao" placeholder="Ex. volta dia xx">
        </div>

      </div>

      <div class="button">
        <input type="submit" value="Cadastrar">
      </div>

      <div class="button">
        <a href="/Index/index.php" class="button">
            <input type="button" value="Cancelar" style="margin-top: 10px">
        </a>
      </div>

    </form>

  </div>

</body>
</html>
