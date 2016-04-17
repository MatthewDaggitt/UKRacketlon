<div data-animation-time="250" class="bd-smoothscroll-3">
	<a href="#" class=" bd-backtotop-1">
		<span class=" bd-icon-66"></span>
	</a>
</div>

<script>
	// Script to control graceful "Smoothscroll" button placement
	var notBottomHeight = 20;
	var bottomHeight = 85;

	var win = jQuery(window);
	var doc = jQuery(document);

	jQuery(window).scroll(function(e)
	{
		var scrollBottom = doc.height() - win.height() - win.scrollTop();

		var value;
		if(scrollBottom + notBottomHeight > bottomHeight)
		{
			value = notBottomHeight;
		}
		else
		{
			value = bottomHeight - scrollBottom;
		}

		jQuery(".bd-smoothscroll-3").css("bottom", value)
	});
</script>