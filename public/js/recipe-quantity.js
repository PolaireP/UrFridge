// Event listener pour récupérer les modifs
document.addEventListener('DOMContentLoaded', function () {
    let currentPeople = 4;
    let peopleDisplay = document.querySelector('.recipe-quantity');
    let increaseButton = document.querySelector('.recipe-quantity-more');
    let decreaseButton = document.querySelector('.recipe-quantity-less');

    // Met à jour l'affichage du nombre de personnes
    function updatePeopleDisplay() {
        peopleDisplay.textContent = currentPeople + " Personnes";
    }

    // Met à jour les quantités d'ingrédients
    function updateQuantities() {
        let ingredientQuantities = document.querySelectorAll('.recipe-ingredient-quantity');
        ingredientQuantities.forEach(function (element) {
            let originalQuantity = parseFloat(element.getAttribute('data-original-quantity'));
            let newQuantity = originalQuantity * currentPeople / 4;
            element.textContent = newQuantity.toFixed(2) + " " + element.getAttribute('data-unit');
        });
    }

    // Augmenter le nombre de personnes pour une recette
    increaseButton.addEventListener('click', function () {
        currentPeople++;
        updatePeopleDisplay();
        updateQuantities();
    });

    // Réduire le nombre de personnes
    decreaseButton.addEventListener('click', function () {
        if (currentPeople > 1) {
            currentPeople--;
            updatePeopleDisplay();
            updateQuantities();
        }
    });

    updatePeopleDisplay();
});
