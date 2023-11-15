var on_off = false;
var sidenav = document.querySelector(".sidenav");
var dir_button = document.querySelector("span");

function switch_on_off() {
    if (on_off == false){
        on_off = true;
        openNav();
    }else {
        on_off = false;
        closeNav();
    }
}
function openNav() {
    document.getElementById("mySidenav").style.width = "250px";
}

function closeNav() {
    document.getElementById("mySidenav").style.width = "0";
}

document.onclick = function(e){
    if (on_off == true && !sidenav.contains(e.target) && !dir_button.contains(e.target)) switch_on_off();
}