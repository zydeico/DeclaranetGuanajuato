function Mask(){
	$(document.body).append("<div class = 'mask'></div>");
	$('.mask').css({
		'width': $(document).width(), 
		'height': $(document).height(), 
		'position': 'absolute', 
		'top': 0, 
		'left': 0, 
		'background-color': 'black', 
		'opacity': 0.5, 
                'z-index': 100000
	});
}

function Loading(){		
    Mask();
    $(document.body).append("<img class = 'loading' src = 'img/loading.gif'>");
    $('.loading').css({
        'position': 'absolute', 
        'top': $(document.body).height() / 2 - 500,
        'left': $(document.body).width() / 2 - 300, 
        'z-index': 100001
    });
}

function doSexy(url, width, height, title){
    if(width == 0 && height == 0)
        $('#ankor').attr('href', url);
    else
        $('#ankor').attr('href', url + '&width=' + width + '&height=' + height + '&modal=1' + (title?'&title=' + title:""));
    $('#ankor').click();
}

function closeSexy(){
    SexyLightbox.close();
}

function getDateTime(){
    var now = new Date();
    var date = now.getFullYear() + '-' + (now.getMonth()<9?"0":"") + (now.getMonth()+1) + '-' + (now.getDate()<10?"0":"") + now.getDate();
    var time = (now.getHours()<10?"0":"") + now.getHours() + ":" + (now.getMinutes()<10?"0":"") + now.getMinutes() + ":" + (now.getSeconds()<10?"0":"") + now.getSeconds();
    return date + " " + time;
}

function Full(obj){
	var full = true;
	$('.watch').removeClass('watch');
	$(obj).find('.require').each(function(){
		if($.trim($(this).val()) == "" && $(this).is(':visible')){
			full = false;
			$(this).addClass('watch');
		}
	});
	return full;	
}

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function validateRFC(rfc){	
	for(var i=0; i<rfc.length; i++){
		if(i < 4){
			if(isNumeric(rfc[i]) || rfc[i] == ' ')
				return false;
		}else if(i > 3 && i < 10){
			if(!isNumeric(rfc[i]) || rfc[i] == ' ')
				return false;
		}		
	}
	return true;
}

function validatePwd(pwd1, pwd2){
    if($.trim(pwd1) == $.trim(pwd2)){
        var numeric = false;
        var letter = false;
        for(var i=0; i<pwd1.length; i++){
            if(isNumeric(pwd1[i]))
                numeric = true;
            else
                letter = true;
        }
        if(!numeric || !letter)
            return "Las claves deben contener números y letras";
    }else{
        return "Las claves no coinciden!";
    }
}

function Reload(obj, page){
    obj.clearAll();
    obj.loadXML(page, function(){ Clear(obj); Count(obj); $('.mask, .loading').remove(); });
}

function Clear(obj){	
        $(obj.entBox).find('input, select').each(function(){
		$(this).val('');
	});
}

function Count(obj){
    var counter = obj.getRowsNum();
    $(obj.entBox).parents('table').find('.RowCount').text("Total: " + counter);
    return counter;
}

function DatePicker(obj, limit){
    $.datepicker.regional['es'] = {
                clearText: 'Borra',
                clearStatus: 'Borra fecha actual',
                closeText: 'Cerrar',
                closeStatus: 'Cerrar sin guardar',
                prevText: '<Ant',
                prevBigText: '<<',
                prevStatus: 'Mostrar mes anterior',
                prevBigStatus: 'Mostrar año anterior',
                nextText: 'Sig>',
                nextBigText: '>>',
                nextStatus: 'Mostrar mes siguiente',
                nextBigStatus: 'Mostrar año siguiente',
                currentText: 'Hoy',
                currentStatus: 'Mostrar mes actual',
                monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio', 'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                monthStatus: 'Seleccionar otro mes',
                yearStatus: 'Seleccionar otro año',
                weekHeader: 'Sm',
                weekStatus: 'Semana del año',
                dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                dayStatus: 'Set DD as first week day',
                dateStatus: 'Select D, M d',
                dateFormat: 'dd/mm/yy',
                firstDay: 1,
                initStatus: 'Seleccionar fecha',
                isRTL: false
        };
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $(obj).datepicker({dateFormat: "yy-mm-dd", changeMonth: true, changeYear: true, maxDate: limit});
}

function fakeLoad(obj){
    $(obj).children().hide();
    $(obj).append("<img src ='img/loadingmini.gif' width ='24' heigth ='24' style = 'margin: 5px 20px 0px 10px;' class ='fakeLoad'>");
}

function ready(){
    var par = $('.fakeLoad').parent();
    $('.fakeLoad').remove();
    $(par).children().show();
}

function removeLegend(){
    $("tspan:contains('chart by')").parents('g').remove();
}

$('.numeric').live('keydown', function(e){
	var AlfaNum = new Array(48, 49, 50, 51, 52, 53, 54, 55, 56, 57);
	var NumPad = new Array(96, 97, 98, 99, 100, 101, 102, 103, 104, 105);
	var dot = new Array(110, 190);	
	var allow = new Array(8, 9, 13, 46);
	var arrow = new Array(37, 38, 39, 40);
	var n = e.which;
        var k = String.fromCharCode(e.keyCode)
//        console.log(n);
//        console.log(k);
//        if(isNumeric(k) || dot.indexOf(n) > -1 || allow.indexOf(n) > -1 || arrow.indexOf(n) > -1)
//            return true;
//        else
//            return false;
	if(AlfaNum.indexOf(n) > -1 || NumPad.indexOf(n) > -1 || dot.indexOf(n) > -1 || allow.indexOf(n) > -1 || arrow.indexOf(n) > -1)
		return true;
	else
		return false;
});

$('.money').live('focusout', function(){
    var val = $.trim($(this).val());
    if(val){
        var exp = val.split(".");
        var stack = new Array();
        var cont = 0;
        for(var i=exp[0].length -1; i>=0; i--){
            if(exp[0][i] != ","){
                stack.push(exp[0][i]);
                cont++;
            }
            if(cont == 3 && exp[0][i-1]){
                cont = 0;
                stack.push(",");
            }
        }
        var final = "";
        for(var j=stack.length -1; j>=0; j--)
            final += (stack[j]);
        $(this).val(final + "." + (exp[1]?exp[1]:"00"));
    }
});

$('.avoid').live('submit', function(){return false;});


