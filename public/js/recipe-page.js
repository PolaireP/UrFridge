const heart = document.getElementsByClassName("recipe-favorite-illustration")[0];
const favButton = document.getElementsByClassName("recipe-favorite-button")[0];
let isFilled = false;

favButton.addEventListener("click", function () {
    if (!isFilled) {
        heart.src = "img/filled-heart.svg";
        isFilled = true;
    } else {
        heart.src = "img/empty-heart.svg";
        isFilled = false;
    }
});