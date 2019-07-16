$(function(){
    $(document.body).not('.menu-deploy').click(function(){
        $('.menu-deploy').remove();
        $('.ui-effects-wrapper').remove();
    });
    
    $('#menu-list').live('mouseleave', function(){
        $('.menu-deploy').remove();
        $('.ui-effects-wrapper').remove();
    });
    
    $('.menu-icon').mouseenter(function(){
       $('.menu-deploy').remove();
       $('.ui-effects-wrapper').remove();
       $(document.body).append("<img id = 'arrow' class = 'menu-deploy' src = 'img/arrow.png'>");
       $('#arrow').css({
           'position': 'absolute', 
           'top': $(this).offset().top, 
           'left': $(this).offset().left + 40
       });
       $(document.body).append("<div id = 'menu-list' class = 'menu-deploy'></div>");
       $(this).parent().find('.hidden').each(function(){
            var action = $(this).attr('action');
            $('#menu-list').append("<a href = '" + action + "' " + (action.indexOf("http") > -1?"target = '_blank'":"") + "><div class = 'menu-sub'><span class = 'menu-link'>" + $(this).text() + "</span></div></a>");
       });
       $('#menu-list').css({
          'position': 'absolute', 
          'background-color': 'black', 
          'width': 165, 
          'min-height': 42, 
          'height': $('#menu-list').children().length * 35,
          'top': $(this).offset().top - ($('#menu-list').children().length>1?$('#menu-list').children().length / 2 * 17:0),
          'left': $(this).offset().left + 40 + 26, 
          'display': 'none'
       });
       $('#menu-list').show('slide', 'fast');
    });

    $('.menu-sub').live('mouseenter', function(){
       $(this).addClass('menu-active');
    });

    $('.menu-sub').live('mouseleave', function(){
       $(this).removeClass('menu-active'); 
    });
});
    