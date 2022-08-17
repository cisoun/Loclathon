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
@media only screen and (min-width: 992px) {
	#description { padding-top: 3rem; }
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
<main id="locloise" class="dual dark">
	<div>
		<picture>
			<source srcset="/static/img/locloise.webp" type="image/webp">
			<source srcset="/static/img/locloise.jpg" type="image/jpeg">
			<img src="/static/img/locloise.jpg" alt="La Locloise">
		</picture>
	</div>
	<div id="description" class="padded">
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
</main>
</block>
