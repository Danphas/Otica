<?php
include('protect.php');

$host = "www.otica";
$database = "db_otica";
$usuario = "root";
$senha = "";

$mysqli = new mysqli($host, $usuario, $senha, $database);
if ($mysqli->connect_errno) {
    echo "Falha ao Conectar: (" . $mysqli->connect_errno . ")" . $mysqli->connect_error;
}

$searchTerm = $_GET['term'];

$sql = "SELECT c.id_cliente, c.nome_cliente, c.cpf, c.cidade, c.data_nascimento
        FROM Clientes c
        WHERE c.nome_cliente LIKE ?";

$searchTerm = "%$searchTerm%";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $searchTerm);
$stmt->execute();

$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <script
      defer
      src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"
    ></script>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="\Img\favicon.ico" type="image/x-icon">
    <title>Otica Cientifica</title>
</head>

<body>
    <nav class="navbar">
        <a href="/Index/index.php"><img src="/Img/logo.png" alt="logo" class="logo"></a>
        <form action="\buscar_cliente\buscar_cliente.php" method="GET">
              <div class="search-box">
                <input type="search" class="search-box__input" name="term" placeholder="Insira o nome">
                    <button type="submit" class="search-btn">
                        <a href="" class="search-btn">
                            <i class="fas fa-search"></i>
                        </a>
                    </button>
            </div>
        </form>
        <ul>
            <li><span class='user'>
                    <?php echo $_SESSION['login']; ?>
                </span></li>
            <li><a id="c" href="logout.php">Sair</a></li>
        </ul>
    </nav>
    <section class="container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <!-- <th>CPF</th> -->
                    <th>Cidade</th>
                    <th>Data Nascimento</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado && $resultado->num_rows > 0) {
                    while ($row = $resultado->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td><a href='/Cliente/cliente.php?id=" . $row['id_cliente'] . "' class='table-row-link'>" . $row['id_cliente'] . "</a></td>";
                        echo "<td><a href='/Cliente/cliente.php?id=" . $row['id_cliente'] . "' class='table-row-link'>" . $row['nome_cliente'] . "</a></td>";
                        // echo "<td>" . $row['cpf'] . "</td>";
                        echo "<td>" . $row['cidade'] . "</td>";
                        echo "<td>" . date('d/m/Y', strtotime($row['data_nascimento'])) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum resultado encontrado</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>
</body>

</html>
