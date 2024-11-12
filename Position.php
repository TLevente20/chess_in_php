<?php
require_once "Config.php";
class Position
{

    static private $position;

    public function __construct($position)
    {
        $this->position = $position;
    }
    public function getPosition()
    {
        return $this->position;
    }
    public function setPosition($position): void
    {
        $this->position = $position;
    }

    static function savePostition($position){
        $config = new Config;
        $connection = $config->getConnection();

        $sqlQuery = "INSERT INTO `actual_position`(`position`) VALUES ('$position')";
        mysqli_query($connection, $sqlQuery);
    }


    static function readPosition()
    {
        $config = new Config;
        $connection = $config->getConnection();

        $sqlQuery = "SELECT * FROM actual_position";

        $queryResult = mysqli_query($connection, $sqlQuery);

        $resultData = mysqli_fetch_all($queryResult, MYSQLI_ASSOC);

        return $resultData[0]["position"];
    }

    
    static function removePosition()
    {
        $config = new Config;
        $connection = $config->getConnection();

        $sqlQuery = "TRUNCATE `chess`.`actual_position`";

        mysqli_query($connection, $sqlQuery);
    }

}
