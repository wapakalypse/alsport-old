$(function(){
    $(window).scroll(function() {
        var top = $(document).scrollTop();
        if (top < 1) $("#header-left-menu").css({top: '0px', position: 'relative', opacity: '1', transition: '1s'});
        else $("#header-left-menu").css({top: '0px', position: 'fixed', opacity: '0.7', transition: '1s',});
    });
});