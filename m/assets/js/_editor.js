$(document).ready(function(){ 
	var format_bold = "**";
	var format_italic = "*";
	var format_blockquote = "> ";
    var format_code = "     ";
    var format_ul = " - ";
    var format_code_1 = "`";
    var format_heading = "----";
    
	var resize_editor_mouse_down=false, mouseY=0,height_e_change=0;
	var _editor = $('._editor textarea');
	var height_editor = _editor.height(); //alert(height_editor);
    
    var index_undo = -1;
    var state_undo = new Array();
    var active_editor = false;
    // Luu trang thai dau tien
    
    
	$("._editor ._resize").mousedown(function(e){ 
		resize_editor_mouse_down=true;
		mouseY = e.pageY; 
		
	});
	mouse_up=function()
	{
		if(resize_editor_mouse_down){
		resize_editor_mouse_down=false; height_editor=height_e_change;
		$("._editor .dim_resize").hide();
		}
	}
	
	$(function(){
		$(document,'._editor').mouseup(function(){
		   mouse_up();
		});
		 $('._editor').mouseup(function(){
		   mouse_up();
		});
		$('textarea,input').mouseup(function(){
		   mouse_up();
		});
	});
	$(window).mousemove(function(e){
		//alert('das');
		if(resize_editor_mouse_down)
		{	var distant=e.pageY-mouseY; 
			
			$("._editor .dim_resize").css({'width':_editor.width()+10+'px'}).show();
			height_e_change=distant+height_editor;// alert(height_e_change);
			//$('.preview').val(mouseY+"-"+e.pageY+"-"+distant+"-"+height_editor);
			//if(height_e_change>50)
			_editor.css({height:height_e_change+'px'});
		} //else alert(e.pageX-mouseX);
		
	});
	
    var cursor_start = 0;
	var cursor_end = 0;
    var selection = '';
    
    
	$("._editor ._tool li").click(function(){
		
		var type = $(this).attr('class');
		cursor_start = _editor.prop("selectionStart");
		cursor_end = _editor.prop("selectionEnd");
		
		selection = _editor.selection();
		
		_editor.focus();
		if(type == "_bold")
		{
			
			var first_tag = get_selection_from_to(cursor_start,cursor_start-2);
			var after_tag = get_selection_from_to(cursor_end,cursor_end+2) ;
			
			if( first_tag == after_tag && first_tag == format_bold)
			{
				_editor.set_selection(cursor_start-2, cursor_end+2);
				_editor.selection('replace', {text: selection});
			}
			else
			{ 
				if(selection.length > 0){
					_editor
					.selection('insert', {text: format_bold, mode: 'before'})
					.selection('insert', {text: format_bold, mode: 'after'});
				}
				else{
					
					if(after_tag == format_bold)
						_editor.set_selection(cursor_start+2, cursor_start+2);
					else
					_editor
					.selection('insert', {text: format_bold, mode: 'before'})
					.selection('replace', {text: 'chử in đậm'})
					.selection('insert', {text: format_bold, mode: 'after'});
				}
			}
			save_state_undo();
		}
		// end type === _bold
		else if(type == "_italic")
		{
			
			var first_tag = get_selection_from_to(cursor_start,cursor_start-1);
			var after_tag = get_selection_from_to(cursor_end,cursor_end+1) ;
			
			if( first_tag == after_tag && first_tag == format_italic)
			{
				_editor.set_selection(cursor_start-1, cursor_end+1);
				_editor.selection('replace', {text: selection});
			}
			else
			{ 
				if(selection.length > 0){
					_editor
					.selection('insert', {text: format_italic, mode: 'before'})
					.selection('insert', {text: format_italic, mode: 'after'});
				}
				else{
					
					if(after_tag == format_italic)
						_editor.set_selection(cursor_start+1, cursor_start+1);
					else
					_editor
					.selection('insert', {text: format_italic, mode: 'before'})
					.selection('replace', {text: 'chử in nghiêng'})
					.selection('insert', {text: format_italic, mode: 'after'});
				}
				
			}
			save_state_undo();
		}
        // end type === _italic
        else if(type == "_blockquote")
		{
			
			var first_tag = get_selection_from_to(cursor_start,cursor_start-2);
			var first_tag_1 = get_selection_from_to(cursor_start,cursor_start-3);
			var endline = (first_tag_1.trim().length <= 1) ? '' : '\n';
			
			/* var after_tag = get_selection_from_to(cursor_end,cursor_end+1) ; */
						
			if( first_tag == format_blockquote)
			{
				_editor.set_selection(cursor_start-2, cursor_end);
				_editor.selection('replace', {text: selection});
			}
			else
			{ 
				if(selection.length > 0){ 
					_editor
					.selection('insert', {text: endline+format_blockquote, mode: 'before'})
					.selection('insert', {text: '', mode: 'after'});
                    
                    var replace = false;
                    while(get_selection_from_to(cursor_start-1,cursor_start ) == ' ')
                    {   replace = true;
                        var val = _editor.val();
                        _editor.val( val.slice(0, cursor_start-1) + val.slice(cursor_start, val.length)) ;
                        cursor_start--; cursor_end--;
                        
                    }
                    if(replace)
                    _editor.set_selection(cursor_start+2, cursor_end+2);
				}
				else{
					
					_editor
					.selection('insert', {text: endline + format_blockquote, mode: 'before'})
					.selection('replace', {text: 'blockquote'})
					.selection('insert', {text: '', mode: 'after'});
				}
			}
		
			save_state_undo();
		}
        // end type === _blockquote
        else if(type == "_code")
		{
			var first_tag_check = get_selection_from_to(cursor_start,cursor_start-6);
            //alert(first_tag_check == ('\n'+format_code)  );            
            //alert(_is_first_document(cursor_start,cursor_end));
            //alert(_is_first_line(cursor_start,cursor_end));
            //alert(_is_end_document(cursor_start,cursor_end));
            //alert(_is_end_line(cursor_start,cursor_end));
            //alert(_has_selected(cursor_start,cursor_end));
            if(
            (_is_first_document() && _is_end_document()) || (_is_end_line() && _is_first_line()) || 
            ( _has_selected() && 
                
                (first_tag_check == '\n'+format_code || (_is_first_line() && _is_end_line_to()))
                
             ) 
            )
            { 
                	var first_tag = get_selection_from_to(cursor_start,cursor_start-5);
        			var first_tag_1 = get_selection_from_to(cursor_start,cursor_start-6);
        			var endline = (first_tag_1.trim().length <= 1) ? '' : '\n';
        			
        			/* var after_tag = get_selection_from_to(cursor_end,cursor_end+1) ; */
        						
        			if( first_tag_1 == '\n'+format_code)
        			{
        				_editor.set_selection(cursor_start-5, cursor_end);
        				_editor.selection('replace', {text: selection});
        			}
        			else
        			{ 
        				if(selection.length > 0){
        					_editor
        					.selection('insert', {text: format_code, mode: 'before'})
        					.selection('insert', {text: '', mode: 'after'});
        				}
        				else{
        					
        					_editor
        					.selection('insert', {text: format_code, mode: 'before'})
        					.selection('replace', {text: 'nhập code ở đây'})
        					.selection('insert', {text: '', mode: 'after'});
        				}
        			}
            }
            
            else
            { 
            	var first_tag = get_selection_from_to(cursor_start,cursor_start-1);
    			var after_tag = get_selection_from_to(cursor_end,cursor_end+1) ;
    			
    			if( first_tag == after_tag && first_tag == format_code_1)
    			{
    				_editor.set_selection(cursor_start-1, cursor_end+1);
    				_editor.selection('replace', {text: selection});
    			}
    			else
    			{ 
    				if(selection.length > 0){
    					_editor
    					.selection('insert', {text: format_code_1, mode: 'before'})
    					.selection('insert', {text: format_code_1, mode: 'after'});
    				}
    				else{
    					
    					if(after_tag == format_code_1)
    						_editor.set_selection(cursor_start+1, cursor_start+1);
    					else
    					_editor
    					.selection('insert', {text: format_code_1, mode: 'before'})
    					.selection('replace', {text: 'nhập code ở đây'})
    					.selection('insert', {text: format_code_1, mode: 'after'});
    				}
    				
    			}    
            }
        
			/* cursor_start = _editor.prop("selectionStart");
			cursor_end = _editor.prop("selectionEnd");
			
			_editor.val(_editor.val().replace("\n\n", "\n"));
			_editor.set_selection(cursor_start, cursor_end); */
			save_state_undo();
		}
        // End type ===  code
        else if(type == '_link')
        {
            if(selection.trim() == "")
            {alert('Vui lòng chọn 1 đoạn text để chèn link'); return false;}
            var src = prompt("Add link", "http://");
            _editor
            .selection('insert', {text: '[', mode: 'before'})
            .selection('replace', {text: selection })
            .selection('insert', {text: '::'+ src + ']', mode: 'after'});
        }
        // End type === _link
        else if(type == "_ul")
		{
			
			var first_tag = get_selection_from_to(cursor_start,cursor_start-3);
			var first_tag_1 = get_selection_from_to(cursor_start,cursor_start-4);
			var endline = (first_tag_1.trim().length <= 1) ? '' : '\n';
			
			/* var after_tag = get_selection_from_to(cursor_end,cursor_end+1) ; */
						
			if( first_tag == format_ul)
			{
				_editor.set_selection(cursor_start-3, cursor_end);
				_editor.selection('replace', {text: selection});
			}
			else
			{ 
				if(selection.length > 0){ 
					_editor
					.selection('insert', {text: endline+format_ul, mode: 'before'})
					.selection('insert', {text: '', mode: 'after'});
                    
                    var replace = false;
                    while(get_selection_from_to(cursor_start-1,cursor_start ) == ' ')
                    {   replace = true;
                        var val = _editor.val();
                        _editor.val( val.slice(0, cursor_start-1) + val.slice(cursor_start, val.length)) ;
                        cursor_start--; cursor_end--;
                        
                    }
                    if(replace)
                    _editor.set_selection(cursor_start+2, cursor_end+2);
				}
				else{
					
					_editor
					.selection('insert', {text: endline + format_ul, mode: 'before'})
					.selection('replace', {text: 'List item'})
					.selection('insert', {text: '', mode: 'after'});
				}
			}
		
			save_state_undo();
		}
        else if(type == "_undo")
        { 
            un_redo('undo');
        }
        else if(type == "_redo")
        {
            un_redo('redo');
        }
		
	});
	
    save_state_undo = function()
    {
        index_undo ++;
        state_undo[index_undo] = new Object();
        state_undo[index_undo].state_val = _editor.val();
        state_undo[index_undo].cursor_start = _editor.prop("selectionStart");
        state_undo[index_undo].cursor_end = _editor.prop("selectionEnd");
    }
    _editor.focus(function(){
        if(!active_editor)
        save_state_undo();
        active_editor = true;
    });

    compare_state_undo = function()
    {
        if(_editor.val() == state_undo[index_undo].state_val ) return true; return false;
    }  
    
    _editor.keydown(function(e){
      
      if( e.which === 90 && e.ctrlKey ){
         un_redo('undo'); e.preventDefault(); return false; 
      }
      else if( e.which === 89 && e.ctrlKey ){
         un_redo('redo');
         e.preventDefault(); return false;
      }
              
    }); 
    
    un_redo = function(t)
    {
        if(!compare_state_undo())
        {
            save_state_undo();
        }
        
        if(t == 'undo' && state_undo[index_undo-1].state_val != 'undefined')
        {
            index_undo --;
        }
        else if(t == 'redo' && state_undo[index_undo+1].state_val != 'undefined')
        {
            index_undo ++;
        }
        else
        {
            return false;
        }
        
        if(state_undo[index_undo].state_val == 'undefined') return false;
        _editor.val(state_undo[index_undo].state_val);
        _editor.set_selection(state_undo[index_undo].cursor_start, state_undo[index_undo].cursor_end);
    }
    
	get_selection_from_to = function(from,to)
	{
		return _editor.val().substring(from,to);
	}
    _has_selected = function()
    {
        return (get_selection_from_to(cursor_start,cursor_end).length == 0) ? false : true;
    }
    _is_first_document = function()
    {
        return (get_selection_from_to(cursor_start, cursor_start-1).length == 0) ? true : false;
    }
    _is_end_document = function()
    {
        return (get_selection_from_to(cursor_start, cursor_start+1).length == 0) ? true : false;
    }
    _is_end_document_to = function()
    {
        return (get_selection_from_to(cursor_end, cursor_end+1).length == 0) ? true : false;
    }
    _is_first_line = function()
    {
        return (get_selection_from_to(cursor_start, cursor_start-1) == '\n' || get_selection_from_to(cursor_start, cursor_start-1).length == 0) ? true : false;
    }
    _is_end_line = function()
    {
        return (get_selection_from_to(cursor_start, cursor_start+1) == '\n' || get_selection_from_to(cursor_start, cursor_start+1).length == 0) ? true : false;
    }
    _is_end_line_to = function()
    {
        return (get_selection_from_to(cursor_end, cursor_end+1) == '\n' || get_selection_from_to(cursor_end, cursor_end+1).length == 0) ? true : false;
    }
    
	
	$.fn.set_selection = function(start, end) {
    if(!end) end = start; 
    return this.each(function() {
        if (this.setSelectionRange) {
            this.focus();
            this.setSelectionRange(start, end);
        } else if (this.createTextRange) {
            var range = this.createTextRange();
            range.collapse(true);
            range.moveEnd('character', end);
            range.moveStart('character', start);
            range.select();
        }
    });
};
	
	
});