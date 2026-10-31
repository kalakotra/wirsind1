<main>
	<div class="container py-3 py-lg-5 text-dark">
		<div class="row justify-content-between">
			<% if $inEdit %>
				<div class="col-auto py-3">
					<p>
						So wird dein Eintrag im EPU-Netzwerk aussehen. Du möchtest noch etwas ändern? Dann gehe einen Schritt zurück!
						<br />
						Wenn alles passt, schicke uns die Daten. Wir schauen uns den Eintrag an und stellen ihn online.
					</p> 
				</div>
			<% else %>
				<div class="col-auto py-3">
					<a href="javascript:history.back()" data-href="$Top.Link" class="text-decoration-none link-dark"><i class="fal fa-long-arrow-left fa-lg"></i> <span class="ps-3">zur&uuml;ck zur &Uuml;bersicht</span></a>
				</div>
				<div class="col-auto py-3 text-end $inEdit">
					<a href="https://www.facebook.com/sharer/sharer.php?u={$BaseHref}{$Top.Link}details/{$ID}" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=300,width=600'); return false;" target="_blank" title="Teilen auf Facebook" class="text-decoration-none link-dark">
						<i class="far fa-share-alt"></i> <small class="ps-1">Profil teilen</small>
					</a>
				</div>
			<% end_if %>
			<div class="col-12 py-3 py-lg-5 overflow-hidden">
				<div id="particles-js"></div>
				<div class="bg-light bg-primary- bg-opacity-10- rounded-xl p-3 p-lg-5 heronet">
					<div class="row align-items-center justify-content-between">
						<% if $Image %>
							<div class="col-12 col-md-4 col-xl-3 text-center py-3">
								<div class="rounded-circle overflow-hidden d-inline-block ms-auto me-auto border border-white border-1">
									$Image.FocusFill(300,300)
								</div>
							</div>
						<% end_if %>
						<div class="col-12 <% if $Image %>col-md-7 col-xl-8<% end_if %> companyDetails text-dark py-3">
							<div class="h1 fw-bold">
								$CompanyName
							</div>
							<div class="h2 fw-bold">
								$Name
							</div>
							$MemberIndustry.Title / $Region
							<% if $Website %>
								<div>
									<a href="$checkURL($Website)" target="_blank" rel="noopener" class="fw-bold text-dark">$Website</a>
								</div>
							<% end_if %>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 <% if $Text != "" && $Text != " " %>col-lg-7<% end_if %> pb-3 companyDetails">
				<div class="h2 fw-bold ">Mein Unternehmen</div>
				<div class="profileDesc pb-3 pb-lg-5">$Description</div>
				<div class="row justify-content-between">
					<% if $Video %>
						<div class="col-12 col-lg-5 py-3">
							<video controls class="w-100-">
								<source src="$Video.Link" type="video/mp4">
								Your browser does not support the video tag.
							</video>
						</div>
					<% end_if %>
					<div class="col-12 <% if $Video %>col-lg-5<% end_if %> py-3">
						<% if $Street="hidden" || $City="hidden" %>
							<!-- they don't want to be shown -->
							<div class="py-3">
								$Street
								<% if $City %>
									<br />
									$PostCode $City
								<% end_if %>
							</div>
						<% end_if %>
						
						<% if $Telephone %>
							<div>
								<a href="tel://$Telephone" class="profileSocialLink text-dark"><i class="fas fa-phone-square-alt fa-2x"></i> $Telephone</a>
							</div>
						<% end_if %>

						
						<% if $SocialMedia %>
							<div class="py-3">
								<a href="$checkURL($SocialMedia)" target="_blank" rel="noopener" class="profileSocialLink text-dark"><i class="fab fa-facebook fa-2x"></i> Mein Facebook Profil</a>
							</div>
						<% end_if %>
						<% if $Instagram %>
							<div class="py-3">
								<a href="$checkURL($Instagram)" target="_blank" rel="noopener" class="profileSocialLink text-dark"><i class="fab fa-instagram-square fa-2x"></i> Mein Insta Profil</a>
							</div>
						<% end_if %>
						<% if $LinkedIn %>
							<div class="py-3">
								<a href="$checkURL($LinkedIn)" target="_blank" rel="noopener" class="profileSocialLink text-dark"><i class="fab fa-linkedin fa-2x"></i> Mein LinkedIn Profil</a>
							</div>
						<% end_if %>
						<% if $TikTok %>
							<div class="py-3">
								<a href="$checkURL($TikTok)" target="_blank" rel="noopener" class="profileSocialLink text-dark"><i class="fab fa-tiktok fa-2x"></i> Mein TikTok Kanal</a>
							</div>
						<% end_if %>
						<% if $OtherSocialMedia %>
							<div class="py-3">
								<a href="$checkURL($OtherSocialMedia)" target="_blank" rel="noopener" class="profileSocialLink text-dark"><i class="fab fa-youtube fa-2x"></i> Mein YouTube Kanal</a>
							</div>
						<% end_if %>
					</div>
				</div>
				
			</div>
			<% if $Text != "" && $Text != " " %>
				<div class="col-12 col-lg-5 pb-3 py-lg-5- ">
					<div class="h2 fw-bold ">Was mich antreibt</div>
					<div class=" pb-3 pb-lg-5">$Text</div>

					<% if IntroductionLink %>
						<div class="h3 fw-bold ">Meine Vorstellung</div>
						<div class="py-3">
							<a href="$IntroductionLink" target="_blank" rel="noopener" class="profileSocialLink text-dark">
								<% if IntroductionLogo=0 %>
									<i class="fab fa-facebook-f fa-2x"></i>
								<% else_if IntroductionLogo='1' %>
									<i class="fab fa-instagram fa-2x"></i>
								<% else %>
								<% end_if %>
								
								<% if IntroductionLinkTitle %> $IntroductionLinkTitle <% else %>Meine Vorstellung Link <% end_if %>
							</a>
						</div>
					<% end_if %>
				</div>
			<% end_if %>

			<% if $inEdit %>
				<div class="col-12 py-3 py-lg-5 text-center">
					<a href="$Link" class="btn btn-secondary mx-2">Zurück</a> <a href="{$Link}finishAddingProfile/" class="btn btn-dark mx-2 text-white">Absenden</a>
				</div>
			<% end_if %>
		</div>
	</div>
</main>