<?php
if(!isset($_SESSION)) {
    session_start();
}

if(!isset($_SESSION['id'])) {
    die('Voce não pode acessar a pagina, faça login primeiramente. <p><a href=\"index.php\">Entrar</a></p>');
}


?>