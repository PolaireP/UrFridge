// récupération des éléments
const parentInteractingArea = document.getElementsByClassName("main-interaction-area")[0];
const filtersArea = document.getElementById("filters-area-box");
const ingredientsSearchBar = document.getElementsByClassName("search-bar")[0];
const ingredientsSearchArea = document.getElementsByClassName("search-area")[0];

const addAllergensButton = document.getElementsByClassName("add-allergens-button")[0];
const addAllergensButtonIcon = document.getElementsByClassName("add-allergens-button-icon")[0];

const addCategoriesButton = document.getElementsByClassName("add-categories-button")[0];
const addCategoriesButtonIcon = document.getElementsByClassName("add-categories-button-icon")[0];

const addFiltersButton = document.getElementsByClassName("add-filters-button")[0];

const allergenBox = document.getElementById("allergens-box");
const categoryBox = document.getElementById("categories-box");
const filterBox = document.getElementById("filters-box");
const ingredientBox = document.getElementById("ingredients-research");

function closeBox (box, followedBox, boxType = "default") {
    box.style.height = '0px';
    box.style.borderWidth = "0px";
    if (boxType === "default") {
        followedBox.style.borderRadius = "";
    } else {
        followedBox.style.borderRadius = "";
        followedBox.style.borderWidth = "";
    }
}

function openBox (box, followedBox, color, boxType = "default") {
    box.style.height = "auto";
    box.style.borderColor = color;
    box.style.borderStyle = "solid";
    box.style.borderWidth = "0 2px 2px 2px";
    if (boxType === "search") {
        followedBox.style.borderWidth = "2px 2px 0 2px";
        box.style.borderRadius = "0 0 38px 38px";
        followedBox.style.borderRadius = "38px 38px 0 0";
    } else {
        box.style.borderWidth = "0 2px 2px 2px";
        followedBox.style.borderRadius = "20px 20px 0 0";
    }
}

function displayBox(box, followedBox, color = "black", boxType = "default", clicked = true) {
    const isBoxAlreadyOpen = box.style.height !== '0px' && box.style.height !== '';

    if (isBoxAlreadyOpen && clicked) {
        closeBox(box, followedBox, boxType);
    } else {
        if (boxType === "default") {
            const overlappingBoxes = [].slice.call(document.getElementsByClassName("overlapping-box"));

            overlappingBoxes.forEach((overlappingBox) => {
                closeBox(overlappingBox, followedBox, boxType);
            });
        }

        openBox(box, followedBox, color, boxType);
    }
}

function updateBoxSize (box, parent, followedBox, boxType = "default") {
    box.style.top = parent.getBoundingClientRect().bottom + window.scrollY + 'px';
    box.style.width = followedBox.scrollWidth + 'px';
    if (boxType === "search" && !(box.style.height === '0px' || box.style.height === '')) {
        if (window.innerWidth >= 1000) {
            parent.style.borderWidth = "4px 4px 0 4px";
            box.style.borderWidth = "0 4px 4px 4px";
        } else if (window.innerWidth >= 600) {
            parent.style.borderWidth = "3px 3px 0 3px";
            box.style.borderWidth = "0 3px 3px 3px";
            parent.style.borderRadius = "20px 20px 0 0";
            box.style.borderRadius = "0 0 20px 20px";
        } else {
            parent.style.borderWidth = "2px 2px 0 2px";
            box.style.borderWidth = "0 2px 2px 2px";
            parent.style.borderRadius = "20px 20px 0 0";
            box.style.borderRadius = "0 0 20px 20px";
        }
    }
}

function setOverlappingBoxesListeners(buttons, boxes, parent, followedBox, color) {
    for (let i = 0; i < buttons.length; i++) {
        buttons[i].addEventListener("click", () => {
           displayBox(boxes[i], followedBox, color);
           updateBoxSize(boxes[i], parent, followedBox);
        });
    }

    boxes.sort().filter(function(item, index, ary) {
        return !index || item !== ary[index - 1];
    });

    window.addEventListener("scroll", () => {
        boxes.forEach((box) => {
            updateBoxSize(box, parent, followedBox);
        })
    });

    window.addEventListener("resize", () => {
        boxes.forEach((box) => {
            updateBoxSize(box, parent, followedBox);
        })
    });
}

setOverlappingBoxesListeners(
    [addAllergensButton, addAllergensButtonIcon, addCategoriesButton, addCategoriesButtonIcon, addFiltersButton],
    [allergenBox, allergenBox, categoryBox, categoryBox, filterBox],
    parentInteractingArea,
    filtersArea,
    "#4CB9A5",
);

document.addEventListener("click", (clickedPoint) => {
    let targetElement = clickedPoint.target;

    const isClickedInsideIngredientsArea = ingredientsSearchArea.contains(targetElement);
    const isClickedInsideIngredientBox = ingredientBox.contains(targetElement);
    const isClickedInsideAllergenBox = allergenBox.contains(targetElement);
    const isClickedInsideCategoryBox = categoryBox.contains(targetElement);
    const isClickedInsideFilterBox = filterBox.contains(targetElement);

    if (!isClickedInsideIngredientsArea && !isClickedInsideIngredientBox &&
        !(ingredientBox.style.height === '0px' || ingredientBox.style.height === '')
    ) {
        displayBox(ingredientBox, ingredientsSearchBar, "#00000000", "search");
    }

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

ingredientsSearchArea.addEventListener("click", () => {
    displayBox(ingredientBox, ingredientsSearchBar, "#00000000", "search", false);
    updateBoxSize(ingredientBox, ingredientsSearchBar, ingredientsSearchArea, "search");
});

window.addEventListener("scroll", () => {
   updateBoxSize(ingredientBox, ingredientsSearchBar, ingredientsSearchArea, "search");
});

window.addEventListener("resize", () => {
    updateBoxSize(ingredientBox, ingredientsSearchBar, ingredientsSearchArea, "search");
});

ingredientsSearchArea.addEventListener("input", () => {
   displayBox(ingredientBox, ingredientsSearchBar, "#00000000", "search", false);
   updateBoxSize(ingredientBox, ingredientsSearchBar, ingredientsSearchArea, "search");
});