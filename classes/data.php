<?php
class data{
    function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    function getData()
    {
        $query = $this->pdo->prepare('SELECT * FROM login');
        $query->execute();
        return $query->fetchAll();
    }
}