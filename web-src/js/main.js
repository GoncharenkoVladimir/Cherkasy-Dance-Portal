$(document).ready(function(){
    var heightSideBar = $('#admin-panel').height();
    $('#admin-panel .control-panel').height(heightSideBar);

    $('.rating_post label').hover(function(){

        var number = $(this).index();

        switch (number) {
            case 1:
                $('.rating_post').css("background-position","-11px -267px");
                break;
            case 3:
                $('.rating_post').css("background-position","-11px -204px");
                break;
            case 5:
                $('.rating_post').css("background-position","-11px -143px");
                break;
            case 7:
                $('.rating_post').css("background-position","-11px -78px");
                break;
            case 9:
                $('.rating_post').css("background-position","-11px -14px");
                break;
            default:
                $('.rating_post').css("background-position","-11px -267px");
                break;
        }
    });
});