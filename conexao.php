<?php
$server = "localhost";
$user = "root";
$pass = "";
$db = "frogtech";

$mysqli = mysqli_connect($server, $user, $pass, $db);

if (!$mysqli) {
    die("Falha na conexão: " . mysqli_connect_error());
}

function mensagem($texto, $tipo) {
    echo "<div class='alert alert-$tipo' role='alert'>$texto</div>";
}
?>
