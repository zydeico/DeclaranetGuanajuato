//v.3.0 build 110707

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/

/*
HTML Link eXcell v.1.0  for dhtmlxGrid 
(c)DHTMLX LTD. 2005


The corresponding  cell value in XML should be a "^" delimited list of following values:
1st - Link Text 
2nd - URL (optional)
3rd - target (optional, default is _blank)

Samples:
<cell>Stephen King</cell>
<cell>Stephen King^http://www.stephenking.com/</cell>
<cell>Stephen King^http://www.stephenking.com/^_self</cell>
*/

/**
*	@desc: link editor
*	@returns: dhtmlxGrid cell editor object
*	@type: public
*/

function eXcell_link(cell){
	this.cell = cell;
    this.grid = this.cell.parentNode.grid;
    this.isDisabled=function(){return true;}
	this.edit = function(){}
	this.getValue = function(){
		if(this.cell.firstChild.getAttribute)
			return this.cell.firstChild.innerHTML+"^"+this.cell.firstChild.getAttribute("href")
		else
			return "";
	}
	this.setValue = function(val){
		if((typeof(val)!="number") && (!val || val.toString()._dhx_trim()=="")){		
			this.setCValue("&nbsp;",valsAr);			
			return (this.cell._clearCell=true);
		}
		var valsAr = val.split("^");
		if(valsAr.length==1)
			valsAr[1] = "";
		else{
			if(valsAr.length>1){
				valsAr[1] = "href='"+valsAr[1]+"'";
				if(valsAr.length==3)
					valsAr[1]+= " target='"+valsAr[2]+"'";
				else
					valsAr[1]+= " target='_blank'";
			}
		}

		this.setCValue("<a "+valsAr[1]+" onclick='(_isIE?event:arguments[0]).cancelBubble = true;'>"+valsAr[0]+"</a>",valsAr);
	}
}

eXcell_link.prototype = new eXcell;
eXcell_link.prototype.getTitle=function(){
	var z=this.cell.firstChild;
	return ((z&&z.tagName)?z.getAttribute("href"):"");
}
eXcell_link.prototype.getContent=function(){
	var z=this.cell.firstChild;
	return ((z&&z.tagName)?z.innerHTML:"");
}
//(c)dhtmlx ltd. www.dhtmlx.com
