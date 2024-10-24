<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frog Tech - Registro</title>
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
            width: 420px; /* Ajuste do tamanho da logo para manter padrão */
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
        <h1>Registrar</h1>
        
        <?php
        // Verificar se o formulário foi enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Conectar ao banco de dados
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "frogtech";

            // Criar conexão
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Verificar a conexão
            if ($conn->connect_error) {
                die("Conexão falhou: " . $conn->connect_error);
            }

            // Receber os dados do formulário
            $nome = mysqli_real_escape_string($conn, $_POST['nome']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $senha = mysqli_real_escape_string($conn, $_POST['senha']);
            $cpf = mysqli_real_escape_string($conn, $_POST['CPF']);

            // Hashear a senha
            $senha_hashed = password_hash($senha, PASSWORD_DEFAULT);

            // Verificar se o email já existe
            $sql_check_email = "SELECT id FROM pessoa WHERE email = ?";
            $stmt_check = $conn->prepare($sql_check_email);
            $stmt_check->bind_param("s", $email);
            $stmt_check->execute();
            $stmt_check->store_result();

            if ($stmt_check->num_rows > 0) {
                // O email já existe
                echo "<p style='color: red;'>Este email já está cadastrado. Por favor, use outro email.</p>";

                // Redirecionar para a página inicial após 2 segundos
                header("Refresh: 2; URL=paginahome.php");
            } else {
                // O email não existe, podemos continuar com o registro

                // Inserir os dados na tabela 'pessoa'
                $sql_insert = "INSERT INTO pessoa (nome, email, senha, cpf) VALUES (?, ?, ?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->bind_param("ssss", $nome, $email, $senha_hashed, $cpf);

                if ($stmt_insert->execute()) {
                    echo "<p>Registro efetuado com sucesso! Redirecionando...</p>";
                    
                    // Redirecionar para a página inicial após o registro bem-sucedido
                    header("Location: paginahome.php");
                    exit();
                } else {
                    echo "Erro: " . $stmt_insert->error;
                }

                $stmt_insert->close();
            }

            // Fechar a verificação de email
            $stmt_check->close();

            // Fechar conexão
            $conn->close();
        }
        ?>

        <form action="" method="POST">
            <input type="text" class="form-control" placeholder="Nome" name="nome" required>
            <input type="email" class="form-control" placeholder="Email" name="email" required pattern=".+@.+\..+" title="O e-mail deve conter @ e um domínio.">
            <input type="password" class="form-control" placeholder="Senha" name="senha" required pattern="(?=.*\d)(?=.*[@]).{8,}" title="A senha deve ter pelo menos 8 caracteres, incluir um número e um símbolo @.">
            <input type="text" class="form-control" placeholder="CPF" name="CPF" required maxlength="11" pattern="\d{11}" title="O CPF deve conter 11 dígitos.">
            <button type="submit">Registrar</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2024 FrogTech. Todos os direitos reservados.</p>
    </footer>
</body>
</html>