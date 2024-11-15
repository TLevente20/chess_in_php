<?php
require_once "Position.php";

$movePieceFrom = $_REQUEST["movePieceFrom"];
$movePieceTo = $_REQUEST["movePieceTo"];

if ($movePieceFrom != $movePieceTo) {
    $numbers = substr($movePieceFrom, -2);
    $movePieceFromDigits = str_split($numbers);

    $numbers = substr($movePieceTo, -2);
    $movePieceToDigits = str_split($numbers);

    $currentPosition = Position::readPosition();
    $currentPositionArray = json_decode($currentPosition, true);
    
    if ($currentPositionArray[$movePieceFromDigits[0]][$movePieceFromDigits[1]] != null) {
        
        $currentPositionArray[$movePieceToDigits[0]][$movePieceToDigits[1]] =
            $currentPositionArray[$movePieceFromDigits[0]][$movePieceFromDigits[1]];

        $currentPositionArray[$movePieceFromDigits[0]][$movePieceFromDigits[1]] = null;

        $newPosition = json_encode($currentPositionArray);
        Position::savePostition($newPosition);

        echo Position::readPosition();
    } else {
        echo Position::readPosition();
    }
} else {
    echo Position::readPosition();
}
