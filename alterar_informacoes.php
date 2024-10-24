<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Conectar ao banco de dados
include('conexao.php'); // Inclua o arquivo de conexão

// Recuperar informações do usuário
$email = $_SESSION['email'];

$query = "SELECT nome, email, cpf FROM pessoa WHERE email = ?";
$stmt = $mysqli->prepare($query);

if ($stmt === false) {
    die("Erro na preparação da consulta: " . $mysqli->error);
}

$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $nome = $user['nome'];
    $cpf = $user['cpf'];
} else {
    header("Location: start.html");
    exit();
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $novo_nome = $_POST['nome'];
    $novo_email = $_POST['email'];
    $novo_cpf = $_POST['cpf'];
    $nova_senha = $_POST['senha'];

    // Atualiza as informações no banco de dados
    $update_query = "UPDATE pessoa SET nome = ?, email = ?, cpf = ?, senha = ? WHERE email = ?";
    $update_stmt = $mysqli->prepare($update_query);
    $update_stmt->bind_param("sssss", $novo_nome, $novo_email, $novo_cpf, password_hash($nova_senha, PASSWORD_DEFAULT), $email);
    $update_stmt->execute();

    // Atualiza a sessão
    $_SESSION['email'] = $novo_email;

    // Redireciona após atualização
    header("Location: perfil.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frog Tech - Alterar Informações</title>
    <style>
        /* Estilos básicos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #333;
            padding-top: 60px; /* Para garantir o espaço para o header fixo */
        }

        header {
            background: rgba(40, 199, 111, 0.8);
            backdrop-filter: blur(10px);
            padding: 20px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            flex: 1;
            display: flex;
            justify-content: flex-start;
        }

        .logo img {
            width: 200px;
        }

        .menu {
            flex: 1;
            display: flex;
            justify-content: flex-end;
        }

        .menu-icon {
            display: flex;
            flex-direction: column;
            justify-content: space-around;
            width: 30px;
            height: 25px;
            cursor: pointer;
            transition: 0.3s;
        }

        .bar {
            height: 3px;
            width: 100%;
            background-color: #fff;
            border-radius: 5px;
        }

        .container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
        }

        .profile-header {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-bottom: 20px;
            padding-top: 100px;
        }

        .profile-header h2 {
            font-size: 24px;
            color: #333;
            margin: 0;
        }

        .profile-header p {
            font-size: 16px;
            color: #666;
        }

        .form-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .form-container h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .form-container label {
            display: block;
            margin: 10px 0 5px;
            font-weight: bold;
            color: #333;
        }

        .form-container input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container button {
            padding: 10px 20px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #dc3545;
        }

        .footer {
            width: 100%;
            position: fixed;
            bottom: 0;
            color: black;
            text-align: center;
            padding: 10px 0;
        }

        .footer p {
            margin: 0;
        }

        .sidebar {
            position: fixed;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
            transition: 0.5s;
            z-index: 1000;
        }

        .sidebar.open {
            right: 0;
        }

        .sidebar ul {
            list-style: none;
            padding: 20px;
        }

        .sidebar ul li {
            padding: 15px 0;
            border-bottom: 1px solid #ccc;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .sidebar ul li a:hover {
            color: #006600;
        }

        /* Overlay para fechar a sidebar */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            display: none;
            z-index: 999;
        }

        .overlay.show {
            display: block;
        }
    </style>
</head>
<body>

<header>
    <div class="logo">
        <img src="../img/logo2.png" alt="Frog Tech Logo">
    </div>
    <div class="menu">
        <div class="menu-icon" id="menuIcon">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </div>
</header>

<!-- Overlay para fechar a sidebar ao clicar em qualquer lugar -->
<div class="overlay" id="overlay"></div>

<div class="sidebar" id="sidebarMenu">
    <ul>
        <li><a href="loja.html">Loja</a></li>
        <li><a href="desenvolvedores.html">Desenvolvedores</a></li>
        <li><a href="paginahome.php">Home</a></li>
        <li><a href="logout.php" class="logout">Sair</a></li>
    </ul>
</div>

<div class="container">
    <!-- Formulário de Alteração de Informações -->
    <div class="form-container">
        <h2>Altere suas informações pessoais</h2>
        <form method="POST" action="">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required>
            <br>
            <label for="email">Novo Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <br>
            <label for="cpf">Novo CPF:</label>
            <input type="text" name="cpf" value="<?php echo htmlspecialchars($cpf); ?>" required>
            <br>
            <label for="senha">Nova Senha:</label>
            <input type="password" name="senha" required>
            <br>
            <button type="submit">Salvar Alterações</button>
        </form>
    </div>
</div>

<footer class="footer">
    <p>&copy; 2024 Frog Tech | Todos os direitos reservados.</p>
</footer>

<script>
    // Script para abrir e fechar a sidebar
    const menuIcon = document.getElementById('menuIcon');
    const sidebarMenu = document.getElementById('sidebarMenu');
    const overlay = document.getElementById('overlay');

    menuIcon.addEventListener('click', () => {
        sidebarMenu.classList.toggle('open');
        overlay.classList.toggle('show');
    });

    overlay.addEventListener('click', () => {
        sidebarMenu.classList.remove('open');
        overlay.classList.remove('show');
    });
</script>

</body>
</html>
