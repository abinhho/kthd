$(document).ready(function(){
 $(".icon_click_sidebar").click(function(e){
 
        e.stopPropagation();
        if($('.main_body').hasClass('active_sidebar'))
        {
            $('.main_body, .mod_banner.scroll_banner').removeClass('active_sidebar');
			$('.main_body').css('height', '');
			$('body').css('overflow-x', '');
            $('.left_sidebar').hide();
        }
        else
        {
            $('.left_sidebar').show();
			$('.main_body').css('height', $('.left_sidebar').height() - 80);
			$('.main_body, .mod_banner.scroll_banner').addClass('active_sidebar');
			$('body').css('overflow-x', 'hidden');
        }
		
    });
$('.main_body').click(function(){
	$('.main_body, .mod_banner.scroll_banner').removeClass('active_sidebar');
	$('.main_body').css('height', '');
	$('body').css('overflow-x', '');
    $('.left_sidebar').hide();
});


check_browser=function(){

	if (navigator.userAgent.indexOf('Firefox') != -1
	&& parseFloat(navigator.userAgent.substring(navigator.userAgent.indexOf('Firefox') + 8)) >= 3.6){
		return "Firefox";
	 }
	 else if (navigator.userAgent.indexOf('Chrome') != -1 
	 && parseFloat(navigator.userAgent.substring(navigator.userAgent.indexOf('Chrome') + 7).split(' ')[0]) >= 15){ 
	 return "Chrome";
	 }
	 else if(navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Version') != -1 
	 && parseFloat(navigator.userAgent.substring(navigator.userAgent.indexOf('Version') + 8)
	 .split(' ')[0]) >= 5){
		return "Safari";
	 }
	 else{
		return false;
	 }
 }
	function _0_01(i)
	{
		if(i<10) 
		return "0"+String(i); 
		return i;
	}function _00_1(i)
	{
		if(i[0]=="0") 
		return i[1]; 
		return i;
	}
	
	h_body=$("body").height();
	h_window=$(window).height();
	bottom_w=window.pageYOffset+h_body;
	w_body=$("body").width();
	
	$.fn.scrollFixed=function(myBottom,myTop){
	var this_=$($(this).selector);
	var top=this_.offset().top;
	var left=this_.offset().left;
	var width=this_.width();
	var height=this_.height();
	h_body=$("body").height();
	if(h_body-height-myBottom-myTop-top>0){
		$(window).scroll(function(){
		var this_w=$(this);
		top_w=window.pageYOffset;
		if(top_w > top)
		{
			
			this_.css({"position":"fixed","top":myTop,"left":left+"px","margin-left":"0","margin-right":"0","width":width});
			var bottom=this_.offset().top+this_.height();
			if(bottom > h_body - myBottom)
			{	
				this_.css({"position":"absolute",top:h_body-myBottom-height+"px","left":left+"px","width":width});
			}
		}
		else 
		{
			this_.css({"position":"","top":"","width":width});
		}
	
		});
	}

	}
	
	
	$.fn.only_accept_num=function(){
	$($(this).selector).live('keyup',function(){
	var value=$(this).val();
	if(isNaN(value))
	{
		while(isNaN(value))
		{		
			value=value.substring(0,value.length-1);
			$(this).val(value);
		}
	}
	});
	}
	$.fn.overflow_bottom=function(){
	var this_=$($(this).selector);
	var width=this_.width();
	var height=this_.height();
	var top=this_.offset().top;
	this_.css({"max-height":(h_window-top-10)+'px',"overflow":"auto"});
	
	}
	$(".confirm").click(function(){
	var y=confirm("Bạn chắc là bạn muốn xóa chứ ???");
	if(!y) return false;
	});
	
	$.fn.document_click_hide=function(){
	var this_=$($(this).selector);
	$(document).click(function(){ 
	this_.hide();
	});
	}
	$.fn.stopPropagation_=function(){
	var this_=$($(this).selector);
	this_.click(function(e){
	e.stopPropagation();return false;
	});
	this_.document_click_hide();
	}
	$.fn.click_close=function(id){
	var this_=$($(this).selector);
	this_.click(function(){
	$(id).fadeOut();
	});
	}
	
	$.fn.count_down_clock=function(){
		var this_=$($(this).selector);
		setInterval(function() {
			text=this_.text();
			var N=text.split(":"); //alert(intval("09")+"--"+N[2]);
			var time= parseInt(_00_1(N[0]))*3600+parseInt(_00_1(N[1]))*60+parseInt(_00_1(N[2]))-1;
			var h= parseInt (time/3600); 
			var i= parseInt ( (time-(3600*h))/60) ;
			var s= parseInt (time-(3600*h)-60*i) ;
			r= _0_01(h)+":"+_0_01(i)+":"+_0_01(s);
			//r= h+":"+i+":"+s;
		  	
			this_.text(r);
		}, 1000);

		
	}
	
	
	
	$.fn.hover_active_li=function(){
		var this_=$($(this).selector);
		
		this_.find("li").live('hover',function(){this_.find("li").removeClass("active");$(this).addClass("active");});
	}
	$.fn.menu_dropdown=function(){
		var this_=$($(this).selector);
		this_.find("li").each(function(){
			$(this).hover(function(){
					$(this).children("ul").slideDown("fast");
				},
				function(){$(this).children("ul").hide();}
			);
			
		});
	}
	
	$.fn.tab_li=function(tab_show){
		var this_=$($(this).selector);
		this_.find("li").live("click",function(){
       
               $($(this).selector+" li,"+tab_show+" li.tab").removeClass("active");
                $(this).addClass("active");
                index=$(this).index();
                var tab_li_b=$(tab_show+" li.tab");
                //var load=$(this).attr("load"); 
                if(tab_li_b.eq(index).text()=="")
                {
                        tab_li_b.eq(index).load(load);
                }
                tab_li_b.eq(index).addClass("active");
				return false;
        });

	}
	
	add_coma=function(str,val,coma)
	{
		if(val.length>0){
			if(str.length>0)
			return str+coma+val;
		}
		return val;
	}
	rm_add_coma=function(str,val,coma)
	{ 
		str = str.replace(val+coma,"");
		str = str.replace(coma+val,"");
		str = str.replace(val,"");
		return str;
	}
	
	add_coma_1=function(str,val)
	{
		if(val.length>0){
			if(str.length>0)
			return str+val+"_";
			return "_"+val+"_";
		}
		return str;
		
	}
	
	$.fn.ajax_seach_normal=function(opt){
		var this_=$($(this).selector);
		var default_={length:5, limit: 20};
		var opt= $.extend({},default_,opt);
		this_.keyup(function(){ 
				
				if(this_.val().length >= opt.length){
				$("."+opt.inner).load(opt.url+"?limit="+opt.limit+"&key="+this_.val().split(" ").join("-") );
				$(".split_page").hide();
				}
				else{
					$("."+opt.inner).html("");
				}
			
			
		});
	}
    
    
    
	/* $.fn.select_updown=function(target){
	var this_=$($(this).selector);
		this_.keydown(function(e){// alert(e.keyCode);
			if(e.keyCode==40 || e.keyCode==39)
			{
				
				first_active=$(target).find("li.active");//alert(first_active.next("li").length);
				$(target).find("li").removeClass("active");
				(first_active.next().length!=0)? first_active.next().addClass("active") : $(target).find("li:first").addClass("active");
			}
			if(e.keyCode==38 || e.keyCode==37)
			{
				
				first_active=$(target).find("li.active");
				$(target).find("li").removeClass("active");
				(first_active.prev().length!=0)? first_active.prev().addClass("active") : $(target).find("li:last").addClass("active");
			}
			$(target).find("li").live('hover',function(){
				$(target).find("li").removeClass("active");
				$(this).addClass("active");
			});
		});
	}
	 */
	/* callback_suggest_append_input = function(opt)
	{
		var li_active=$(".auto_suggest_absolute").find("li.active").find("a.tag_name").attr('tag_name'); //alert(li_active.text());
		var tag_id=$(".auto_suggest_absolute").find("li.active").find("a.tag_name").attr('tag_id');
		if(li_active!= undefined){
			
			$("span."+opt.inner).append("<span tag_id="+tag_id+" class='each_tag'>"+li_active+"<i class='remove_me'></i></span>");
			
			var input_val=add_coma($("input."+opt.inner).val(),li_active,";");
			$("input."+opt.inner).val(input_val);
			$(".auto_suggest_absolute").remove();
		}
		return false;
	} */
	$("input").keydown(function(event){
		if(event.keyCode == 13) {
            if($(this).parents('form').hasClass('accept_enter')) return true;
            
			event.preventDefault();
			return false;
		}
	}); 
	
	/* update_auto_suggest_input = function(span)
	{
		var r="",id="";
		$("span."+span+" span").each(function(){
			r=add_coma(r,$(this).text(), ";");
			id=add_coma(id,$(this).attr('tag_id'),",");
		});
		$("input."+span).val(r);
		$("input."+span+'_id').val(id);
	}
	 */

	$.fn.auto_suggest_append=function(opt){
	   
       var default_={limit:15};
	   var opt= $.extend({},default_,opt);
       
		var this_=$($(this).selector);
		this_.click(function(){
			$(this).find("input.input_suggest").focus();
		});
		var input_suggest=this_.find("input.input_suggest");
		var key8=0;
		input_suggest.live('keyup',function(e){
		  
          var catid = $("select#select_ask_catid");
          if(catid.val() == "") {
               catid.addClass('error');
               return;
          }
          catid.removeClass('error');
			
			$(this).attr('size', $(this).val().length);
			if(e.keyCode!=13 && e.keyCode!=40 && e.keyCode!=38&& e.keyCode!=37&& e.keyCode!=39 && e.keyCode!=13){
				if($(this).val().length>=1){

					$("body").append("<div class='auto_suggest_absolute'></div>");
					$(".auto_suggest_absolute").css({"top":this_.offset().top+this_.height()+3+'px',"left":this_.offset().left});
                    
                    var url = opt.url+"?limit="+opt.limit+"&key="+$(this).val().split(" ").join("-")+"&showed="+$("input."+opt.inner+"_id").val() + "&catid="+catid.val(); 
                    
					$(".auto_suggest_absolute").load(url);
					}
					else
					{
						$(".auto_suggest_absolute").remove();
					}
				}
				else if(e.keyCode ==13)
				{ 
					callback_suggest_append_input({inner:opt.inner});
					update_auto_suggest_input(opt.inner);
					input_suggest.val('').focus();
					return false;
				}
				(e.keyCode==8)? key8--:key8=$(this).val().length;
				
				if(input_suggest.val()=="" && key8<0 && e.keyCode==8)
				{
					input_suggest.val($("."+opt.inner).find('span:last').text());
						$("."+opt.inner).find('span:last').remove();
						update_auto_suggest_input(opt.inner);
					
				}
				return false;
			
			
		});
		$(".auto_suggest_absolute").find("li.active").find("a.tag_name").live('click',function(){
			callback_suggest_append_input({inner:opt.inner});
			update_auto_suggest_input(opt.inner);
			input_suggest.val('').focus();
			return false;
		});
		$(document).click(function(){
			$(".auto_suggest_absolute").remove();
		});
		input_suggest.select_updown(".auto_suggest_absolute");
		
		$("i.remove_me").live('click',function(){
			$(this).parent("span.each_tag").remove();
			update_auto_suggest_input(opt.inner,"append_span");
		});
		
	}
	

	
	scroll_to=function(c){
		$('body,html').animate({scrollTop : $(c).offset().top},'slow');
		return false;
	}
	
	
	$("font,span,a,div,h1,h2,h3,h4,i").live('mouseenter',function(){
		var this_=$(this);
		var type=this_.attr('t_title');
		var type_1=this_.attr('t_title_1'); 
		var type_2=this_.attr('t_title_2'); 
		if(type!=undefined)
		{
			$(".t_title_abso").removeClass("style_1");
			$(".t_title_abso").removeClass("style_2");
			$(".t_title_abso").css({top:this_.offset().top - this_.height()-20+'px',left:this_.offset().left+'px'}).fadeIn()
			.find(".content").text(type);
		}
		else if(type_1!=undefined)
		{ 
			$(".t_title_abso").removeClass("style_2").addClass("style_1")
			.css({top:this_.offset().top  + 'px',left:this_.offset().left + this_.width()+ 8 +'px'}).fadeIn()
			.find(".content").text(type_1);
		}
		else if(type_2!=undefined)
		{ 
			$(".t_title_abso").removeClass("style_1").addClass("style_2").find(".content").text(type_2); 
			$(".t_title_abso").css({top:this_.offset().top - 4 + 'px',left:this_.offset().left - $(".t_title_abso").width() - 30 +'px'}).fadeIn();
			
		}
		
	}).live('mouseout',function(){
			$(".t_title_abso").hide();
	});
	
	
	
	
var resize_topic_mouse_down=false, mouseY=0,height_topic_change=0;
$.fn.resize_topic=function(opt){
		var default_={height:100,min_height:100};
		var opt= $.extend({},default_,opt);
		var this_=$($(this).selector);
		if(this_.children('.resize_mouse').length==0)
		this_.append("<div class='resize_mouse'></div>");
		this_.children('.content').css({height:opt.height+'px'});
		
		
		this_.find('.resize_mouse').mousedown(function(e){ 
			resize_topic_mouse_down=true;
			mouseY = e.pageY; 
			height_topic=this_.children('.content').height();
		});
		
		$(document).mouseup(function(){
			if(resize_topic_mouse_down){
			resize_topic_mouse_down=false; height_topic=height_topic_change;
			}
		});
		
		$(window).mousemove(function(e){// alert(height_topic);
			if(resize_topic_mouse_down)
			{	var distant=e.pageY-mouseY;  
				var frame = this_.find('.content'); 
				height_topic_change=distant+height_topic;
				if(height_topic_change>opt.min_height)
				frame.css({height:height_topic_change+'px'});
			} 
			
		});
		
	}
	var alert_once_times = false;
	$.fn.my_validate=function(opt){
		
		var error = false;
		var default_={length:1, divshow:'',type:'input'};
		var opt= $.extend({},default_,opt);
		var this_=$($(this).selector);
		this_.removeClass('error'); 
		$(opt.divshow).fadeOut();
		
        if(opt.type == 'input')
        var val = this_.val();
        else if(opt.type=='editor')
        {
            val =  this_.find("iframe").contents().find("body").text();
        }
        
		if(val.length < opt.length)
		{
			
			$(opt.divshow).fadeIn();
			if(!alert_once_times){
				alert("Có lổi xãy ra, vui lòng kiểm tra lại các thông tin");
				alert_once_times = true;
			}
			opt.form.preventDefault();
			
		}
			
		
	}
	$.fn.ajax_check_login=function(opt){
		
		var error = false;
		var default_={url:base_url+'user/ajax_check'};
		var opt= $.extend({},default_,opt); 
		var this_=$(this);
		
		this_.live('click',function(){ var this__ = $(this);
		$.ajax({
				type:"POST",
				data:{}, 
				dataType:"json",
				url:opt.url,
				success: function (data){
					if(!data.ok)
					{ 
						open_promt_front_end({url:base_url+'user/ajax_form_login'});
						return false;
					}
					else
					{ 
						if(opt.func != undefined)
						{
							var fn = window[opt.func];
							fn(this__);
						}
						
					}
				
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
				
				
			});
		});
	}
    
	if(!$(".alert_message_abso").length)
		$('body').append('<div class="alert_message_abso"></div>');
	var  alert_message_abso = $(".alert_message_abso");
    show_alert_message = function(str)
	{
		str = str.replace('...','')+ ' ...';
		alert_message_abso.html(str).css('margin-left','-' + alert_message_abso.width()/2 + 'px').fadeIn();
		setTimeout(function(){
				alert_message_abso.fadeOut();  
		},3000);
	}
	if(alert_message!='')
	show_alert_message(alert_message);
	
	
	
	
});


