  <script>$(function(){
    $(window).scroll(function() {
        var top = $(document).scrollTop();
        if (top < 100) $(".floating").css({top: '0', position: 'relative'});
        else $(".floating").css({top: '10px', position: 'fixed'});
    });
});</script>