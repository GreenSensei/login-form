<?php
require "classes/Conn.php";

session_start();
$_SESSION['error'] = "";
$_SESSION['good'] = "";

$_SESSION['errorLength'] = 0;

$_SESSION['creAccFirst'] = $_POST['voornaam'];
$_SESSION['creAccLast'] = $_POST['achternaam'];
$_SESSION['creAccEmail'] = $_POST['email'];
$_SESSION['creAccPass'] = $_POST['password'];

if ($_POST['voornaam'] == ""){
    $_SESSION['error'] .= "Geen Voornaam ingevoerd.<br>";
    unset($_SESSION['creAccFirst']);
} else if (!preg_match('/^[a-zA-Z]+$/', $_POST['voornaam'])){
    $_SESSION['error'] .= "Voornaam is niet geldig.<br>";
    unset($_SESSION['creAccFirst']);
}
if ($_POST['achternaam'] == ""){
    $_SESSION['error'] .= "Geen Achternaam ingevoerd.<br>";
    unset($_SESSION['creAccLast']);
} else if (!preg_match('/^[a-zA-Z]+$/', $_POST['achternaam'])){
    $_SESSION['error'] .= "Achternaam is niet geldig.<br>";
    unset($_SESSION['creAccLast']);
}
if ($_POST['email'] == ""){
    $_SESSION['error'] .= "Geen email ingevoerd.<br>";
    unset($_SESSION['creAccEmail']);
} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] .= "Email is niet geldig.<br>";
    unset($_SESSION['creAccEmail']);
} else {
    $conn = new Conn();

    $create = $conn->connect();
    $sth = $create->prepare("SELECT * FROM `login` WHERE email=?");
    $sth -> execute([$_POST['email']]);
    $row = $sth->fetch();

    if ($row != "") {
        $_SESSION['error'] .= "Er bestaat al een ander account dat dit email gebruikt.<br>";
        unset($_SESSION['creAccEmail']);
    }
}
if ($_POST['password'] == ""){
    $_SESSION['error'] .= "Geen wachtwoord ingevoerd.<br>";
    header("Location: createAccount.php");
} else {
    if (!preg_match('@[A-Z]@', $_POST['password'])) {
        $_SESSION['error'] .= "Wachtwoord moet minstens 1 hoofdletter bevatten.<br>";
        unset($_SESSION['creAccPass']);
    }
    if (!preg_match('@[a-z]@', $_POST['password'])) {
        $_SESSION['error'] .= "Wachtwoord moet minstens 1 kleine letter bevatten.<br>";
        unset($_SESSION['creAccPass']);
    }
    if (!preg_match('@[0-9]@', $_POST['password'])) {
        $_SESSION['error'] .= "Wachtwoord moet minstens 1 cijfer bevatten.<br>";
        unset($_SESSION['creAccPass']);
    }
    if (!preg_match('@[^\w]@', $_POST['password'])) {
        $_SESSION['error'] .= "Wachtwoord moet minstens 1 speciaal karakter bevatten.<br>";
        unset($_SESSION['creAccPass']);
    }
    if (strlen($_POST['password']) < 8) {
        $_SESSION['error'] .= "Wachtwoord moet minstens 8 karakters bevatten.<br>";
        unset($_SESSION['creAccPass']);
    }
//    if ($_POST['password']!=$_POST['repass']){
//        $_SESSION['error'] .= "Wachtwoorden komen niet overeen.<br>";
//    }
//   unset($_SESSION['creAccPass']);
//    unset($_SESSION['creAccRepass']);
//}
//    if (!isset($_POST['teacher'])) {
//        $_SESSION['error'] .= "Je hebt niet aangegeven of je een leraar of een leerling bent.<br>";
//    }

    $_SESSION['errorLength'] = substr_count($_SESSION['error'], "<br>");

    if ($_SESSION['error'] != "") {
//        $_SESSION['extendHeight'] = 710 + ($_SESSION['errorLength'] * 23);
        header("Location: createAccount.php");
        exit();
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sth = $create->prepare("INSERT INTO `login` (`voornaam`,`achternaam`,`email`,`password`) VALUES (?,?,?,?)");
        $sth->execute([$_POST['voornaam'], $_POST['achternaam'], $_POST['email'], $password]);

        $sth = $create->prepare("SELECT * FROM `login` WHERE email=?");
        $sth->execute([$_POST['email']]);
        $row = $sth->fetch();
        $_SESSION['good'] .= "Uw account is aangemaakt!<br>";
        header("Location: createAccount.php");
        exit;

//        if (!isset($row['perms'])) {
//            $_SESSION['error'] .= "Er ging aan onze kant iets mis bij het maken van je account, sorry! Probeer het later opnieuw.<br>";
//            $_SESSION['extendHeight'] = 750;
//            header("Location: createAccount.php");
//            exit();
//        }

//        $_SESSION['loggedID'] = $row['ID'];

//        if ($_POST['teacher'] == 0) {
//            header("Location: ../Student/studentSite.php?selected=1");
//            exit();
//        } else {
//            header("Location: ../teacher/teacherSite.php?selected=1");
//            exit();
//        }
    }
}