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