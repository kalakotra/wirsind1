<% include Carousel CarouselID='homeSlider', CarouselCustomClass='crossfade', CarouselIndicator=1, CarouselLoop=$HomeSlide.exclude("Inactive", 1) %>

<% if getMyClass("VideoPage") %>
	<% with getMyClass("VideoPage").First %>
		<section>
			<div class="container py-3 py-lg-5">
				<div class="row justify-content-center">
					<div class="col-12 col-md-4 text-center order-2 order-md-1">
						<video controls poster='$getRandomVideo.poster'  width="280" height="497">
                            <source src="$getRandomVideo.video" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
					</div>
					<div class="col-12 col-md-4 offset-md-1 order-1 order-md-2">
						<div class="h1 fw-bold mb-0">
							$PreviewTitle
						</div>
						<div class="text-dark py-3">
							$PreviewText
							<div class="py-1">
								<a href="$Link" class="btn btn-dark rounded-pill px-4">Mehr erfahren</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<% end_with %>
<% end_if %>

<section class="yellowBgSection">
	<div class="container py-3 py-lg-5">
		<div class="row">
			<div class="col-12 text-center py-3 py-lg-5">
				<div class="h1 fw-bold mb-0">$ProfilesTitle</div>
				<div class="text-dark py-3">$ProfilesText</div>
				<% if ProfilesLinkTitle %>
					<a href="$ProfilesLinkURL" class="btn btn-dark rounded-pill px-4">$ProfilesLinkTitle</a>
				<% end_if %>
			</div>
			<div class="col-12 py-3 py-lg-5">
				<div class="row memberBoxTopHolder">
					<% loop getMyMembers.sort("Created DESC").limit(3) %>
						<div class="col-12 col-md-6 col-xl-4 py-3" data-info="$New - $Deactivated">
							<div class="memberBoxHolder shadow p-3 px-lg-5 text-center rounded-xl h-100 ">
								<div class="rounded-circle overflow-hidden d-inline-block ms-auto me-auto">
									<% if $Image %>
										$Image.FocusFill(150,150)
									<% end_if %>
								</div>
								<a href="{$Top.getMyClass('FilterPage').exclude('ClassName', 'FormularPage').First().Link}details/{$ID}/$URLSegmentCompany" class="d-block stretched-link text-decoration-none text-body">{$Name}<% if $Region %>, $Region<% end_if %></a>
								<div class="h3 fw-bold px-lg-5">
									$CompanyName
								</div>
							</div>
						</div>
					<% end_loop %>
				</div>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">
		<div class="row py-3 py-lg-5">
			<div class="col-12 text-center">
				<div class="h1 fw-bold mb-0">$BlogTitle</div>
				<div class="text-dark py-3">$BlogText</div>
			</div>
			<div class="col-12 py-3 py-lg-5">
				<div class="row memberBoxTopHolder">
					<% loop getBlogPost.sort("PublishDate DESC").limit(3) %>
						<div class="col-12 col-md-6 col-xl-4 py-3">
							<div class="rounded-xl h-100 shadow overflow-hidden blogListBox mx-lg-4-">
								$FeaturedImage.FocusFill(600,300)
								<div class="py-3 px-4">
									<a href="$Link" class="text-decoration-none text-body stretched-link"><% with Categories.First %>$Title<% end_with %></a>
									<div class="fw-bold h3">$Title</div>
								</div>
							</div>
						</div>
					<% end_loop %>
				</div>
			</div>
			<div class="col-12 text-center">
				<a href="blog/" class="btn btn-dark rounded-pill px-4">Alle anzeigen</a>
			</div>
		</div>
	</div>
</section>

<main>
	<div class="container py-3 py-lg-5">
		<div class="row justify-content-center">
			<div class="col-12 col-md-8">
				<article>
					<h1 class="fw-bold text-center">$Title</h1>
					<div class="content text-dark">$Content</div>
				</article>
			</div>
		</div>
	</div>
</main>