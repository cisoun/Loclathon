<?php
$articles = $params['articles'];
$states   = __('shop.states');
?>

?>
<extend layouts/shop>

<block css>
.article {
	background-color: var(--dark-2);
	border-radius:    1rem;
	border:           2px solid var(--background);
	display:          flex;
	flex-direction:   column;
	padding:          1rem;
	transition:       all var(--transition);
}

.article:hover {
	background-color: var(--dark-3);
	transform:        scale(1.03);
}

.article > .preview {
	aspect-ratio:        1;
	background-position: center;
	background-repeat:   no-repeat;
	background-size:     contain;
	border-radius:       0.5rem;
	display:             block;
	height:              100%;
	margin-bottom:       1rem;
	margin-left:         auto;
	margin-right:        auto;
	width:               100%;
}
.article > .title {
	color: var(--foreground);
	font-size: 1.2em;
	font-weight: bold;
}

.article > .title,
.article > .price { text-align: center; }

.article[data-state="2"] {
	background-color: var(--dark-0);
}
.article[data-state="2"] > *:not(i) {
	opacity: 0.3;
}


.article i {
	background: var(--red-700);
	border-radius: 0.5rem;
	color: white;
	padding: 0.2rem 1rem;
	position: absolute;
}

.article[data-state="1"] i {
	background: var(--teal-8);
	color:      var(--teal-3);
}
.article[data-state="2"] i {
	background: var(--red-9);
	color:      var(--red-5);
}
.article[data-state="3"] i {
	background: var(--yellow-8);
	color:      var(--yellow-3);
}

#grid {
	display: grid;
	grid-gap: 1rem;
	grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
	grid-auto-rows: 1fr;
	max-width: 992px;
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

<block content>
<h1><?= __('menu.shop') ?></h1>
<div id="grid" class="centered">
<?php foreach ($articles as $article): ?>
<a class="article" href="/{{lang}}/shop/product/<?= $article['url'] ?>" data-state="<?= $article['state'] ?>">
	<div class="preview" style="background-image: url(<?= Articles::preview($article) ?>);"></div>
	<div class="title"><?= $article['title'] ?></div>
	<div class="price light"><?= $article['price'] ?> CHF</div>
	<?php if ($article['state'] > 0): ?>
	<i><?= $states[$article['state'] - 1] ?></i>
	<?php endif; ?>
</a>
<?php endforeach ?>
</div>
</block>
