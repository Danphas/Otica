<?php
session_start();

$host = "www.otica";
$database = "db_otica";
$usuario = "root";
$senha = "";

$mysqli = new mysqli($host, $usuario, $senha, $database);
if ($mysqli->connect_errno) {
    echo "Falha ao Conectar: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;
    exit();
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
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="\Img\favicon.ico" type="image/x-icon">
    <title>Ótica Cientifica</title>
</head>

<body>
    <section class="container">
        <div class="left">
            <form method="POST">
                <h2>Login</h2>
                <input type="text" name="login" placeholder="Login">
                <input type="password" name="senha" placeholder="Senha">
                <button type="submit">Entrar</button>
            </form>
            <?php if (isset($error)) {
                echo "<p>$error</p>";
            } ?>
        </div>

        <div class="right">
            <img src="/Img/login" alt="Otica Cientifica">
        </div>
    </section>
</body>

</html>
