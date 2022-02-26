<?php
require 'classes/Conn.php';
session_start();

//if (isset($_POST['email']) && $_POST['password']){
//    $conn = new Conn();
//
//    $email = $_POST['email'];
//
//    $create = $conn->connect();

//    $sth = $create->prepare("SELECT `email` from `login` WHERE email = ?");
//    $sth->execute([$email]);
//
//    if ($row = $sth->fetch()) {
//        echo "email already exist";
//        exit;
//    }
//    else{
//        $sth2 = $create->prepare("INSERT INTO `login` (`voornaam`,`achternaam`,`email`,`password`) VALUES (?,?,?,?)");
//        $sth2 -> execute([$_POST['voornaam'],$_POST['achternaam'],$_POST['email'],password_hash($_POST['password'],PASSWORD_DEFAULT)]);
//    }
//}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>password</title>
</head>
<body>
<div class="login-box create"<?php if (isset($_SESSION['error'])&&$_SESSION['error']!=""){echo "extend";}?> <?php if (isset($_SESSION['good'])&&$_SESSION['good']!=""){echo "extend";}?> id="createAccount">
    <img src="images/runa.jpg" class="avatar">
    <h1>Create Account</h1>
    <form action="createAccountBackend.php" autocomplete="off" method="post">
        <p>Name</p>
        <input type="text" name="voornaam" placeholder="Enter Name">
        <p>Lastname</p>
        <input type="text" name="achternaam" placeholder="Enter Lastname">
        <p>Email</p>
        <input type="email" name="email" placeholder="Enter Email">
        <p>Password</p>
        <input type="password" name="password" placeholder="Enter Password">
        <input type="submit" name="" value="create">
        <a href="login.php">Already got an account?</a>
    </form>
    <h4 class="good" id="createAccount"><?php if(isset($_SESSION['good'])){echo $_SESSION['good']; unset($_SESSION['good']);}?></h4>
    <h4 class="error" id="createAccount"><?php if(isset($_SESSION['error'])){echo $_SESSION['error']; unset($_SESSION['error']);}?></h4>
</div>
</body>
</html>