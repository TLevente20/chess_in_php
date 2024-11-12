const squares = document.querySelectorAll('.square');

squares.forEach(square => {
    square.addEventListener('click', () => setMoveCordinates(square));
});
let movePieceFrom = "";
let movePieceTo = "";

function setMoveCordinates(square) {

    if(movePieceFrom == ""){
        movePieceFrom = square.id;
    }else{
        if(movePieceTo == ""){
            movePieceTo = square.id;
        }
    }
}

function movePiece(){
    if(!(movePieceFrom == "" || movePieceTo == "")){
        document.getElementById("debug").innerHTML = movePieceFrom + movePieceTo;
        movePieceFrom = "";
        movePieceTo = "";
    }else{
        document.getElementById("debug").innerHTML = "INVALID";
    }
    
}