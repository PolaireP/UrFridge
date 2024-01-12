export function displayBox(box, followedBox, color = "black", boxType = "default", clicked = true) {
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

export function closeBox (box, followedBox, boxType = "default") {
    box.style.height = '0px';
    box.style.borderWidth = "0px";
    if (boxType === "default") {
        followedBox.style.borderRadius = "";
    } else {
        followedBox.style.borderRadius = "";
        followedBox.style.borderWidth = "";
    }
}

export function openBox (box, followedBox, color, boxType = "default") {
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

export function updateBoxSize (box, parent, followedBox, boxType = "default") {
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

export function setOverlappingBoxesListeners(buttons, boxes, parent, followedBox, color) {
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

export function buildCategoryCheckBox(categoryId, categoryName, criteriasAgregate) {
    const checkBoxContainer = document.createElement('label');
    checkBoxContainer.classList.add('checkbox-container');

    const checkBoxInput = document.createElement('input');
    checkBoxInput.classList.add('checkbox');
    checkBoxInput.setAttribute('type', 'checkbox');
    checkBoxInput.setAttribute('name', categoryName);
    checkBoxInput.setAttribute('value', categoryId);
    if (criteriasAgregate.indexOf(categoryId) !== -1) {
        checkBoxInput.setAttribute('checked', '');
    }
    checkBoxContainer.appendChild(checkBoxInput);

    const checkBoxCheckMark = document.createElement('span');
    checkBoxCheckMark.classList.add('checkmark');
    checkBoxContainer.appendChild(checkBoxCheckMark);

    checkBoxContainer.innerHTML += categoryName;

    return checkBoxContainer;
}

export function emptyElt(elt) {
    while (elt.firstChild) {
        elt.removeChild(elt.firstChild);
    }
}

export function getCategories(search, controller) {
    const criterias = {
        searchCategories: search,
    };

    const fetchInit = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        signal: controller.signal,
        body: JSON.stringify(criterias),
    };
    const fetchCategories = fetch(`/recipe/categories`, fetchInit);
    return fetchCategories.then((response) =>
        response.json(),
    );
}

export function setCategoryLoading() {
    const categoriesBox = document.getElementById("categories-box");
    if (categoriesBox.lastElementChild.classList.contains("no-category")) {
        categoriesBox.lastElementChild.remove();
    }
    const loadingText = document.createElement("p");
    loadingText.classList.add("no-category");
    loadingText.innerHTML += "Chargement...";
    categoriesBox.appendChild(loadingText);
}

export function setNoCategory() {
    const categoriesBox = document.getElementById("categories-box");
    if (categoriesBox.lastElementChild.classList.contains("no-category")) {
        categoriesBox.lastElementChild.remove();
    }
    const noResultText = document.createElement("p");
    noResultText.classList.add("no-category");
    noResultText.innerHTML += "Pas de catégorie correspondant à votre recherche";
    categoriesBox.appendChild(noResultText);
}

export function clearNoCategoryElement() {
    const categoriesBox = document.getElementById("categories-box");
    if (categoriesBox.lastElementChild.classList.contains("no-category")) {
        categoriesBox.lastElementChild.remove();
    }
}

export function setChangeListener(entity, elt, criteriasAgregate) {
    elt.addEventListener('change', (event) => {
        const search = document.getElementById("search-recipes").value;
        if (event.target.checked) {
            criteriasAgregate.push(entity.id);
            let ingredientsId;
        } else {
            let index = criteriasAgregate.indexOf(entity.id);
            if (index !== -1) {
                criteriasAgregate.splice(index, 1);
            }
        }
    });
}

export function updateCategoriesElt(search, controller, criteriasAgregate) {
    const targetList = document.getElementsByClassName("entity-checkbox-append")[1];
    emptyElt(targetList);
    setCategoryLoading();
    getCategories(search, controller).then((response) => {
        if (response && Array.isArray(response)) {
            response.forEach((category) => {
                const categoryElt = buildCategoryCheckBox(category.id, category.categoryName, criteriasAgregate);
                targetList.appendChild(categoryElt);
                setChangeListener(category, categoryElt, criteriasAgregate);
            });
            if (response.length === 0) {
                setNoCategory();
            } else {
                clearNoCategoryElement();
            }
        } else {
            setNoCategory();
        }
    });
}

export function buildRecipeBox(recipeId, recipeName, author, recipePhoto, stepNumbers) {
    const recipeElt = document.createElement('div');
    recipeElt.classList.add('recipe');

    const recipeIllustration = document.createElement('img');
    recipeIllustration.classList.add('recipe-illustration');
    if (recipePhoto) {
        recipeIllustration.setAttribute('src',  `data:image/jpg;base64,${recipePhoto}`);
    } else {
        recipeIllustration.setAttribute('src', 'img/default-recipe.svg');
    }
        recipeIllustration.setAttribute('alt', `Photo de ${recipeName}`);

    recipeElt.appendChild(recipeIllustration);

    const recipeInformationsArea = document.createElement('div');
    recipeInformationsArea.classList.add('recipe-informations-era');

    const recipeNameElt = document.createElement('h1');
    recipeNameElt.classList.add('recipe-name');
    recipeNameElt.innerHTML += recipeName;

    recipeInformationsArea.appendChild(recipeNameElt);

    if (author) {
        const recipeAuthor = document.createElement('p');
        recipeAuthor.classList.add('recipe-author');
        recipeAuthor.innerHTML += author;

        recipeInformationsArea.appendChild(recipeAuthor);
    }

    const stepNumbersElt = document.createElement('p');
    stepNumbersElt.classList.add('step-numbers');
    stepNumbersElt.innerHTML += `${stepNumbers} étape(s)`;

    recipeInformationsArea.appendChild(stepNumbersElt);

    const seeRecipe = document.createElement('a');
    seeRecipe.classList.add('see-recipe');
    seeRecipe.setAttribute('href', `/recipe/${recipeId}`);
    seeRecipe.innerHTML += 'Voir la recette';

    recipeInformationsArea.appendChild(seeRecipe);

    recipeElt.appendChild(recipeInformationsArea);

    return recipeElt;
}

export function setRecipeLoading() {
    const recipesList = document.getElementsByClassName('recipes-list')[0];
    if (recipesList.firstElementChild && recipesList.firstElementChild.classList.contains("no-recipe")) {
        recipesList.firstElementChild.remove();
    }
    const loadingText = document.createElement("p");
    loadingText.classList.add("no-recipe");
    loadingText.innerHTML += "Chargement...";
    recipesList.appendChild(loadingText);
}

export function setNoRecipe() {
    const recipesList = document.getElementsByClassName('recipes-list')[0];
    if (recipesList.firstElementChild && recipesList.firstElementChild.classList.contains("no-recipe")) {
        recipesList.firstElementChild.remove();
    }
    const noResultText = document.createElement("p");
    noResultText.classList.add("no-recipe");
    noResultText.innerHTML += "Pas de recette correspondant à votre recherche";
    recipesList.appendChild(noResultText);
}

export function clearNoRecipeElement() {
    const recipesList = document.getElementsByClassName('recipes-list')[0];
    if (recipesList.firstElementChild && recipesList.firstElementChild.classList.contains("no-recipe")) {
        recipesList.firstElementChild.remove();
    }
}

export function getRecipes(search, ingredientsId, allergensId, categoriesId, filters, controller) {
    const criterias = {
        search: search,
        ingredientsId: ingredientsId,
        allergensId: allergensId,
        categoriesId: categoriesId,
        filters: filters,
    };

    const fetchInit = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        signal: controller.signal,
        body: JSON.stringify(criterias),
    };
    const fetchRecipes = fetch(`/recipe/recipes`, fetchInit);
    return fetchRecipes.then((response) =>
        response.json(),
    );
}

export function updateRecipesElt(search, ingredientsId, allergensId, categoriesId, filters, controller) {
    const targetList = document.getElementsByClassName("recipes-list")[0];
    const resNumber = document.getElementById('res-number');
    emptyElt(targetList);
    setRecipeLoading();
    getRecipes(search, ingredientsId, allergensId, categoriesId, filters, controller).then((response) => {
        if (response && Array.isArray(response)) {
            response.forEach((recipe) => {
                const recipeElt = buildRecipeBox(recipe.id,
                    recipe.recipeName, recipe.author, recipe.recipePhoto, recipe.stepNumbers);
                targetList.appendChild(recipeElt);
            });
            resNumber.innerHTML = response.length;
            if (response.length === 0) {
                setNoRecipe();
            } else {
                clearNoRecipeElement();
            }
        } else {
            resNumber.innerHTML = '0';
            setNoRecipe();
        }
    });
}

