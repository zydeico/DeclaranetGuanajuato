//v.3.0 build 110707

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/
dhtmlXGridObject.prototype._process_json_row=function(r, data){
		r._attrs=data;
		for (var j = 0; j < r.childNodes.length; j++)r.childNodes[j]._attrs={
		};
		if (data.userdata)
			for (var a in data.userdata)
				this.setUserData(r.idd,a,data.userdata[a])
				
		for (var i=0; i<data.data.length; i++)
			if (typeof data.data[i] == "object" && data.data[i] != null){
				r.childNodes[i]._attrs=data.data[i];
				if (data.data[i].type) r.childNodes[i]._cellType=data.data[i].type;
				data.data[i]=data.data[i].value;
				
			}
		this._fillRow(r, (this._c_order ? this._swapColumns(data.data) : data.data));
		return r;
}	
dhtmlXGridObject.prototype._process_json=function(data){
		this._parsing=true;
		try {
		if (data&&data.xmlDoc)
			eval("data="+data.xmlDoc.responseText+";");
		else if (typeof data == "string")
			eval("data="+data+";");
		} catch(e){
				dhtmlxError.throwError("LoadXML", "Incorrect JSON", [
					(data.xmlDoc||data),
					this
				]);
				data = {rows:[]};
		}
			
			
		var cr = parseInt(data.pos||0);
		var total = parseInt(data.total_count||0);
		
		var reset = false;
		if (total){
			if (!this.rowsBuffer[total-1]){
				if (this.rowsBuffer.length)
					reset=true;
			this.rowsBuffer[total-1]=null;
			} 
			if (total<this.rowsBuffer.length){
				this.rowsBuffer.splice(total, this.rowsBuffer.length - total);
				reset = true;
			}
		}
			
		for (var key in data){
			if (key!="rows")
				this.setUserData("",key, data[key]);
		}
		
		if (this.isTreeGrid())
			return this._process_tree_json(data);
			
		for (var i = 0; i < data.rows.length; i++){
			if (this.rowsBuffer[i+cr])
				continue;
			var id = data.rows[i].id;
			this.rowsBuffer[i+cr]={
				idd: id,
				data: data.rows[i],
				_parser: this._process_json_row,
				_locator: this._get_json_data
				};
	
			this.rowsAr[id]=data.rows[i];
		//this.callEvent("onRowCreated",[r.idd]);
		}
		
		if (reset && this._srnd){
			var h = this.objBox.scrollTop;
			this._reset_view();
			this.objBox.scrollTop = h;
		} else {
			this.render_dataset();
		}
		
		this._parsing=false;
}

dhtmlXGridObject.prototype._get_json_data=function(data, ind){
	if (typeof data.data[ind] == "object")
		return data.data[ind].value;
	else
		return data.data[ind];
};

dhtmlXGridObject.prototype._process_tree_json=function(data,top,pid){
	this._parsing=true;
	var main=false;
	if (!top){
		this.render_row=this.render_row_tree;
		main=true;
		top=data;
		pid=top.parent||0;
		if (pid=="0") pid=0;
		if (!this._h2)	 this._h2=new dhtmlxHierarchy();
		if (this._fake) this._fake._h2=this._h2;
	} 
	
	if (top.rows) 
	for (var i = 0; i < top.rows.length; i++){
			var id = top.rows[i].id;
			var row=this._h2.add(id,pid);
			row.buff={ idd:id, data:top.rows[i], _parser: this._process_json_row, _locator:this._get_json_data };
			if (top.rows[i].open)
			    row.state="minus";
			
			this.rowsAr[id]=row.buff;
		    this._process_tree_json(top.rows[i],top.rows[i],id);
	}
		
	if (main){ 
		
		if (pid!=0) this._h2.change(pid,"state","minus")
		this._updateTGRState(this._h2.get[pid]);
		this._h2_to_buff();
		
		if (pid!=0 && (this._srnd || this.pagingOn))
			this._renderSort();
		else
			this.render_dataset();
		
		
	
		if (this._slowParse===false){
			this.forEachRow(function(id){
				this.render_row_tree(0,id)
			})
		}
		this._parsing=false;
	}
	
}	
