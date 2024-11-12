const squares = document.querySelectorAll('.square');

squares.forEach(square => {
    square.addEventListener('click', () => setMoveCordinates(square));
});

let movePieceFrom = "";
let movePieceTo = "";

function setMoveCordinates(square) {
    if (movePieceFrom == "") {
        movePieceFrom = square.id;
    } else {
        if (movePieceTo == "") {
            movePieceTo = square.id;
        }
    }
}


async function startingPosition() {
    await fetch("reset.php", {
        method: "POST",
    }).then(response => response.json())
        .then(json => {
            renderPosition(JSON.stringify(json));
            movePieceFrom = "";
            movePieceTo = "";
        })
        .catch(error => console.error('Error:', error));
}


const params = new URLSearchParams();

async function movePiece() {
    if (!(movePieceFrom == "" || movePieceTo == "")) {


        params.append("movePieceFrom", movePieceFrom);
        params.append("movePieceTo", movePieceTo);

        // Fetch the move result from chess.php
        await fetch("chess.php", {
            method: "POST",
            body: params,
        }).then(response => response.json())
            .then(json => {
                renderPosition(JSON.stringify(json));
                movePieceFrom = "";
                movePieceTo = "";
            })
            .catch(error => console.error('Error:', error));

    } else {
        document.getElementById("debug").innerHTML = "INVALID";
    }
}

function renderPosition(json) {

    const position = JSON.parse(json, (key, value) => {
        // For each row, convert its object into an array of 8 elements, using null for missing values
        if (typeof value === 'object' && value !== null) {
            const rowArray = Array(8).fill(null);
            Object.keys(value).forEach(col => {
                rowArray[Number(col) - 1] = value[col];
            });
            return rowArray;
        }
        return value;
    });

    // Loop through each row (1 to 8)
    for (let row = 1; row <= 8; row++) {
        // Loop through each column (1 to 8)
        for (let col = 1; col <= 8; col++) {
            const squareId = "square-" + row + col;
            const square = document.getElementById(squareId);
            square.innerHTML = '';
            // Get the piece for the current square from the JSON
            const piece = position[row - 1] ? position[row - 1][col - 1] : null;
            // If there is a piece, add its image to the square
            if (piece) {
                const img = document.createElement('img');
                img.src = `pieces/${piece}.svg`;  // Adjust path if needed
                img.alt = piece;
                img.classList.add('piece');
                square.appendChild(img);  // Add the image to the square
            }
        }
    }
}