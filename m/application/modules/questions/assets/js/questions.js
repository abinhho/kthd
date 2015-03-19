var vote = '';
$(document).ready(function(){ 
    $("#form_answer").submit(function(e){
      
         $("#cke_noi_dung").my_validate({
            divshow:'.error_noi_dung'
            ,length: 25
            ,form:e
            //,type: 'editor'
        });
       
    });
    $('.sprites.vote_up').ajax_check_login({func:'vote_up'});
    $('.sprites.vote_down').ajax_check_login({func:'vote_down'});
    $('.sprites.bookmark').ajax_check_login({func:'bookmark'});
    $('#comment_topic').ajax_check_login({func:'comment_topic'});
    
    
    vote_up = function(this_)
    { 
            var val = this_.parents('.vote_tool').children("input[name='_id_']").val();
            do_vote_bookmark({type:'vote_up', val:val, this_:this_});
    }
    vote_down = function(this_)
    { 
            var val = this_.parents('.vote_tool').children("input[name='_id_']").val();
            do_vote_bookmark({type:'vote_down', val:val, this_:this_});
    }
    bookmark = function(this_)
    { 
            var val = this_.parents('.vote_tool').children("input[name='_id_']").val();
            do_vote_bookmark({type:'bookmark', val:val, this_:this_});
    }
    do_vote_bookmark = function(opt){
        var default_={url:base_url+'questions/ajax_vote_bookmark'};
		var opt= $.extend({},default_,opt);
        
       	$.ajax({
			type:"POST",
			data:{val:opt.val,type:opt.type}, 
			dataType:"json",
			url:opt.url,
			success: function (data){  //alert(data);
			    if(!data.ok)
                { 
				    
                }
				else
				{ 
					$('#'+data.score_id).text(data.n_votes);
                    if(data.type == 'vote_up' || data.type == 'vote_down')
                    opt.this_.parent('.vote_tool').children('.votes').removeClass('active');
                    
                    if(data.active)
                    { 
                        if(opt.type != 'bookmark')
                        opt.this_.parents('.vote_tool').find('a.votes').removeClass('active');
                        opt.this_.addClass('active');
                    }
                    else opt.this_.removeClass('active');
                    
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}		
        });
        
        
    }
    
    
   	share_topic  = function(this_, type, id, url){
		//$(".form_comment").hide();
        var top = this_.offset().top;
        var left = this_.offset().left;
        var frame = $(".form_share_abso");
        
        var text_type = (type == 'questions')? 'Chia sẽ câu hỏi này' : 'Chia sẽ câu trả lời này';
        
        frame.find('input').val(url);
        frame.find('.text_type').text(text_type);
        frame.find('a.facebook').attr('href', 'http://www.facebook.com/share.php?u='+url);
        frame.find('a.google').attr('href', 'http://twitter.com/home?status=?u='+url);
        frame.find('a.twitter').attr('href', 'https://plus.google.com/share?url='+url);
		frame.css({left:left+'px', top:top+15+'px'}).fadeIn();
		return false;
	}
	comment_topic  = function(this_){
	   var type = this_.parent('.tool_comment').children("input[name='_comment_']").val(); //alert(type);
		$(".form_share").hide();
		$("#comment_"+type).slideToggle("fast");
        
        $("#comment_"+type).children('input.button').click(function(){
       	    
            var area = $("#comment_"+type).children('textarea');
           var val = area.val();
           
           if(val.trim().length < 5){
                //alert('Bình luận phải ít nhất 5 ký tự'); 
				return false;
           }
           $("#comment_"+type).children('textarea').val('')  ;
           $.ajax({
			type:"POST",
			data:{val: val, type:type, notes_data: area.attr('notes_data')  }, 
			dataType:"json",
			url:base_url+'questions/ajax_comment/',
			success: function (data){  //alert(data);
			    if(!data.ok)
                { 
				    
                }
				else
				{ 
					if(data.html == "") return;
				    $("#comment_"+type).children('textarea').val('');
				    $("#comment_"+type).hide();
					$("#item_comments_"+type).append(data.html);
					
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}		
            });
        });
        
		return false;
	}
    
    $("textarea#count_down_char").keyup(function(){
        var val = $(this).val();
        $(this).parent('.form_comment').find('#count_down_number').text(250 - val.length);
    });
    
    del_comment = function(id, this_)
    {
         var y=confirm("Bạn chắc là bạn muốn xóa chứ ?");
         if(!y) return false;
        
        $.ajax({
			type:"POST",
			data:{id: id, question_id:this_.attr('question-id')}, 
			dataType:"json",
			url:base_url+'questions/ajax_del_comment/',
			success: function (data){ 
			    if(!data.ok)
                { 
				    
                }
				else
				{ 
				    this_.parent('li').fadeOut();
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}		
            });
    }
    
    $("#select_ask_catid").change(function(){
        $.ajax({
				type:"POST",
				data:{catid:$(this).val(), tags_id: $("input#tags_id").val()}, 
				dataType:"html",
				url:base_url+'tags/ajax_checkbox_tags',
				success: function (html){
					$(".div_checkbox_tags").html(html);
                    
                    re_show_tags_selected();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
				
				
			});
    });
    
    $(".div_checkbox_tags input").live('change',function(){ 
        if($(".div_checkbox_tags input:checked").length > 5) 
        {
            alert('Bạn chỉ được chọn tối đa 5 tag');
            $(this).attr('checked',false);
            return false;
        }
        re_show_tags_selected();
    });
    var append_info_tags = $("#append_info_tags .append_span"); 
    
    append_info_tags.find('span.each_tag i.remove_me').live('click', function(){
        var p = $(this).parent('span.each_tag');
        $(".div_checkbox_tags input").each(function(){
            if($(this).val() == p.attr('tag_id'))
            $(this).attr('checked',false);
        });
        p.remove();
        re_show_tags_selected();
    });
    
    re_show_tags_selected = function()
    {
        
        append_info_tags.html('');
        
        var tags_id = '';
        
        $(".div_checkbox_tags input").each(function(){
            if($(this).is(':checked'))
            { 
                var tieu_de = $(this).attr('data_tieu_de');  
                append_info_tags.append('<span class="each_tag" tag_id="'+$(this).val()+'">'+tieu_de+'<i class="remove_me"></i></span>') ;
                tags_id = add_coma(tags_id,$(this).val(),",");
            }
        });
        $("input#tags_id").val(tags_id);
    }
    
	show_more_comment = function(_this)
	{
		_this.hide().parent('.item_comments').find('li').fadeIn(); return false;
	}
	
    // show suggest khi user nhap 1 vai char trong tieu de dang tin
    $("#ask_tieu_de").ajax_seach_normal({inner:'inner_question_suggest_upload',url:base_url + 'questions/ajax_search/' })
    
});