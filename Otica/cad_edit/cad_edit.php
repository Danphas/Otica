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

if ($result && $result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $nome_cliente = $row['nome_cliente'];
  $cpf = $row['cpf'];
  $email = $row['email'];
  $cidade = $row['cidade'];
  $telefone = $row['telefone'];
  $celular = $row['celular'];
  $data_nascimento = $row['data_nascimento'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['apagar'])) {
    $query_delete_cliente = "DELETE FROM clientes WHERE id_cliente='$id_cliente'";
    if ($mysqli->query($query_delete_cliente) === TRUE) {
      $query_delete_vendas = "DELETE FROM vendas WHERE id_cliente='$id_cliente'";
      if ($mysqli->query($query_delete_vendas) === TRUE) {
        echo "Dados excluídos com sucesso.";
        header("Location: /Index/index.php");
        exit();
      } else {
        echo "Erro ao excluir os dados: " . $mysqli->error;
      }
    }
  } else {
    $nome_cliente = $_POST['nome_cliente'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $cidade = $_POST['cidade'];
    $telefone = $_POST['telefone'];
    $celular = $_POST['celular'];
    $data_nascimento = $_POST['data_nascimento'];

    $query = "UPDATE clientes SET nome_cliente='$nome_cliente', cpf='$cpf', email='$email', cidade='$cidade', telefone='$telefone', celular='$celular', data_nascimento='$data_nascimento' WHERE id_cliente='$id_cliente'";
    if ($mysqli->query($query) === TRUE) {
      echo "Dados atualizados com sucesso.";
      header("Location: /Cliente/cliente.php?id=$id_cliente");
      exit();
    } else {
      echo "Erro ao atualizar os dados: " . $mysqli->error;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
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
    <div>
      <div class="form">
        <div class="container">
          <form method="POST">
            <div class="b-cadcan">
              <div id="cad">
                <button type="submit">Confirmar</button>
              </div>
              <div id="cancel">
                <button type="submit" name="apagar">Apagar</button>
              </div>
            </div>
            <header class="form-header">
              <h1>Cliente</h1>
            </header>
            <div class="section">
              <div class="left">
                <label for="nome_cliente">Nome</label>
                <input type="text" id="nome_cliente" name="nome_cliente" value="<?php echo $nome_cliente; ?>" required>

                <label for="cpf">CPF</label>
                <input type="text" id="cpf" name="cpf" value="<?php echo $cpf; ?>" required>

                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
              </div>
              <div class="right">
                <label for="telefone">Telefone</label>
                <input type="text" id="telefone" name="telefone" value="<?php echo $telefone; ?>">

                <label for="celular">Celular</label>
                <input type="text" id="celular" name="celular" value="<?php echo $celular; ?>">

                <label for="cidade">Cidade</label>
                <input type="text" id="cidade" name="cidade" value="<?php echo $cidade; ?>" required>
              </div>
              <div class="center">
                <label for="data_nascimento">Data de Nascimento</label>
                <input type="date" id="data_nascimento" name="data_nascimento" value="<?php echo $data_nascimento; ?>">
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</body>

</html>
