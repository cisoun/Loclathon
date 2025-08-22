<?php
$uri            = Request::uri();
$page           = substr($uri, 3);
$locales        = Lang::locales();
$current_locale = Lang::locale();

Session::start();
$cart = Session::get('cart');
?>
<!doctype html>
<html lang="<?= $current_locale ?>" class="dark">
<head>
	<title>Le Loclathon | <? title ?></title>

	<link rel="icon" type="image/svg" href="/static/img/favicon.svg">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@0,300..900;1,300..900&display=swap" rel="stylesheet">

	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="description" content="Site officiel du Loclathon et de l'absinthe La Locloise.">
	<meta name="keywords" content="loclathon,absinthe,le locle,locloise">
	<meta name="author" content="Comité du Loclathon">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Open Graph data -->
	<meta property="og:description" content="Site officiel du Loclathon et de l'absinthe La Locloise.">
	<meta property="og:image" content="/static/img/preview.jpg">
	<meta property="og:title" content="Le Loclathon | <? title ?>">

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

	<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/iconoir-icons/iconoir@main/css/iconoir.css">

	<style type="text/css">
	<? css ?>
	</style>

	<? head ?>
</head>
<body>
	<!-- Header -->
	<nav id="menu">
		<a href="#" class="trigger"><svg class="outline"><use xlink:href="/static/img/icons.svg#circle-menu"/></svg> Le Loclathon</a>
		<ul>
			<li><router to="/{{lang}}/loclathon">Le Loclathon</router></li>
			<li><router to="/{{lang}}/locloise">La Locloise</router></li>
			<li><router to="/{{lang}}/photos"><?= __('menu.photos') ?></router></li>
			<li><router to="/{{lang}}/shop"><?= __('menu.shop') ?></router></li>
			<li><router to="/{{lang}}/contact"><?= __('menu.contact') ?></router></li>
			<li id="langs">
				<a><span><img src="/static/img/lang.<?= $current_locale ?>.svg"/> <?= $current_locale ?></span></a>
				<ul>
					<?php foreach ($locales as $locale): ?>
					<?php if ($locale !== $current_locale): ?>
					<li><a href="/<?= $locale . $page ?>"><img src="/static/img/lang.<?= $locale ?>.svg"/><?= LANG_NAMES[$locale] ?></a></li>
					<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</li>
			<?php if ($cart): ?>
			<a href="/{{lang}}/shop/cart" class="button only-desktop">
				<svg class="outline icon"><use xlink:href="/static/img/icons.svg#cart"/></svg>
				<?= array_sum($cart) ?>
			</a>
			<?php endif ?>
		</ul>
	</nav>
	<div id="content" class="container flex vertical">
		<?php if ($cart): ?>
		<div class="only-mobile flex">
			<a href="/{{lang}}/shop/cart" class="button white">
				<svg class="outline dark"><use xlink:href="/static/img/icons.svg#cart"/></svg>
				<?= array_sum($cart) ?> articles dans le panier
			</a>
		</div>
		<?php endif; ?>
	<? content ?>
	</div>
	<footer>
		<div id="footer-content" class="flex centered">
			<div>
				<div class="logo"></div>
				<small>
					Association du Loclathon<br/>
					Le Locle, Switzerland<br/>
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
		const nav        = document.getElementById('menu');
		const navTrigger = document.querySelector('nav > .trigger');

		nav.classList.remove('nojs');
		nav.classList.add('transparent');

		// Make navbar transparent or not.
		// window.onscroll    = () => nav.classList.toggle('transparent', window.scrollY < 50);
		navTrigger.onclick = () => nav.classList.toggle('toggled');

		<? js ?>
	</script>
</body>
</html>
