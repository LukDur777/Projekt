<?php
if(!empty($_POST)) {
    //cos przyslo postem
    $postTitle = $_POST['postTitle'];
    $postDescription = $_POST['postDescription'];
    //wgrywanie pliku
    //zdefiniuj folder docelowy
    $targetDirectory = "img/";
    //uzyj oryginalnej nazwy pliku
    //$fileName = $_FILES['file']['name'];
    
    $fileName = hash('sha356', $_FILES['file']['name'].microtime());

    //uzyj oryginalnej nazwy pliku
    //przesun plik z lokalizacji tymczasowej do docelowej
    //move_uploaded_file($_FILES['file']['tmp_name'], $targetDirectory.$fileName);

    //[1] wczytaj zawartosc pliku graficznego do stringa
    $fileString = file_get_contents($_FILES['file']['tmp_name']);

    //[2] wczytaj otrzymany z formularza obrazek uzywajac biblioteki GD do obiektu klasa GDimage
    $gdImage = imagecreatefromgd($_FILES['files']['tmp_name']);

//przygotuj pelny url pliku
    $finalUrl = "http://localhost/loremm/img" .$fileName.".webp";

    //[3] zapisz obraz skonwertowany do webp pod nazwa pliku + rozszerzenie webp
    imagewebp($gdImage, )

    //dopisz posta do bazy
    //tymczasowo = authorID
    $authorID. = 1;

    $imageUrl = "localhost/lorem/img/" . $fileName;

    $db = new mysqli('localhost','root','','lorem' );
    $q = $db->prepare("INSERT INTO post (author, imgUrl, title)VALUES (?, ?, ?)");

    //pierwszy atrybut jest liczba, dwa pozostale tekstem wiec integer string string
    $q->bind_param("iss", $authorID, $imageUrl, $postTitle);
    $q->execute();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj nowy post</title>
</head>
<body>
    <form action="upload.php" method="post" enctype="multipart/form-data">
        <label for="postTitleInput">Tytuł posta:</label>
        <input type="text" name="postTitle" id="postTitleInput">
        <br>
        <label for="postDescripition">Opis posta:</label>
        <input type="text" name="postDescription" id="postDescriptionInput">
        <br>
        <label for="fileInput">Obrazek:</label>
        <input type="file" name="file" id="fileInput">
        <br>
        <input type="submit" value="Wyślij!" >
    </form>
</body>
</html>