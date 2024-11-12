<?php
require_once "Position.php";

Position::removePosition();

$newPosition = file_get_contents("startingPosition.json");

Position::savePostition($newPosition);

echo $newPosition;





