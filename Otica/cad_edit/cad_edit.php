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

$id_cliente = $_GET['id'];

$query = "SELECT * FROM clientes WHERE id_cliente = '$id_cliente'";
$result = $mysqli->query($query);
$row = $result->fetch_assoc();

$nome_cliente = $row['nome_cliente'];
$telefone = $row['telefone'];
$celular = $row['celular'];
$cpf = $row['cpf'];
$cidade = $row['cidade'];
$data_nascimento = $row['data_nascimento'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['delete'])) {
    $deleteVendasQuery = "DELETE FROM vendas WHERE id_cliente = '$id_cliente'";
    $mysqli->query($deleteVendasQuery);

    $deleteClientesQuery = "DELETE FROM clientes WHERE id_cliente = '$id_cliente'";
    if ($mysqli->query($deleteClientesQuery)) {
      echo "Dados excluídos com sucesso!";
      header('Location: /Index/index.php');
      exit();
    } else {
      echo "Erro ao excluir os dados: " . $mysqli->error;
    }
  } else {
    echo "Nenhum dado foi excluído.";
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
  <title>Editar Cadastro</title>
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
  <section class="cad-user">
    <div class="container-form center-form">
      <div class="form">
        <div class="container">
          <form method="POST">
            <div class="form-section">

              <div class="b-cadcan">
                <div id="cad">
                  <button type="submit" name="outras_submit" value="Enviar">Enviar</button>
                </div>
                <div id="cancel">
                  <button type="submit" name="delete">Apagar</button>
                </div>
              </div>

              <div class="left">
                <header class="left-header">
                  <h1>Cliente</h1>
                </header>
                <div class="left-column">
                  <div class="l-left">
                    <label for="nome_cliente">Nome</label>
                    <input type="text" id="nome_cliente" name="nome_cliente" value="<?php echo $nome_cliente; ?>" required>

                    <label for="telefone">Telefone</label>
                    <input type="text" id="telefone" name="telefone" value="<?php echo $telefone; ?>">

                    <label for="celular">Celular</label>
                    <input type="text" id="celular" name="celular" value="<?php echo $celular; ?>">
                  </div>
                  <div class="r-left">
                    <label for="cpf">CPF</label>
                    <input type="text" id="cpf" name="cpf" value="<?php echo $cpf; ?>">

                    <label for="cidade">Cidade</label>
                    <input type="text" id="cidade" name="cidade" value="<?php echo $cidade; ?>">

                    <label for="data_nascimento">Data de Nascimento</label>
                    <input type="date" id="data_nascimento" name="data_nascimento" value="<?php echo $data_nascimento; ?>">
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