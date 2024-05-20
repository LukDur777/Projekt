<?php
class Post {
    private $id;
    private $author;
    private $title;
    private $timestamp;
    private $imgUrl;

    public function __construct(int $id, string $author, string $title, string $timestamp, string $imgUrl) {
        $this->id = $id;
        $this->author = $author;
        $this->title = $title;
        $this->timestamp = $timestamp;
        $this->imgUrl = $imgUrl;
    }

    public function GetTitle() : string {
        return $this->title;
    }
    public function GetAuthor() : string {
        return $this->author;
    }
    public function GetAuthorEmail() : string {
        return $this->author;
    }
    public function GetImageURL() : string {
        return $this->imgUrl;
    }
    public function GetTimestamp() : string {
        return $this->timestamp;
    }

    static function GetPosts() : array {
        // Connect to the database
        $db = new mysqli('localhost', 'root', '', 'cms');
    
        // Prepare the SQL query
        $sql = "SELECT post.ID, post.title, post.timestamp, post.imgUrl, user.email AS author 
                FROM `post` 
                INNER JOIN user ON user.id = post.authorID 
                ORDER BY timestamp DESC 
                LIMIT 10";
        $query = $db->prepare($sql);
    
        // Execute the query
        $query->execute();
    
        // Fetch the results
        $result = $query->get_result();
    
        // Create an array to store the Post objects
        $posts = [];
    
        // Loop through the results and create a Post object for each row
        while ($row = $result->fetch_assoc()) {
            $post = new Post($row['ID'], $row['author'], $row['title'], $row['timestamp'], $row['imgUrl']);
            $posts[] = $post;
        }
    
        // Close the database connection
        $db->close();
    
        // Return the array of Post objects
        return $posts;
    }
    static function CreatePost(string $title, string $description) : bool {
        
        //wgrywanie pliku
        //zdefiniuj folder docelowy
        $targetDirectory = "img/";
        //użyj oryginalnej nazwy pliku
        //$fileName = $_FILES['file']['name'];
        //modyfikacja - użyj sha256
        $fileName = hash('sha256', $_FILES['file']['name'].microtime());
        
        //przesuń plik z lokalizacji tymczasowej do docelowej
        //move_uploaded_file($_FILES['file']['tmp_name'], $targetDirectory.$fileName);
        //zmiana - użyj imagewebp do zapisania

        //po 0!: wczytaj zawartość pliku graficznego do stringa
        $fileString = file_get_contents($_FILES['file']['tmp_name']);

        //po 1!: wczytaj otrzymany z formularza obrazek używając biblioteki GD do obiektu klasy GDImage
        $gdImage = imagecreatefromstring($fileString);

        //przygotuj pełny url pliku
        $finalUrl = "http://localhost/cms/img/".$fileName.".webp";
        //imagewebp nie umie z http - link wewnętrzny
        $internalUrl = "img/".$fileName.".webp";

        //po 2!: zapisz obraz skonwertowany do webp pod nową nazwą pliku + rozszerzenie webp
        imagewebp($gdImage, $internalUrl);

        //dopisz posta do bazy
        //tymczasowo - authorID
        $authorID = $_SESSION['user']->getID();


        $db = new mysqli('localhost', 'root', '', 'cms');
        $q = $db->prepare("INSERT INTO post (author, imgUrl, title) VALUES (?, ?, ?)");
        //pierwszy atrybut jest liczba, dwa pozostale tekstem wiec integer string string
        $q->bind_param("iss", $authorID, $finalUrl, $title);
        if($q->execute())
            return true;
        else
            return false;
    }
}
?>