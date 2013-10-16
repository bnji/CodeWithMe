$(function() {
	//alert(storage.get('isFirstTime'));


	createTip("#my-solutions", "bottom", "Step 1", "You'll find all your solutions here.<br /><button id='goToTip2' type='button' class='btn btn-primary'>Next...</button>");
	createTip("#friends-solutions", "bottom", "Step 2", "You'll find all your solutions here.<br /><button id='goToTip3' type='button' class='btn btn-primary'>Next...</button>")
	createTip("#menu-file", "bottom", "Step 3", "You'll find all your solutions here.<br /><button id='goToTip4' type='button' class='btn btn-primary'>Next...</button>");
	createTip("#menu-account", "bottom", "Step 4", "You'll find all your solutions here.<br /><button id='goToTip5' type='button' class='btn btn-primary'>Next...</button>");
	//showTip("#my-solutions");
	//showTip("#friends-solutions");
	//showTip("#menu-file");



	$("#goToTip2").click(function(e) {
		hideTip("#my-solutions");
		showTip("#friends-solutions");
    	e.preventDefault();
	});

	$("#goToTip3").click(function(e) {
		hideTip("#friends-solutions");
		showTip("#menu-file");
    e.preventDefault();
	});

	$("#goToTip4").click(function(e) {
		hideTip("#menu-file");
		showTip("#menu-account");
    e.preventDefault();
	});

	function createTip(id, placement, title, content) {
		$(id).popover({
			'animation': true,
			'html': true,
			'placement': placement,
			'trigger': 'manual',
			'title': title,
			'content': content,
			'delay': { show: 500, hide: 100 }
		});
	}

	function showTip(id) {
		$(id).popover('show');
	}

	function hideTip(id) {
		$(id).popover('hide');
	}
});