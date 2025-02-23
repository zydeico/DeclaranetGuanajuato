//v.3.0 build 110707

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/
dhtmlXGridObject.prototype._in_header_collapse=function(t,i,c){
	var rt=t.tagName=="TD"?t:t.parentNode;
	i=rt._cellIndexS;
	if (!this._column_groups) this._column_groups=[];
	var cols=c[1].split(":")
	var count = parseInt(cols[0]); 
	t.innerHTML=c[0]+"<img src='"+this.imgURL+"minus.gif' style='padding-right:10px;'/><span style='position:relative; top:-6px;'>"+(cols[1]||"")+"<span>";
	t.style.paddingBottom='0px';
	var self = this;
	this._column_groups[i]=t.getElementsByTagName("IMG")[0];
	this._column_groups[i].onclick=function(e){
		(e||event).cancelBubble=true;
		this._cstate=!this._cstate;
		for (var j=i+1; j<(i+count); j++)
			self.setColumnHidden(j,this._cstate)
		if (this._cstate){
			if (rt.colSpan && rt.colSpan>0) {
				rt._exp_colspan=rt.colSpan;
				var delta=Math.max(1,rt.colSpan-count)
				if (!_isFF || window._KHTMLrv) //create additional cells to compensate colspan
				for (var z=0; z<rt.colSpan-delta; z++){
					var td=document.createElement("TD");
					if (rt.nextSibling)
						rt.parentNode.insertBefore(td,rt.nextSibling);
					else
						rt.parentNode.appendChild(td);
				}	
				rt.colSpan=delta;
			}
		} else 
			if (rt._exp_colspan){
				rt.colSpan=rt._exp_colspan;
				if (!_isFF || window._KHTMLrv)
				for (var z=1; z<rt._exp_colspan; z++)
					rt.parentNode.removeChild(rt.nextSibling);
			}
		this.src=self.imgURL+(this._cstate?"plus.gif":"minus.gif");
		
		if (self.sortImg.style.display!="none")
			self.setSortImgPos();		
	}	
}
dhtmlXGridObject.prototype.collapseColumns=function(ind){
	if (!this._column_groups[ind]) return;
	this._column_groups[ind]._cstate=false;
	this._column_groups[ind].onclick({});
}
dhtmlXGridObject.prototype.expandColumns=function(ind){
	if (!this._column_groups[ind]) return;
	this._column_groups[ind]._cstate=true;
	this._column_groups[ind].onclick({});
}
