//根据屏幕设定html根目录文字字号
var dis = $(window).width()/750;
$('html').css('fontSize',dis*100+'px');
$(window).resize(function(){//对浏览器窗口调整大小进行计数
   var dis = $(window).width()/750;
   $('html').css('fontSize',dis*100+'px');//方法用于按照指定的尺寸来显示字符串。
});

//(function(doc, win) {
//	var docEl = doc.documentElement,
//		resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
//		recalc = function() {
//			var clientWidth = docEl.clientWidth;
//			if(!clientWidth) return;
//			docEl.style.fontSize = 100 * (clientWidth / 750) + 'px';
//		};
//
//	if(!doc.addEventListener) return;
//	win.addEventListener(resizeEvt, recalc, false);
//	doc.addEventListener('DOMContentLoaded', recalc, false);
//})(document, window);


 
