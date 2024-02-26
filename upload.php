<?php
if(!empty($_POST)) {
    //cos przyslo postem
    $postTitle = $_POST['postTitle'];
    $postDescription = $_POST['postDescription'];
    //wgrywanie pliku
    //zdefiniuj folder docelowy
    $targetDirectory = "img/";
    //uzyj oryginalnej nazwy pliku
    $fileName = $_FILES['file']['name'];
    //przesun plik z lokalizacji tymczasowej do docelowej
    move_uploaded_file($_FILES['file']['tmp_name'], $targetDirectory.$fileName);

    //dopisz posta do bazy
    //tymczasowo = authorID
    $authorID = 1;
    $imageUrl = "localhost/lorem/img/" . $fileName;

    $db = new mysqli('localgost','root','','lorem' );
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