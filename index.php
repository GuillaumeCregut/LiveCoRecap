<?php
require 'config.php';
$connection = new PDO('mysql:host=' . SERVER . ';dbname=' . DATABASE . ';charset=utf8', USER, PASSWORD);
$sql = 'SELECT * FROM shoes';
$st = $connection->query($sql);
$shoes = $st->fetchAll(pdo::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/style.css">
    <title>Ma super boutique de chaussures</title>
</head>

<body>
    <header>
        <div class="header-container">
            <a href="/">
                <img src="./assets/pictures/logo.png" alt="logo de la boutique Wild Shoes" class="logo">
            </a>
            <h1 class="title">Bienvenue chez Wild Shoes</h1>
        </div>
        <nav>
            <ul class="nav-menu">
                <li><a href="">Contact</a></li>
                <li><a href="backOffice.php">Back Office</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h2>Nos chaussures</h2>
            <ul class="shoes-container">
                <?php foreach ($shoes as $shoe) : ?>
                    <li class="shoe-card">

                        <p><img src="./assets/pictures/<?= $shoe['picture'] ?>" alt="<?= $shoe['name'] ?>" class="shoe-picture"></p>
                        <p><a href="update.php?id=<?=$shoe['id'] ?>"><?= $shoe['name'] ?></a></p>
                        <p>Prix : <?= $shoe['price'] ?> euros</p>
                        <p>Pointure : <?= $shoe['shoeSize'] ?></p>
                    </li>
                <?php endforeach ?>
            </ul>
        </section>
    </main>
    <footer>
        &copy; 2023 Wild Shoes
    </footer>
</body>

</html>