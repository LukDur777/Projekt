<?php
if(isset($_REQUEST['email']) && isset($_REQUEST['password']) ) {
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    $db = new mysqli("localhost", "root", "", "cms");
    
    //$q = "SELECT * FROM user WHERE email = '$email";
    //echo $q;
    $q = $db->prepare("SELECT * FROM user WHERE email = ? LIMIT 1");
    
    $q->bind_param("s", $email);
    
    $q ->execute();
    
    $result = $q->get_result();
    
    $userRow = $result->fetch_assoc();
    
    if($userRow == null){
        echo "Nie istnieje <br>";
    } else {
        if(password_verify($password, $userRow['password'])) {
            
            echo "Zalogowano pomyslnie <br>";
    
        } else {
            echo "Błędny login lub haslo <br>";
        }
    }
}







?>

<form action="index.php" method="get">
    <label for="emailInput">Login:</label>
    <input type="email" name="email" id="emailInput">
    <label for="passwordInput">Hasło:</label>
    <input type="password" name="password" id="passwordInput">
    <input type="submit" value="zaloguj">
</form>
