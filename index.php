<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chessboard</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="container">
        <div class="buttons">
            <button onclick="movePiece()">Lépés</button>
            <button onclick="startingPosition()">Alaphelyzet</button>
        </div>
        <div class="chessboard">

            <?php
            for ($row = 1; $row <= 8; $row++) {

                for ($col = 1; $col <= 8; $col++) {

                    $colorClass = (($row + $col) - 1) % 2 == 0 ? "black" : "white";

                    $squareId = "square-$row$col";

                    echo "<div class='square $colorClass' id='$squareId'>";

                    // If there's a piece, render its SVG
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>

    <script src="index.js"></script>
</body>

</html>