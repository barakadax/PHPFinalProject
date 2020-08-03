'use strict';
let del = document.getElementById("window");
let add = document.getElementById("adding");
let contact = document.getElementById("contact");
let save = document.getElementById("save");

function show() {
    if(window.getComputedStyle(del).visibility === "hidden")
        del.style.visibility = "visible";
    else
        del.style.visibility = "hidden";
}//O(1)

function add_win() {
    add.style.visibility = "visible";
}//O(1)

function contact_show() {
    contact.style.visibility = "visible";
}//O(1)

function save_show() {
    save.style.visibility = "visible";
}//O(1)

function exit_adding_note() {
    del.style.visibility = "hidden";
    add.style.visibility = "hidden";
    save.style.visibility = "hidden";
    contact.style.visibility = "hidden";
}//O(1)