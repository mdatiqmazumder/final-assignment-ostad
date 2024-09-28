window.addEventListener('load', function () {
    hideProgress();
}
);

//page loading animation
pageloadinganim = document.querySelector('#pageloadinganim');
// create function
function showProgress(){
    pageloadinganim.classList.remove('hidden');
}
function hideProgress(){
    pageloadinganim.classList.add('hidden');
}

