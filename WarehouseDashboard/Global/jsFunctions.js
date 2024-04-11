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

function AddOrRemoveItemToClassList_ID(addOrRemove, element, className)
{
    if(addOrRemove == "add")
        document.getElementById(element).classList.add(className);
    else
        document.getElementById(element).classList.remove(className);
}

//this code is crap
//but I'm way too lazy to remake it with arrays and loops
//besides, nobody will see it anyway -mark
function ToggleSubmenuButtons(type, number, appearOrDisappear)
{
    if(appearOrDisappear == "appear")
    {
        if(type == "delete")
        {
            AddOrRemoveItemToClassList_ID("add", "accountPass_DeleteButton_" + number, "accountPass_functionButton_hidden");
            AddOrRemoveItemToClassList_ID("add", "accountPass_confirmDeleteButton_" + number, "accountPass_functionButton_row");
            AddOrRemoveItemToClassList_ID("add", "accountPass_cancelDeleteButton_" + number, "accountPass_functionButton_row");
            AddOrRemoveItemToClassList_ID("remove", "accountPass_confirmDeleteButton_" + number, "accountPass_functionButton_hidden");
            AddOrRemoveItemToClassList_ID("remove", "accountPass_cancelDeleteButton_" + number, "accountPass_functionButton_hidden");
        }
        else
        {
            console.log("edit");
            AddOrRemoveItemToClassList_ID("add", "accountPass_EditButton_" + number, "accountPass_functionButton_hidden");
            AddOrRemoveItemToClassList_ID("add", "accountPass_confirmEditButton_" + number, "accountPass_functionButton_row");
            AddOrRemoveItemToClassList_ID("add", "accountPass_cancelEditButton_" + number, "accountPass_functionButton_row");
            AddOrRemoveItemToClassList_ID("remove", "accountPass_confirmEditButton_" + number, "accountPass_functionButton_hidden");
            AddOrRemoveItemToClassList_ID("remove", "accountPass_cancelEditButton_" + number, "accountPass_functionButton_hidden");        }
    }
    else
    {
        if(type == "delete")
        {
            AddOrRemoveItemToClassList_ID("remove", "accountPass_DeleteButton_" + number, "accountPass_functionButton_hidden");
            AddOrRemoveItemToClassList_ID("remove", "accountPass_confirmDeleteButton_" + number, "accountPass_functionButton_row");
            AddOrRemoveItemToClassList_ID("remove", "accountPass_cancelDeleteButton_" + number, "accountPass_functionButton_row");
            AddOrRemoveItemToClassList_ID("add", "accountPass_confirmDeleteButton_" + number, "accountPass_functionButton_hidden");
            AddOrRemoveItemToClassList_ID("add", "accountPass_cancelDeleteButton_" + number, "accountPass_functionButton_hidden");        }
        else
        {
            console.log("edit");
            AddOrRemoveItemToClassList_ID("remove", "accountPass_EditButton_" + number, "accountPass_functionButton_hidden");
            AddOrRemoveItemToClassList_ID("remove", "accountPass_confirmEditButton_" + number, "accountPass_functionButton_row");
            AddOrRemoveItemToClassList_ID("remove", "accountPass_cancelEditButton_" + number, "accountPass_functionButton_row");
            AddOrRemoveItemToClassList_ID("add", "accountPass_confirmEditButton_" + number, "accountPass_functionButton_hidden");
            AddOrRemoveItemToClassList_ID("add", "accountPass_cancelEditButton_" + number, "accountPass_functionButton_hidden");
        }
    }
}