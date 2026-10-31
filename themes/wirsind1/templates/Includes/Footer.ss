<footer <% if Video1 || Video2 || Video3 %>class="bg-light"<% end_if %> >
	<div class="px-5">
		<div class="container-fluid py-3 py-lg-5">
			<div class="row justify-content-between">
				<div class="col-12 col-lg-4 py-3 fs-5">
					<% loop $Top.getMyClass.filter("ShowInFooter", "1") %>
						<a href="$Link" class="fs-5">$MenuTitle</a><% if not $IsLast %> | <% end_if %>
					<% end_loop %>
				</div>
				<% loop getMyClass("FooterLogo") %>
					<div class="col-12 col-lg-8 col-lg-4- col-xl-3-">
						<div class="row align-items-center">
							
							<div class="col-12 col-md-6  py-3 fs-5">
								$Logo.ScaleMaxHeight(70)
							</div>
							<div class="col-12 col-md-6  py-3 fs-5">
								$Text
							</div>
						</div>
					</div>
				<% end_loop %>
				<div class="d-lg-none py-3 text-center">
					<a href="https://www.facebook.com/wirsind1.at" class="p-2" target="_blank" rel="noopener" ><i class="fab fa-facebook-square fa-lg"></i><span class="visually-hidden">Facebook Share</span></a>

					<a href="https://www.instagram.com/wirsind1_noe/" class=" p-2" target="_blank" rel="noopener" ><i class="fab fa-instagram-square fa-lg"></i><span class="visually-hidden">Instagram</span></a>

					<a href="https://www.youtube.com/@wirsind1-ein-personen-unte450/videos" class=" p-2" target="_blank" rel="noopener" ><i class="fab fa-youtube fa-lg"></i><span class="visually-hidden">Youtube</span></a>
				</div>
			</div>
		</div>
	</div>
</footer>