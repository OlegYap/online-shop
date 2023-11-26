<?php
session_start();
if (isset($_SESSION['user_id'])){
    //print_r($_SESSION['login']);
    // создаем соединение
    $pdo = new PDO("pgsql:host=db;dbname=postgres","dbuser","dbpwd");
    // выполняем запрос за продуктами
    $stmt = $pdo->prepare('SELECT * FROM products');
    $stmt->execute();
    // сохраняем в переменную данные о продуктах
    $products = $stmt->fetchAll();
    //print_r($products);
} else {
    header('Location: /login.php');
}
?>

<body>
<div class="container">
    <h3>Catalog</h3>
    <div class="card-deck">
        <?php foreach ($products as $product): ?>
            <div class="card text-center">
                <div class="card-header">
                    Фрукты
                    <a href="#">
                        <img src="https://media.istockphoto.com/id/1178919117/ru/%D1%84%D0%BE%D1%82%D0%BE/%D0%BA%D0%BE%D0%BC%D0%BF%D0%BE%D0%B7%D0%B8%D1%82%D0%BD%D0%BE%D0%B5-%D0%B8%D0%B7%D0%BE%D0%B1%D1%80%D0%B0%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5-%D1%81-%D1%86%D0%B5%D0%BB%D1%8C%D0%BD%D1%8B%D0%BC%D0%B8-%D0%B8-%D1%80%D0%B0%D0%B7%D1%80%D0%B5%D0%B7%D0%B0%D0%BD%D0%BD%D1%8B%D0%BC%D0%B8-%D1%84%D1%80%D1%83%D0%BA%D1%82%D0%B0%D0%BC%D0%B8-%D0%B1%D0%B0%D0%BD%D0%B0%D0%BD-%D1%8F%D0%B1%D0%BB%D0%BE%D0%BA%D0%BE-%D0%B8-%D0%BA%D0%BB%D1%83%D0%B1%D0%BD%D0%B8%D0%BA%D0%B0-%D0%B8%D0%B7%D0%BE%D0%BB%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D1%8B.jpg?s=612x612&w=0&k=20&c=JayQ9Sa9xzoDTHbla2YCNaVHGPrX01hgMvZbSjeVqLA=">

                        <div class="card-body">
                            <p class="card-text"><?php echo $product['name']; ?> </p>
                            <div class="text"><?php echo $product['description'];?>
                            <a><h5 class="card-title"></h5></a>
                            <div class="card-footer">
                                <?php echo $product['price'] . " rub"; ?>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
</body>

<style>
    body {
        color: blue;
    }

    a {
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    h3 {
        line-height: 3em;
    }

    .card {
        max-width: 16rem;
    }

    .card:hover {
        box-shadow: 1px 2px 10px lightgray;
        transition: 0.2s;
    }

    .card-header {
        font-size: 13px;
        color: red;
        background-color: white;
    }

    .text-muted {
        font-size: 11px;
    }

    .card-footer{
        font-weight: bold;
        font-size: 18px;
        background-color: white;
    }
</style>