<?php
$articles = $params['articles'];

$states = [
	'PRECOMMANDE',
	'ÉPUISÉ',
	'SOLDE'
];

Session::start();
$cart = Session::get('cart') ?? [];

$articles_count = array_sum(array_values($cart));
?>

?>
<extend>layouts/shop</extend>

<block css>
.article {
	border: 2px solid var(--background);
	border-radius: var(--border-radius);
	padding: 1rem;
}
.article:hover { background-color: var(--gray-150); }

.article > img {
	border-radius: var(--border-radius);
	display: block;
	margin-bottom: 1rem;
	width: 100%;
}
.article > .title {
	 color: var(--foreground);
	font-size: 1.2em;
	font-weight: bold;
}

.article > .title,
.article > .price { text-align: center; }

.article i {
	background: var(--red-700);
	color: white;
	padding: 0.2em 0.5em;
	position: absolute;
}
.article[data-state="1"] i { background: var(--green-800);  color: var(--green-300); }
.article[data-state="2"] i { background: var(--red-800);    color: var(--red-300); }
.article[data-state="3"] i { background: var(--yellow-800); color: var(--yellow-300); }

#grid {
	display: grid;
	grid-gap: 1rem;
	grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
	grid-auto-rows: 1fr;
}

#subnav {
	background-color: var(--gray-150);
	column-gap: 1rem;
	display: flex;
	font-weight: bold;
	padding: 0.5rem 0;
	text-align: center;
	align-items: center;
	justify-content: center;
}
</block>

<block subnav>
<?php if ($articles_count > 0): ?>
<div id="subnav">
	<?= $articles_count ?> articles dans le panier
	<a href="/{{lang}}/shop/cart" class="button white">
		<svg class="outline dark"><use xlink:href="/static/img/icons.svg#cart"/></svg>
		Consulter
	</a>
</div>
<?php endif; ?>
</block>

<block content>

<h1><?= __('menu.shop') ?></h1>

<div id="grid">
<?php foreach ($articles as $article): ?>
<a class="article" href="/{{lang}}/shop/product/<?= $article['url'] ?>" data-state="<?= $article['state'] ?>">
	<?php if ($article['state'] > 0): ?>
	<i><?= $states[$article['state'] - 1] ?></i>
	<?php endif; ?>
	<img src="/static/img/shop/small/<?= $article['id'] ?>.png"/>
	<div class="title"><?= $article['title'] ?></div>
	<div class="price light"><?= $article['price'] ?> CHF</div>
</a>
<?php endforeach ?>
</div>

</block>
