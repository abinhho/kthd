var dcom,Editor;
$(document).ready(function(){
Editor = document.getElementById('textbox').contentWindow.document;
var Editor_win = document.getElementById('textbox').contentWindow;
var old_noi_dung="";
var new_noi_dung="";
var bookmark=[];
var Editor_body=$(Editor).find("body");
var height_editor=200;

function setforcus()
{
	document.getElementById('textbox').contentWindow.focus(); 
	$("textarea[name='"+name_tbeditor+"']").val($(Editor_body).html());
	preview_html();
}
$(Editor).click(function(){
	Editor.designMode = "on";
});
$('#box_editor #editor_top').click(function(e){
	e.preventDefault();
});
function setunforcus()
{ $(Editor_body).attr('ContentEditable','false'); }

Format = function (action)
{
	Editor.execCommand(action, false, null);
	 setforcus();
	 return false;
}
 
FontColor = function (colour)
{		
	Editor.execCommand("forecolor",false, colour);
	 setforcus();
	 return false;
}
HiliteColor = function (colour)
{		
	Editor.execCommand("hiliteColor",false, colour);
	$(Editor_body).find("span").filter(function() {
		return $(this).css('background-color') != "";
	}).css({'padding':'4px','margin':'0 2px'});
	 setforcus();
	 return false;
}

InsertImage =function (path)
{		
	Editor.execCommand("InsertImage",false, path);
	 setforcus();
	 return false;
}
SetFontSize = function (size)
{		
	Editor.execCommand("FontSize",false, size);
	 setforcus();
	 return false;
}
 SetFont = function(font)
{		
	Editor.execCommand("fontName",false, font);
	 setforcus();
	 return false;
}
 checkselect =function(){
var txt='';
if(self.parent.frames[0].getSelection())
{
txt=self.parent.frames[0].getSelection()
} else
{
txt=self.parent.frames[0].selection.createRange();
}
return txt; 
} 
undo =function()
{	
	Editor.execCommand("undo",false);
	setforcus();
	return false;
}
redo =function()
{	
	Editor.execCommand("redo",false);
	setforcus();
	return false;
}
AddLink =function()
{	
	var src = prompt("Add link", "http://");
	Editor.execCommand("CreateLink",false,src);
	setforcus();
	return false;
}
Unlink =function()
{		
	Editor.execCommand("unlink",false,false);
	 setforcus();
	 return false;
}
IndentTextC =function()
{		
	Editor.execCommand("indent",false,10);
	 setforcus();
	 return false;
}
IndentTextT =function()
{		
	Editor.execCommand("outdent",false,-10);
	 setforcus();
	 return false;
}
 NumOrderList = function()
{		
	Editor.execCommand("insertOrderedList",false,false);
	 setforcus();
	 return false;
}
 UnNumOrderList =function()
{		
	Editor.execCommand("insertUnorderedList",false,false);
	 setforcus();
	 return false;
}
 removeFormat = function()
{		
	Editor.execCommand("RemoveFormat",false,false);
	setforcus();
	 return false;
}
 StrikeThrough=function()
{		
	Editor.execCommand("StrikeThrough",false,false);
	setforcus();
	 return false;
}
doImage = function ()
{
var imgSrc = prompt('Enter image location', '');
if(imgSrc != null)
Editor.execCommand('insertimage', false, imgSrc);
return false;
}

$(Editor).keydown(function(e) {

		var keycode =e.keyCode;
		 if ($.browser.mozilla) {
            if (e.ctrlKey) {
                if (e.preventDefault)
                {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }
        }
        // IE
        else if ($.browser.msie) {
            if (window.event.ctrlKey) {
                window.event.returnValue = false;
                window.event.keyCode = 0;
                window.status = "Refresh is disabled";
			}
		}
        if(e.ctrlKey)
		{
			if (e.keyCode == 66) {
				Format('bold');
			}
			else if (e.keyCode == 73) {
				Format('italic');
			}
			else if (e.keyCode == 85) {
				Format('underline');
			}
			else if (e.keyCode == 76) {
				StrikeThrough();
			}
		}
});

function parentElement()
{ 
	var sel = Editor.getSelection();
		var range = sel.getRangeAt(0);
		var parentElement = range.commonAncestorContainer;
		if (parentElement.nodeType == 3) {
				parentElement = parentElement.parentNode;
		}
		return parentElement;
}


function get_cursor_pos_all() {

ctrl = document.getElementById('textbox').contentWindow;
	var sel=ctrl.getSelection();
		range = sel.getRangeAt(0);
			preCaretRange = range.cloneRange();
				preCaretRange.selectNodeContents(Editor);
				preCaretRange.setEnd(range.endContainer, range.endOffset);
				caretOffset = preCaretRange.toString().length;
				return (caretOffset);
			
}

function addBookmark()
{ 
	var sel=Editor.getSelection();
		range = sel.getRangeAt(0);
			preCaretRange = range.cloneRange();
				preCaretRange.selectNodeContents(Editor);
				preCaretRange.setEnd(range.endContainer, range.endOffset);
				caretOffset = preCaretRange.toString().length; 
				bookmark['start']=parseInt(caretOffset-get_length_selection());
				bookmark['end']=parseInt(caretOffset);
}
var sss,rrr,pos,range;
// function 
dig = function(el,start,end){
	// alert(sss);
	
	$(el).contents().each(function(i,e){ 
        if (e.nodeType==1){
           dig(e,start,end);   
        }else{ 
            if (pos<start){
               if (pos+e.length>=start){
                range.setStart(e, start-pos); 
               }
            }
            
            if (pos<end){
               if (pos+e.length>=end){
                range.setEnd(e, end-pos);
               }
            }            
            pos = pos+e.length;
        }
    });  
}


highlight = function(opt){
	
	rrr = Editor.createRange();
	sss = Editor.getSelection();
	pos = 0;
	var default_={ 
	element:$(Editor)
	,st:bookmark['start'],
	en:bookmark['end']
	};
	var opt= $.extend({},default_,opt);
	
	range = Editor.createRange();
	dig(opt.element,opt.st,opt.en);
	sss.removeAllRanges();
	sss.addRange(range);
    setforcus();
}

var storedSelections = [];
var rangeObj;

function SaveSelection (idx) {
            if (Editor.getSelection) {  // all browsers, except IE before version 9
                var selection = Editor.getSelection ();
                if (selection.rangeCount > 0) {
                    storedSelections[idx] = selection.getRangeAt (0);
                }
            }
            else {
                if (Editor.selection) {   // Internet Explorer
                    var range = Editor.selection.createRange ();
                    storedSelections[idx] = range.getBookmark ();
                }
            }
        }


function RestoreSelection (idx) {
            if (Editor.getSelection) {  // all browsers, except IE before version 9
                Editor.getSelection ().removeAllRanges ();
                Editor.getSelection ().addRange (storedSelections[idx]);
            }
            else {
                if (Editor_body.createTextRange) {    // Internet Explorer
                    rangeObj = Editor_body.createTextRange ();
                    rangeObj.moveToBookmark (storedSelections[idx]);
                    rangeObj.select ();
                }
            }
}


function get_cursor_pos_tag(s) {

	
	var sel=Editor.getSelection();
		range = sel.getRangeAt(0);
		if(s=="start")
		return range.startOffset;
		else
		return range.endOffset;
			
}
function get_length_selection() {
	
		ctrl = document.getElementById('textbox').contentWindow;
		var sel=ctrl.getSelection().getRangeAt(0);
		return sel.toString().length;		
}
function get_text_curr_tag() {

		return $(parentElement()).text();
}
function get_html_curr_tag() {

		return $(parentElement()).html();
}

function get_length_curr_tag()
{
	return $(parentElement()).text().length;
}

getCurrent_node = function(type) //ok
{
	
	if(type=="index")
	return $(parentElement()).index();
	return parentElement().nodeName;

}

set_id_curr_tag = function(id)
{
	if(parentElement().nodeName=="P")
	$(parentElement()).attr('id',id); 
	else
	{
		if($(parentElement()).parents("p").length>0)
		$(parentElement()).parents("p").attr('id',id);
		else
		$(parentElement()).parentsUntil('body,blockquote').attr('id',id); 
		
	}
}


set_setStartAfter_curr_tag = function()
{
	
	var sel = Editor.getSelection();
	if (sel.rangeCount > 0) {
		var range = sel.getRangeAt(0);
		
		var referenceNode = Editor.getElementsByTagName(getCurrent_node("")).item(getCurrent_node("index"));
		range.setStartAfter(referenceNode); //alert('DAS');
	}
}

set_setStartAfter = function(id)
{
	if(getCurrent_node('')=='BODY' && old_noi_dung != new_noi_dung){
			addBookmark();
			//$('input').val(bookmark['start']);
			highlight({});
	}
	$(Editor).find("*").removeAttr("id");
}
function check_parent(p)
{
	if(parentElement().tagName.toUpperCase()==p)
	return true;
	else
	return $(parentElement()).parents(p).length;
}

function check_active()
{ 
	var list=["b","u","i","strike","ul","ol","code","blockquote","sub","sup"];
	for(var i=0;i<list.length;i++)
	{ 
		if(check_parent(list[i].toUpperCase()))
		{
			$("#editor_top").children('.'+list[i]).addClass('active');
		}
		else
		{
			$("#editor_top").children('.'+list[i]).removeClass('active');
		}
	}
}


$(Editor_body).mousedown(function(){
	if(get_length_selection()==0)
	check_active();
	
});

function check_parent_by_id(cl,p)
{	
	if( $(Editor).find('#'+cl).parents(p).length>0)
	return true;
	return false;
}

function check_next(p)
{
	return $(parentElement()).next(p).length;
}
function check_prev(p)
{
	return $(parentElement()).prev(p).length;
}

$(Editor_body).keydown(function(e){
	old_noi_dung= $(Editor_body).html();
});
preview_html=function(){
	$('.preview_noi_dung').html( $(Editor_body).html());
}
$(Editor_body).keyup(function(e){
	new_noi_dung= $(Editor_body).html();
	check_active();
	if(e.keyCode!=13){
		
		var id='i'+Math.random();	var ok=false;
		var p= $(this).contents()
		.filter(function(){
			//alert(this.nodeName);
			if(this.nodeType === 3)
			{
				ok=true;
				return true;
			}
				return false;
		})
		.wrap("<p id='"+id+"'>")
		if(ok)
		set_setStartAfter(id);
	}
	else
	{
		var tag = getCurrent_node('');
		var index = getCurrent_node('index');
		$(Editor_body).find(tag).children('br:last').remove();
	}
	
	//alert($(Editor_body).html());
	//preview_html();
	setforcus();
});
function getSelectionHtml() {
    var html = "";
    if (typeof Editor.getSelection != "undefined") {
        var sel = Editor.getSelection();
        if (sel.rangeCount) {
            var container = Editor.createElement("div");
            for (var i = 0, len = sel.rangeCount; i < len; ++i) {
                container.appendChild(sel.getRangeAt(i).cloneContents());
            }
            html = container.innerHTML;
        }
    } else if (typeof Editor.selection != "undefined") {
        if (Editor.selection.type == "Text") {
            html = Editor.selection.createRange().htmlText;
        }
    }
    return html;
}
 function GetSelectedText () {
            if (Editor.getSelection) {  // all browsers, except IE before version 9
                var range = Editor.getSelection ();                                        
                return range.toString ();
            } 
            else {
                if (Editor.selection.createRange) { // Internet Explorer
                    var range = Editor.selection.createRange ();
                    return range.text;
                }
            }
        }
function remove_tag_st_en(st,en,tag)
{	
	var ok=false;
	for(var i=st;i<=en;i++)
	{
		highlight({st:i,en:i});
		if(getCurrent_node()== tag)
		{	
			$(parentElement()).contents().unwrap(tag);
			ok=true;
		}
	}
	return ok;
}

function insertTextAtCursor(text) {
    var sel, range, html;
    if (Editor.getSelection) {
		sel = Editor.getSelection();
        if (sel.getRangeAt && sel.rangeCount && bookmark['start']>0) {
            range = sel.getRangeAt(0);
            range.deleteContents();
            range.insertNode( Editor.createTextNode(text) );
        }
		else if(bookmark['start']==0)
		{
			$(Editor_body).html(text+$(Editor_body).html());
		}
    } else if (Editor.selection && Editor.selection.createRange) {
        Editor.selection.createRange().text = text;
    }
}
close_promt_editor_special_char = function(){
	$("#promt_editor_special_char").hide();
	$("#promt_add_code").hide();
}
special_char=function(){
	addBookmark();
	var this_=$("#promt_editor_special_char");
	this_.css({top:$(document).scrollTop()+100+'px'}).fadeIn();
	this_.find(".left span").unbind('click');
	this_.find(".left span").hover(function(){
		this_.find(".right").text($(this).text());
	}).click(function(){
		insertTextAtCursor($(this).text());
		highlight({st:bookmark['end']+1,en:bookmark['end']+1});
		close_promt_editor_special_char();
	});
	this_.find("a.close").click(function(){
		close_promt_editor_special_char();
	});
}
function pasteHtmlAtCaret(html) {
    var sel, range;
    if (Editor.getSelection) {
        // IE9 and non-IE
        sel = Editor.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = sel.getRangeAt(0);
            //range.deleteContents();
			
            // Range.createContextualFragment() would be useful here but is
            // non-standard and not supported in all browsers (IE9, for one)
            var el = Editor.createElement("div");
            el.innerHTML = html;
            var frag = Editor.createDocumentFragment(), node, lastNode;
            while ( (node = el.firstChild) ) {
                lastNode = frag.appendChild(node);
            }
			range.deleteContents();
			range.insertNode(frag);
            
            // Preserve the selection
            if (lastNode) {
                range = range.cloneRange();
                range.setStartAfter(lastNode);
				range.collapse(true);
                sel.removeAllRanges();
                sel.addRange(range);
            }
        }
    } else if (document.selection && document.selection.type != "Control") {
        // IE < 9
        document.selection.createRange().pasteHTML(html);
    }
}
set_cur_after_curr_node = function(){
	$(parentElement()).attr('id','start');
		var node = Editor.getElementById('start');
		var ranges= Editor.createRange();
		var sel = Editor.getSelection();
		ranges.setStartAfter(node); //lert("Hãy chọn 1 đoạn văn bản...");
		sel.removeAllRanges();
		sel.addRange(ranges);
}
remove_temp=function(){
	$(Editor).find(".start_,.end_,.end_b_").remove(); 
	$(Editor).find("*").removeAttr('class'); 
	$(Editor).find("*").removeAttr('id'); 
}
wrap2tag = function(st,en,tag)
{
	var foundBegin = false;
	var foundEnd = false;

	$(Editor).find(st).parent()
		.contents()
		.filter(function() {
			if($(this).is(st)) {
				foundBegin = true;
			}
			if($(this).is(en)) {
				foundEnd = true;
			}
			return foundBegin && !foundEnd;
		})
		
		.wrapAll(tag);
}
replace2tag=function(tag){
	var html= $(Editor_body).html();
	html = html.replace("["+tag+"]","<"+tag+">");
	html = html.replace("[/"+tag+"]","</"+tag+">");
	$(Editor_body).html(html);
}
add_Code = function()
{
	SaveSelection(1);
	addBookmark();
	
	var this_=$("#promt_add_code");
	this_.css({top:$(document).scrollTop()+100+'px'}).fadeIn().find('textarea').focus().val(getSelectionHtml());
	this_.find(".done").unbind('click');
	this_.find('.done').click(function(){
		close_promt_editor_special_char();
		//remove_tag_st_en(bookmark['start'],bookmark['end'],"CODE");
		//remove_tag_st_en(bookmark['start'],bookmark['end'],"PRE");
		//highlight({st:bookmark['start'],en:bookmark['end']});
		
		RestoreSelection(1);
		var feed = this_.find('textarea').val(); //alert(feed);
		pasteHtmlAtCaret("<pre>"+feed+"</pre>");
		RestoreSelection(1);
	});
	
	this_.find("a.close").click(function(){
		close_promt_editor_special_char();
	});
	
	remove_temp();
	setforcus();
}
get_html_select=function(){
	var sel = Editor.getSelection ();
	range = sel.getRangeAt(0);
    return range.cloneContents();
}


function insertHtmlAtCursor(html) {
    var sel, range, node;
    if (Editor.getSelection) {
        sel = Editor.getSelection();
        if (sel.getRangeAt && sel.rangeCount) {
            range = Editor.getSelection().getRangeAt(0);
            node = range.createContextualFragment(html);
            range.insertNode(node);
        }
    } else if (document.selection && document.selection.createRange) {
        document.selection.createRange().pasteHTML(html);
    }
}
check_end_or_start_node= function(st){

	if(bookmark['start'] != bookmark['end']){
	highlight({st:st,en:st});
	var p1=parentElement();
	highlight({st:st+1,en:st+1});
	var p2=parentElement();
	if(p1==p2)
	return false; return true;
	} else
	return false;
}


add_blockQuote =function() {
	addBookmark();
	$(Editor).find("*").removeAttr("id");
	var st= bookmark['start'];
	var en= bookmark['end']; 
	if(check_end_or_start_node(st)) st++;
	highlight({st:st,en:st});
	set_id_curr_tag('start');
	var check_parent_st=check_parent_by_id('start','blockquote');
	
	//insertHtmlAtCursor("<abc href=''>aa</abc>");
	//alert(get_cursor_pos_tag('start'));
	highlight({st:en,en:en});
	set_id_curr_tag('end');
	var check_parent_en=check_parent_by_id('end','blockquote');
	
	//alert(check_parent_st);
	//alert(check_parent_en);
	//return false;
	$("<p class='start_'>start</p>").insertBefore($(Editor).find('#start') ); 
	$("<p class='end_'>end</p>").insertAfter($(Editor).find('#end') );
	
	if(!check_parent_st && !check_parent_en)
	{	 
		if($(Editor).find('.start_').length>0)
		{
			$(Editor).find('.start_').nextUntil('.end_').wrapAll("<blockquote>");
		}
		else $(Editor).find('#end').wrapAll("<blockquote></blockquote>");
	}
	else if(check_parent_st && !check_parent_en)
	{
		$(Editor).find('.start_').prevUntil('blockquote').wrapAll("<blockquote>");
		$(Editor).find('.start_').nextUntil('.end_').unwrap("<blockquote>");
		
	}
	else if(check_parent_st && check_parent_en)
	{
		if($(Editor).find('.start_').length>0)
		{
			if($(Editor).find('.start_').prev("p").length>0)
			{
				$(Editor).find('.start_').prevUntil('blockquote').wrapAll("<blockquote>");
				$(Editor).find('.end_').nextUntil('blockquote').wrapAll("<blockquote>");
			}
			else if($(Editor).find('.end_').next("p").length>0)
			{
				$("<p class='end_b_'>end_b</p>").insertAfter( $(Editor).find('.end_').parents('blockquote') );
				$(Editor).find('.end_').prevUntil('blockquote').unwrap("<blockquote>");
				$(Editor).find('.end_').nextUntil('.end_b_').wrapAll("<blockquote>");
			}
			
			$(Editor).find('.start_').nextUntil('.end_').unwrap("<blockquote>");
		}
		else
		{
			if($(Editor).find('.end_').prev("p").length>0)
			{
				$("<p class='end_b_'>end_b</p>").insertAfter( $(Editor).find('.end_').parents('blockquote') );
				$(Editor).find('.end_').prev().prevUntil('blockquote').wrapAll("<blockquote>");
				$(Editor).find('.end_').unwrap("<blockquote>");
				$(Editor).find('.end_').nextUntil('.end_b_').wrapAll("<blockquote>");
			}
			else{
				$(Editor).find('#end').prevUntil('blockquote').wrapAll("<blockquote>");
				$(Editor).find('#end').unwrap("<blockquote>");
			}
		}
	}
	else if(!check_parent_st && check_parent_en)
	{
		
		$("<p class='end_b_'>end_b</p>").insertAfter( $(Editor).find('#end').parents('blockquote') );
		$(Editor).find('.start_').nextUntil('.end_b_').each(function(){
			
			$(this).children().unwrap('<blockquote>');
			
		});
		$(Editor).find('.start_').nextUntil('.end_b_').wrapAll("<blockquote>");
		
	}
	remove_temp();
	highlight({st:bookmark['start'],en:bookmark['end']});
	//return false;
	
	old_noi_dung=0;
	new_noi_dung=1; //alert(getCurrent_node(''));
	
	if(tag=="P")
	{
		var parent=$(parentElement());
	}
	else
	{
		var parent=$(parentElement()).parents("p");// alert(parent);
	}		
	//alert(parentElement());
		
	//alert(Editor.getSelection().anchorNode.text);
	//alert(parent.html());
	for (n in Editor.getSelection())
	{
		//document.write(n+"<br>");
	}//alert(check_parent('BLOCKQUOTE'));
	if(!check_parent('BLOCKQUOTE'))
	{
		//$('input').val('no_block');
		
		if(Editor.getSelection().toString().length>0)
		{
			
			var sel = Editor.getSelection();
			//var sel= sel.anchorNode.parentNode;
			//alert($(sel).html());
			//alert(getSelectedElementTags(Editor));
			range = sel.getRangeAt(0);
			//alert(getSelectionHtml(Editor));
			getSelectionHtml(Editor)
			newNode = document.createElement("blockquote");
			var htmls=range.cloneContents();
			
			var p= $(htmls).contents()
				.filter(function(){
					//alert(this.nodeName);
					return this.nodeName != 'P';
				})
				.wrapAll("<p>");
			
			$(newNode).html(htmls);
			//alert(htmls);
            range.deleteContents();
            set_setStartAfter_curr_tag();
            range.insertNode(newNode);
		}
		else
		{
			if(check_parent('P'))
			{	var id='i'+Math.random();
				//$("input").val('has_p');
				//$(parentElement()).attr('id',id);
				
				var html =parent.html();
				parent.wrap("<blockquote>").parent().html("<p id='"+id+"'>"+html+"</p>");
				set_setStartAfter(id);
			}
			else
			{ 
				var p= $(Editor_body).contents()
				.filter(function(){
					return this.nodeType === 3;
				})
				.wrapAll("<blockquote><p id='"+id+"'>")
				.parent();
				
				set_setStartAfter(id);
			}
		}
			
	}
	else if(check_parent('BLOCKQUOTE'))
	{
		//$('input').val('has_block');
		if(!check_next('P') && !check_prev('P'))
		{
			//$('input').val('no_next');
			parent.attr('id',id);
			parent.unwrap('<blockquote>');
			set_setStartAfter(id);
		}
	}
	//var a= $(Editor_body).find("blockquote"); //alert(a.length);
	//a.find("blockquote").unwrap('blockquote');
	//$(parentElement()).hide();
	setforcus();
	//preview_html();
	return false;
}

DesignHTML =function(mode)
{
	var area=$('#mode_html');
	var frame=$('#textbox');
	if(mode=="on"){
	var nd=Editor.body.innerHTML;
	area.show().css({height:frame.height(),width:frame.width()});
	frame.hide(); 
	area.val(nd).focus();
	$("#editor_top input,#editor_top select").attr({disabled:'disabled'}).addClass('disabled');
	}
	else
	{
	nd=area.val();
	Editor.body.innerHTML=nd;
	//setforcus();
	var area=$('#mode_html');
	var frame=$('#textbox');
	frame.show().css({height:height_editor+ 'px',width:'100%'});
	area.hide();
	$("#editor_top input,#editor_top select").removeAttr('disabled').removeClass('disabled');
	
	}
	return false;
}
function Write_top(div,val)
{	
	document.getElementById(div).innerHTML+=val;
}
$('.area_design,.frame_design').click(function(){ 
	$('.area_design,.frame_design').removeClass('active');
	$(this).addClass('active');
});
$('.area_design').click(function(){ 
	DesignHTML('on');
});
$('.frame_design').click(function(){
	DesignHTML('off');
});
var resize_editor_mouse_down=false, mouseY=0,height_e_change=0;
$("#box_editor .resize").mousedown(function(e){ 
	resize_editor_mouse_down=true;
	mouseY = e.pageY; 
	
});
mouse_up=function()
{
	if(resize_editor_mouse_down){
	resize_editor_mouse_down=false; height_editor=height_e_change;
	$("#box_editor .dim_resize").hide();
	}
}

$(function(){
    $(document,Editor).mouseup(function(){
       mouse_up();
    });
	 $(Editor).mouseup(function(){
       mouse_up();
    });
	$('textarea,input').mouseup(function(){
       mouse_up();
    });
});
$(window).mousemove(function(e){
	
	if(resize_editor_mouse_down)
	{	var distant=e.pageY-mouseY;
		var frame = $('#textbox');
		$("#box_editor .dim_resize").css({'height':height_e_change+30+'px','width':frame.width()+2+'px'}).show();
		height_e_change=distant+height_editor;
		//$('.preview').val(mouseY+"-"+e.pageY+"-"+distant+"-"+height_editor);
		if(height_e_change>50)
		frame.show().css({height:height_e_change+'px'});
	} //else alert(e.pageX-mouseX);
	
});
	
	$("#editor_top .show_hide_tool").live('click',function(){
		$(this).toggleClass('active');
		$("#editor_top input").slideToggle();
	});
	
	
window.onload = function()
{
/* 	var i=0; 
	var select_fonts='';
	for(i=1;i<=14;i++)
	{
	select_fonts+='<option onclick="SetFontSize('+i+')">'+i+'</option>';
	}
	select_fonts="<select class=edt_select style='width:50px;padding:1px;'>"+select_fonts+"</select>";
	var family="<select class=edt_select style='width:150px;padding:1px;'><option onclick=\"return SetFont(\'Arial\')\">Arial</option><option onclick=\"return SetFont(\'tahoma\')\">Tahoma</option><option onclick=\"return SetFont(\'time news roman\')\">Time News Roman</option><option onclick=\"return SetFont(\'verdana\')\">Verdana</option></select>";
	 */
	$(Editor).find("head")
		.append($("<link href='"+HOME_PATH+"/tbeditor/nd.css' rel='stylesheet'/>"));
		Editor.designMode="on";
		$(Editor_body).html($('#mode_html').val());
		//alert(Editor.designMode);
		//alert($(Editor_body).html() != $('#mode_html').val());
	
	Write_top('editor_top','<input type=\'image\' class=\'b\' src='+HOME_PATH+'/tbeditor/images/bold.gif onclick="return Format(\'bold\')"/>');
	Write_top('editor_top','<input type=image class=\'i\' src='+HOME_PATH+'/tbeditor/images/italic.gif onclick="return Format(\'italic\')"/>');
	Write_top('editor_top','<input type=image class=\'u\' src='+HOME_PATH+'/tbeditor/images/underline.gif onclick="return Format(\'underline\')"/>');
	Write_top('editor_top','<input type=image class=\'strike\' src='+HOME_PATH+'/tbeditor/images/strikethrough.gif onclick="return StrikeThrough()"/>');
	Write_top('editor_top','<input type=image src='+HOME_PATH+'/tbeditor/images/bgcolor.gif onclick="return HiliteColor(\'#eaeaea\')"/>');
	
	Write_top('editor_top','<input type=image  src='+HOME_PATH+'/tbeditor/images/removeFormat.gif onclick="return removeFormat()"/>');
	
	Write_top('editor_top','<input type=image class=\'blockquote\' src='+HOME_PATH+'/tbeditor/images/blockquote.gif onclick="return add_blockQuote() "/>');
	Write_top('editor_top','<input type=image class=\'code\' src='+HOME_PATH+'/tbeditor/images/code.gif onclick="return add_Code()" />');
	
	Write_top('editor_top','<input type=image class=\'sup\' src='+HOME_PATH+'/tbeditor/images/sup.gif onclick="return Format(\'superscript\')"/>');
	Write_top('editor_top','<input type=image class=\'sub\' src='+HOME_PATH+'/tbeditor/images/sub.gif onclick="return Format(\'subscript\')"/>');
	Write_top('editor_top','<input type=image src='+HOME_PATH+'/tbeditor/images/special_char.gif onclick="return special_char()"/>');
	//Write_top('editor_top',family);
	//Write_top('editor_top',select_fonts);
	//Write_top('editor_top','<input type=image src='+HOME_PATH+'/tbeditor/images/textcolor.gif onclick="return FontColor(\'gray\')"/>');
	//Write_top('editor_top','<input type=image src='+HOME_PATH+'/tbeditor/images/outdent.gif onclick="return IndentTextT()"/>');
	//Write_top('editor_top','<input type=image src='+HOME_PATH+'/tbeditor/images/indent.gif onclick="return IndentTextC()"/>');
	Write_top('editor_top','<input type=image class=\'ul\' src='+HOME_PATH+'/tbeditor/images/list.gif onclick="return UnNumOrderList()"/>');
	Write_top('editor_top','<input type=image class=\'ol\' src='+HOME_PATH+'/tbeditor/images/numbered_list.gif onclick="return NumOrderList()"/>');
	//Write_top('editor_top','<input type=image src='+HOME_PATH+'/tbeditor/images/left_just.gif onclick="return Format(\'justifyleft\')"/>');
	//Write_top('editor_top','<input type=image src='+HOME_PATH+'/tbeditor/images/centre.gif onclick="return Format(\'justifycenter\')"/>');
	//Write_top('editor_top','<input type=image src='+HOME_PATH+'/tbeditor/images/right_just.gif onclick="return Format(\'justifyright\')"/>');
	Write_top('editor_top','<input type=image src='+HOME_PATH+'/tbeditor/images/hyperlink.gif onclick="return AddLink()"/>');
	Write_top('editor_top','<input type=image src='+HOME_PATH+'/tbeditor/images/unhyperlink.gif onclick="return Unlink()"/>');
	
	Write_top('editor_top','<input type=image src='+HOME_PATH+'/tbeditor/images/addImage.gif onclick="return doImage()"/>');
	Write_top('editor_top','<input type=image src='+HOME_PATH+'/tbeditor/images/undo.gif onclick="return undo()"/>');
	Write_top('editor_top','<input type=image src='+HOME_PATH+'/tbeditor/images/redo.gif onclick="return redo()"/>');
	//DesignHTML('off');
	
	/* $("#newpost").click(function()
	{
		var nd=Editor.body.innerHTML;
		var nd1=$('#mode_html').val();
		var on=$('#mode_html').css('display');
		var r="";
		(on=='none')?r=nd:r=nd1;
		$('#temp_nd').val(r);
	}); */
}
	
});

