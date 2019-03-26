<?php
/**
 * Created by PhpStorm.
 * User: Mexahoid
 * Date: 23.03.2019
 * Time: 14:28
 */

include 'Storage.php';

class Connector implements Storage
{
    var $pdo;

    function __construct($connstr, $user, $pass)
    {
        $this->pdo = new PDO($connstr, $user, $pass);
    }

    function saveData($query, $data)
    {
        $this->pdo->prepare($query)->execute($data);
    }

    function getData($query, $data)
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($data);
        return $stmt->fetchAll();
    }
}