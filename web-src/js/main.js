$(document).ready(function(){

    var page = 2;
    var total = $('.count').text();
    var itemsPerPage = 10;
    $(window).scroll(function () {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            page++;
            if((page-1)* itemsPerPage > total) {
                $('#no-more').show();
                $('#more').hide();
            }else{
                $('#more').show();

                $.get("/app_dev.php/infinity-scroll", function(json) {
                    for (var i in json.players) {
                        $('.list-players').html($('.list-players').html() +
                            "<li>Name: " + json.players[i].name +
                            "<br/>Age: " + json.players[i].age +
                            "<br/>Position: " + json.players[i].position + "<br/><br/></li>");
                    }
                }, 'json');
            }
        }
    });
});