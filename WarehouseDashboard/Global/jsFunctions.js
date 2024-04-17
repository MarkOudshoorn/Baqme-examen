function Redirect(link)
{
    window.location.href = link;
} //helper functie om makkelijker te kunnen redirecten


//obtain de elementen om de blur te displayen op de correcte momenten
//en om het goede menu te verplaatsen
var subMenu = null;
var bgBlur = null;
document.addEventListener("DOMContentLoaded", function() {
    subMenu = document.getElementById("subMenu");
    bgBlur = document.getElementById("bgBlur");
});

let isOpen = false; //initiate het menu als false


//wordt aangeroepen zodra de gebruiker het submenu wilt openen (in de navbar)
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

//helper function voor het adden en removen van classes
function AddOrRemoveItemToClassList_ID(addOrRemove, element, className)
{
    if(addOrRemove == "add")
        document.getElementById(element).classList.add(className);
    else
        document.getElementById(element).classList.remove(className);
}

function ToggleSubmenuButtonsOnNewUser(openOrClose)
{
    if(openOrClose == "open")
    {
        document.getElementById("accountPass_SaveButton_newAccount").classList.add("accountPass_functionButton_column_hidden");
        document.getElementById("accountPass_confirmSaveButton_newAccount").classList.remove("accountPass_functionButton_hidden");
        document.getElementById("accountPass_confirmSaveButton_newAccount").classList.add("accountPass_functionButton_row");
        document.getElementById("accountPass_cancelSaveButton_newAccount").classList.remove("accountPass_functionButton_hidden");
        document.getElementById("accountPass_cancelSaveButton_newAccount").classList.add("accountPass_functionButton_row");
    }
    else
    {
        document.getElementById("accountPass_SaveButton_newAccount").classList.remove("accountPass_functionButton_column_hidden");
        document.getElementById("accountPass_confirmSaveButton_newAccount").classList.add("accountPass_functionButton_hidden");
        document.getElementById("accountPass_confirmSaveButton_newAccount").classList.remove("accountPass_functionButton_row");
        document.getElementById("accountPass_cancelSaveButton_newAccount").classList.add("accountPass_functionButton_hidden");
        document.getElementById("accountPass_cancelSaveButton_newAccount").classList.remove("accountPass_functionButton_row");
    }
}

//Zeer slechte code om bepaalde elementen te hiden en te displayen (wordt gebruikt voor de edit/delete knoppen in de navbar's submenu)
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
            AddOrRemoveItemToClassList_ID("remove", "accountPass_EditButton_" + number, "accountPass_functionButton_hidden");
            AddOrRemoveItemToClassList_ID("remove", "accountPass_confirmEditButton_" + number, "accountPass_functionButton_row");
            AddOrRemoveItemToClassList_ID("remove", "accountPass_cancelEditButton_" + number, "accountPass_functionButton_row");
            AddOrRemoveItemToClassList_ID("add", "accountPass_confirmEditButton_" + number, "accountPass_functionButton_hidden");
            AddOrRemoveItemToClassList_ID("add", "accountPass_cancelEditButton_" + number, "accountPass_functionButton_hidden");
        }
    }
}