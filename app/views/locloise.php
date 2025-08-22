<?php
$description = __('locloise.description');
$details = __('locloise.details');
?>

<extend layouts/main>

<block title>La Locloise</block>

<block css>
ul.breadcrumb {
	background-color: var(--gray-100);
	border: 1px solid var(--foreground);
	border-radius: 1rem;
	display: inline-block;
	line-height: 1rem;
	padding: unset;
	text-align: center;
}
ul.breadcrumb li {
	display: inline-block;
	padding: 0.5rem 1rem;
}
ul.breadcrumb li:not(:last-child) {
	border-right: 1px solid var(--foreground);
}
@media only screen and (max-width: 600px) {
	ul.breadcrumb { display: block; }
	ul.breadcrumb li { display: block; text-align: left; }
	ul.breadcrumb li:not(:last-child) {
		border-bottom: 1px solid var(--foreground);
		border-right: unset;
	}
}
#buy { overflow: hidden; transition: var(--transition); }
#buy .outline {
	margin-left: -3.4rem; /* -Icon size - button padding */
	margin-right: 1.9rem; /* Icon size + 0.5rem */
	opacity: 0;
	transition: var(--transition);
}
#buy:hover .outline {
	margin-left: 0rem;
	margin-right: 0.5rem;
	opacity: 1;
}
</block>

<block content>
<main id="locloise" class="flex dark">
	<div>
		<picture>
			<!-- <source srcset="/static/img/locloise.webp" type="image/webp"> -->
			<source srcset="/static/img/locloisenew.jpg" type="image/jpeg">
			<img src="/static/img/locloisenew.jpg" alt="La Locloise"  class="rounded">
		</picture>
	</div>
	<div id="description" class="flex vertical">
		<div class="card">
			<h1>La Locloise</h1>
			<div id="status"><span id="price">38</span> CHF</div>
			<p><?= $description[0] ?></p>
			<p><?= $description[1] ?></p>
			<p><?= $description[2] ?></p>
			<p>
				<ul class="breadcrumb">
					<li><?= $details[0] ?></li>
					<li><?= $details[1] ?></li>
					<li><?= $details[2] ?></li>
				</ul>
			</p>
			<a id="buy" class="button big responsive white" href="/{{lang}}/shop/product/la-locloise-05l">
				<svg class="outline dark"><use xlink:href="/static/img/icons.svg#cart"/></svg>
				<?= __('locloise.buy') ?>
			</a>
		</div>
		<div class="card">
			<h1><?= __('locloise.resellers') ?></h1>
			<h3>Le Locle</h3>
			<ul>
				<li><a href="https://www.facebook.com/profile.php?id=100063500294476" target="_blank">L'épicerie de Marie</a></li>
			</ul>
			<h3>Peseux</h3>
			<ul>
				<li><a href="https://linsolite.ch" target="_blank">L'INSOLITE</a></li>
			</ul>
		</div>
	</div>
</main>
</block>
