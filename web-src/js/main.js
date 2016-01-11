$(document).ready(function(){

    var page = 2;
    var total = $('.count').text();
    var itemsPerPage = 5;
    $(window).scroll(function () {
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            page++;
            if((page-1)* itemsPerPage > total) {
                $('#no-more').show();
                $('#more').hide();
            }else{
                $('#more').show();

                $.get("/app_dev.php/infinity-scroll", function(json) {
                    console.log(json);
                    for (var i in json.posts) {
                        $('.post-outer').html($('.post-outer').html() +
                            "<div class=\"post hentry\"><div class=\"post-body entry-content\" id=\"\"><div class=\"thumbs\">" +
                            "<a href=\"http://asterism-mairagall.blogspot.com/2015/04/wypas-cookie-caramels-souffle-caramels.html\">"+
                            "<img src=\"http://4.bp.blogspot.com/-GteVT4IofuQ/VQNd8fCd93I/AAAAAAAADgQ/EOXamheeLDU/s370-c/keyboard-old-typewriter-3319.jpg\" alt=\"Wypas cookie caramels soufflé caramels cookie \">" +
                            "</a></div>" +
                            "<div class=\"items-right\">" +
                            "<h3 class=\"post-title entry-title\">" +
                            "<a href=\"http://asterism-mairagall.blogspot.com/2015/04/wypas-cookie-caramels-souffle-caramels.html\">" + json.posts[i].title + "</a></h3>" +
                            "<h2 class=\"date-header\"><span>" + json.posts[i].createTime + "</span></h2>" +
                            "<p class=\"excerpt\">" + json.posts[i].content + "</p>" +
                            "<div class=\"jump-link\">" +
                            "<a href=\"http://asterism-mairagall.blogspot.com/2015/04/wypas-cookie-caramels-souffle-caramels.html#more\">Continue Reading<i class=\"fa fa-caret-right\"></i></a></div>" +
                            "</div><div style=\"clear: both;\"></div></div></div>");
                    }
                }, 'json');
            }
        }
    });
});