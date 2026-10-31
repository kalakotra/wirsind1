<section class="pageHeader">
	<div class="container py-3 py-lg-5">
		<div class="row justify-content-center">
			<div class="col-12 col-md-8 col-lg-6">
				<article class="text-center">
					<h1 class="fw-bold">$Title</h1>
					<h2 class="mb-3 mb-lg-5">$Subtitle</h2>
					<a href="$Link(/profil)" class="btn btn-danger btn-lg rounded-pill px-5">Jetzt eintragen</a>
				</article>
			</div>
		</div>
	</div>
</section>
<main>
	<div class="container py-3 py-lg-5">
		<div class="row justify-content-center">
			<div class="col-12 col-md-6 col-lg-4 py-1 py-lg-3">
				<select class="form-select form-select-lg rounded-pill" aria-label=".form-select-lg" id="memberBoxIndustryFilter" data-href="$Link">
					<option selected value="">Alle Branchen</option>
					<% loop getMyClass("MemberIndustry") %>
						<option value="$ID">$Title</option>
					<% end_loop %>
				</select>
			</div>
			<div class="col-12 col-md-6 col-lg-4 py-1 py-lg-3">
				<select class="form-select form-select-lg rounded-pill" aria-label=".form-select-lg" id="memberBoxRegionFilter" data-href="$Link">
					<option selected value="">Alle Bezirke</option>
					<% loop getMemberRegions %>
						<option value="$Region">$Region</option>
					<% end_loop %>
				</select>
			</div>
			<div class="col-12 col-md-12 col-lg-4 py-1 py-lg-3 memberBoxTextFilterHolder">
				<input type="text" name="filterText" id="memberBoxTextFilter" placeholder="Suche" class="form-text form-select-lg rounded-pill w-100">
			</div>
			<div class="col-12 ">
				<div class="row memberBoxTopHolder" id="memberBoxTopHolder">
					<% if getBackLinkMembers %>
						<% loop getBackLinkMembers %>
							<div class="col-12 col-md-6 col-xl-4 py-3">
								<div class="memberBoxHolder shadow p-3 px-lg-5 text-center rounded-xl h-100 ">
									<div class="rounded-circle overflow-hidden d-inline-block ms-auto me-auto">
										<% if $Image %>
											$Image.FocusFill(150,150)
										<% end_if %>
									</div>
									<a href="{$Top.Link}/details/$ID" class="d-block stretched-link text-decoration-none text-body">{$Name}<% if $Region %>, $Region<% end_if %></a>
									<div class="h3 fw-bold px-lg-5">
										$CompanyName
									</div>
								</div>
							</div>
						<% end_loop %>
					<% else %>
						<% loop getMyMembers %>
							<div class="col-12 col-md-6 col-xl-4 py-3" data-changed="$Changed"	>
								<div class="memberBoxHolder shadow p-3 px-lg-5 text-center rounded-xl h-100 ">
									<div class="rounded-circle overflow-hidden d-inline-block ms-auto me-auto">
										<% if $Image %>
											$Image.FocusFill(150,150)
										<% end_if %>
									</div>
									<a href="{$Top.Link}/details/$ID" class="d-block stretched-link text-decoration-none text-body">{$Name}<% if $Region %>, $Region<% end_if %></a>
									<div class="h3 fw-bold px-lg-5">
										$CompanyName
									</div>
								</div>
							</div>
						<% end_loop %>
					<% end_if %>
					<% if $getMyMembers.MoreThanOnePage %>
						<div class="col-12 text-center d-none">
						    <% if $getMyMembers.NotLastPage %>
						        <a class="next memberBoxLoadMoreLink" href="$getMyMembers.NextLink">Next</a>
						    <% end_if %>
						</div>
					<% end_if %>
				</div>
				<div id="memberBoxLoading">
				</div>
				<div class="text-center py-3">
					<button class="btn btn-dark rounded-pill px-4" id="memberBoxLoadMoreButton">Mehr laden</button>
					<span id="noSearchResults" >Es wurde kein Eintrag gefunden.</span>
				</div>
			</div>
		</div>
	</div>
</main>