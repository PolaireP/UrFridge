// récupération des éléments
import {displayBox, setOverlappingBoxesListeners, updateBoxSize} from "./overlapping-box.js";

const parentInteractingArea = document.getElementsByClassName("main-interaction-area")[0];
const filtersArea = document.getElementById("filters-area-box");
const recipesSearchBar = document.getElementsByClassName("search-bar")[0];
const recipesSearchArea = document.getElementsByClassName("search-area")[0];

const addAllergensButton = document.getElementsByClassName("add-allergens-button")[0];
const addAllergensButtonIcon = document.getElementsByClassName("add-allergens-button-icon")[0];

const addCategoriesButton = document.getElementsByClassName("add-categories-button")[0];
const addCategoriesButtonIcon = document.getElementsByClassName("add-categories-button-icon")[0];

const addFiltersButton = document.getElementsByClassName("add-filters-button")[0];

const allergenBox = document.getElementById("allergens-box");
const categoryBox = document.getElementById("categories-box");
const filterBox = document.getElementById("filters-box");

setOverlappingBoxesListeners(
    [addAllergensButton, addAllergensButtonIcon, addCategoriesButton, addCategoriesButtonIcon, addFiltersButton],
    [allergenBox, allergenBox, categoryBox, categoryBox, filterBox],
    parentInteractingArea,
    filtersArea,
    "#4CB9A5",
);

document.addEventListener("click", (clickedPoint) => {
    let targetElement = clickedPoint.target;

    const isClickedInsideIngredientsArea = recipesSearchArea.contains(targetElement);
    const isClickedInsideAllergenBox = allergenBox.contains(targetElement);
    const isClickedInsideCategoryBox = categoryBox.contains(targetElement);
    const isClickedInsideFilterBox = filterBox.contains(targetElement);

    if (!isClickedInsideAllergenBox && !addAllergensButton.contains(targetElement) &&
        !addAllergensButtonIcon.contains(targetElement) &&
        !(allergenBox.style.height === '0px' || allergenBox.style.height === '')
    ) {
        displayBox(allergenBox, filtersArea, "#4CB9A5");
    }

    if (!isClickedInsideCategoryBox && !addCategoriesButton.contains(targetElement) &&
        !addCategoriesButtonIcon.contains(targetElement) &&
        !(categoryBox.style.height === '0px' || categoryBox.style.height === '')
    ) {
        displayBox(categoryBox, filtersArea, "#4CB9A5");
    }

    if (!isClickedInsideFilterBox && !addFiltersButton.contains(targetElement) &&
        !(filterBox.style.height === '0px' || filterBox.style.height === '')
    ) {
        displayBox(filterBox, filtersArea, "#4CB9A5");
    }
});