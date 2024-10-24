<?php
if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_id'])) { // Use 'user_id' para proteger a página
    die("Você não tem permissão para acessar esta página porque não está logado. <p><a href=\"login.php\">Clique aqui</a></p>");
}

// Debug: Mostra as variáveis de sessão
echo '<pre>';
var_dump($_SESSION);
echo '</pre>';
?>
