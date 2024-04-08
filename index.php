<?php
session_start();
require("./class/User.class.php");
?>

<?php
if(isset($_REQUEST['action']) && $_REQUEST['action'] == "login") {
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $result = User::Login($email,$password);
        if($result){
        echo "Konto utworzone poprawnie";
    } else {
        echo "Nie udalo sie";
    }
}
//     $db = new mysqli("localhost", "root", "", "cms");
    
//     //$q = "SELECT * FROM user WHERE email = '$email";
//     //echo $q;
//     $q = $db->prepare("SELECT * FROM user WHERE email = ? LIMIT 1");
    
//     $q->bind_param("s", $email);
    
//     $q ->execute();
    
//     $result = $q->get_result();
    
//     $userRow = $result->fetch_assoc();
    
//     if($userRow == null){
//         echo "Nie istnieje <br>";
//     } else {
//         if(password_verify($password, $userRow['passwordHash'])) {
            
//             echo "Zalogowano pomyslnie <br>";
    
//         } else {
//             echo "Błędny login lub haslo <br>";
//         }
//     }
// }
// if(isset($_REQUEST['action']) && $_REQUEST['action'] == "register"){
//     $db = new mysqli("localhost", "root", "", "cms");
//     $email = $_REQUEST['email'];
//     $email = filter_var($email, FILTER_SANITIZE_EMAIL);
//     $password = $_REQUEST['password'];
//     $passwordRepeat = $_REQUEST['password'];
//     if($password = $passwordRepeat){
//     $q = $db->prepare("INSERT INTO user VALUES (NULL, ?, ?)");
//     $passwordHash = password_hash($password, PASSWORD_ARGON2I);
//     $q->bind_param("ss", $email, $passwordHash);
//     $result = $q->execute();
//     if($result){
//         echo "Konto utworzone poprawnie";
//     } else {
//         echo "Nie udalo sie";
//     }
//     } else {
//         echo "Hasła nie sa identyczne";
//     }
// }






?>
<h1>Zaloguj sie</h1>
<form action="index.php" method="post">
    <label for="emailInput">Login:</label>
    <input type="email" name="email" id="emailInput">
    <label for="passwordInput">Hasło:</label>
    <input type="password" name="password" id="passwordInput">
    <input type="hidden"  name="action" value="login" >
    <input type="submit" value="Zaloguj">
</form>
<h2>zarejestruj sie </h2>
<form action="index.php" method="post">
    <label for="emailInput">Email</label>
    <input type="email" name="email" id="emailInput">
    <label for="passwordInput">Haslo:</label>
    <input type="password" name="password" id="passwordInput">
    <label for="passwordRepeatInput">Haslo ponownie:</label>
    <input type="password" name="password" id="passwordRepeatInput">
    <input type="hidden"  name="action" value="register" >
    <input type="submit" value="Zarejestruj">
    
</form>