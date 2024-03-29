<?php
$cart = $params['data'];
?>

<extend layouts/shop>

<block css>
.article {
	border-bottom: 1px solid var(--gray-300);
	column-gap: 1rem;
	display: flex;
	padding: 2rem 0;
	width: 100%;
}
.article img {
	border-radius: var(--border-radius);
	height: 5em;
}
.article:last-child { border-bottom: unset; }
.article > div:first-child {
	text-align: center;
	width: 5rem;
}

.variant { color: var(--gray-600); }
#actions {
	display: flex;
	column-gap: 1rem;
}
.article .price { font-weight: bold; }
.article .header {
	line-height: 1;
	margin-bottom: 1rem;
}
.article .header,
.article .body {
	display: flex;
	column-gap: 1rem;
	justify-content: space-between;
}
</block>

<block content>
	<h1>Panier</h1>
	<form method="post" action="/{{lang}}/shop/cart" class="dual spaced">
		<div>
			<?php foreach ($cart as $key => $article): ?>
			<div class="article">
				<div>
					<img src="<?= $article['picture'] ?>" />
				</div>
				<div>
					<div class="header">
						<div>
							<a href="/{{lang}}/shop/product/<?= $article['url'] ?>"><?= $article['title'] ?></a>
							<?php if ($article['variant']): ?>
							<span class="variant"><?= $article['variant'] ?></span>
							<?php endif; ?>
						</div>
						<div class="price"><?= $article['price'] ?> CHF</div>
					</div>
					<div class="body">
						<div class="group number">
							<div>
								<input type="number" class="hide-controls" name="cart[<?= $article['id'] ?>]" min=0 max=100 value=<?= $article['units'] ?> required>
								<button type="button" class="">-</button>
								<button type="button" class="">+</button>
							</div>
						</div>
						<button name="delete" value=<?= $article['id'] ?> class="red">supprimer</button>
					</div>
				</div>
			</div>
			<?php endforeach ?>
			<?php if (!$cart): ?>
				Le panier est vide.
			<?php endif; ?>
		</div>
		<div class="uni">
			<h3>Total</h3><h2><?= $params['total'] ?> CHF</h2>
			<fieldset>
				<button name="checkout" class="white w-100">
					<svg class="outline dark"><use xlink:href="/static/img/icons.svg#cart"/></svg>
					Passer à la caisse
				</button>
			</fieldset>
			<div class="separator">
				<span>Panier</span>
			</div>
			<fieldset id="actions">
				<button name="update" class="w-100">Actualiser</button>
				<button name="clear" class="w-100">Vider</button>
			</fieldset>
		</div>
	</form>
</block>
