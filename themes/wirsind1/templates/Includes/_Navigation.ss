<nav class="primary">
	<ul class="nav justify-content-end">
        <% loop $Menu(1) %>
			<li class="$LinkingMode nav-item">
				<a href="$Link" title="$Title.XML" class="nav-link">$MenuTitle.XML</a>
			</li>
		<% end_loop %>
		<li class="nav-item">
			<a href="https://www.facebook.com/wirsind1.at" class="nav-link fbShare- px-2"  rel="noopener" target="_blank" ><i class="fab fa-facebook-square fa-lg"></i><span class="visually-hidden">Facebook Share</span></a>
		</li>
		<li class="nav-item">
			<a href="https://www.instagram.com/wirsind1_noe/" class="nav-link px-2" target="_blank" rel="noopener" ><i class="fab fa-instagram-square fa-lg"></i><span class="visually-hidden">Instagram</span></a>
		</li>
		<li class="nav-item">
			<a href="https://www.youtube.com/@wirsind1-ein-personen-unte450/videos" class="nav-link px-2" target="_blank" rel="noopener" ><i class="fab fa-youtube fa-lg"></i><span class="visually-hidden">Youtube</span></a>
		</li>
	</ul>
</nav>
