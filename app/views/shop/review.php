<?php
$country  = $params['country'];
$payment  = $params['payment'];
$shipping = $params['shipping'];
$articles = $params['articles'];
$total    = $params['total'];
?>

<extend layouts/shop>

<block css>
#shop table {
	width: 100%;
}
#shop tr {
	background-color: var(--input-background);
}
#shop #total {
	font-size: 1.4rem;
	font-weight: bold;
}

h3 {
	font-size: 1.4rem;
	font-weight: normal;
	margin-top: 3rem;
}

#pay > a.button {
	width: 100%;
}

.panel {
	background-color: var(--dark-2);
	border-radius: var(--border-radius);
	margin: 0.5rem 0;
	overflow: hidden;
	padding: 1rem;
}

.panel.splitted {
	background: none;
	padding: unset;
}

.panel.splitted div {
	align-items: center;
	background-color: var(--dark-2);
	display: flex;
	justify-content: space-between;
	margin-bottom: 1px;
	padding: 0.5rem 1rem;
}
.panel.splitted div:last-child {
	margin-bottom: unset;
}

#pay .panel.splitted { font-weight: bold; }

</block>
<block content>
<h1><?= __('shop.order_summary') ?></h1>
<div class="flex">
	<div>
		<h3><?= __('shop.address') ?></h3>
		<address class="panel">
			{{ first_name }} {{ last_name }}<br>
			{{ street }}<br>
			{{ npa }} {{ city }}<br>
			<?= __('shop.countries')[$country] ?>
		</address>
		<div class="panel">
			<b><?= __('shop.confirmation_to') ?></b>:<br>
			{{ email }}
		</div>
		<a href="/{{lang}}/shop/checkout">↻ <?= __('shop.change_address') ?></a>
	</div>
	<div id="pay">
		<h3><?= __('shop.payment') ?></h3>
		<div class="panel splitted">
			<?php foreach ($articles as $article): ?>
			<div>
				<span><?= $article['units'] ?> x <?= $article['title'] ?> <?= $article['variant'] ?></span>
				<span><?= $article['price'] ?> CHF</span>
			</div>
			<?php endforeach; ?>
			<div>
				<span>
					<?= __('shop.shippings')[$shipping] ?><br>
					<small class="text-light"><?= __('shop.shipping_fees') ?></small>
				</span>
				<span>{{ shipping_fees }} CHF</span>
			</div>
			<div>
				<span>
					<?= __('shop.payments')[$payment] ?><br>
					<small class="text-light"><?= __('shop.payment_fees') ?></small>
				</span>
				<span>{{ payment_fees }} CHF</span>
			</div>
			<div id="total">
				<span>Total</span>
				<span>{{ total }} CHF</span>
			</div>
		</div>
		<a href="/{{lang}}/shop/cart">↻ <?= __('shop.change_order') ?></a>
		<h3><?= __('shop.shipping') ?></h3>
		<form action="/{{lang}}/shop/pay" method="post">
			<button type="submit" class="white w-100">
				<svg class="outline dark"><use href="<?= statics('img/icons.svg#card') ?>"/></svg>
				<?= __('shop.pay') ?>
			</button>
		</form>
	</div>
</div>
</block>
