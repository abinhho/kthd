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
            user_notes_set_viewed_inval = setInterval(mod_user_set_viewed_user_notes,10000); 
       }
       else {
            $(this).addClass('active');
            $(this).find('ul').show();
            if(user_ajax)
            {
                clearInterval(user_notes_inval);
                clearInterval(user_notes_set_viewed_inval);
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
    
});