<?php
$article = $params['article'];

$id = $article['id'];
$variants = $params['variants'];
$pictures = $article['pictures'];

$referer = $_SERVER['HTTP_REFERER'] ?? "/{{lang}}/shop";

function variant($variant) {
	$title = $variant['title'];
	$attrs = ['value' => $variant['id']];
	if ($variant['state'] == Shop::STATE_SOLDOUT) {
		$title = sprintf('%s (épuisé)', $title);
		$attrs['disabled'] = NULL;
	}
	return HTML::option($title, $attrs);
}
?>

<extend layouts/shop>

<block css>
#picture { width: 100%; }
#pictures {
	margin: 3em 0;
	display: grid;
	grid-template-columns: repeat(3, 1fr);
	grid-gap: 1em;
}
#picture,
#pictures img {
	border-radius: 5px;
	width: 100%;
}
#description { margin: 4rem 0; }
#description ul li {
	list-style: '―';
	text-indent: 1rem;
}
</block>

<block ogd>
<meta property="og:description" content="<?= strip_tags($article['description']) ?>">
<meta property="og:image" content="https://<?= $_SERVER['HTTP_HOST'] ?>/static/img/shop/<?= $article['id'] ?>.png">
<meta property="og:title" content="Le Loclathon | <?= $article['title'] ?>">
</block>

<block content>
	<div class="dual spaced">
		<div>
			<img id="picture" src="/static/img/shop/<?= $article['id'] ?>.png"/>
			<div id="pictures">
				<?php foreach ($pictures as $picture): ?>
				<a href="/static/img/shop/<?= $picture ?>" target="_blank"><img src="/static/img/shop/<?= $picture ?>" alt="" /></a>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="uni">
			<h1><?= $article['title'] ?></h1>
			<h2><?= $article['price'] ?> CHF</h2>

			<div id="description" class="text-justify"><?= $article['description'] ?></div>

			<?php if ($article['state'] < 2): ?>
			<form action="/{{lang}}/shop/cart/add/<?= $article['id'] ?>" method="post">
				<fieldset class="group number">
					<label for="units">Nombre:</label>
					<div>
						<input id="units" name="units" type="number" value=1 min=1 max=100 class="hide-controls" required>
						<button type="button" class="">-</button>
						<button type="button" class="">+</button>
					</div>
				</fieldset>

				<?php if ($variants): ?>
				<fieldset>
					<label for="variant">Variante:</label>
					<select id="variant" name="variant">
						<?php foreach ($variants as $variant): ?>
						<?= variant($variant) ?>
						<?php endforeach; ?>
					</select>
				</fieldset>
				<?php endif; ?>

				<div class="separator"></div>

				<fieldset>
					<button class="white w-100"><svg class="outline dark"><use xlink:href="/static/img/icons.svg#cart"/></svg> Dans le panier</button>
				</fieldset>

			</form>
			<?php endif; ?>
		</div>
	</div>

</block>
