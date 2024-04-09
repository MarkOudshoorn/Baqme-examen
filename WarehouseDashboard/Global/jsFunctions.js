function Redirect(link)
{
    window.location.href = link;
}

var subMenu = null;
var bgBlur = null;
document.addEventListener("DOMContentLoaded", function() {
    subMenu = document.getElementById("subMenu");
    bgBlur = document.getElementById("bgBlur");
});

let isOpen = false;

function ToggleSubMenu() {
    isOpen = !isOpen; // Toggle the state
    if (isOpen) {
        subMenu.style.right = "0px"; // Open the submenu
        bgBlur.classList.add("blur");
        bgBlur.classList.remove("noblur");
    } else {
        subMenu.style.right = "-500px"; // Close the submenu
        bgBlur.classList.remove("blur");
        bgBlur.classList.add("noblur");
    }
}
