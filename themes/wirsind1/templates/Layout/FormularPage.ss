<section class="pageHeader">
	<div class="container py-3 py-lg-5">
		<div class="row justify-content-center">
			<div class="col-12 col-md-8 col-lg-6">
				<article class="text-center">
					<h1 class="fw-bold">$Title</h1>
					<h2 class="mb-3 mb-lg-5">$Subtitle</h2>
				</article>
			</div>
		</div>
	</div>
</section>
<main class="bg-light">
	<div class="container py-3 py-lg-5">
		<div class="row justify-content-center">
			<% if getCurrentMember %><% else %>
				<% if HideHierAnmelden %><% else %>
					<div class="col-12 col-lg-10 py-3">
						Wenn du ein Profil hast, kannst du dich <a href="/Security/login?BackURL=/epu-netzwerk/profil">hier</a> anmelden. 
					</div>
				<% end_if %>
			<% end_if %>
			<div class="col-12 col-lg-10 py-3">
				<% if getCurrentMember && changePasswordMode %>
					<div class="row justify-content-center">
						<div class="col-12 col-md-6 col-lg-5 text-center mb-3 mb-lg-4">
							<h2 class="h4 fw-bold">Passwort ändern</h2>
							$PasswordChangeForm
						</div>
					</div>
				<% else %>
					<% if getCurrentMember %>
						<div class="col-12 small py-2">
							$ProfileForm
						</div>
					<% else %>
						$ProfileForm
					<% end_if %>
				<% end_if %>
			</div>
		</div>
	</div>
</main>