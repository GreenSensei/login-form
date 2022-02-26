<?php
require 'classes/Conn.php';
session_start();

if (isset($_POST['login'])) {
    $conn = new Conn();

    $email = $_POST['email'];
    $password = $_POST['password'];

    $create = $conn->connect();
    $sth = $create->prepare("SELECT email,password FROM `login` WHERE `email` = ?");
    $sth->execute([$email]);

    while ($row = $sth->fetch()) {
        if (password_verify($password, $row['password'])){
            echo "goedzo";
            exit;
        }
        else{
            ?>
            <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>            <?php
            exit;
        }
    }
}

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
<div class="login-box login <?= isset($_SESSION['error']) && $_SESSION['error']!="" ? "extend" : ""?>" id="signIn">
    <img src="images/runa.jpg" class="avatar">
    <h1>Login Here</h1>
    <form autocomplete="off" method="post" action="loginBackend.php">
        <p>Email</p>
        <input type="email" name="email" placeholder="Enter Email">
        <p>Password</p>
        <input type="password" name="password" placeholder="Enter Password">
        <input type="submit" name="login" value="login" onclick="return promptLogin()">
        <a href="createAccount.php">Don't have an account?</a>
    </form>
    <h4 class="error" id="signIn"><?php if(isset($_SESSION['error'])){echo $_SESSION['error']; unset($_SESSION['error']);}?></h4>
</div>
</body>
</html>