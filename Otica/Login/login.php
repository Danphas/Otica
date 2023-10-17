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
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@400;600;700&display=swap"
      rel="stylesheet"
    />
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ótica Cientifica</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div id="page" class="flex">
      <div>
        <!-- <header>
          <img src="/Otica/Img/logo.png" alt="Otica Cientifica">
        </header> -->
        <main>
          <div class="headline">
            <h1>Acesse a plataforma</h1>
            <p>
              Faça login para efetuar os cadastros.
            </p>
          </div>
          <form method="POST">
            <div class="input-wrapper">
              <label for="email">Usuário</label>
              <input type="text" name="login" placeholder="Usuário" required>
            </div>

            <div class="input-wrapper">
              <div class="label-wrapper flex">
                <label for="senha"> Senha </label>
              </div>

              <input type="password" name="senha" placeholder="Senha">

              <img
                onclick="togglePassword()"
                class="eye"
                src="./assets/eye-off.svg"
                alt=""
              />
              <img
                onclick="togglePassword()"
                class="eye hide"
                src="./assets/eye.svg"
                alt=""
              />
            </div>

            <button type="submit">Entrar</button>
          </form>

          <?php if (isset($error)) {
                echo "<p>$error</p>";
            } ?>
        </main>
      </div>
      <img src="./assets/bg.jpg" alt="" />
    </div>

    <script>
      function togglePassword() {
        document
          .querySelectorAll(".eye")
          .forEach((eye) => eye.classList.toggle("hide"))

        const type =
          senha.getAttribute("type") == "password" ? "text" : "password"

        senha.setAttribute("type", type)
      }
    </script>
  </body>
</html>
