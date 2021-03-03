function myFunction() {
    var x = document.getElementById("myLinks");
    if (x.className === "sub-menu") {
        x.className += " responsive";
    } else {
        x.className = "sub-menu";
    }
}

function showSearch() {
    var x = document.getElementById("center-nav");
    var logo = document.getElementById("this-logo");
    if (x.className === "central-nav-panel") {
        x.className += " show-search";
        logo.className += " hide-logo"
    } else {
        x.className = "central-nav-panel";
        logo.className = "logotype";
    }
}