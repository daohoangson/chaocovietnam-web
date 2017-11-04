/**
 * Script is written by Dao Hoang Son
 * Email: daohoangson at gmail dot com
 * Chao Co Viet Nam@05-09-2010
**/
function isYES(response) {
	if (response == 'no' || response == '') {
		// it's a NO
		return false;
	} else {
		// it should be a YES now
		return true;
	}
}

/**
 * The main handler to play lyrics
 * It catches <div> with id in the format "al<second>" 
 * They are processes and ready to be used later on
 * Support both audio tag and flash
**/
var LyricsPlayer = function() {
	$al = $('#anthem_lyrics div');
	var lyrics = new Array();
	$al.each(function(i) {
		var t = parseFloat($(this).attr('id').substr(2));
		if (t > 0) {
			var l = $(this).text();
			lyrics.push({"time":t,"lyrics":l});
		}
	});
	this.lyrics = lyrics;
}
LyricsPlayer.prototype = {
	audioTag: function(audio) {
		if (typeof audio.addEventListener == 'function') {
			audio.addEventListener('timeupdate', this.timeupdate, true);
		}
	}
	,timeupdate: function(tu) {
		// process audio tag
		var ct = tu.target.currentTime;
		lyricsPlayer.display(ct);
	}
	,flash: function() {
		this.flash = document.getElementById('anthem');
		if (typeof this.flash != "undefined") {
			setInterval('lyricsPlayer.interval();',250);
		}
	}
	,interval: function() {
		// process flash (2)
		if (typeof this.flash.GetVariable == 'function') {
			var ct = this.flash.GetVariable('songPosition')/1000;
			this.display(ct);
		}
	}
	,display: function(second) {
		if (typeof this.displayer == 'undefined') {
			this.displayer = document.createElement('div');
			var $d = $(this.displayer);
			var $f = $('#flag');
			$d.addClass('lyrics_over_flag')
				.css('position','absolute')
				.insertAfter($f);
			
			$f.resize(function() {
				var offset = $f.offset();
				var fs = parseInt($d.css('font-size'));
				var newfs = $f.width()/35;
				if (fs != newfs) {
					$d.css('font-size',newfs);
					fs = newfs;
				}
				$d.css('top',offset.top + $f.height() - (fs + 10))
					.css('left',offset.left)
					.css('width',$f.width());
			});
			$f.resize();
		}
		var newText = null;
		for (var i = 0; i < this.lyrics.length; i++) {
			var l = this.lyrics[i];
			if (l.time < second) {
				newText = l.lyrics;
			}
		}
		if (newText == null) {
			//$(this.displayer).text('');
		} else if ($(this.displayer).text() != newText) {
			$(this.displayer).text(newText);
			$(this.displayer).css('opacity',0)
				.animate({opacity:1},'fast');
		}
	}
};
var lyricsPlayer;

/** 
 * Detects browser support for audio tag (HTML5), audio object
 * Or fall back to use flash to play anthem
 * There must be a global anthem object with mp3, ogg and flash pre-defined!
**/
function setupAnthem() {
	// use various methods to play our beloved national anthem
	var audio = document.createElement('audio');
	var audioTagSupport = !!(audio.canPlayType);
	lyricsPlayer = new LyricsPlayer();
	
	if (audioTagSupport) {
		// wow, use audio tag now
		audio.id = 'anthem';
		//audio.autoplay = 'autoplay';
		audio.controls = 'controls';
		audio.alt = anthem.alt;
		audio.title = anthem.title;
		lyricsPlayer.audioTag(audio);
		$(audio).insertAfter($('#flag'));
		
		//determine which format to choose (mp3 or ogg)
		if (isYES(audio.canPlayType('audio/ogg'))) {
			var anthem_link = anthem.ogg;
		} else {
			var anthem_link = anthem.mp3;
		}
		// start loading
		audio.src = anthem_link;
	} else {
		// no audio tag support
		try {
			// at first, try the Audio class...
			var audioObj = new Audio('');
			
			if (isYES(audioObj.canPlayType('audio/ogg'))) {
				var anthem_link = anthem.ogg;
			} else {
				var anthem_link = anthem.mp3;
			}
			// we got here, everything seems to be fine
			
			var realAudioObj = new Audio(anthem_link);
			realAudioObj.play();
		} catch (e) {
			// building flash object/embed code
			try {
				// building dom elements
				var object = document.createElement('object');
				object.id = 'anthem';
				object.classid = 'clsid:D27CDB6E-AE6D-11cf-96B8-444553540000';
				object.codebase = 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0'; // flash version 6
				object.width = 165;
				object.height = 37;
				
				var paramMovie = document.createElement('param');
				paramMovie.name = 'movie';
				paramMovie.value = anthem.flash;
				object.appendChild(paramMovie);
				
				var paramAllow = document.createElement('param');
				paramAllow.name = 'allowScriptAccess';
				paramAllow.value = 'always';
				object.appendChild(paramAllow);
				
				var embed = document.createElement('embed');
				embed.src = anthem.flash;
				embed.width = 165;
				embed.height = 37;
				embed.allowScriptAccess = 'always';
				embed.type = 'application/x-shockwave-flash';
				embed.pluginspage = 'http://www.macromedia.com/go/getflashplayer';
				object.appendChild(embed);
				
				$(object).insertAfter($('#flag'));
			} catch (e) {
				// ugliest: writing html directly. IE sucks all the time
				html = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" ';
				html += 'id="anthem" ';
				html += 'codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" ';
				html += 'width="165" height="37">';
				html += '<param name=movie value="' + anthem.flash + '">';
				html += '<param name="allowScriptAccess" value="always" />';
				html += '<embed src="' + anthem.flash + '" width="165" height="37" allowScriptAccess="always" ';
				html += 'type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">';
				html += '</embed>';
				html += '</object>';
				
				var dumb = document.createElement('div');
				dumb.id = 'anthem_container';
				dumb.innerHTML = html;
				
				$(dumb).insertAfter($('#flag'));
			}
			lyricsPlayer.flash();
		}
	}
}

/**
 * Scale the flag to fit the viewport
 * Actually, make the #primary fit the viewport by scaling the #flag
**/
function scaleFlag(min) {
	var $p = $('#primary');
	var $f = $('#flag');
	var $w = $(window);
	var ofW = $f.width();
	var ofH = $f.height();
	$w.resize(function() {
		var newfH = Math.min(ofH,Math.max(min,$w.height() - ($p.height() - $f.height())));
		var newfW = Math.min(ofW,Math.max(min,$p.width()));
		if (newfH/ofH < newfW/ofW) newfW = Math.floor(newfH/ofH*ofW); else newfH = Math.floor(newfW/ofW*ofH);
		$f.css('width',newfW).css('height',newfH);
	});
	$w.resize();
}

/**
 * Displays the subscribe form
**/
function setupSubscribe() {
	if (!window.requestAnimationFrame) {
		return;
	}

	var raf = window.requestAnimationFrame;
	var $sf = $('#subscribe_simple');
	var w = $sf.width();
	var w3 = -1 * w;
	$sf.css('display','block')
		.css('position','absolute')
		.css('top',0)
		.css('left',w3);
	$sf.click(function(e) {
		if (e.target.tagName && e.target.tagName.toLowerCase() == 'input') return;
		if (parseInt($sf.css('left')) != w3) $sf.animate({left: w3},'fast'); else $sf.animate({left: 0},'fast');
	});

	var doPosition = function() {
		var top = Math.floor(($(window).height() - $sf.height())/2) + $(window).scrollTop();
		$sf.css('top',top + 'px');
		raf(doPosition);
	};
	doPosition();
}
