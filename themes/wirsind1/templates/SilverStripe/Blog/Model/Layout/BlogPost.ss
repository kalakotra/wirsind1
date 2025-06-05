<section class="blogPostHeader mb-3">
	$FeaturedImage
</section>
<main>
	<div class="container py-3 py-lg-5">
		<div class="row justify-content-between">
			<div class="col-12 py-3">
				<a href="$Parent.Link" class="text-decoration-none text-body">$Parent.MenuTitle</a> <i class="far fa-chevron-right fs-6"></i> <% loop Categories %><a href="$Link" class="text-decoration-none text-body">$Title</a><% if not Last %> <i class="far fa-chevron-right fs-6"></i> <% end_if %><% end_loop %>
			</div>
			<div class="col-12 col-lg-8 py-3">
				<article>
					<h1 class="fw-bold">$Title</h1>
					<% if Subtitle %>
						<blockquote>$Subtitle</blockquote>
					<% end_if %>
					<div class="content py-3 py-lg-5 text-dark">$Content</div>
					<a href="https://www.facebook.com/sharer/sharer.php?u={$BaseHref}{$Top.Link}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600'); return false;" target="_blank" title="Teilen auf Facebook" class="text-decoration-none link-dark">
						<i class="far fa-share-alt"></i> <small class="ps-1">Profil teilen</small>
					</a>
				</article>
			</div>
			<% if $Credits %>
			<div class="col-12 col-lg-3 py-3 companyDetails">
				<% loop $Credits %>
					<div class="shadow p-3 text-center rounded-xl mb-5">
						<div class="row h-100 align-items-center">
							<div class="col-6 col-lg-12 py-2">
									<div class="rounded-circle overflow-hidden d-inline-block ms-auto me-auto">
									<% if BlogProfileImage %>
										$BlogProfileImage.FocusFill(150,150)
									<% else %>
										<% if $Image %>
											$Image.FocusFill(150,150)
										<% else %>
											<img src="$themedResourceURL('/images/icon.png')" alt="icon" width="150" height="150" />
										<% end_if %>
									<% end_if %>
								</div>
							</div>
							<div class="col-6 col-lg-12 py-2">
								<div class="h4 fw-bold pb-2">
									$Name.XML
								</div>
								<% if Website %>
									<div class="text-dark pb-4">$Website</div>
								<% end_if %>
								<% if BlogProfileSummary %>
									<div class="pb-4">$BlogProfileSummary</div>
								<% end_if %>
								<a href="{$Top.getMyClass('FilterPage').exclude('ClassName', 'FormularPage').First.Link}/details/$ID" class="btn btn-dark rounded-pill px-5">Zum Profil</a>
							</div>
						</div>
					</div>
				<% end_loop %>
			</div>
			<% end_if %>
		</div>
	</div>
</main>
<section class="bg-light similarBlogHolder">
	<div class="container">
		<div class="row py-3 py-lg-5">
			<div class="col-12 text-center h2 fw-bold py-3">
				Weitere Beitr&auml;ge
			</div>
			<% loop Categories %>
				<% loop BlogPosts.exclude("ID", $Top.ID) %>
					<div class="col-12 col-md-6 col-lg-4 py-3 similarBlog">
						<div class="rounded-xl h-100 shadow overflow-hidden blogListBox">
							$FeaturedImage.FocusFill(600,300)
							<div class="py-3 px-4">
								<a href="$Link" class="text-decoration-none text-body stretched-link"><% loop Categories.First %>$Title<% end_loop %></a>
								<div class="fw-bold h3">$Title</div>
							</div>
						</div>
					</div>
				<% end_loop %>
			<% end_loop %>
		</div>
	</div>
</section>