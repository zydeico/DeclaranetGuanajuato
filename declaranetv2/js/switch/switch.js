(function($){
   $.fn.extend({
      makeSwitch: function(options){
         var settings = {
            language: 'en', 
            status: 'on', 
            fnOn: function(){}, 
            fnOff: function () {}
         };
         if(options)
             $.extend(settings, options);
         
         var path = "js/switch/";
         return this.each(function(){
                $(this).addClass("switch-" + settings.status);
                var img = new Array();
                img['en'] = new Array();
                img['en']['switch-on'] = 'on.png';
                img['en']['switch-off'] = 'off.png';
                img['es'] = new Array();
                img['es']['switch-on'] = 'si.png';
                img['es']['switch-off'] = 'no.png';
                
                var html = "<img src = '" + path + img[settings.language]['switch-on'] + "' class = 'img-on' style = 'display:none;'>"
                         + "<img src = '" + path + img[settings.language]['switch-off'] + "' class = 'img-off' style = 'display:none;'>";
                $(this).html(html);
                $(this).find('.img-' + settings.status).show();
                
                $(this).css({
                   'width': $(this).find('img').width(), 
                   'cursor': 'pointer'
                });
                
                $(this).click(function(){
                    var w = $(this).width();
                    if($(this).hasClass('switch-on')){
                        $(this).find('.img-on').hide();
                        $(this).find('.img-off').show();
                        $(this).removeClass('switch-on').addClass('switch-off');
                        settings.fnOff();
                    }else{
                        $(this).find('.img-off').hide();
                        $(this).find('.img-on').show();
                        $(this).removeClass('switch-off').addClass('switch-on');
                        settings.fnOn();
                    }
                });
                
                
          }); // END EACH
      },// END function
      
      getStatus: function(){
          if($(this).hasClass('switch-on'))
              return "on";
          else
              return "off";
      }, 
              
      setStatus: function(state){
          if(state == "on"){
              $(this).removeClass('switch-off').addClass('switch-on');
              $(this).find('.img-off').hide();
              $(this).find('.img-on').show();
          }else if(state == "off"){
              $(this).removeClass('switch-on').addClass('switch-off');
              $(this).find('.img-on').hide();
              $(this).find('.img-off').show();
          }
      }
   }); // END extend
})(jQuery);