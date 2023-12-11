const hamburger = document.getElementsByClassName("hamburger")[0],
    navMobile = document.getElementsByClassName("header-nav-hamburger")[0];

console.log(hamburger);
hamburger.addEventListener("click", function () {
    "0px" !== navMobile.style.maxHeight && navMobile.getAttribute("style") ? (navMobile.style.maxHeight = "0px") : (navMobile.style.maxHeight = navMobile.scrollHeight + "px");
});