
    function updatePlaceholder() {
        var inputElement = document.querySelector('.search-box .input');

        if (window.matchMedia('(max-width: 480px)').matches) {
            inputElement.placeholder = 'Rechercher';
        } else {
            inputElement.placeholder = 'Spaghetti bolognaise, risotto à la crème ... ';
        }
    }

    updatePlaceholder();

    window.addEventListener('resize', updatePlaceholder);
