//v.3.0 build 110707

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/
dhtmlXGridObject.prototype.enableDragAndDrop=function(a){a=="temporary_disabled"?(this.dADTempOff=!1,a=!0):this.dADTempOff=!0;this.dragAndDropOff=convertStringToBoolean(a);this._drag_validate=!0;if(a)this.objBox.ondragstart=function(a){(a||event).cancelBubble=!0;return!1}};
dhtmlXGridObject.prototype.setDragBehavior=function(a){this.dadmodec=this.dadmodefix=0;switch(a){case "child":this.dadmode=0;this._sbmod=!1;break;case "sibling":this.dadmode=1;this._sbmod=!1;break;case "sibling-next":this.dadmode=1;this._sbmod=!0;break;case "complex":this.dadmode=2;this._sbmod=!1;break;case "complex-next":this.dadmode=2,this._sbmod=!0}};dhtmlXGridObject.prototype.enableDragOrder=function(a){this._dndorder=convertStringToBoolean(a)};
dhtmlXGridObject.prototype._checkParent=function(a,c){var e=this._h2.get[a.idd].parent;if(e.parent){for(var d=0;d<c.length;d++)if(c[d]==e.id)return!0;return this._checkParent(this.rowsAr[e.id],c)}};
dhtmlXGridObject.prototype._createDragNode=function(a,c){this.editStop();if(window.dhtmlDragAndDrop.dragNode)return null;if(!this.dADTempOff)return null;a.parentObject={};a.parentObject.treeNod=this;var e=this.callEvent("onBeforeDrag",[a.parentNode.idd,a._cellIndex]);if(!e)return null;for(var d=[],d=(d=this.getSelectedId())&&d!=""?d.split(this.delim):[],h=!1,f=0;f<d.length;f++)d[f]==a.parentNode.idd&&(h=!0);if(!h)this.selectRow(this.rowsAr[a.parentNode.idd],!1,c.ctrlKey,!1),c.ctrlKey||(d=[]),d[this.selMultiRows?
d.length:0]=a.parentNode.idd;if(this.isTreeGrid())for(f=d.length-1;f>=0;f--)this._checkParent(this.rowsAr[d[f]],d)&&d.splice(f,1);var g=this;d.length&&this._dndorder&&d.sort(function(a,b){return g.rowsAr[a].rowIndex>g.rowsAr[b].rowIndex?1:-1});var b=this.getFirstParentOfType(_isIE?c.srcElement:c.target,"TD");if(b)this._dndExtra=b._cellIndex;this._dragged=[];for(f=0;f<d.length;f++)if(this.rowsAr[d[f]])this._dragged[this._dragged.length]=this.rowsAr[d[f]],this.rowsAr[d[f]].treeNod=this;a.parentObject.parentNode=
a.parentNode;var j=document.createElement("div");j.innerHTML=e!==!0?e:this.rowToDragElement(a.parentNode.idd);j.style.position="absolute";j.className="dragSpanDiv";return j};dhtmlXGridObject.prototype._createSdrgc=function(){this._sdrgc=document.createElement("DIV");this._sdrgc.innerHTML="&nbsp;";this._sdrgc.className="gridDragLine";this.objBox.appendChild(this._sdrgc)};
function dragContext(a,c,e,d,h,f,g,b,j,k){this.source=a||"grid";this.target=c||"grid";this.mode=e||"move";this.dropmode=d||"child";this.sid=h||0;this.tid=f;this.sobj=g||null;this.tobj=b||null;this.sExtra=j||null;this.tExtra=k||null;return this}dragContext.prototype.valid=function(){if(this.sobj!=this.tobj)return!0;if(this.sid==this.tid)return!1;if(this.target=="treeGrid")for(var a=this.tid;a=this.tobj.getParentId(a);)if(this.sid==a)return!1;return!0};
dragContext.prototype.close=function(){this.tobj=this.sobj=null};dragContext.prototype.copy=function(){return new dragContext(this.source,this.target,this.mode,this.dropmode,this.sid,this.tid,this.sobj,this.tobj,this.sExtra,this.tExtra)};dragContext.prototype.set=function(a,c){this[a]=c;return this};dragContext.prototype.uid=function(){for(this.nid=this.sid;this.tobj.rowsAr[this.nid];)this.nid+=(new Date).valueOf();return this};
dragContext.prototype.data=function(){return this.sobj==this.tobj?this.sobj._getRowArray(this.sobj.rowsAr[this.sid]):this.source=="tree"?this.tobj.treeToGridElement(this.sobj,this.sid,this.tid):this.tobj.gridToGrid(this.sid,this.sobj,this.tobj)};dragContext.prototype.childs=function(){return this.source=="treeGrid"?this.sobj._h2.get[this.sid]._xml_await?this.sobj._h2.get[this.sid].has_kids:null:null};
dragContext.prototype.pid=function(){if(!this.tid)return 0;if(!this.tobj._h2)return 0;if(this.target=="treeGrid")if(this.dropmode=="child")return this.tid;else{var a=this.tobj.rowsAr[this.tid],c=this.tobj._h2.get[a.idd].parent.id;if(this.alfa&&this.tobj._sbmod&&a.nextSibling){var e=this.tobj._h2.get[a.nextSibling.idd].parent.id;if(e==this.tid)return this.tid;if(e!=c)return e}return c}};
dragContext.prototype.ind=function(){if(this.tid==window.unknown)return 0;this.target=="treeGrid"&&(this.dropmode=="child"?this.tobj.openItem(this.tid):this.tobj.openItem(this.tobj.getParentId(this.tid)));var a=this.tobj.rowsBuffer._dhx_find(this.tobj.rowsAr[this.tid]);if(this.alfa&&this.tobj._sbmod&&this.dropmode=="sibling"){var c=this.tobj.rowsAr[this.tid];if(c.nextSibling&&this._h2.get[c.nextSibling.idd].parent.id==this.tid)return a+1}return a+1+(this.target=="treeGrid"&&a>=0&&this.tobj._h2.get[this.tobj.rowsBuffer[a].idd].state==
"minus"?this.tobj._getOpenLenght(this.tobj.rowsBuffer[a].idd,0):0)};dragContext.prototype.img=function(){return this.target!="grid"&&this.sobj._h2?this.sobj.getItemImage(this.sid):null};dragContext.prototype.slist=function(){for(var a=[],c=0;c<this.sid.length;c++)a[a.length]=this.sid[c][this.source=="tree"?"id":"idd"];return a.join(",")};
dhtmlXGridObject.prototype._drag=function(a,c,e,d){if(this._realfake)return this._fake._drag();var h=this.lastLanding;this._autoOpenTimer&&window.clearTimeout(this._autoOpenTimer);var f=e.parentNode,g=a.parentObject;if(!f.idd)f.grid=this,this.dadmodefix=0;var b=new dragContext(0,0,0,f.grid.dadmode==1||f.grid.dadmodec?"sibling":"child");if(g&&g.childNodes)b.set("source","tree").set("sobj",g.treeNod).set("sid",b.sobj._dragged);else{if(!g)return!0;g.treeNod.isTreeGrid&&g.treeNod.isTreeGrid()&&b.set("source",
"treeGrid");b.set("sobj",g.treeNod).set("sid",b.sobj._dragged)}f.grid.isTreeGrid()?b.set("target","treeGrid"):b.set("dropmode","sibling");b.set("tobj",f.grid).set("tid",f.idd);if(b.tobj.dadmode==2&&b.tobj.dadmodec==1&&b.tobj.dadmodefix<0)b.tid=b.tobj.obj.rows[1].idd!=b.tid?f.previousSibling.idd:0;var j=this.getFirstParentOfType(d,"TD");j&&b.set("tExtra",j._cellIndex);j&&b.set("sExtra",b.sobj._dndExtra);b.sobj.dpcpy&&b.set("mode","copy");if(b.tobj._realfake)b.tobj=b.tobj._fake;if(b.sobj._realfake)b.sobj=
b.sobj._fake;b.tobj._clearMove();if(g&&g.treeNod&&g.treeNod._nonTrivialRow)g.treeNod._nonTrivialRow(this,b.tid,b.dropmode,g);else{b.tobj.dragContext=b;if(!b.tobj.callEvent("onDrag",[b.slist(),b.tid,b.sobj,b.tobj,b.sExtra,b.tExtra]))return b.tobj.dragContext=null;var k=[];if(typeof b.sid=="object"){for(var i=b.copy(),l=0;l<b.sid.length;l++)if(i.set("alfa",!l).set("sid",b.sid[l][b.source=="tree"?"id":"idd"]).valid())i.tobj._dragRoutine(i),i.target=="treeGrid"&&i.dropmode=="child"&&i.tobj.openItem(i.tid),
k[k.length]=i.nid,i.set("dropmode","sibling").set("tid",i.nid);i.close()}else b.tobj._dragRoutine(b);b.tobj.laterLink&&b.tobj.laterLink();b.tobj.callEvent("onDrop",[b.slist(),b.tid,k.join(","),b.sobj,b.tobj,b.sExtra,b.tExtra])}b.tobj.dragContext=null;b.close()};
dhtmlXGridObject.prototype._dragRoutine=function(a){if(a.sobj==a.tobj&&a.source=="grid"&&a.mode=="move"&&!this._fake){if(!a.sobj._dndProblematic){var c=a.sobj.rowsAr[a.sid],e=a.sobj.rowsCol._dhx_find(c);a.sobj.rowsCol._dhx_removeAt(a.sobj.rowsCol._dhx_find(c));a.sobj.rowsBuffer._dhx_removeAt(a.sobj.rowsBuffer._dhx_find(c));a.sobj.rowsBuffer._dhx_insertAt(a.ind(),c);if(a.tobj._fake){a.tobj._fake.rowsCol._dhx_removeAt(e);var d=a.tobj._fake.rowsAr[a.sid];d.parentNode.removeChild(d)}a.sobj._insertRowAt(c,
a.ind());a.nid=a.sid;a.sobj.callEvent("onGridReconstructed",[])}}else{var h;this._h2&&typeof a.tid!="undefined"&&a.dropmode=="sibling"&&(this._sbmod||a.tid)?a.alfa&&this._sbmod&&this._h2.get[a.tid].childs.length?(this.openItem(a.tid),h=a.uid().tobj.addRowBefore(a.nid,a.data(),this._h2.get[a.tid].childs[0].id,a.img(),a.childs())):h=a.uid().tobj.addRowAfter(a.nid,a.data(),a.tid,a.img(),a.childs()):h=a.uid().tobj.addRow(a.nid,a.data(),a.ind(),a.pid(),a.img(),a.childs());if(a.source=="tree"){this.callEvent("onRowAdded",
[a.nid]);var f=a.sobj._globalIdStorageFind(a.sid);if(f.childsCount){for(var g=a.copy().set("tid",a.nid).set("dropmode",a.target=="grid"?"sibling":"child"),b=0;b<f.childsCount;b++)a.tobj._dragRoutine(g.set("sid",f.childNodes[b].id)),a.mode=="move"&&b--;g.close()}}else if(a.tobj._copyUserData(a),this.callEvent("onRowAdded",[a.nid]),a.source=="treeGrid"){if(a.sobj==a.tobj)h._xml=a.sobj.rowsAr[a.sid]._xml;var j=a.sobj._h2.get[a.sid];if(j&&j.childs.length){g=a.copy().set("tid",a.nid);a.target=="grid"?
g.set("dropmode","sibling"):(g.tobj.openItem(a.tid),g.set("dropmode","child"));for(var k=j.childs.length,b=0;b<k;b++)if(a.sobj.render_row_tree(null,j.childs[b].id),a.tobj._dragRoutine(g.set("sid",j.childs[b].id)),k!=j.childs.length)b--,k=j.childs.length;g.close()}}if(a.mode=="move"&&(a.sobj[a.source=="tree"?"deleteItem":"deleteRow"](a.sid),a.sobj==a.tobj&&!a.tobj.rowsAr[a.sid]))a.tobj.changeRowId(a.nid,a.sid),a.nid=a.sid}};
dhtmlXGridObject.prototype.gridToGrid=function(a,c){for(var e=[],d=0;d<c.hdr.rows[0].cells.length;d++)e[d]=c.cells(a,d).getValue();return e};dhtmlXGridObject.prototype.checkParentLine=function(a,c){return!this._h2||!c||!a?!1:a.id==c?!0:this.checkParentLine(a.parent,c)};
dhtmlXGridObject.prototype._dragIn=function(a,c,e,d){if(!this.dADTempOff)return 0;var h=this.isTreeGrid(),f=c.parentNode.idd?c.parentNode:c.parentObject;if(this._drag_validate){if(a.parentNode==c.parentNode)return 0;if(h&&this==f.grid&&this.checkParentLine(this._h2.get[a.parentNode.idd],c.parentNode.idd))return 0}if(!this.callEvent("onDragIn",[f.idd||f.id,a.parentNode.idd,f.grid||f.treeNod,a.grid||a.parentNode.grid]))return this._setMove(a,e,d,!0);this._setMove(a,e,d);h&&a.parentNode.expand!=""?(this._autoOpenTimer=
window.setTimeout(new callerFunction(this._autoOpenItem,this),1E3),this._autoOpenId=a.parentNode.idd):this._autoOpenTimer&&window.clearTimeout(this._autoOpenTimer);return a};dhtmlXGridObject.prototype._autoOpenItem=function(a,c){c.openItem(c._autoOpenId)};dhtmlXGridObject.prototype._dragOut=function(a){this._clearMove();var c=a.parentNode.parentObject?a.parentObject.id:a.parentNode.idd;this.callEvent("onDragOut",[c]);this._autoOpenTimer&&window.clearTimeout(this._autoOpenTimer)};
dhtmlXGridObject.prototype._setMove=function(a,c,e,d){if(a.parentNode.idd){var h=getAbsoluteTop(a),f=getAbsoluteTop(this.objBox);if(h-f>parseInt(this.objBox.offsetHeight)-50)this.objBox.scrollTop=parseInt(this.objBox.scrollTop)+20;if(h-f+parseInt(this.objBox.scrollTop)<parseInt(this.objBox.scrollTop)+30)this.objBox.scrollTop=parseInt(this.objBox.scrollTop)-20;if(d)return 0;if(this.dadmode==2){var g=e-h+(document.body.scrollTop||document.documentElement.scrollTop)-2-a.offsetHeight/2;Math.abs(g)-a.offsetHeight/
6>0?(this.dadmodec=1,this.dadmodefix=g<0?-1:1):this.dadmodec=0}else this.dadmodec=this.dadmode;if(this.dadmodec)this._sdrgc||this._createSdrgc(),this._sdrgc.style.display="block",this._sdrgc.style.top=h-f+parseInt(this.objBox.scrollTop)+(this.dadmodefix>=0?a.offsetHeight:0)+"px";else if(this._llSelD=a,a.parentNode.tagName=="TR")for(var b=0;b<a.parentNode.childNodes.length;b++)g=a.parentNode.childNodes[b],g._bgCol=g.style.backgroundColor,g.style.backgroundColor="#FFCCCC"}};
dhtmlXGridObject.prototype._clearMove=function(){if(this._sdrgc)this._sdrgc.style.display="none";if(this._llSelD&&this._llSelD.parentNode.tagName=="TR")for(var a=this._llSelD.parentNode.childNodes,c=0;c<a.length;c++)a[c].style.backgroundColor=a[c]._bgCol;this._llSelD=null};dhtmlXGridObject.prototype.rowToDragElement=function(a){var c=this.cells(a,0).getValue();return c};
dhtmlXGridObject.prototype._copyUserData=function(a){if(!a.tobj.UserData[a.nid]||a.tobj!=a.sobj){a.tobj.UserData[a.nid]=new Hashtable;var c=a.sobj.UserData[a.sid],e=a.tobj.UserData[a.nid];if(c)e.keys=e.keys.concat(c.keys),e.values=e.values.concat(c.values)}};dhtmlXGridObject.prototype.moveRow=function(a,c,e,d){switch(c){case "row_sibling":this.moveRowTo(a,e,"move","sibling",this,d);break;case "up":this.moveRowUp(a);break;case "down":this.moveRowDown(a)}};
dhtmlXGridObject.prototype._nonTrivialNode=function(a,c,e,d,h){if(a.callEvent&&!h&&!a.callEvent("onDrag",[d.idd,c.id,e?e.id:null,this,a]))return!1;for(var f=d.idd,g=f;a._idpull[g];)g+=(new Date).getMilliseconds().toString();var b=this.isTreeGrid()?this.getItemImage(f):"";if(e){for(i=0;i<c.childsCount;i++)if(c.childNodes[i]==e)break;i!=0?e=c.childNodes[i-1]:(st="TOP",e="")}var j=a._attachChildNode(c,g,this.gridToTreeElement(a,g,f),"",b,b,b,"","",e);if(this._h2){var k=this._h2.get[f];if(k.childs.length)for(var i=
0;i<k.childs.length;i++)this._nonTrivialNode(a,j,0,this.rowsAr[k.childs[i].id],1),this.dpcpy||i--}this.dpcpy||this.deleteRow(f);a.callEvent&&!h&&a.callEvent("onDrop",[g,c.id,e?e.id:null,this,a])};dhtmlXGridObject.prototype.gridToTreeElement=function(a,c,e){return this.cells(e,0).getValue()};
dhtmlXGridObject.prototype.treeToGridElement=function(a,c){var e=[],d=this.cellType._dhx_find("tree");d==-1&&(d=0);for(var h=0;h<this.getColumnCount();h++)e[e.length]=h!=d?a.getUserData(c,this.getColumnId(h))||"":a.getItemText(c);return e};dhtmlXGridObject.prototype.moveRowTo=function(a,c,e,d,h,f){var g=new dragContext((h||this).isTreeGrid()?"treeGrid":"grid",(f||this).isTreeGrid()?"treeGrid":"grid",e,d||"sibling",a,c,h||this,f||this);g.tobj._dragRoutine(g);g.close();return g.nid};
dhtmlXGridObject.prototype.enableMercyDrag=function(a){this.dpcpy=convertStringToBoolean(a)};

//v.3.0 build 110707

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/