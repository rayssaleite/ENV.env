<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Frog Tech - Home</title>

    <!-- Fonte Poppins do Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        /* Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #fff;
            color: #333;
            line-height: 1.6;
        }

        header {
            background-color: #fff;
            padding: 15px;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo img {
            width: 180px;
            height: auto;
        }

        /* Menu Icon */
        .menu-icon {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 20px;
            cursor: pointer;
            transition: 0.3s;
        }

        .menu-icon:hover .bar {
            background-color: #4CAF50;
        }

        .bar {
            height: 3px;
            width: 100%;
            background-color: #333;
            border-radius: 5px;
            transition: 0.3s;
        }

        /* Carrinho de compras */
        .cart-icon {
            width: 24px;
            height: 24px;
            cursor: pointer;
        }

        .cart-count {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 5px 8px;
            font-size: 0.8rem;
        }

        .cart {
            position: relative;
            margin-right: 20px;
        }

        /* Title Section */
        .titulo {
            margin-top: 120px;
            text-align: center;
            padding: 20px;
        }

        .titulo h1 {
            color: #333;
            font-size: 3rem;
            font-weight: 600;
        }

        .titulo h3 {
            margin-top: 10px;
            color: #666;
            font-size: 1.5rem;
            font-weight: 300;
        }

        /* Botão Ir às Compras */
        .shop-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 15px 30px;
            background-color: #4CAF50;
            color: white;
            font-size: 1.2rem;
            font-weight: 600;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            text-decoration: none;
        }

        .shop-btn:hover {
            background-color: #388e3c;
        }

        /* Cards Section */
        .cards-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            padding: 60px 20px;
            flex-wrap: wrap;
            background-color: #fafafa;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .card, .side-card {
            background-color: #fff;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            width: 280px;
            height: 280px;
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .card:hover, .side-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            background-color: #4CAF50;
            color: white;
        }

        .card h2, .side-card h2 {
            color: #4CAF50;
            margin-bottom: 10px;
            font-size: 1.8rem;
        }

        .card p, .side-card p {
            color: #666;
            font-size: 1.1rem;
            line-height: 1.5;
        }

        /* Footer */
        footer {
            color: #fff;
            text-align: center;
            padding: 20px 0;
            background-color: #333;
            position: relative;
            width: 100%;
            margin-top: 50px;
        }

        footer p {
            font-size: 0.9rem;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100%;
            background-color: #fff;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.05);
            transition: 0.5s;
            z-index: 1001;
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
            transition: color 0.3s ease;
        }

        .sidebar ul li a:hover {
            color: #4CAF50;
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

        /* Responsive */
        @media (max-width: 768px) {
            .cards-container {
                flex-direction: column;
                align-items: center;
            }

            .titulo h1 {
                font-size: 2.5rem;
            }

            .titulo h3 {
                font-size: 1.2rem;
            }

            .card, .side-card {
                width: 100%;
                height: auto;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="../img/logo2.png" alt="Frog Tech Logo">
        </div>
        <div class="cart">
            <img src="https://cdn-icons-png.flaticon.com/512/263/263142.png" alt="Carrinho de Compras" class="cart-icon" id="cartIcon">
            <span class="cart-count" id="cartCount">0</span>
        </div>
        <div class="menu-icon" id="menuIcon">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </header>

    <div class="sidebar" id="sidebarMenu">
        <ul>
            <li><a href="loja.htm">Loja</a></li>
            <li><a href="desenvolvedores.html">Desenvolvedores</a></li>
            <li><a href="perfil.php">Perfil de Usuário</a></li>
            <li><a href="logout.php" class="logout">Sair</a></li>
        </ul>
    </div>

    <div class="overlay" id="overlay"></div>

    <div class="titulo">
        <h1>Bem-vindo à Frog Tech</h1>
        <h3>Seu e-commerce de tecnologia</h3>
        <a href="loja.htm" class="shop-btn">Ir às Compras</a>
    </div>

    <div class="cards-container">
        <div class="side-card">
            <h2>Inovação</h2>
            <p>Compromisso com a inovação contínua, qualidade e atendimento excepcional.</p>
        </div>
        <div class="card">
            <h2>Missão</h2>
            <p>Oferecer produtos e serviços que garantam o melhor custo-benefício aos nossos clientes.</p>
        </div>
        <div class="side-card">
            <h2>Visão</h2>
            <p>Ser referência em tecnologia, reconhecida pela qualidade e inovação dos nossos produtos.</p>
        </div>
    </div>

    <div class="cards-container">
        <div class="card">
            <h2>Produto 1</h2>
            <p>Preço: R$ 100,00</p>
            <button onclick="addToCart('Produto 1', 100)">Comprar</button>
        </div>
        <div class="card">
            <h2>Produto 2</h2>
            <p>Preço: R$ 200,00</p>
            <button onclick="addToCart('Produto 2', 200)">Comprar</button>
        </div>
        <div class="card">
            <h2>Produto 3</h2>
            <p>Preço: R$ 300,00</p>
            <button onclick="addToCart('Produto 3', 300)">Comprar</button>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Frog Tech. Todos os direitos reservados.</p>
    </footer>

    <script>
        const menuIcon = document.getElementById('menuIcon');
        const sidebarMenu = document.getElementById('sidebarMenu');
        const overlay = document.getElementById('overlay');
        const cartIcon = document.getElementById('cartIcon');
        const cartCount = document.getElementById('cartCount');
        let cart = [];

        // Função para abrir/fechar o menu lateral
        menuIcon.addEventListener('click', () => {
            sidebarMenu.classList.toggle('open');
            overlay.classList.toggle('show');
        });

        overlay.addEventListener('click', () => {
            sidebarMenu.classList.remove('open');
            overlay.classList.remove('show');
        });

        // Função para adicionar itens ao carrinho
        function addToCart(product, price) {
            cart.push({ product, price });
            updateCartCount();
            saveCart();
        }

        // Função para salvar o carrinho no LocalStorage
        function saveCart() {
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        // Carregar o carrinho do LocalStorage ao carregar a página
        function loadCart() {
            const savedCart = localStorage.getItem('cart');
            if (savedCart) {
                cart = JSON.parse(savedCart);
                updateCartCount();
            }
        }

        // Atualiza o número de itens no carrinho
        function updateCartCount() {
            cartCount.textContent = cart.length;
        }

        // Redirecionar para a página do carrinho
        cartIcon.addEventListener('click', () => {
            window.location.href = 'carrinho.htm';
        });

        // Carregar o carrinho ao carregar a página
        loadCart();
    </script>
</body>

</html>