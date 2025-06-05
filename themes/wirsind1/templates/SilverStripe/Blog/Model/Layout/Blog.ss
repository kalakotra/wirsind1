<section class="pageHeader">
	<div class="container py-3 py-lg-5">
		<div class="row justify-content-center">
			<div class="col-12 col-md-8  py-3 py-lg-5">
				<article class="text-center">
					<h1 class="fw-bold">$Title</h1>
				</article>
			</div>
		</div>
	</div>
</section>
<main>
	<div class="container py-3 py-lg-5">
		<div class="row justify-content-center">
			<div class="col-12 col-lg-10 text-center blogCatLinks">
				<% if $CurrentCategory %>
					<a href="$Link" class="text-body ">Alle Kategorien</a>
				<% else %>
					<a href="$Link" class="link-dark fw-bold ">Alle Kategorien</a>
				<% end_if %>
				<% loop Categories %>
					<a href="$Link" class="text-body  <% if $Top.CurrentCategory.ID = $ID %>link-dark fw-bold<% end_if %>">$Title $LinkingMode</a> 
				<% end_loop %>
			</div>
			<div class="w-100 py-3"></div>
			<% loop $PaginatedList %>
				<div class="col-12 col-md-6 col-lg-4 py-3 py-lg-4-">
					<div class="rounded-xl h-100 shadow overflow-hidden blogListBox mx-lg-4-">
						$FeaturedImage.FocusFill(600,300)
						<div class="py-3 px-4">
							<a href="$Link" class="text-decoration-none text-body stretched-link"><% loop Categories.First %>$Title<% end_loop %></a>
							<div class="fw-bold h3">$Title</div>
						</div>
					</div>
				</div>
			<% end_loop %>
		</div>
	</div>
</main>