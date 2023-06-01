<?php
session_start();


$host = "www.otica";
$database = "db_otica";
$usuario = "root";
$senha = "";

$mysqli = new mysqli($host, $usuario, $senha, $database);
if ($mysqli->connect_errno) {
    echo "Falha ao Conectar: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;
}

if (isset($_POST['login']) && isset($_POST['senha'])) {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM ADM WHERE login = ? AND senha = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ss", $login, $senha);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['id'] = $row['id'];
        $_SESSION['login'] = $row['login'];
        $stmt->close();
        $mysqli->close();
        header("Location: /Index/index.php");
        exit();
    } else {
        $error = "Falha ao fazer login";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>
        Otica Cientifica
    </title>
    <link rel="icon" type="image/x-icon" href="/Img/favico.ico">
</head>

<body>
    <nav>
        <section class="logo">
            <a href="/Login/login.php"><img src="/Img/logo.png" alt="logo" class="logo"></a>
        </section>
    </nav>

    <header>
        <div class="login">
            <form action="" method="POST">
                <label for="login">Login</label>
                <input type="text" id="login" name="login" required>
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
                <button type="submit">Entrar</button>
            </form>
            <?php if (isset($error)) {
                echo "<p>$error</p>";
            } ?>
        </div>
    </header>
</body>

</html>