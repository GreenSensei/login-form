<?php
require "classes/Conn.php";

session_start();

$_SESSION['appMan'] = 0;
unset($_SESSION['error']);
$_SESSION['errorLength'] = 0;

$conn = new Conn();

$create = $conn->connect();
$sth = $create->prepare("SELECT * FROM `login` WHERE email=?");
$sth -> execute([$_POST['email']]);
$row = $sth->fetch();

$_SESSION['loggedID'] = $row['ID'];

$_SESSION['error'] = "";
$_SESSION['signInPass'] = $_POST['password'];
$_SESSION['signInEmail'] = $_POST['email'];

if ($_POST['email'] == ""){
    $_SESSION['error'] .= "Geen email ingevoerd.<br>";
    unset($_SESSION['signInEmail']);
}
elseif ($row['email'] == "") {
    $_SESSION['error'] .= "Er bestaat geen account dat deze email gebruikt.<br>";
    unset($_SESSION['signInEmail']);
}
if ($_POST['password'] == "") {
    $_SESSION['error'] .= "Geen wachtwoord ingevoerd.<br>";
    unset($_SESSION['signInPass']);
}
elseif (!password_verify($_POST['password'],$row['password']) && $row != "") {
    $_SESSION['error'] .= "Uw wachtwoord is onjuist.<br>";
    unset($_SESSION['signInPass']);
}

if ($_SESSION['error'] != "") {
    $_SESSION['errorLength'] = substr_count($_SESSION['error'], "<br>");
    $_SESSION['extendHeight'] = 450 + ($_SESSION['errorLength'] * 24);
    echo $_SESSION['error'];
    header("Location: login.php");
    exit();
}else{
    echo "goed bezig!";
}