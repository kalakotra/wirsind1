jQuery.noConflict();

(function($) {
	$(document).ready(function() {
		$(".hamburger").click(function() {
			$(".hamburger").toggleClass("is-active");
			$("#mobileMenu").toggleClass("is-active");
		});

		$("#mobileMenu .arrow").on("click", function() {
			var myHolder = $(this).parent();
			myHolder.toggleClass("active");
		});

		$(window).scroll(function() {
			if ($(document).scrollTop() > 100) {
				$('header').addClass('scrolled');
			} else {
				$('header').removeClass('scrolled');
			}
		});
		var memberBoxLoadMoreLinkClickedNew = 0;
		var myActLink = window.location.href.replace(window.location.hash,"");
		$('.memberBoxLoadMoreButton').on("click", function() {
			$('html, body').animate({
				scrollTop: $(this).offset().top - 120
			}, 500);
			$(this).parent().addClass('d-none');
			$($(this).data("target")).removeClass('d-none');

			memberBoxLoadMoreLinkClickedNew = memberBoxLoadMoreLinkClickedNew + 1;
			history.pushState({}, '', myActLink + '#' + memberBoxLoadMoreLinkClickedNew);
		});

		var LoadMoreButtonTime = 1000;
		var memberBoxLoadMoreLinkClicked = 0;
		$("#memberBoxLoadMoreButton").on("click", function() {

			$('html, body').stop().animate({
				scrollTop: $(this).offset().top - 120
			}, 500);

			var myLink = $("a.memberBoxLoadMoreLink").last().attr("href");
			
			var myHolder = $("#memberBoxLoading").append('<div>');
			$("#memberBoxLoading div").last().load(myLink + " #memberBoxTopHolder ", function(responseTxt, statusTxt, xhr) {

			});

			memberBoxLoadMoreLinkClicked = memberBoxLoadMoreLinkClicked + 1;
			history.pushState({}, '', 'https://www.wirsind1.at/epu-netzwerk/#' + memberBoxLoadMoreLinkClicked);

			$("a.memberBoxLoadMoreLink").last().parent().remove();

			setTimeout(function() {
				if ($("a.memberBoxLoadMoreLink").length == 0) {
					$("#memberBoxLoadMoreButton").remove();
				} 
			}, LoadMoreButtonTime);
		});

		if ($(".memberBoxLoadMoreButton").length > 0) {
			if (window.location.hash != "") {
				var myHash = window.location.hash;
				// if hash is numeric, click the load more button x hash times
				if (myHash.replace("#", "") != "") {
					var myHash = myHash.replace("#", "");
					if ($.isNumeric(myHash)) {
						for (var i = 0; i < myHash; i++) {
							// get first load more button
							var myButton = $('.memberBoxLoadMoreButtonHolder:not(.d-none) button.memberBoxLoadMoreButton').first();
							myButton.trigger("click");
						}
					}
				}
			}
		}

		$("#memberBoxIndustryFilter, #memberBoxRegionFilter").on("change", function() {

			$("#noSearchResults").hide();
			$("#memberBoxLoading").html("");
			var myFilter = "?fli=1";
			if ($("#memberBoxIndustryFilter").val() != "") {
				var myFilter = myFilter + "&ind=" + $("#memberBoxIndustryFilter").val();
			}

			if ($("#memberBoxRegionFilter").val() != "") {
				var myFilter = myFilter + "&bz=" + encodeURIComponent($("#memberBoxRegionFilter").val());
			}

			if ($("#memberBoxTextFilter").val() != "") {
				var myFilter = myFilter + "&tx=" + $("#memberBoxTextFilter").val();
			} 


			var myLink = $(this).data("href")+myFilter;

			window.location.href = myLink;

			//history.pushState({}, '', myLink);

			/*var myHolder = $("#memberBoxLoading").append('<div>');
			$("#memberBoxTopHolder").last().load(myLink + " #memberBoxTopHolder > div", function(responseTxt, statusTxt, xhr) {

			});

			setTimeout(function() {
				if ($("a.memberBoxLoadMoreLink").length == 0) {
					$("#memberBoxLoadMoreButton").hide();
				} else {
					$("#memberBoxLoadMoreButton").show();
				}

				if ($("#memberBoxTopHolder > div").length == 0) {
					$("#noSearchResults").show();
				}
			}, LoadMoreButtonTime);*/
		});

		var myTimer = "";
		$("#memberBoxTextFilter").on("keyup", function() {
			clearTimeout(myTimer);
			if ($(this).val().length > 2 || $(this).val().length == 0) {
				myTimer = setTimeout(function() {
					$("#memberBoxIndustryFilter").trigger("change");
				}, 1000);
			}
		});

		$(".fbShare").on("click", function() {
			window.open($(this).data("src"), 'Facebook share');
			return false;
		});

		if( $("body.BlogPost").length > 0 ) {
			if ( $(".similarBlog").length == 0 ) {
				$(".similarBlogHolder").hide();
			}
		}
	});
}(jQuery));
