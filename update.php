<?php
require "config.php";
if (!empty($_GET)){
    if(isset($_GET["id"])){
        $connection=new PDO('mysql:host=' . SERVER . ';dbname=' . DATABASE .';charset=utf8',USER,PASSWORD);
        //Todo : securiser
        $id=intval($_GET['id']);
        $query="SELECT * FROM shoes WHERE id=" . $id;
        $st = $connection->query($query);
        $shoe = $st->fetch(pdo::FETCH_ASSOC);
    }
}
if(!empty($_POST)){
    //Définition des erreurs
    $errors=[];
    $connection=new PDO('mysql:host=' . SERVER . ';dbname=' . DATABASE .';charset=utf8',USER,PASSWORD);
    //Vérifier mon tableau post
    if(isset($_POST['name']) && trim($_POST['name'])!==''){
        $name=htmlspecialchars($_POST['name']);
    } else {
        $errors[]='Veuillez saisir un nom';
    }
    if(isset($_POST['price']) && trim($_POST['price'])!==''){
        $price=filter_var($_POST['price'],FILTER_VALIDATE_INT);
        if(!$price) {
            $errors[]='Veuillez saisir un prix correct';
        }
    } else {
        $errors[]='Veuillez saisir un prix';
    }
    if(isset($_POST['size']) && trim($_POST['size'])!==''){
        $size=filter_var($_POST['size'],FILTER_VALIDATE_INT);
        if(!$size) {
            $errors[]='Veuillez saisir une pointure correcte';
        }
    } else {
        $errors[]='Veuillez saisir une pointure';
    }


    if(isset($_POST['picture']) && trim($_POST['picture'])!==''){
        $picture=htmlspecialchars($_POST['picture']);
    } else {
        $errors[]='Veuillez saisir un nom de fichier';
    }
    if(empty($errors)){
        $sql='UPDATE shoes SET name=:name, price=:price, picture=:picture, shoeSize=:shoeSize) WHERE id=:id';
        $st=$connection->prepare($sql);
        $st->bindValue(':name',$name);
        $st->bindValue(':price',$price);
        $st->bindValue(':picture',$picture);
        $st->bindValue(':shoeSize',$size);
        $st->bindValue(':id',$_POST['id']);
        var_dump($_POST);
      //  $st->execute();
       // header("Location: /");
        /*
        $cars=[
            0=>[
                'name'=>'Voiture2',
                'picture'=>'photo.jpg',
                'price'=>12,
            ],
            1=>[
                'name'=>'Voiture1',
                'picture'=>'photo.png',
                'price'=>58,
            ],
        ]
        $sql='INSERT INTO shoes (name, price, picture, shoeSize) VALUES (:name, :price, :picture, :shoeSize)';
        $st=$connection->prepare($sql);
        foreach($cars as $car) {
            $st->bindValue(':name',$car['name']);
            $st->bindValue(':price',$car['price']);
            $st->bindValue(':picture',$car['picture']);
            $st->execute();
        }
        */
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/style.css">
    <title>Back Office</title>
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
        <h1>Back Office</h1>
        <div>
            <h2>Ajouter une paire de chaussures</h2>
            <form action="update.php" method="post" enctype="multipart/form-data">
                <label for="name-shoes">Nom : 
                    <input type="text" name="name" id="name-shoes" value="<?=$shoe['name'] ?>" required>
                </label>
                <label for="price">Prix : 
                    <input type="number" name="price" id="price" value="<?=$shoe['price'] ?>"  required>
                </label>
                <label for="size">Pointure : 
                    <input type="number" name="size" id="size" value="<?=$shoe['shoeSize'] ?>"  required>
                </label>
                <label for="picture">Photo : 
                    <input type="text" name="picture" id="picture" value="<?=$shoe['picture'] ?>"  required>
                </label>
                <input type="submit" value="Modifier">
                <input type="hidden" name="id" value="<?=$shoe['id'] ?>">
            </form>
        </div>
    </main>
    <footer>
        &copy; 2023 Wild Shoes
    </footer>
</body>
</html>