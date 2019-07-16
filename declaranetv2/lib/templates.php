<?

class Context{
    var $__excludedVariables = array('__excludedVariables');

    function __initialize__($arrayOfValues=NULL){
        if($arrayOfValues){
            foreach($arrayOfValues as $Variable => $Value)
                $this->$Variable = $Value;
        }
    }
    
    function GetVariables(){
        $Variables = array();
        foreach( get_object_vars($this) as $Variable => $Value ){
            if( !in_array($Variable, $this->__excludedVariables) )
                $Variables[$Variable] =$Value;
        }
        return $Variables;
    }
}

function RenderTemplate($templatePath, $context=NULL, $masterTemplatePath=NULL){   
	Header('Expires:Mon, 26 Jul 1997 05:00:00 GMT');
	Header('Cache-Control: no-cache');
	Header('Pragma: no-cache');
	if($masterTemplatePath){
        include($templatePath);
        include($masterTemplatePath);
    }else{
        include($templatePath);
    }
}

?>
