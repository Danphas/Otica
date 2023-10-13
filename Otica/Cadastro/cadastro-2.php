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

  <!-- <nav>
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
  <br> -->

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

      <div class="button">
        <button type="submit" name="outras_submit" value="Enviar">Cadastrar</button>
      </div>

      <div class="button">
      <a href="/Index/index.php"><button type="button">Cancelar</button></a>
      </div>

    </form>

  </div>

  <div class="container">
    <div class="title">Consulta</div>

    <form action="#">
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
      <button type="submit" name="outras_submit" value="Enviar">Enviar</button>
      <div class="button">

    </form>

  </div>

</body>
</html>
