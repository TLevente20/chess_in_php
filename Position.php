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

    static function savePostition($position)
    {
        $config = new Config;
        $connection = $config->getConnection();

        $sqlQuery = "DELETE p
    FROM `actual_position` p
    JOIN (
        SELECT MAX(`created_at`) AS latest_active
        FROM `actual_position`
        WHERE `active` = true
    ) AS latest_active_record
    ON p.`created_at` > latest_active_record.latest_active;
";
        mysqli_query($connection, $sqlQuery);

        $sqlQuery = "UPDATE `actual_position` SET `active` = false";

        mysqli_query($connection, $sqlQuery);


        $sqlQuery = "INSERT INTO `actual_position` (`position`, `created_at`, `active`) VALUES ('$position', CURRENT_TIMESTAMP, 1)";
        mysqli_query($connection, $sqlQuery);
    }


    static function readPosition()
    {
        $config = new Config;
        $connection = $config->getConnection();

        $sqlQuery = "SELECT * FROM `actual_position` WHERE `active` = true";

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

    static function undoPosition()
    {
        $config = new Config;
        $connection = $config->getConnection();

        $sqlQuery = "UPDATE `actual_position` p
    JOIN (
        SELECT MIN(`created_at`) AS earliest_created_at
        FROM `actual_position`
        WHERE `created_at` > (
            SELECT MAX(`created_at`)
            FROM `actual_position`
            WHERE `active` = true
        )
    ) AS subquery
    ON p.`created_at` = subquery.earliest_created_at
    SET p.`active` = true;
";
        mysqli_query($connection, $sqlQuery);

        $sqlQuery = "UPDATE `actual_position` p
    JOIN (
        SELECT MAX(`created_at`) AS latest_created_at
        FROM `actual_position`
        WHERE `active` = true
    ) AS subquery
    ON p.`created_at` = subquery.latest_created_at
    SET p.`active` = false;
";

        mysqli_query($connection, $sqlQuery);
    }

    static function redoPosition()
    {
        $config = new Config;
        $connection = $config->getConnection();

        $sqlQuery = "UPDATE actual_position
        SET active = 1
        WHERE created_at < (SELECT created_at FROM actual_position WHERE active = 1 LIMIT 1)
        ORDER BY created_at DESC
        LIMIT 1
";
        mysqli_query($connection, $sqlQuery);

        $sqlQuery = "UPDATE `actual_position` p
    JOIN (
        SELECT MIN(`created_at`) AS earliest_active_created_at
        FROM `actual_position`
        WHERE `active` = true
    ) AS subquery
    ON p.`created_at` = subquery.earliest_active_created_at
    SET p.`active` = false;
";

        mysqli_query($connection, $sqlQuery);
    }
}
