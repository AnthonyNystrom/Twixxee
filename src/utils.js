var utils = {
	// From http://taiyolab.com/mbtweet
	r : function() {
		return (((1 + Math.random()) * 0x10000) | 1).toString(16).substring(1);
	},

	// From http://taiyolab.com/mbtweet
	guid : function() {
		return (utils.r() + utils.r() + "-" + utils.r() + "-" + utils.r() + "-" + utils.r() + "-" + utils.r() + utils.r() + utils.r());
	},
	
	mergeHashes : function(h1, h2) {
		var h = {};
		for (var key in h1)
			h[key] = h1[key];
		for (var key in h2)
			h[key] = h2[key];
		return h;	
	},
	
	outerHtml : function(stuff) {
		return jQuery("<div>").append(stuff).html();
	},
	
	showAbout : function() {
		jQuery("#aboutText").dialog({
			modal: true,
			closeOnEscape: false,
			height: 300,
			width:500,
			resizable: false,
			title: 'About Twixxee',
			show: 'blind',
			hide: 'blind',
			buttons: {
				Close: function() {
					jQuery(this).dialog('close');
				}
			}
		});

	}
};
