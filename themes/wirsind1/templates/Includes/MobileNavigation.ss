<nav >
	<ul class="sideMain">
		<% loop $Menu(1) %>
			<li class="$LinkingMode">
				<a href="$Link" title="$Title.XML" class="animated">$MenuTitle.XML</a>
				<% if Children %>
					<ul class="sideSub">
						<% loop Children %>
							<li class="$LinkingMode">
								<a href="$Link" title="$Title.XML" class="animated">$MenuTitle.XML</a>
								<% if Childrenasdf %>
									<span class="arrow"></span>
									<ul class="sideSub">
										<% loop Children %>
											<li class="$LinkingMode"><a href="$Link" title="$Title.XML" class="animated">$MenuTitle.XML</a></li>
										<% end_loop %>
									</ul>
								<% end_if %>
							</li>
						<% end_loop %>
					</ul>
				<% end_if %>
			</li>
		<% end_loop %>
		<li class="pt-3">
			<a href="https://www.facebook.com/wirsind1.at" class="fbShare- px-2"  rel="noopener" target="_blank" ><i class="fab fa-facebook-square fa-lg"></i><span class="visually-hidden">Facebook Share</span></a>
			<a href="https://www.instagram.com/wirsind1_noe/" class=" px-2" target="_blank" rel="noopener" ><i class="fab fa-instagram-square fa-lg"></i><span class="visually-hidden">Instagram</span></a>
			<a href="https://www.youtube.com/@wirsind1-ein-personen-unte450/videos" class=" px-2" target="_blank" rel="noopener" ><i class="fab fa-youtube fa-lg"></i><span class="visually-hidden">Youtube</span></a>
		</li>
		<% if getCurrentMember %>
			
			<li  class="pt-3">
				<a href="/epu-netzwerk/profil" class=" px-2" title="Profil bearbeiten"><i class="fas fa-user-edit"></i><span class="visually-hidden">Edit Profile</span></a>
			
				<a href="/Security/logout?BackURL=/home" class=" px-2" title="Logout"><i class="fas fa-sign-out-alt"></i><span class="visually-hidden">Logout</span></a>
			</li>
		<% else %>
			<li class="pt-3">
				<a href="/epu-netzwerk/profil" class=" px-2" title="Profil erstellen"><i class="fas fa-user-plus"></i><span class="visually-hidden">Register</span></a>
			
				<a href="/Security/login?BackURL=/epu-netzwerk/profil" class=" px-2" title="Login"><i class="far fa-user-circle"></i><span class="visually-hidden">Login</span></a>
			</li>
		<% end_if %>
	</ul>
</nav>
