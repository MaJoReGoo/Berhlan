var $body = $('body'),
	$window = $('window'),
	headerOpen = false,
	$window = $(window),
	$document = $(document),
	footerFixed = false,
	statsInserted = false;

$document.ready(function() {
	$body.on('click','#menu-trigger', _hToggle);
	$window.on('scroll', _pHor);
	$window.on('resize', _footFix);
	$window.on('beforeunload', _trackUnload);
	$(".chart-bar").each(_chartBar);
	$(".list-ol").each(_listOL);
	$(".share-links").find('a').on('click', _handleShares);
	$("a[href^=#]").on('click', _handleHashScroll);
	_hImgScale();
	_footFix();
	_track();
});

var _hToggle = function() {
	headerOpen ? $body.removeClass('headerOpen') : $body.addClass('headerOpen');
	$body.addClass('disableMouse');
	setTimeout(function() {
		$body.removeClass('disableMouse');
	},500);
	headerOpen = !headerOpen;	
}
var _pHor = function() {
	$body.scrollLeft = 0;
}
var _hImgScale = function() {
	$img = $("div.header-image");
	if($img.length > 0) {
		$img.css("background-image", "url("+$img.data('src')+")");
		$img.removeData('src');
	}
}
var _footFix = function() {
	var heightXL = $window.height() < $document.height();
	if(heightXL && footerFixed) {
		$body.removeClass('height-s-window');
		footerFixed = false;
	} else if(!heightXL && !footerFixed) {
		$body.addClass('height-s-window');
		footerFixed = true;
	}
}
var _chartBar = function() {
	var $this = $(this),
		$data = $this.data();
		dataset = eval($data.set),
		w = 100/dataset.length+"%",
		max = getMax(dataset,[1]),
		datasetlabel = eval($data.set+"_label"),
		datasetupdated = eval($data.set+"_updated");
	for(var i=0;i<dataset.length;i++) {
		var h = dataset[i][1]*90/max +"%",
			hinner = dataset[i][2]*100/max + "%",
			tooltipposgt = dataset.length < 10 ? "left:50%": "left:150%",
			tooltiplt = dataset.length < 10 ? "right:50%" : "right: 150%";
			tooltippos = i<dataset.length/2 ? tooltipposgt : tooltiplt;
		$barcont = $('<div class="bar-container"></div>');
		if(dataset[i][3] == "invert") { $barcont.addClass('invert') }
		$barcont.append('<div class="bar main" style="height: '+h+'"></div><div class="bar sub" style="height: '+hinner+'"></div>');
		$tooltip = $('<div class="tooltip" style="'+tooltippos+'"></div>');
		for(var ii=0;ii<dataset[i].length;ii++) {
			if(dataset[i][ii] !== "invert" && dataset[i][ii] !== undefined) {
				var text = datasetlabel[ii] == "" ? dataset[i][ii] : datasetlabel[ii]+": "+dataset[i][ii];
				$tooltip.append('<p>'+text+'</p>');
			}
		}
		$barcont.append($tooltip);
		$this.append($barcont);
	}
	$this.find('.bar-container').css({width: w});
	$this.prev('h5.subhead').text('Will update in less than '+Math.ceil(datasetupdated/60)+' minutes');
}
var _listOL = function(e) {
	var $this = $(this),
		$data = $this.data(),
		dataset = eval($data.set);
		$ol = $('<ol></ol>')
		for(var i=0;i<dataset.length;i++) {
			$li = $('<li></li>');
			var d = dataset[i][1].replace("http://www.ericwenn.se","");
			$li.append(dataset[i][1].indexOf("http://") !== -1 ? '<a href="'+dataset[i][1]+'" title="'+d+'">'+d+'</a>' : d);
			$li.append(dataset[i][0] !== undefined ? ' â€” '+dataset[i][0] : '');
			$ol.append($li);
		}
		$this.append($ol);
}
var getMax = function(a,k) {
	var r;
	for(var i=0;i<a.length;i++) {
		var needle;
		if(k!== undefined) {
			needle = a[i][k];
		} else {
			needle = a[i];
		}
		if(i==0) {
			r = needle;
		} else {
			if(needle>r) {
				r=needle;
			}
		}
	}
	return r;
}
var _track = function() {
	var trackobj = {};
	trackobj.ref = document.referrer;
	trackobj.page = window.location.href;
	trackobj.width = $window.innerWidth();
	trackobj.height = $window.innerHeight();

	var src = 'http://www.ericwenn.se/php/tracking.php';
	var i = 0;
	$.each(trackobj, function(k,v) {
		src += (i==0?'?':'&')+k+'='+encodeURIComponent(v);
		i++;
	});
	$("#_ewt_beacon").attr('src', src);
}
var _trackUnload = function() {
	var req = new XMLHttpRequest();
    req.open("GET", "http://www.ericwenn.se/php/tracking_unload.php",false); // false
    req.send();
}
var _handleShares = function(e) {
	$this = $(this),
	target = $this.attr('href');
	e.preventDefault();
	window.open(target, 'Share on Twitter', 'height=420,width=550');
}
var _handleHashScroll = function(e) {
	e.preventDefault();
	var t = $(this.hash);
	if(t.length > 0) {
		$body.animate({scrollTop: t.offset().top},500);
		window.location.hash = this.hash;
	}
}
