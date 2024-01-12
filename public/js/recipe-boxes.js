export function emptyElt(elt) {
    while (elt.firstChild) {
        elt.removeChild(elt.firstChild);
    }
}

export function setLoading() {
    const recipesArea = document.getElementById("fill");

    if (recipesArea.lastElementChild !== null && recipesArea.lastElementChild.classList.contains("no-recipe")) {
        recipesArea.lastElementChild.remove();
    }
    const loadingText = document.createElement("p");
    loadingText.classList.add("no-recipe");
    loadingText.innerHTML += "Chargement...";
    recipesArea.appendChild(loadingText);
}

export function setNoResult() {
    const recipesArea = document.getElementById("fill");
    if (recipesArea.lastElementChild !== null && recipesArea.lastElementChild.classList.contains("no-recipe")) {
        recipesArea.lastElementChild.remove();
    }
    const noResultText = document.createElement("p");
    noResultText.classList.add("no-recipe");
    noResultText.innerHTML += "Pas de recette correspondant à votre recherche";
    recipesArea.appendChild(noResultText);
}

export function buildRecipeElement(recipeId, recipeName, recipePhoto, author, steps, link) {
    const recipeDiv = document.createElement('div');
    recipeDiv.classList.add('recipe');

    const recipeInfos = document.createElement('div');
    recipeInfos.classList.add('recipe-informations-area');

    const recipeTitle = document.createElement('h1');
    recipeTitle.classList.add('recipe-name');
    recipeTitle.innerHTML = recipeName;

    const recipeAuthor = document.createElement('p');
    recipeAuthor.classList.add('recipe-author');
    recipeAuthor.innerHTML = author;

    const recipeSteps = document.createElement('p');
    recipeSteps.classList.add('step-numbers');
    recipeSteps.innerHTML = steps + ' étapes';

    const recipeImage = document.createElement('img');
    recipeImage.classList.add('recipe-illustration');
    recipeImage.src = 'data:image/jpg;base64,' + recipePhoto;
    recipeImage.alt = recipeName;

    const recipeLink = document.createElement('a');
    recipeLink.classList.add('see-recipe');
    recipeLink.href = link;
    recipeLink.innerHTML = 'Voir la recette'

    recipeDiv.appendChild(recipeImage);
    recipeInfos.appendChild(recipeTitle);
    recipeInfos.appendChild(recipeAuthor);
    recipeInfos.appendChild(recipeSteps);
    recipeInfos.appendChild(recipeLink);
    recipeDiv.appendChild(recipeInfos);

    console.log(recipeDiv);
    return recipeDiv;
}

export function clearNoRecipeElement() {
    const recipeArea = document.getElementById("fill");
    if (recipeArea.lastElementChild.classList.contains("no-recipe")) {
        recipeArea.lastElementChild.remove();
    }
}

export function updateRecipesElt(search, controller) {
    const targetList = document.getElementsByClassName("fridge-recipes-list")[0];
    emptyElt(targetList);
    setLoading();
    getRecipes(search, controller).then((response) => {
        if (response && Array.isArray(response)) {
            response.forEach((recipe) => {
                const recipeElt = buildRecipeElement(recipe.id, recipe.recipeName, recipe.recipePhoto, recipe.author, recipe.steps, recipe.recipeLink);
                targetList.appendChild(recipeElt);
            });
            if (response.length === 0) {
                setNoResult();
            } else {
                clearNoRecipeElement();
            }
        } else {
            setNoResult();
        }
    });
}

export function getRecipes(search, controller) {
    const criterias = {
        search: search
    };

    const fetchInit = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(criterias),
        signal: controller.signal,
    };
    const fetchRecipes = fetch(`/profil/getfavorites`, fetchInit);
    return fetchRecipes.then((response) =>
        response.json(),
    );
}

