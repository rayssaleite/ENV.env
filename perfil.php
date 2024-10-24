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

$query = "SELECT nome, email, cpf, foto_perfil FROM pessoa WHERE email = ?";
$stmt = $mysqli->prepare($query); // Use $mysqli aqui

if ($stmt === false) {
    die("Erro na preparação da consulta: " . $mysqli->error); // Altere para $mysqli
}

$stmt->bind_param("s", $email); // Alterado para 's' para o tipo string
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $nome = $user['nome'];
    $cpf = $user['cpf'];
    $foto_perfil = $user['foto_perfil'];
} else {
    header("Location: start.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuário - Frog Tech</title>
    <style>
        /* Estilos básicos */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', 'Helvetica', sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            padding-top: 60px; /* Para garantir espaço para o header fixo */
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
    justify-content: flex-start; /* Alinha a logo à esquerda */
    padding-left:18px; /* Adiciona espaço extra à esquerda, se necessário */
}

.logo img {
    width: 200px;
    margin-left: 200px; /* Ajuste a distância da logo para a direita */
}


.menu {
    flex: 1;
    display: flex;
    justify-content: flex-end;
    margin-right: 250px; /* Ajusta a distância da borda direita */
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

        .menu-icon:hover .bar {
            background-color: #006600;
        }

        .bar {
            height: 3px;
            width: 100%;
            background-color: #fff;
            border-radius: 5px;
            transition: 0.3s;
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

        .profile-header img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
            margin-bottom: 15px;
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

        .profile-details {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .profile-details h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .profile-details p {
            margin: 5px 0;
            font-size: 16px;
        }

        .profile-details a {
            color: #28a745;
            text-decoration: none;
            margin-top: 15px;
            display: inline-block;
        }

        .profile-details a:hover {
            text-decoration: underline;
        }

        .btn {
            padding: 10px 20px;
            color: #fff;
            background-color: #28a745; /* Cor inicial (verde) */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            position: relative;
            display: inline-flex;
            align-items: center;
            transition: background-color 0.3s, color 0.3s; /* Adiciona a transição suave */
        }

        .btn:hover {
            background-color: #dc3545; /* Cor ao passar o mouse (vermelho) */
            color: #fff;
        }

        .btn::after {
            content: '→'; /* Adiciona uma seta após o texto */
            margin-left: 10px;
            font-size: 18px;
            transition: transform 0.3s; /* Transição suave para o movimento da seta */
        }

        .btn:hover::after {
            transform: translateX(5px); /* Move a seta para a direita ao passar o mouse */
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

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
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

<div class="sidebar" id="sidebarMenu">
    <ul>
        <li><a href="loja.html">Loja</a></li>
        <li><a href="desenvolvedores.html">Desenvolvedores</a></li>
        <li><a href="paginahome.php">Home</a></li>
        <li><a href="logout.php" class="logout">Sair</a></li>
    </ul>
</div>

<div class="overlay" id="overlay"></div>

<div class="container">
    <!-- Cabeçalho do Perfil -->
    <div class="profile-header">
        <img src="<?php echo htmlspecialchars($foto_perfil); ?>" alt="Foto de Perfil">
        <h2><?php echo htmlspecialchars($nome); ?></h2>
        <p><?php echo htmlspecialchars($email); ?></p>
    </div>

    <!-- Detalhes do Perfil -->
    <div class="profile-details">
        <h3>Informações Pessoais</h3>
        <p><strong>Nome:</strong> <?php echo htmlspecialchars($nome); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
        <p><strong>CPF:</strong> <?php echo htmlspecialchars($cpf); ?></p>
    </div>

    <!-- Ações do Perfil -->
    <a href="alterar_informacoes.php" class="btn">Alterar informações</a>
    
</div>

<footer class="footer">
    <p>&copy; 2024 Frog Tech. Todos os direitos reservados.</p>
</footer>

<script>
    const menuIcon = document.getElementById('menuIcon');
    const sidebar = document.getElementById('sidebarMenu');
    const overlay = document.getElementById('overlay');

    menuIcon.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
    });
</script>

</body>
</html>
