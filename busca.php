<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Busca de Produtos - Frog Tech</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #fff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .logo img {
            width: 80px;
            border-radius: 50%;
        }

        h1 {
            font-size: 2em;
            color: #2e7d32;
            font-weight: 600;
        }

        .menu-icon {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 20px;
            cursor: pointer;
        }

        .bar {
            height: 3px;
            width: 100%;
            background-color: #333;
            border-radius: 5px;
            transition: 0.3s;
        }

        .sidebar {
            position: fixed;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100%;
            background-color: #fff;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.05);
            transition: 0.5s ease;
            z-index: 1001;
            padding-top: 60px;
        }

        .sidebar.open {
            right: 0;
        }

        .sidebar ul {
            list-style: none;
            padding: 20px;
            margin: 0;
        }

        .sidebar ul li {
            padding: 15px 0;
            border-bottom: 1px solid #e1e1e1;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            font-size: 1.1rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .sidebar ul li a:hover {
            color: #2e7d32;
        }

        .sidebar ul li a.logout {
            color: #ff0000;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 1000;
        }

        .overlay.show {
            display: block;
        }

        .search-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 120px auto 20px;
        }

        .search-container h1 {
            margin-bottom: 20px;
            font-size: 24px;
            text-align: center;
        }

        .search-container form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .search-container label {
            font-size: 18px;
            font-weight: bold;
        }

        .search-container input,
        .search-container select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
        }

        .search-container button {
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-container button:hover {
            background-color: #218838;
        }

        .results ul {
            list-style-type: none;
            padding: 0;
        }

        .results li {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .results img {
            max-width: 200px;
            height: auto;
            display: block;
            margin-bottom: 10px;
        }

        .results h3 {
            margin-bottom: 10px;
        }

        .results p {
            margin: 5px 0;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 1.5em;
            }
        }
    </style>
</head>
<body>

<!-- Cabeçalho -->
<header>
    <div class="logo">
        <img src="../img/logo1.png" alt="Logo da Loja">
    </div>
    <h1>Frog Tech</h1>
    <div class="menu-icon" id="menuIcon">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
    </div>
</header>

<!-- Menu Lateral -->
<div class="sidebar" id="sidebarMenu">
    <ul>
        <li><a href="paginahome.php">Home</a></li>
        <li><a href="loja.htm">Loja</a></li>
        <li><a href="perfil.php">Perfil de Usuário</a></li>
        <li><a href="logout.php" class="logout">Sair</a></li>
    </ul>
</div>
<div class="overlay" id="overlay"></div>

<!-- Seção de Busca -->
<div class="search-container">
    <h1>Buscar Produtos</h1>
    <form method="POST">
        <label for="search">Termo de Busca:</label>
        <input type="text" id="search" name="q" placeholder="Digite o nome ou descrição do produto">

        <label for="categoria">Categoria:</label>
        <select id="categoria" name="categoria">
            <option value="">Todas as Categorias</option>
            <option value="Eletrônico">Eletrônico</option>
            <option value="Periférico">Periférico</option>
            <option value="Networking">Networking</option>
            <option value="Armazenamento">Armazenamento</option>
            <option value="Acessório">Acessório</option>
        </select>

        <button type="submit">Buscar</button>
    </form>
</div>

<!-- Resultados da Busca -->
<div class="results">
    <?php
    // Configurações de conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "noc";

    // Conexão ao banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar se houve erro na conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Verificar se o formulário foi enviado
    if (isset($_POST['q']) || isset($_POST['categoria'])) {
        // Pegar o termo de pesquisa e tratar para evitar SQL injection
        $busca = isset($_POST['q']) ? $conn->real_escape_string($_POST['q']) : '';
        $categoria = isset($_POST['categoria']) ? $conn->real_escape_string($_POST['categoria']) : '';

        // Montar a consulta SQL
        $sql = "SELECT produtos.*, categoria.nome AS nome_categoria 
                FROM produtos 
                JOIN categoria ON produtos.categoria_id = categoria.id 
                WHERE 1=1"; // Usa WHERE 1=1 para facilitar a adição de condições dinâmicas

        // Se um termo de busca for fornecido
        if (!empty($busca)) {
            $sql .= " AND (produtos.nome LIKE '%$busca%' OR produtos.descricao LIKE '%$busca%')";
        }

        // Se uma categoria for selecionada
        if (!empty($categoria)) {
            $sql .= " AND categoria.nome = '$categoria'";
        }

        // Executar a consulta
        $resultado = $conn->query($sql);

        // Verificar se há resultados
        if ($resultado->num_rows > 0) {
            echo "<h2>Resultados da busca</h2>";
            echo "<ul>"; // Usar lista para exibir os produtos

            // Exibir os resultados
            while ($produto = $resultado->fetch_assoc()) {
                echo "<li>";
                
                // Exibir a imagem do produto
                if (!empty($produto['imagem'])) {
                    echo "<img src='" . htmlspecialchars($produto['imagem']) . "' alt='" . htmlspecialchars($produto['nome']) . "'/>";
                }

                // Exibir o nome do produto
                echo "<h3>" . htmlspecialchars($produto['nome']) . "</h3>";

                // Exibir a descrição do produto
                echo "<p>" . htmlspecialchars($produto['descricao']) . "</p>";

                // Exibir a categoria do produto
                echo "<p><strong>Categoria:</strong> " . htmlspecialchars($produto['nome_categoria']) . "</p>";

                // Exibir o preço do produto
                echo "<p><strong>Preço:</strong> R$ " . number_format($produto['preco'], 2, ',', '.') . "</p>";
                echo "</li>";
            }

            echo "</ul>";
        } else {
            echo "<h2>Nenhum produto encontrado.</h2>";
        }
    } else {
        echo "<h2>Por favor, insira um termo de busca ou selecione uma categoria.</h2>";
    }

    // Fechar a conexão com o banco de dados
    $conn->close();
    ?>
</div>

<script>
    const menuIcon = document.getElementById('menuIcon');
    const sidebarMenu = document.getElementById('sidebarMenu');
    const overlay = document.getElementById('overlay');

    // Abrir menu lateral ao clicar no ícone
    menuIcon.addEventListener('click', () => {
        sidebarMenu.classList.toggle('open');
        overlay.classList.toggle('show');
    });

    // Fechar o menu lateral ao clicar no overlay
    overlay.addEventListener('click', () => {
        sidebarMenu.classList.remove('open');
        overlay.classList.remove('show');
    });

    // Fechar o menu lateral ao pressionar a tecla "Esc"
    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            sidebarMenu.classList.remove('open');
            overlay.classList.remove('show');
        }
    });
</script>

</body>
</html>