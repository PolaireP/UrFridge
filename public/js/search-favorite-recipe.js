// récupération des éléments
import {
    setLoading,
    setNoResult,
    updateRecipesElt
} from "./recipe-boxes.js";

const searchRecipes = document.getElementById("search-recipes");

const controller = new AbortController();

searchRecipes.controller = controller;
//setLoading();
updateRecipesElt('', searchRecipes.controller);
searchRecipes.addEventListener("input", (event) => {
    searchRecipes.controller.abort();
    searchRecipes.controller = new AbortController();
    const search = event.target.value;
    updateRecipesElt(search, searchRecipes.controller);
});

document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form');

    forms.forEach(function (form) {
        form.addEventListener('keydown', function (event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });
    });
});
