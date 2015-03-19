$(document).ready(function(){
    
    var selector_user_notes = $(".head_account li.user_notes");
    var user_ajax = 0;
    mod_user_get_numof_user_notes = function()
    { 
        if(user_id == '') return false;
        	$.ajax({
			type:"POST",
			data:{}, 
			dataType:"json",
			url:base_url+'user/ajax_user_notes/',
			success: function (data){  
                user_ajax = true;
			    if(!data.numof_notes)
                { 
				    selector_user_notes.find('b.number').text('').removeClass('active');
                    if(selector_user_notes.find('.loading').length)
                    selector_user_notes.find('div.contents_notes').html(data.html);
                }
				else
				{ 
					selector_user_notes.find('b.number').text(data.numof_notes).addClass('active');
                    selector_user_notes.find('div.contents_notes').html(data.html);
				}
                
			},
			error: function (xhr, ajaxOptions, thrownError) {
				//	alert(xhr.status);
				//	alert(thrownError);
				}		
        });
        
    }
    
    
    var ui_block_user_login_small = $("#ui_user_login_small"); 
    if(ui_block_user_login_small.length)
    {
        $.ajax({
			type:"POST",
			data:{}, 
			dataType:"html",
			url:base_url+'user/ajax_block_login_small/',
			success: function (data){
               ui_block_user_login_small.html(data);
			}
        });
    }
    
    
    if(user_id != '')
    var user_notes_inval = setInterval(mod_user_get_numof_user_notes,10000);

    mod_user_set_viewed_user_notes = function()
    { 
        	$.ajax({
			type:"POST",
			data:{ids: $("input[name='user_notes']").val()}, 
			dataType:"html",
			url:base_url+'user/ajax_set_viewed_user_notes/',
			success: function (data){ 
               selector_user_notes.find('b.number').text('').removeClass('active');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				//	alert(xhr.status);
				//	alert(thrownError);
				}		
        });
        
    }
    
    del_user_notes = function(val, this_)
    { 
            var y=confirm("Bạn chắc là bạn muốn xóa chứ ?");
            if(!y) return false;
        	$.ajax({
			type:"POST",
			data:{val:val}, 
			dataType:"json",
			url:base_url+'user/ajax_del_user_notes/',
			success: function (data){ 
                if(data.feed && data.feed ==  'all') 
                {
                    location.reload(true); return;
                }
                this_.parents('li').fadeOut();
			},
			error: function (xhr, ajaxOptions, thrownError) {
					//alert(xhr.status);
					//alert(thrownError);
				}		
        });
        
    }

    mod_user_get_numof_user_notes();
    selector_user_notes.click(function(e){
       
       if($(this).hasClass('active'))
       {
            $(this).removeClass('active');
            $(this).find('ul').hide();
            user_notes_inval = setInterval(mod_user_get_numof_user_notes,10000); 
       }
       else {
            $(this).addClass('active');
            $(this).find('ul').show();
            if(user_ajax)
            {
                mod_user_set_viewed_user_notes();
                clearInterval(user_notes_inval);
            }
            
       }
       
       e.stopPropagation(); return false;
    });
    selector_user_notes.find('ul').click(function(e){
        e.stopPropagation();
    })
    $(document).click(function(){
        selector_user_notes.removeClass('active').find('ul').hide();
        user_notes_inval = setInterval(mod_user_get_numof_user_notes,10000); 
    });
    
   	function set_timeout_tooltip(clss)
	{
		tooltip_timeout = setTimeout(function() {
			$('.'+clss).hide();
			}, 1000);
			//$('.'+clss).data('timeout', t);
	}
	
	$(".tooltip_userinfo").hover(function(){
		
		$(".tooltip_userinfo_abso").hide();
		var this_=$(this);
		//var html=this_.parent("span").find("i").html();
        
        
		tooltip_timeout = setTimeout(function() {
        
        var uid = this_.attr('data-id');
        var hidden_class= 'hidden_tooltip_userinfo_'+uid;
        if($('.'+hidden_class).length)
        {
            $(".tooltip_userinfo_abso")
						.css({top:this_.offset().top-145+'px',left:this_.offset().left-5+'px'}).find('.contents')
						.html($('.'+hidden_class).html());
            $('.tooltip_userinfo_abso').show();
            return false;
        }
        
        
		$.ajax({
				url:base_url+'user/ajax_tooltip_info/'
				,type:'post'
				,data:{id:uid}
				,dataType:'html'
				,success: function (D) {
					if(D.trim().length>0)
					{
					   if(!$('.'+hidden_class).length)
					   $('body').append('<div class="hidden '+hidden_class+'" >'+D+'</div>')
						
						$(".tooltip_userinfo_abso")
						.css({top:this_.offset().top-145+'px',left:this_.offset().left-5+'px'}).find('.contents')
						.html(D);
						
						$('.tooltip_userinfo_abso').fadeIn('fast');
						
						
					}
				}
				,error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
				
			});
			}, 1000); //end timeout
			
	}, function() {
			clearTimeout(tooltip_timeout);
			//$('.tooltip_tag_abso').hide();
			set_timeout_tooltip("tooltip_userinfo_abso");
	});
	$(".tooltip_userinfo_abso").hover(function(){
		clearTimeout(tooltip_timeout);
	}, function() {
			set_timeout_tooltip("tooltip_userinfo_abso");
	});
    if(!$('.tooltip_userinfo_abso').length)
    $('body').append('<div class="tooltip_userinfo_abso"><i class="sprites arrow_bottom"></i><div class="contents"></div></div>')
    
});var RATE="";
$(document).ready(function(){
	var block_rate =$(".block_rate");
	var stars =$(".block_rate .stars");
	var block_text_rate =$(".block_rate .text_rate");
	var text_rate = block_text_rate.text();
	$(".block_rate .stars.mod_on .each").hover(function(){ 
		var rate = $(this).index()+1;
		stars.children(".each").removeClass("hover");
		for(var i=0;i<=rate-1;i++)
		{
			stars.children(".each").eq(i).addClass("hover");
		}
		var marks=["rất kém","kém","đạt","tốt","rất tốt"];
		block_text_rate.text("Điểm: "+ marks[rate-1]);
		
		$(this).click(function(){
			$("iframe[name='temp_frame']").attr({src:$("input[name='url_do']").val() + '?rate='+rate+'&mod='+$("input[name='mod_rate']").val()+'&id='+$("input[name='id_topic']").val() });
		});
		
	}
	,function () {
	stars.children(".each").removeClass("hover");
	block_text_rate.text(text_rate);
	}
	);
	
	RATE = {
	
	feed_back:function(opts)
	{
		stars.removeClass("mod_on");
		$(".block_rate .stars .each").unbind('mouseenter mouseleave click');
		block_rate.find(".vote_total").text(opts.vote);
		block_rate.find(".vote_times").text(opts.vote_times);
	}
	
	
	};
	
});var vote = '';
$(document).ready(function(){ 
    $("#form_answer").submit(function(e){
      
         $("#cke_noi_dung").my_validate({
            divshow:'.error_noi_dung'
            ,length: 25
            ,form:e
            ,type: 'editor'
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
    
    if($('.nd img').length)
        $('.nd img').each(function(){
           var src = $(this).attr('src');
           if($(this).parent('a').length)
                $(this).parent('a').addClass('fancyBox').attr('href', src);
           else {
                $(this).wrap('<a href="'+src+'" class="fancyBox"></a>');
           }
        });
    $("a.fancyBox").fancybox();
});