<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>
<body>
    <div class="container">
        <div>
            <?php
            include "conexao.php"; // Incluindo o arquivo de conexão

            if (!isset($_SESSION)) {
                session_start();
            }

            if (isset($_SESSION['email'])) {
                header("Location: paginahome.php");
                exit();
            }

            if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['CPF'])) {
                $nome = $_POST['nome'];
                $email = $_POST['email'];
                $senha = $_POST['senha'];
                $CPF = $_POST['CPF'];

                // Consulta de inserção
                $sql1 = "INSERT INTO `pessoa` (`nome`, `email`, `senha`, `CPF`) 
                         VALUES ('$nome', '$email', '$senha', '$CPF')";

                // Executando a consulta
                if (mysqli_query($mysqli, $sql1)) {
                    $_SESSION['email'] = $email; // Armazena o email na sessão
                    header("Location: paginahome.php");
                    exit();
                } else {
                    mensagem("$nome Não foi cadastrado! Erro: " . mysqli_error($mysqli), 'danger');
                }
            } else {
                echo "Por favor, preencha todos os campos.";
            }
            ?>
        </div>
    </div>
</body>
</html>
