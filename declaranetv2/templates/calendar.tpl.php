<?function Style($context){?>
<style type ="text/css">
    .label {font-size: 10pt; font-weight: bold; }
    .title {background-color: #2D60AB; color: white; font-weight:bold; }
    .timeline {float: left; width: 30%; height: 200px; margin: 25px 10px; }
    .month-maked {font-size: 11pt; border-collapse: collapse; width: 80%; }
    .month-maked td {padding: 5px; text-align: center;  }
    .blocked {background-color: #C2C4C6; border: 1px solid black; cursor: pointer;}
    .day {background-color: white; border: 1px solid black; cursor: pointer; }
    .data {font-size: 11pt }
    .titleday {font-weight: bold; background-color: #CCE2FE; cursor: default; }
    .active {background-color: #CCE2FE;}
</style>
<? } ?>

<?function Script($context){?>
<script type ="text/javascript">
    
    $(function(){
       Loading();
       $('#calendar').load('calendar.php?action=<?=hideVar('load')?>', function(){
           $('.mask, .loading').remove();
       });
       
       $('#cmbYear').change(function(){
           Loading();
           $('#calendar').load('calendar.php?action=<?=hideVar('load')?>&year=' + $(this).val(), function(){
                $('.mask, .loading').remove();
           });
       });
       
       $('.day').live('mouseenter', function(){
          $(this).addClass('active'); 
       });
       
       $('.day').live('mouseleave', function(){
          $(this).removeClass('active'); 
       });
       
       <?if(in_array(19, $context->allow)){?>
           
       $('.day').live('click', function(){
          var self = $(this);
          $.get('calendar.php?action=<?=hideVar('add')?>&d=' + $(this).attr('id'), function(data){
              if(data)
                 $.msgBox({title: "Error", content: data, type: "error"});
              else{
                 $(self).removeClass('day');
                 $(self).removeClass('active');
                 $(self).addClass('blocked');
              }
          }); 
       });
       
       $('.blocked').live('click', function(){
          var self = $(this);
          $.get('calendar.php?action=<?=hideVar('quit')?>&d=' + $(this).attr('id'), function(data){
              if(data)
                 $.msgBox({title: "Error", content: data, type: "error"});
              else{
                 $(self).removeClass('blocked');
                 $(self).addClass('day');
              }
          }); 
       });
       
       <?}?>
       
    });// END
    
    
</script>
<? } ?>

<?function Body($context){?>
<div class ="section-title"><?=$context->title?> >_</div>
<center>
    <table>
        <tr>
            <td>Mostrar año: </td>
            <td>
                <select id = "cmbYear">
                    <?if($context->min){?>
                        <?for($i=Date('Y')+1; $i>=$context->min; $i--){?>
                                <option value = "<?=$i?>" <?=($i==Date('Y')?"selected":"")?>><?=$i?></option>
                        <?}?>
                    <?}else{?>
                        <option value = "<?=Date('Y')?>"><?=Date('Y')?></option>
                    <?}?>
                </select>
            </td>
        </tr>
    </table>
    <div id ="calendar"></div>
</center>

<? } ?>