<header class="sticky-top shadow bg-white">
	<div class="container">
		<div class="row justify-content-between py-3 align-items-center">
			<div class="col-9 col-lg-5 ">
				<div class="row align-items-center">
					<div class="col-auto order-1">
						<a href="home/"><img src="$themedResourceURL('/images/logo.png')" alt="Logo" class="logo" width="1374" height="374" /></a>
					</div>
					<div class="col-12 col-lg-4 small text-dark order-3 order-lg-2">
						$SiteConfig.Tagline
					</div>
					<div class="col-auto order-2 order-lg-3">
						<img src="$themedResourceURL('/images/noe_logo.svg')" alt="Logo" width="35" height="35" />
					</div>
				</div>
			</div>
            <div class="col col-lg-7 align-self-center d-none d-lg-block">
                <% include Navigation %>
            </div>
			<div class="col-3 d-lg-none align-self-center text-right">
                <button class="hamburger hamburger--squeeze" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                        <span class="invisible">menu</span>
                    </span>
                </button>
            </div>
		</div>
	</div>
</header>
<div id="mobileMenu" class="animated shadow d-lg-none">
	<div class="container">
		<div class="row justify-content-between py-3 align-items-center">
			<div class="col-9 col-lg-6 ">
				<div class="row align-items-center">
					<div class="col-auto order-1">
						<a href="home/"><img src="$themedResourceURL('/images/logo.png')" alt="Logo" class="logo" width="1374" height="374" /></a>
					</div>
					<div class="col-12 col-lg-4 small text-dark order-3 order-lg-2">
						$SiteConfig.Tagline
					</div>
					<div class="col-auto order-2 order-lg-3">
						<img src="$themedResourceURL('/images/noe_logo.svg')" alt="Logo" width="35" height="35" />
					</div>
				</div>
			</div>
			<div class="col-3 d-lg-none align-self-center text-right">
                <button class="hamburger hamburger--squeeze" type="button">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                        <span class="invisible">menu</span>
                    </span>
                </button>
            </div>
            <div class="col-12 py-3 py-lg-5">
            	<% include MobileNavigation %>
            </div>
		</div>
	</div>
	
</div>