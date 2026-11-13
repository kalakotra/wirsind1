jQuery.noConflict();

function showIframeElement() {
	var iframe = document.getElementById("wallsio-iframe");
	iframe.classList.add("active");
	iframe.setAttribute("src", iframe.getAttribute("data-src"));
	document.querySelector(".walls-holder > div").style.display = "none";
}

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

		// show "Mehr laden" only when a next page link exists
		function updateLoadMoreButton() {
			if ($("a.memberBoxLoadMoreLink").length == 0) {
				$("#memberBoxLoadMoreButton").hide();
			} else {
				$("#memberBoxLoadMoreButton").show();
			}
		}

		function updateNoSearchResults() {
			if ($("#memberBoxTopHolder .memberBoxHolder").length == 0) {
				$("#noSearchResults").show();
			} else {
				$("#noSearchResults").hide();
			}
		}

		if ($("#memberBoxTopHolder").length > 0) {
			updateLoadMoreButton();
			updateNoSearchResults();
		}

		// load next 12 members and append them to the list
		$("#memberBoxLoadMoreButton").on("click", function() {
			var myButton = $(this);
			var myLinkElement = $("a.memberBoxLoadMoreLink").last();
			if (myLinkElement.length == 0 || myButton.prop("disabled")) {
				return;
			}

			// remove variable "paged" from the URL
			var myLink = myLinkElement.attr("href").replace(/&paged=[0-9]*/, "");

			myButton.prop("disabled", true);

			$.get(myLink, function(html) {
				var newItems = $("<div>").append($.parseHTML(html)).find("#memberBoxTopHolder").children();

				// remove old "next" link, the loaded items contain the new one
				myLinkElement.parent().remove();
				$("#memberBoxTopHolder").append(newItems);

				history.pushState({}, '', myLink + "&paged=1");
			}).always(function() {
				myButton.prop("disabled", false);
				updateLoadMoreButton();
			});
		});

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
				var myFilter = myFilter + "&tx=" + encodeURIComponent($("#memberBoxTextFilter").val());
			} 


			var myLink = $(this).data("href")+myFilter;
			history.pushState({}, '', myLink);

			$("#memberBoxTopHolder").load(myLink + " #memberBoxTopHolder > div", function() {
				updateLoadMoreButton();
				updateNoSearchResults();
			});
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



		/*
		// Enable AOS in PageController::init() function first!!!
		AOS.init({
			// Global settings:
			disable: false, // accepts following values: 'phone', 'tablet', 'mobile', boolean, expression or function
			startEvent: 'DOMContentLoaded', // name of the event dispatched on the document, that AOS should initialize on
			initClassName: 'aos-init', // class applied after initialization
			animatedClassName: 'aos-animate', // class applied on animation
			useClassNames: false, // if true, will add content of `data-aos` as classes on scroll
			disableMutationObserver: false, // disables automatic mutations' detections (advanced)
			debounceDelay: 50, // the delay on debounce used while resizing window (advanced)
			throttleDelay: 99, // the delay on throttle used while scrolling the page (advanced)


			// Settings that can be overridden on per-element basis, by `data-aos-*` attributes:
			offset: 120, // offset (in px) from the original trigger point
			delay: 0, // values from 0 to 3000, with step 50ms
			duration: 800, // values from 0 to 3000, with step 50ms
			easing: 'ease', // default easing for AOS animations
			once: false, // whether animation should happen only once - while scrolling down
			mirror: false, // whether elements should animate out while scrolling past them
			anchorPlacement: 'top-bottom', // defines which position of the element regarding to window should trigger the animation

		});
		*/
	});
}(jQuery));
