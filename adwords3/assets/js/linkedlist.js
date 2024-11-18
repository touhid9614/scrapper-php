(function ($) {
	var linkedlist_options;

	$.fn.extend({
		LinkedList: function (options) {
			var defaults = {
				expanded: false,
				itemClick: false
			};

			options = $.extend(defaults, options);
			$(this).addClass('LinkedList');
			linkedlist_options = options;
			activateTree(this, options);
		},
		LLItemAdded: function (li) {
			$(li).click(linkedlist_item_clicked);
		}
	});

	// This function traverses the list and add links
	// to nested list items
	function activateTree(olist) {
		$.each($(olist).find('ul'), function (i, v) {
			var display_val = 'none';
			if (linkedlist_options.expanded) display_val = 'block';
			$(v).css('display', display_val);
		});

		olist.click(toggleBranch);
		addLinksToBranches(olist);
	}

	// This is the click-event handler
	function toggleBranch(event) {
		var oBranch, cSubBranches;
		if (event.target) {
			oBranch = event.target;
		} else if (event.srcElement) { // For IE
			oBranch = event.srcElement;
		}
		cSubBranches = oBranch.getElementsByTagName("ul");
		if (cSubBranches.length > 0) {
			if (cSubBranches[0].style.display == "block") {
				cSubBranches[0].style.display = "none";
			} else {
				cSubBranches[0].style.display = "block";
			}
		}
	}

	// This function makes nested list items look like links
	function addLinksToBranches(olist) {
		$.each($(olist).children('li'), function (index, value) {
			$(value).addClass('HandCursorStyle');
			$(value).click(linkedlist_item_clicked);
			if ($(value).children('ul').length > 0) {
				$(value).addClass('expandable');
				$(value).children('ul').addClass('nestedGroup');

				$.each($(value).children('ul'), function (i, v) {
					addLinksToBranches(v);
				});
			}
		});
	}

	function linkedlist_item_clicked(event) {
		if (linkedlist_options.itemClick) {
			linkedlist_options.itemClick(this);
		}
		toggleBranch(event);
		return false;
	}
})(jQuery);