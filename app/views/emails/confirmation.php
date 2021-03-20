<?php
$m = __('email.confirmation');
$countries = __('shop.countries');
$payment = $params['payment'];
$shipping = $params['shipping'];
$payments = __('shop.payments');
$shippings = __('shop.shippings');
?>

<extend>layouts/email</extend>

<block css>
h3 { margin-top: 2em; }
#order {
	border-collapse: collapse;
	margin-bottom: 2rem;
	width: 100%;
}
#order th, #order td { padding-top: 0.5em; }
#order th {
	font-size: 1.2em;
	font-weight: bold;
	text-align: left;
}
#order hr {
	border: 0;
	border-top: 1px solid #eee;
}
#address, #contact { float: left; width: 45%; }
#address { margin-right: 10%; }
#contact { text-align: right; }
.sum {
	font-weight: bold;
	text-align: right !important;
}
.clear { clear: both; }
</block>

<block header><?= $m['thanks'] ?></block>

<block body>
<table id="order">
	<tr>
		<th colspan="2">
			<?= __('shop.cart') ?>
		</th>
	</tr>
	<tr>
		<td>{{ units }} x La Locloise</td>
		<td class="sum">{{ price }} CHF</td>
	</tr>
	<tr><td colspan="2"><hr/></td></tr>
	<tr>
		<th colspan="2">
			<?= __('shop.shipping') ?>
		</th>
	</tr>
	<tr>
		<td><?= $shippings[$shipping] ?></td>
		<td class="sum">{{ shipping_fees }} CHF</td>
	</tr>
	<tr><td colspan="2"><hr/></td></tr>
	<tr>
		<th colspan="2">
			<?= __('shop.payment') ?>
		</th>
	</tr>
	<tr>
		<td>
		<?= $payments[$payment] ?>
		<?php if ($payment == 'paypal'): ?>
		<br><small><?= $m['paypal_order_id'] ?></small>
		<?php endif; ?>
	</td>
		<td class="sum">{{ payment_fees }} CHF</td>
	</tr>
	<tr><td colspan="2"><hr/></td></tr>
	<tr>
		<th>TOTAL</th>
		<th class="sum">{{total}} CHF</th>
	</tr>
</table>
<h3><?= __('shop.contact') ?></h3>
<div id="address">
	{{first_name}} {{last_name}}<br>
	{{street}}<br>
	{{npa}} {{city}}<br>
	<?= $countries[$params['country']] ?>
</div>
<div id="contact">
	<a href="mailto:{{email}}">{{email}}</a><br>
	{{phone}}
</div>
<div class="clear"></div>

<?php if ($payment == 'direct'): ?>
<h3><?= $m['process'] ?></h3>
<p class="justify">
	<?= $m['instructions'] ?>
</p>
<p>
	<b><?= $m['bank_account'] ?></b><br>
	RUBI MATHIEU<br>
	ASSOCIATION DU LOCLATHON<br>
	CH27 0900 0000 1544 2657 0
</p>
<p><b><?= $m['reference'] ?></b><br>ORDRE#{{order_id}}</p>
<p><b><?= $m['amount'] ?></b><br>{{total}} CHF</p>
<?php endif; ?>
</block>
