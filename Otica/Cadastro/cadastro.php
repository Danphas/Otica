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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeCliente = $_POST['nome_cliente'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $cidade = $_POST['cidade'];
    $telefone = $_POST['telefone'];
    $celular = $_POST['celular'];
    $dataNascimento = $_POST['data_nascimento'];
    $dataCadastro = date('Y-m-d');
    $usuarioResponsavel = $_SESSION['login'];

    $sql = "SELECT MAX(id_cliente) AS ultimo_id FROM clientes";
    $resultado = $mysqli->query($sql);
    if ($resultado) {
        $row = $resultado->fetch_assoc();
        $ultimoIdCliente = $row['ultimo_id'];
        $novoIdCliente = $ultimoIdCliente + 1;

        $sql = "INSERT INTO clientes (id_cliente, nome_cliente, cpf, email, cidade, telefone, celular, data_nascimento, data_cadastro, usuario_responsavel) VALUES ('$novoIdCliente', '$nomeCliente', '$cpf', '$email', '$cidade', '$telefone', '$celular', '$dataNascimento', '$dataCadastro', '$usuarioResponsavel')";
        $resultado = $mysqli->query($sql);

        if ($resultado) {
            echo "Dados do cliente foram adicionados com sucesso ao banco de dados.";
            $idCliente = $novoIdCliente;
            header("Location: /Cliente/cliente.php?id=$idCliente");
            exit;
        } else {
            echo "Erro ao adicionar dados do cliente ao banco de dados: " . mysqli_error($mysqli);
        }
    } else {
        echo "Erro ao obter o último ID de cliente: " . mysqli_error($mysqli);
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
        <div>
            <div class="form">
                <div class="container">
                    <form method="POST">
                        <div class="b-cadcan">
                            <div id="cad">
                                <button type="submit">Cadastrar</button>
                            </div>
                            <div id="cancel">
                                <a href="/Index/index.php"><button type="button">Cancelar</button></a>
                            </div>
                        </div>
                        <header class="form-header">
                            <h1>Cliente</h1>
                        </header>
                        <div class="section">
                            <div class="left">
                                <label for="nome_cliente">Nome</label>
                                <input type="text" id="nome_cliente" name="nome_cliente" required>

                                <label for="cpf">CPF</label>
                                <input type="text" id="cpf" name="cpf" required>

                                <label for="email">E-mail</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="right">
                                <label for="telefone">Telefone</label>
                                <input type="text" id="telefone" name="telefone">

                                <label for="celular">Celular</label>
                                <input type="text" id="celular" name="celular">

                                <label for="cidade">Cidade</label>
                                <input type="text" id="cidade" name="cidade" required>
                            </div>
                            <div class="center">
                                <label for="data_nascimento">Data de Nascimento</label>
                                <input type="date" id="data_nascimento" name="data_nascimento">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
