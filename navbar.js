function togglerMenu() {
    var x = document.getElementById("nav-content");
    var y = document.getElementById("navbar");
    if(x.style.display == "none" || x.style.display == "") {
        x.style.display = "block";
        y.style.width = "70vw";
    } else {
        x.style.display = "none";
        y.style.width = "10vw";
    }
}