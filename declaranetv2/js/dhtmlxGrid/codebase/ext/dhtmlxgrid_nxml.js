//v.3.0 build 110707

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/
dhtmlXGridObject.prototype.loadCSVFile=function(b,d){this.load(b,d,"csv")};dhtmlXGridObject.prototype.enableCSVAutoID=function(b){this._csvAID=convertStringToBoolean(b)};dhtmlXGridObject.prototype.enableCSVHeader=function(b){this._csvHdr=convertStringToBoolean(b)};dhtmlXGridObject.prototype.setCSVDelimiter=function(b){this.csv.cell=b};dhtmlXGridObject.prototype._csvAID=!0;dhtmlXGridObject.prototype.loadCSVString=function(b){this.parse(b,"csv")};
dhtmlXGridObject.prototype.serializeToCSV=function(b){this.editStop();this._agetm=this._mathSerialization?"getMathValue":this._strictText||b?"getTitle":"getValue";var d=[];if(this._csvHdr)for(var c=1;c<this.hdr.rows.length;c++){for(var e=[],a=0;a<this._cCount;a++)(!this._srClmn||this._srClmn[a])&&e.push(this.getColumnLabel(a,c-1));d.push(this.csvParser.str(e,this.csv.cell,this.csv.row))}for(var a=0,j=this.rowsBuffer.length;a<j;a++){var f=this._serializeRowToCVS(null,a);f!=""&&d.push(f)}return this.csvParser.block(d,
this.csv.row)};
dhtmlXGridObject.prototype._serializeRowToCVS=function(b,d,c,e){var a=[];b||(b=this.render_row(d),this._fake&&!this._fake.rowsAr[b.idd]&&this._fake.render_row(d));if(!this._csvAID)a[a.length]=b.idd;for(var c=c||0,e=e||this._cCount,j=!1,f=c;b.childNodes[c]._cellIndex>f&&c;)c--;for(var k=c;f<e;k++){if(!b.childNodes[k])break;var i=b.childNodes[k]._cellIndex;if(!this._srClmn||this._srClmn[i]){for(var h=b.childNodes[k],l=this.cells(b.idd,i);f!=i;)if(f++,a.push(""),f>=e)break;if(f>=e)break;f++;zxVal=l.cell?
l[this._agetm]():"";this._chAttr&&l.wasChanged()&&(j=!0);a[a.length]=zxVal===null?"":zxVal;if(this._ecspn&&h.colSpan&&h.colSpan>1)for(var h=h.colSpan-1,g=0;g<h;g++)a[a.length]="",f++}else f++}return this._onlChAttr&&!j?"":this.csvParser.str(a,this.csv.cell,this.csv.row)};dhtmlXGridObject.prototype.toClipBoard=function(b){window.clipboardData?window.clipboardData.setData("Text",b):(new Clipboard).copy(b)};
dhtmlXGridObject.prototype.fromClipBoard=function(){return window.clipboardData?window.clipboardData.getData("Text"):(new Clipboard).paste()};dhtmlXGridObject.prototype.cellToClipboard=function(b,d){if(!b||!d){if(!this.selectedRows[0])return;b=this.selectedRows[0].idd;d=this.cell._cellIndex}var c=this.cells(b,d);this.toClipBoard(((c.getLabel?c.getLabel():c.getValue())||"").toString())};
dhtmlXGridObject.prototype.updateCellFromClipboard=function(b,d){if(!b||!d){if(!this.selectedRows[0])return;b=this.selectedRows[0].idd;d=this.cell._cellIndex}var c=this.cells(b,d);c[c.setImage?"setLabel":"setValue"](this.fromClipBoard())};
dhtmlXGridObject.prototype.rowToClipboard=function(b){var d="";this._agetm=this._mathSerialization?"getMathValue":this._strictText?"getTitle":"getValue";if(b)d=this._serializeRowToCVS(this.getRowById(b));else for(var c=[],e=0;e<this.selectedRows.length;e++)c[c.length]=this._serializeRowToCVS(this.selectedRows[e]),d=this.csvParser.block(c,this.csv.row);this.toClipBoard(d)};
dhtmlXGridObject.prototype.updateRowFromClipboard=function(b){var d=this.fromClipBoard();if(d){var c=b?this.getRowById(b):this.selectedRows[0];if(c){var e=this.csvParser,d=e.unblock(d,this.csv.cell,this.csv.row)[0];this._csvAID||d.splice(0,1);for(var a=0;a<d.length;a++){var j=this.cells3(c,a);j[j.setImage?"setLabel":"setValue"](d[a])}}}};
dhtmlXGridObject.prototype.csvParser={block:function(b,d){return b.join(d)},unblock:function(b,d,c){for(var e=(b||"").split(c),a=0;a<e.length;a++)e[a]=(e[a]||"").split(d);return e},str:function(b,d){return b.join(d)}};
dhtmlXGridObject.prototype.csvExtParser={_quote:RegExp('"',"g"),_quote_esc:RegExp('\\\\"',"g"),block:function(b,d){return b.join(d)},unblock:function(b,d,c){var e=[[]],a=0;if(!b)return e;for(var j=/^[ ]*"/,f=/"[ ]*$/,k=RegExp(".*"+c+".*$"),i=b.split(d),h=0;h<i.length;h++)if(i[h].match(j)){for(var l=i[h].replace(j,"");!i[h].match(f);)h++,l+=i[h];e[a].push(l.replace(f,"").replace(this._quote_esc,'"'))}else if(i[h].match(k)){var g=i[h].split(c,2);e[a].push(g[0]);a++;e[a]=[];i[h]=g[1];h--}else(i[h]||
h!=i.length-1)&&e[a].push(i[h]);return e},str:function(b,d){for(var c=0;c<b.length;c++)b[c]='"'+b[c].replace(this._quote,'\\"')+'"';return b.join(d)}};dhtmlXGridObject.prototype.addRowFromClipboard=function(){var b=this.fromClipBoard();if(b)for(var d=this.csvParser.unblock(b,this.csv.cell,this.csv.row),c=0;c<d.length;c++)d[c]&&(b=d[c],b.length&&(this._csvAID?this.addRow(this.getRowsNum()+2,b):(this.rowsAr[b[0]]&&(b[0]=this.uid()),this.addRow(b[0],b.slice(1)))))};
dhtmlXGridObject.prototype.gridToClipboard=function(){this.toClipBoard(this.serializeToCSV())};dhtmlXGridObject.prototype.gridFromClipboard=function(){var b=this.fromClipBoard();b&&this.loadCSVString(b)};
dhtmlXGridObject.prototype.getXLS=function(b){if(!this.xslform){this.xslform=document.createElement("FORM");this.xslform.action=(b||"")+"xls.php";this.xslform.method="post";this.xslform.target=_isIE?"_blank":"";document.body.appendChild(this.xslform);var d=document.createElement("INPUT");d.type="hidden";d.name="csv";this.xslform.appendChild(d);var c=document.createElement("INPUT");c.type="hidden";c.name="csv_header";this.xslform.appendChild(c)}var e=this.serializeToCSV();this.xslform.childNodes[0].value=
e;for(var a=[],j=this._cCount,f=0;f<j;f++)a.push(this.getHeaderCol(f));a=a.join(",");this.xslform.childNodes[1].value=a;this.xslform.submit()};
dhtmlXGridObject.prototype.printView=function(b,d){var c="<style>TD { font-family:Arial; text-align:center; padding-left:2px;padding-right:2px; } \n td.filter input, td.filter select { display:none; }\t\n  </style>",e=null;if(this._fake)for(var e=[].concat(this._hrrar),a=0;a<this._fake._cCount;a++)this._hrrar[a]=null;c+="<base  href='"+document.location.href+"'></base>";this.parentGrid||(c+=b||"");c+='<table width="100%" border="2px" cellpadding="0" cellspacing="0">';var j=Math.max(this.rowsBuffer.length,
this.rowsCol.length),f=this._cCount,k=this._printWidth();c+='<tr class="header_row_1">';for(a=0;a<f;a++)if(!this._hrrar||!this._hrrar[a]){for(var i=this.hdr.rows[1].cells[this.hdr.rows[1]._childIndexes?this.hdr.rows[1]._childIndexes[parseInt(a)]:a],h=i.colSpan||1,l=i.rowSpan||1,g=1;g<h;g++)k[a]+=k[g];c+='<td rowspan="'+l+'" width="'+k[a]+'%" style="background-color:lightgrey;" colspan="'+h+'">'+this.getHeaderCol(a)+"</td>";a+=h-1}c+="</tr>";for(a=2;a<this.hdr.rows.length;a++)if(_isIE){c+="<tr style='background-color:lightgrey' class='header_row_"+
a+"'>";for(var p=this.hdr.rows[a].childNodes,g=0;g<p.length;g++)if(!this._hrrar||!this._hrrar[p[g]._cellIndex])c+=p[g].outerHTML;c+="</tr>"}else c+="<tr class='header_row_"+a+"' style='background-color:lightgrey'>"+(this._fake?this._fake.hdr.rows[a].innerHTML:"")+this.hdr.rows[a].innerHTML+"</tr>";for(a=0;a<j;a++)if(c+="<tr>",this.rowsCol[a]&&this.rowsCol[a]._cntr)c+=this.rowsCol[a].innerHTML.replace(/<img[^>]*>/gi,"")+"</tr>";else if(!(this.rowsCol[a]&&this.rowsCol[a].style.display=="none")){var n;
if(this.rowsCol[a])n=this.rowsCol[a].idd;else if(this.rowsBuffer[a])n=this.rowsBuffer[a].idd;else continue;for(g=0;g<f;g++)if(!this._hrrar||!this._hrrar[g]){if(this.rowsAr[n]&&this.rowsAr[n].tagName=="TR")var m=this.cells(n,g),q=m._setState?"":m.getContent?m.getContent():m.getImage||m.combo?m.cell.innerHTML:m.getValue();else q=this._get_cell_value(this.rowsBuffer[a],g);var t=this.columnColor[g]?"background-color:"+this.columnColor[g]+";":"",u=this.cellAlign[g]?"text-align:"+this.cellAlign[g]+";":
"",o=m.getAttribute("colspan");c+='<td style="'+t+u+'" '+(o?'colSpan="'+o+'"':"")+">"+(q===""?"&nbsp;":q)+"</td>";o&&(g+=o-1)}c+="</tr>";if(this.rowsCol[a]&&this.rowsCol[a]._expanded){var s=this.cells4(this.rowsCol[a]._expanded.ctrl);c+=s.getSubGrid?'<tr><td colspan="'+f+'">'+s.getSubGrid().printView()+"</td></tr>":'<tr><td colspan="'+f+'">'+this.rowsCol[a]._expanded.innerHTML+"</td></tr>"}}if(this.ftr)for(a=1;a<this.ftr.childNodes[0].rows.length;a++)c+="<tr style='background-color:lightgrey'>"+(this._fake?
this._fake.ftr.childNodes[0].rows[a].innerHTML:"")+this.ftr.childNodes[0].rows[a].innerHTML+"</tr>";c+="</table>";if(this.parentGrid)return c;c+=d||"";var r=window.open("","_blank");r.document.write(c);r.document.write("<script>window.onerror=function(){return true;}<\/script>");r.document.close();if(this._fake)this._hrrar=e};
dhtmlXGridObject.prototype._printWidth=function(){for(var b=[],d=0,c=0;c<this._cCount;c++){var e=this.getColWidth(c);b.push(e);d+=e}for(var a=[],j=0,c=0;c<b.length;c++){var f=Math.floor(b[c]/d*100);j+=f;a.push(f)}a[a.length-1]+=100-j;return a};dhtmlXGridObject.prototype.loadObject=function(){};dhtmlXGridObject.prototype.loadJSONFile=function(){};dhtmlXGridObject.prototype.serializeToObject=function(){};dhtmlXGridObject.prototype.serializeToJSON=function(){};
if(!window.clipboardData)window.clipboardData={_make:function(){var b=Components.classes["@mozilla.org/widget/clipboard;1"].createInstance(Components.interfaces.nsIClipboard);if(!b)return null;var d=Components.classes["@mozilla.org/widget/transferable;1"].createInstance(Components.interfaces.nsITransferable);if(!d)return null;d.addDataFlavor("text/unicode");var c=Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);this._p=[b,d,c];return!0},
setData:function(b,d){try{netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect")}catch(c){return dhtmlxError.throwError("Clipboard","Access to clipboard denied",[b,d]),""}if(!this._make())return!1;this._p[2].data=d;this._p[1].setTransferData("text/unicode",this._p[2],d.length*2);var e=Components.interfaces.nsIClipboard;this._p[0].setData(this._p[1],null,e.kGlobalClipboard)},getData:function(b){try{netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect")}catch(d){return dhtmlxError.throwError("Clipboard",
"Access to clipboard denied",[b]),""}if(!this._make())return!1;this._p[0].getData(this._p[1],this._p[0].kGlobalClipboard);var c={},e={};try{this._p[1].getTransferData("text/unicode",e,c)}catch(a){return""}e&&(e=e.value.QueryInterface(Components.interfaces.nsISupportsString));return e?e.data.substring(0,c.value/2):""}};

//v.3.0 build 110707

/*
Copyright DHTMLX LTD. http://www.dhtmlx.com
To use this component please contact sales@dhtmlx.com to obtain license
*/