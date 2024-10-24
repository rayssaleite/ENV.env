<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frog Tech - Login</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #eeeeee;
        }

        .header {
            position: absolute;
            top: 10px;
            width: 100%;
            display: flex;
            justify-content: center;
            z-index: 1;
        }

        .header img.main-logo {
            width: 420px; 
        }

        .login-container {
            background-color: #ffffff;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 30px 50px;
            border-radius: 20px;
            color: black;
            text-align: center;
            width: 350px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .login-container h1 {
            margin-bottom: 20px;
            color: #333;
        }

        input {
            padding: 15px;
            border-radius: 50px;
            outline: none;
            font-size: 15px;
            width: 100%;
            box-sizing: border-box;
            border: 1px solid #ccc;
            margin-bottom: 20px;
            padding-left: 40px;
            position: relative;
        }

        button {
            background-color: #0a74059f;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 50px;
            color: white;
            font-size: 15px;
            transition: all 0.8s;
        }

        button:hover {
            background-color: #950000;
            cursor: pointer;
        }

        footer {
            background-color: rgba(0, 71, 15, 0);
            color: rgb(0, 0, 0);
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
        }

        a {
            color: #0a74059f;
        }

        a:hover {
            text-decoration: underline;
            color: red;
            transition: all 0.8s; 
        }
    </style>
</head>
<body>
    <header>
        <div class="header">
            <img src="../img/logo2.png" alt="Logo" class="main-logo">
        </div>
    </header>
    <div class="login-container">
        <h1>Login</h1>
        <form method="POST" action="">
            <input type="email" placeholder="Email" name="email" required>
            <input type="password" placeholder="Senha" name="password" required>
            <button type="submit">Entrar</button>
            <p>Não possui conta? <a href="regis.php">Registrar</a></p>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 Meu Site. Todos os direitos reservados a Frogtech.</p>
    </footer>
</body>
</html>

<?php
include("conexao.php");

if (!isset($_SESSION)) {
    session_start();
}


if (isset($_SESSION['email'])) {
    header("Location: paginahome.php");
    exit();
}


if (isset($_POST['email']) && isset($_POST['password'])) {
    if (strlen($_POST['email']) == 0) {
        echo "Email inválido";
    } else if (strlen($_POST['password']) == 0) {
        echo "Senha inválida";
    } else {
        
        $email = $mysqli->real_escape_string($_POST['email']);
        $password = $_POST['password']; 

        $sql_code = "SELECT * FROM pessoa WHERE email = ?";
        $stmt = $mysqli->prepare($sql_code);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

 
        if ($result->num_rows == 1) {
            $usuario = $result->fetch_assoc();
            

            if (password_verify($password, $usuario['senha'])) {

                $_SESSION['email'] = $usuario['email'];
                header("Location: paginahome.php");
                exit();
            } else {
                echo "<p style='color: red;'>Senha incorreta. Tente novamente.</p>";
            }
        } else {
            echo "<p style='color: red;'>Email não encontrado. Verifique seus dados.</p>";
        }

 
        $stmt->close();
    }
}
?>