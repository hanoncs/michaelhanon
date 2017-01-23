// var e=document.createElement('div');
// e.id='detect-ads-div';
// e.style.display='none';
// document.body.appendChild(e);


if (typeof(Storage) !== "undefined") {
    // Code for localStorage/sessionStorage.
    localStorage.setItem("ads-blocked", "no");
}