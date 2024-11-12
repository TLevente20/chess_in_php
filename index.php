<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chessboard</title>
    <link rel="stylesheet" href="index.css">
</head>

<body>
    <div class="chessboard">
    <?php
    $startingPosition = [
        1 => ["rook-b", "knight-b", "bishop-b", "queen-b", "king-b", "bishop-b", "knight-b", "rook-b"],
        2 => array_fill(0, 8, "pawn-b"),
        5 => ["pawn-w"],
        7 => array_fill(1, 8, "pawn-w"),
        8 => ["rook-w", "knight-w", "bishop-w", "queen-w", "king-w", "bishop-w", "knight-w", "rook-w"],
    ];

    for ($row = 1; $row <= 8; $row++) {

        for ($col = 1; $col <= 8; $col++) {

            $colorClass = (($row + $col)-1) % 2 == 0 ? "black" : "white";

            $squareId = "square-$row$col";

            $piece = $startingPosition[$row][$col - 1] ?? null;
            echo "<div class='square $colorClass' id='$squareId'>";

            // If there's a piece, render its SVG
            if ($piece) {
                echo "<img src='pieces/{$piece}.svg' alt='$piece' class='piece'>";
            }
            echo "</div>";
        }
    }
    ?>
    </div>
    <button onclick= movePiece()>Move</button>

    <p id="debug"></p>
    <script src="index.js"></script>
</body>

</html>