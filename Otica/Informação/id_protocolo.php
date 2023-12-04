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
        $data_nascimento = $row_cliente['data_nascimento'];
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="\Img\favicon.ico" type="image/x-icon">

  <link rel="stylesheet" href="cadastro.css">
  <title>Dados - Cliente</title>
</head>
<body>

  <div class="container">
    <div class="title">Cliente</div>

    <form action="#">
      <div class="user-details">
        <div class="input-box">
          <span class="details">Nome Completo</span>
          <input type="text" id="nome_cliente" name="nome_cliente" value="<?php echo $nome_cliente; ?>">
        </div>

        <div class="input-box">
          <span class="details">CPF</span>
          <input type="text" value="<?php echo $cpf; ?>">
        </div>

        <div class="input-box">
          <span class="details">Telefone</span>
          <input type="text" value="<?php echo $telefone; ?>">
        </div>

        <div class="input-box">
          <span class="details">Celular</span>
          <input type="text" id="celular" name="celular" value="<?php echo $celular; ?>">
        </div>

        <div class="input-box">
          <span class="details">Data de nascimento</span>
          <input type="date" value="<?php echo $data_nascimento; ?>">
        </div>

        <div class="input-box">
          <span class="details">Cidade</span>
          <input type="text" id="cidade" name="cidade" value="<?php echo $cidade; ?>">
        </div>


      </div>

      <div id="edit-client">
            <a href="/cad_edit/cad_edit.php?id=<?php echo $cliente_id; ?>">
                Editar dados
            </a>
      </div>

    </form>

  </div>

  <div class="container">
    <div class="title">Consulta</div>

    <form action="#">
      <div class="user-details">
        <div class="input-box">
          <span class="details">OD</span>
          <input class="input" type="text" id="od" name="od" value="<?php echo $od; ?>">
        </div>

        <div class="input-box">
          <span class="details">DNP OD</span>
          <input type="text" id="dnp_od" name="dnp_od" value="<?php echo $dnp_od; ?>">
        </div>

        <div class="input-box">
          <span class="details">Altura OD</span>
          <input type="text" value="<?php echo $altura_od; ?>">
        </div>

        <div class="input-box">
          <span class="details">OE</span>
          <input class="input" type="text" id="oe" name="oe" value="<?php echo $oe; ?>">
        </div>

        <div class="input-box">
          <span class="details">DNP OE</span>
          <input type="text" id="dnp_oe" name="dnp_oe" value="<?php echo $oe; ?>">
        </div>

        <div class="input-box">
          <span class="details">Altura OE</span>
          <input type="text" id="altura_oe" name="altura_oe" value="<?php echo $altura_oe; ?>">
        </div>

        <div class="input-box">
          <span class="details">Adição</span>
          <input type="number" id="adicao" name="adicao" value="<?php echo $adicao; ?>">
        </div>

        <div class="input-box">
          <span class="details">Data da consulta</span>
          <input type="date" value="<?php echo $data_consulta; ?>">
        </div>

        <div class="input-box">
          <span class="details">Médico</span>
          <input type="text" id="medico" name="medico" value="<?php echo $medico; ?>">
        </div>

        <div class="input-box">
          <span class="details">Responsável</span>
          <input type="text" id="responsavel" name="responsavel" value="<?php echo $responsavel; ?>">
        </div>

        <div class="input-box">
          <span class="details">NR Pedido</span>
          <input id="nr_pedido" name="nr_pedido" value="<?php echo $nr_pedido; ?>">
        </div>

        <div class="input-box">
          <span class="details">Armação (AR)</span>
          <input type="text" id="armacao" name="armacao" value="<?php echo $armacao; ?>">
        </div>

        <div class="input-box">
          <span class="details">Lente (LT)</span>
          <input type="text" id="lente" name="lente" value="<?php echo $lente; ?>">
        </div>

        <div class="input-box">
          <span class="details">Valor</span>
          <input type="number" id="valor" name="valor" value="<?php echo $valor; ?>">
        </div>


        <div class="input-box">
          <span class="details">Observação</span>
          <input type="text" id="observacao" name="observacao" value="<?php echo $observacao; ?>">
        </div>

      </div>

      <div class="button">
        <input type="submit" value="Cadastrar">
      </div>

    </form>

  </div>

</body>
</html>
