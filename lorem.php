<?php
require_once("class/User.class.php");
session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
        crossorigin="anonymous">
    <link rel="stylesheet" href="lorem.css">
</head>
<body>
    <header>
        <h1>CMS</h1>
    </header>
    <div id="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between px-3">
            <a class="navbar-brand">Nawigacja</a>
            <?php if(User::isLogged()) : ?>
                <!-- zalogowany -->
                <a href="profile.php">
                    <button class="btn btn-primary">
                        <i class="fa-solid fa-user"></i> Profil
                    </button>
                </a>
            <?php else: ?>
                <!-- nie zalogowany -->
                <a href="login.php">
                    <button class="btn btn-primary">
                        <i class="fa-solid fa-user"></i> Zaloguj się
                    </button>
                </a>
            <?php endif; ?>  
        </nav>
        <?php
        //nowe połaczenie do bazy danych
        $db = new mysqli('localhost', 'root', '', 'cms');
        //przygotuj kwerendę
        $q = $db->prepare("SELECT post.id, post.imgUrl, post.title, 
                                    post.timestamp, user.email 
                            FROM `post` 
                            INNER JOIN user ON post.author = user.ID
                            ORDER BY post.timestamp DESC;");
        //wywołaj kwerendę
        $q->execute();
        //pobierz dane
        $result = $q->get_result();
        while($row = $result->fetch_assoc()) {
            //$row to jeden wiersz z bazy danych
            echo '<div class="post-block">';
            echo '<h2 class="post-title">'.$row['title'].'</h3>';
            echo '<h3 class="post-author">'.$row['email'].'</h6>';
            echo '<img src="'.$row['imgUrl'].'" alt="obrazek posta" class="post-image">';
            echo '<p class="post-description">TODO: Opis posta</p>';
            echo '<div class="post-footer">
                <span class="post-meta">'.$row['timestamp'].'</span>
                <span class="post-score">TODO: punkty</span>
                </div>';
            echo '</div>'; //post-block
        }
        ?>

    </div>
/<body>
</html>