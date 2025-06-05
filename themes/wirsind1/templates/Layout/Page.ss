<% if ClassName.ShortName='Member' %>
	<% include ProfileDetails %>
<% else %>
	<main>
		<div class="container py-3 py-lg-5">
			<div class="row justify-content-center">
				<div class="col-12 col-md-8">
					<article>
						<h1 class="fw-bold text-center">$Title</h1>
						<div class="content py-3 py-lg-5">$Content</div>
					</article>
				</div>
			</div>
		</div>
	</main>
<% end_if %>