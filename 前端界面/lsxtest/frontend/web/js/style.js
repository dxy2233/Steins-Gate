//根据屏幕设定html根目录文字字号
/*var dis = $(window).width()/750;
$('html').css('fontSize',dis*100+'px');
$(window).resize(function(){
   var dis = $(window).width()/750;
   $('html').css('fontSize',dis*100+'px');
});*/

(function(doc, win) {
	var docEl = doc.documentElement,
		resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
		recalc = function() {
			var clientWidth = docEl.clientWidth;
			if(!clientWidth) return;
			docEl.style.fontSize = 100 * (clientWidth / 750) + 'px';
		};

	if(!doc.addEventListener) return;
	win.addEventListener(resizeEvt, recalc, false);
	doc.addEventListener('DOMContentLoaded', recalc, false);
})(document, window);

// 只能输入数字和一位小数点和小数点后面两位小数
function clearNoNum(ticket){
	if(!/^\d+(?:\.\d)?$/.test(ticket)){
		return false;
	}else{
		return true;
	}

}


 
