const hamburger = document.getElementsByClassName("hamburger")[0],
    navMobile = document.getElementsByClassName("header-nav-hamburger")[0];

console.log(hamburger);
hamburger.addEventListener("click", function () {
    "0px" !== navMobile.style.height && navMobile.getAttribute("style") ? (navMobile.style.height = "0px") : (navMobile.style.height = navMobile.scrollHeight + "px");
});

document.addEventListener("scroll", function() {
    if ("0px" !== navMobile.style.height) {
        navMobile.style.height = "0px";
    }
});
