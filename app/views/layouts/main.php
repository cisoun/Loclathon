<?php
$uri            = Request::uri();
$page           = substr($uri, 3);
$locales        = Lang::locales();
$current_locale = Lang::locale();
?>
<!doctype html>
<html lang="<?= $current_locale ?>">
<head>
	<title>Le Loclathon | <? title ?></title>

	<link rel="icon" type="image/svg" href="/static/img/favicon.svg">

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="description" content="Site officiel du Loclathon et de l'absinthe La Locloise.">
	<meta name="keywords" content="loclathon,absinthe,le locle,locloise">
	<meta name="author" content="Comité du Loclathon">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Open Graph data -->
	<meta property="og:description" content="Site officiel du Loclathon et de l'absinthe La Locloise.">
	<meta property="og:image" content="/static/img/preview.jpg">
	<meta property="og:title" content="Le Loclathon | La Locloise">

	<!-- CSS -->
	<link rel="preload" href="/static/css/layout.css" as="style" crossorigin>
	<link rel="preload" href="/static/css/style.css" as="style" crossorigin>
	<link rel="preload" href="/static/css/phone.css" as="style" crossorigin>
	<link rel="preload" href="/static/css/desktop.css" as="style" crossorigin>
	<? preload ?>

	<link rel="stylesheet" href="/static/css/layout.css">
	<link rel="stylesheet" href="/static/css/style.css">
	<link rel="stylesheet" href="/static/css/phone.css" media="screen and (max-width: 992px)">
	<link rel="stylesheet" href="/static/css/desktop.css" media="screen and (min-width: 992px)">
	<!--? stylesheets ?-->

	<style type="text/css">
	<? css ?>
	</style>
</head>
<body>
	<!-- Header -->
	<nav id="menu" class="nojs">
		<a href="javascript:void(0);" class="trigger"><svg class="outline"><use xlink:href="/static/img/icons.svg#circle-menu"/></svg> Le Loclathon</a>
		<ul>
			<li><a href="/{{lang}}">Le Loclathon</a></li>
			<li><a href="/{{lang}}/locloise">La Locloise</a></li>
			<li><a href="/{{lang}}/photos"><?= __('menu.photos') ?></a></li>
			<li><a href="/{{lang}}/shop"><?= __('menu.shop') ?></a></li>
			<li><a href="/{{lang}}/contact"><?= __('menu.contact') ?></a></li>
			<li id="langs">
				<a href="/{{lang}}"><span><img src="/static/img/lang.<?= $current_locale ?>.svg"/> <?= $current_locale ?></span></a>
				<div>
					<?php foreach ($locales as $locale): ?>
					<?php if ($locale !== $current_locale): ?>
					<a href="/<?= $locale . $page ?>"><img src="/static/img/lang.<?= $locale ?>.svg"/><?= LANG_NAMES[$locale] ?></a>
					<?php endif; ?>
					<?php endforeach; ?>
				</div>
			</li>
		</ul>
	</nav>
	<? content ?>
	<footer>
		<div class="quad container padded">
			<div>
				<div class="logo"></div>
				<small>
					Association du Loclathon<br/>
					2400 Le Locle<br/>
					&copy; 2019 - ∞
				</small>
			</div>
			<div>
				<svg class="outline fill"><use xlink:href="/static/img/icons.svg#user"/></svg>
				<h1>Social</h1>
				<a href="https://instagram.com/loclathon">Instagram</a>
				<a href="https://fb.com/loclathon">Facebook</a>
			</div>
			<div>
				<svg class="outline fill"><use xlink:href="/static/img/icons.svg#grid"/></svg>
				<h1><?= __('footer.resources') ?></h1>
				<a href="/static/files/tour.pdf"><?= __('footer.resources.map') ?></a>
				<a href="/static/img/logo.svg"><?= __('footer.resources.logo') ?></a>
			</div>
			<div>
				<svg class="outline fill"><use xlink:href="/static/img/icons.svg#mail"/></svg>
				<h1><?= __('footer.contact') ?></h1>
				<a href="/{{lang}}/contact"><?= __('footer.contact.write') ?></a>
			</div>
		</div>
	</footer>
	<? footer ?>
	<script type="text/javascript">
		const nav = document.querySelector('nav');
		nav.classList.remove('nojs');
		nav.classList.add('transparent');

		window.onscroll = () => {
			if (window.pageYOffset < 100) {
				nav.classList.add('transparent');
			} else {
				nav.classList.remove('transparent');
			}
		};

		const navTrigger = document.querySelector('nav > .trigger');
		navTrigger.onclick = () => {
			nav.classList.toggle('toggled');
		}
	</script>
</body>
</html>
