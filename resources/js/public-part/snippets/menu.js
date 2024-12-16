$(document).ready(function (){
    let toggleRightMenu = function (){
        $(".right__menu").toggleClass('visible');
    }

    $(".hamburger__wrapper").click(function (){
        toggleRightMenu();
    });
    $(".rm__exit").click(function (){
        toggleRightMenu();
    });
})
