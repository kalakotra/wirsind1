<% if ClassName.ShortName='Member' %>
	<% include ProfileDetails %>
<% else %>
	<section class="pageHeader">
		<div class="container py-3 py-lg-5">
			<div class="row justify-content-center">
				<div class="col-12 col-md-8  py-3 py-lg-5">
					<article class="text-center">
						<h1 class="fw-bold">$Title</h1>
						<% if HeaderSubtitle %>
							<h2 class="mb-3 mb-lg-5">$HeaderSubtitle</h2>
						<% end_if %>
					</article>
				</div>
			</div>
		</div>
	</section>
	<main>
		<div class="container py-3 py-lg-5">
			<div class="row justify-content-center">
				<div class="col-12 col-md-8">
					<article>
						<div class="content py-3 py-lg-5">$Content</div>
					</article>
				</div>
				<% if CustomHTML %>
					<div class="col-12">
						<div class="custom-html">
							$CustomHTML
						</div>
					</div>
				<% end_if %>
			</div>
		</div>
	</main>
<% end_if %>