jQuery(document).ready(function ($) {
	/*var jsvar = "<?php $popis?>";
	$(".more").click(function () {
		window.open(jsvar);
	});*/
	$(document).on("click", ".open-modal", function (e) {
		e.preventDefault();
		var t = $(this);
		var href = t.attr("data-target");
		var modal = $(document).find(".modal" + href);
		var back = $(document).find(".filter-back");
		if (modal.length > 0) {
			modal.addClass("active");
			back.addClass("active");
		}
	});
	$(document).on("click", ".filter-back", function (e) {
		e.preventDefault();
		var t = $(this);
		var html = $("html");
		var modal = $(document).find(".modal");
		if (modal.hasClass("active") && t.hasClass("active")) {
			modal.removeClass("active");
			t.removeClass("active");
			html.removeClass("remove");
		}
	});
	$(document).on("click", ".modal .exit", function (e) {
		e.preventDefault();
		var back = $(document).find(".filter-back");
		var html = $("html");
		var modal = $(document).find(".modal");
		if (modal.hasClass("active") && back.hasClass("active")) {
			modal.removeClass("active");
			back.removeClass("active");
			html.removeClass("remove");
		}
	});
	$(document).on("input", "#search", function () {
		const t = $(this);
		let value = t.val();
		if (value !== "") {
			$.ajax({
				type: "GET",
				url: window.location.href,
				data: { searchValue: value },
				success: function (response) {
					$(document).find(".search-collection").html();
					//setTimeout(function () {
					$(document).find(".search-collection").html(response);
					//}, 500);
				},
			});
		} else {
			$.ajax({
				type: "GET",
				url: window.location.href,
				data: { resetPosts: true },
				success: function (response) {
					$(document).find(".search-collection").html();
					setTimeout(function () {
						$(document).find(".search-collection").html(response);
					}, 500);
				},
			});
		}
	});

	$(document).on("change", "select[name='categories']", function (e) {
		e.preventDefault();
		var t = $(this);
		var value = t.val();
		$.ajax({
			type: "GET",
			url: window.location.href,
			data: { categoriesValue: value },
			success: function (response) {
				$(document).find(".search-collection").html();
				//setTimeout(function () {
				$(document).find(".search-collection").html(response);
				//}, 500);
			},
		});
	});

	$(document).on("change", "select[name='rad']", function (e) {
		e.preventDefault();
		var t = $(this);
		var value = t.val();
		$.ajax({
			type: "GET",
			url: window.location.href,
			data: { radValue: value },
			success: function (response) {
				$(document).find(".search-collection").html();
				//setTimeout(function () {
				$(document).find(".search-collection").html(response);
				//}, 500);
			},
		});
	});
});
