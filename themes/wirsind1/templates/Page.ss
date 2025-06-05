<!DOCTYPE html>
<!--
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
Silverstripe Theme Starter by www.kalakotra.com
>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
-->

<html lang="$ContentLocale">
<head>
	<% base_tag %>
	<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=1">
	$MetaTags(false)

	<meta name="facebook-domain-verification" content="urmswk88low6egfx92szfj01f1yteg" />

	<% if ClassName.ShortName='Member' %>
		<meta property="og:image" content="{$BaseHref}<% if $Image %>$Image.Pad(250,250).URL<% else %>$ThemeDir/images/icon.png<% end_if %>">
		<meta property="og:url" content="{$BaseHref}{$Top.Link}details/{$ID}">
		<meta property="og:description" content="$Description.limitWordCount(40, '')">
		<meta property="og:title" content="$CompanyName">


		<script type="application/ld+json">
		{
		  "@context": "https://schema.org",
		  "@type": "LocalBusiness",
		  "name": "<% if $CompanyName %>$CompanyName<% else %>$Name<% end_if %>",
		  "image": "{$BaseHref}<% if $Image %>$Image.Pad(250,250).URL<% else %>$ThemeDir/images/icon.png<% end_if %>",
		  "@id": "{$BaseHref}{$Top.Link}details/{$ID}",
		  "url": "{$BaseHref}{$Top.Link}details/{$ID}",
		  <% if $Telephone %>"telephone": "$Telephone",<% end_if %>
		  "address": {
		    "@type": "PostalAddress",
		    "streetAddress": "$Street",
		    "addressLocality": "$City",
		    "postalCode": "$PostCode",
		    "addressCountry": "AT"
		  }  
		}
		</script>
	<% end_if %>

	<% if ClassName.ShortName='BlogPost' %>
		<meta property="og:image" content="{$BaseHref}<% if $FeaturedImage %>$FeaturedImage.Pad(250,250).URL<% else %>$ThemeDir/images/icon.png<% end_if %>">
		<meta property="og:url" content="{$BaseHref}{$Top.Link}">
		<meta property="og:description" content="$Content.limitWordCount(40, '')">
		<meta property="og:title" content="$Title">

		<script type="application/ld+json">
		{
		  "@context": "https://schema.org",
		  "@type": "BlogPosting",
		  "mainEntityOfPage": {
		    "@type": "WebPage",
		    "@id": "{$BaseHref}{$Top.Link}"
		  },
		  "headline": "$Title",
		  "description": "$Content.limitWordCount(40, '')",
		  "image": "{$BaseHref}<% if $FeaturedImage %>$FeaturedImage.Pad(250,250).URL<% else %>$ThemeDir/images/icon.png<% end_if %>",
		  <% if $Credits %>  
		  "author": {
		    "@type": "Person",
		    "name": "<% loop $Credits %>$Name.XML<% if Last %><% else %>, <% end_if %><% end_loop %>",
		    "url": "{$BaseHref}<% with Credits.First %><% if BlogProfileImage %>$BlogProfileImage.Pad(250,250).URL<% else %><% if $Image %>$Image.Pad(250,250).URL<% else %>$ThemeDir/images/icon.png<% end_if %><% end_if %><% end_with %>"
		  },
		  <% end_if %>
		  "publisher": {
		    "@type": "Organization",
		    "name": "Wirsind1",
		    "logo": {
		      "@type": "ImageObject",
		      "url": "{$BaseHref}$ThemeDir/images/icon.png"
		    }
		  },
		  "datePublished": "$Created"
		}
		</script>
	<% end_if %>
	<meta property="og:type" content="website">
	<meta property="og:image:height" content="250">
	<meta property="og:image:width" content="250">


	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<link rel="mask-icon" href="/safari-pinned-tab.svg" color="#023361">
	<meta name="msapplication-TileColor" content="#ffffff">
	<meta name="theme-color" content="#ffffff">

	<% if ClassName.ShortName!="BlogPost" && ClassName.ShortName!="Member" %>
		<script type="application/ld+json">
		{
		  "@context": "https://schema.org/",
		  "@type": "WebSite",
		  "name": "WirSind1",
		  "url": "{$BaseHref}",
		  "potentialAction": {
		    "@type": "SearchAction",
		    "target": "{$BaseHref}epu-netzwerk/{search_term_string}",
		    "query-input": "required name=search_term_string"
		  }
		}
		</script>
	<% end_if %>

</head>
<body class="$ClassName.ShortName" <% if $i18nScriptDirection %>dir="$i18nScriptDirection"<% end_if %>>
<% include Header %>
$Layout
<% include Footer %>
<script src="https://app.jurafox.de/bot/ccLoader/af55d131f6c4574385657fe101bed048/fe1c108d62d397bdf8deab4787dd7d2e" defer></script>

<script>
	setTimeout(function() {
		if (typeof jfCC_stat_ga !== 'undefined' || typeof jfCC_stat_fb !== 'undefined') {
			if (typeof jfCC_stat_ga !== 'undefined') {
				juraFox_GA = 1;
			} else {
				juraFox_GA = 0;
			}
			if (typeof jfCC_stat_fb !== 'undefined') {
				juraFox_FB = 1;
			} else {
				juraFox_FB = 0;
			}
			window.dataLayer = window.dataLayer || [];
			window.dataLayer.push({ 
			   'juraFox_GA': juraFox_GA,
			  'juraFox_FB': juraFox_FB
			});

			console.log(window.dataLayer);

			(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
			new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
			j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
			'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
			})(window,document,'script','dataLayer','GTM-NDJBZV7');
		}
	}, 1000);
</script>
</body>
</html>