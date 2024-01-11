document.addEventListener('DOMContentLoaded', function () {
    var currentPeople = 4; // Nombre de personnes par défaut
    var peopleDisplay = document.querySelector('.recipe-quantity');
    var increaseButton = document.querySelector('.recipe-quantity-more');
    var decreaseButton = document.querySelector('.recipe-quantity-less');

    // Met à jour l'affichage du nombre de personnes
    function updatePeopleDisplay() {
        peopleDisplay.textContent = currentPeople + " Personnes";
    }

    // Met à jour les quantités d'ingrédients
    function updateQuantities() {
        var ingredientQuantities = document.querySelectorAll('.recipe-ingredient-quantity');
        ingredientQuantities.forEach(function (element) {
            var originalQuantity = parseFloat(element.getAttribute('data-original-quantity'));
            var newQuantity = originalQuantity * currentPeople / 4;
            element.textContent = newQuantity.toFixed(2) + " " + element.getAttribute('data-unit');
        });
    }

    // Augmenter le nombre de personnes
    increaseButton.addEventListener('click', function () {
        currentPeople++;
        updatePeopleDisplay();
        updateQuantities();
    });

    // Réduire le nombre de personnes
    decreaseButton.addEventListener('click', function () {
        if (currentPeople > 1) { // Empêcher le nombre de personnes de devenir inférieur à 1
            currentPeople--;
            updatePeopleDisplay();
            updateQuantities();
        }
    });

    updatePeopleDisplay(); // Mise à jour initiale de l'affichage
});
