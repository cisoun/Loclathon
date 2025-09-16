<?php
$countries = $params['countries'];
$selected_country = $params['country'] ?? $params['countries'][0];
$errors = $params['errors'] ?? [];

$inputs          = __('shop.inputs');
$payments        = __('shop.payments');
$payments_infos  = __('shop.payments.infos');
$shippings       = __('shop.shippings');
$shippings_infos = __('shop.shippings.infos');


$form = [
	'firstName'      => ['name' => 'first_name', 'type' => 'text',     'value' => '{{first_name}}', 'required' => true, 'placeholder' => $inputs['first_name']],
	'lastName'       => ['name' => 'last_name',  'type' => 'text',     'value' => '{{last_name}}',  'required' => true, 'placeholder' => $inputs['last_name']],
	'street'         => ['name' => 'street',     'type' => 'text',     'value' => '{{street}}',     'required' => true, 'placeholder' => $inputs['street']],
	'city'           => ['name' => 'city',       'type' => 'text',     'value' => '{{city}}',       'required' => true, 'placeholder' => $inputs['city']],
	'npa'            => ['name' => 'npa',        'type' => 'number',   'value' => '{{npa}}',        'required' => true, 'placeholder' => "1000", 'min' => 1000],
	'email'          => ['name' => 'email',      'type' => 'email',    'value' => '{{email}}',      'required' => true, 'placeholder' => $inputs['email']],
	'phone'          => ['name' => 'phone',      'type' => 'tel',      'value' => '{{phone}}',      'placeholder' => $inputs['phone']],
	'age'            => ['name' => 'age',        'type' => 'checkbox', 'checked' => $params['age'] ?? ''],
	'shippingLocal'  => ['name' => 'shipping',   'type' => 'radio',    'value' => 'local',  'checked' => $params['shipping.local']],
	'shippingPickUp' => ['name' => 'shipping',   'type' => 'radio',    'value' => 'pickup', 'checked' => $params['shipping.pickup']],
	'shippingByPost' => ['name' => 'shipping',   'type' => 'radio',    'value' => 'post',   'checked' => $params['shipping.post']],
	'payIBAN'        => ['name' => 'payment',    'type' => 'radio',    'value' => 'direct', 'checked' => $params['payment.direct']],
	'payTwint'       => ['name' => 'payment',    'type' => 'radio',    'value' => 'twint',  'checked' => $params['payment.twint']],
	'payPaypal'      => ['name' => 'payment',    'type' => 'radio',    'value' => 'paypal', 'checked' => $params['payment.paypal']],
];
$input = function($id) use ($form, $params) {
	$attrs = ["id=\"$id\""];
	foreach ($form[$id] as $key => $value) {
		switch($key) {
			case 'checked': if ($value) { $attrs[] = 'checked'; } break;
			case 'required': if ($value) { $attrs[] = 'required'; } break;
			default: $attrs[] = "$key=\"$value\"";
		}
	}
	return '<input ' . join(' ', $attrs) . '/>';
}
?>

<extend layouts/shop>

<block title><?= __('menu.shop') ?></block>

<block preload>
<link rel="preload" href="<?= statics("js/layout.js") ?>" as="script">
<link rel="preload" href="<?= statics("js/fetch.js") ?>" as="script">
<link rel="preload" href="<?= statics("js/shop.js") ?>" as="script">
</block>

<block head>
<script src="<?= statics("js/shop.js") ?>" type="module" defer></script>
</block>

<block css>
form h1 { font-size: 1.4rem; }

hr {
	margin: 2rem 0;
	padding: 0;
}

.radio label { font-weight: bold; }
.radio label small { font-weight: normal; }

#shipping { font-size: 1rem; padding-bottom: 1rem; white-space: nowrap; }
#shipping div:last-child { font-weight: bold; text-align: right; }

#price { font-size: 1.4rem; padding-bottom: 1rem; white-space: nowrap; }
#price div:first-child { line-height: 2rem; }
#price div:last-child { font-size: 1.6rem; font-weight: bold; text-align: right; }

#payByPaypal, #payByInvoice { display: block; margin-top: 1rem; width: 100%; }
#pay .outline.dark { margin-right: 0.5rem; stroke: white; }
</block>

<block content>
<?php if ($errors): ?>
<div class="alert error">
	<ul>
	<?php foreach ($errors as $error): ?>
		<li><?= __('shop.errors')[$error] ?></li>
	<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>

<form action="/{{lang}}/shop/checkout" method="post" autocomplete="on">
	<div class="flex">

		<!-- First column -->
		<div>

			<h1><?= __('shop.contact') ?></h1>

			<fieldset class="dual">
				<div class="group">
					<label for="firstName"><?= $inputs['first_name'] ?>:</label>
					<?= $input('firstName') ?>
				</div>
				<div class="group">
					<label for="lastName"><?= $inputs['last_name'] ?>:</label>
					<?= $input('lastName') ?>
				</div>
			</fieldset>
			<fieldset>
				<label for="street"><?= $inputs['street'] ?>:</label>
				<?= $input('street') ?>
			</fieldset>
			<fieldset class="tria">
				<div class="group">
					<label for="city"><?= $inputs['city'] ?>:</label>
					<?= $input('city') ?>
				</div>
				<div class="group">
					<label for="npa"><?= $inputs['npa'] ?>:</label>
					<?= $input('npa') ?>
				</div>
				<div class="group dropdown">
					<label for="country"><?= $inputs['country'] ?>:</label>
					<select name="country" id="country" required>
						<?php foreach ($countries as $country) { ?>
							<option value="<?= $country ?>" <?= $country == $selected_country ? 'selected' : ''; ?>><?= __('shop.countries')[$country] ?></option>
						<?php } ?>
					</select>
				</div>
			</fieldset>
			<fieldset class="group">
				<label for="email"><?= $inputs['email'] ?>:</label>
				<?= $input('email') ?>
			</fieldset>
			<fieldset class="group">
				<label for="phone"><?= $inputs['phone'] ?>:</label>
				<?= $input('phone') ?>
			</fieldset>

			<div class="group checkbox">
				<?= $input('age') ?>
				<label for="age"><?= $inputs['age'] ?></label>
			</div>

		</div>

		<!-- Second column -->
		<div>

			<h1><?= __('shop.shipping') ?></h1>

			<fieldset class="group radio with-check">
				<?= $input('shippingLocal') ?>
				<label for="shippingLocal" id="shippingLocalLabel">
					<?= $shippings['local'] ?>
					<span class="label green"><?= __('shop.free') ?></span><br>
					<small><?= $shippings_infos['local'] ?></small>
				</label>
				<?= $input('shippingPickUp') ?>
				<label for="shippingPickUp">
					<?= $shippings['pickup'] ?>
					<span class="label green"><?= __('shop.free') ?></span><br>
					<small><?= $shippings_infos['pickup'] ?></small>
				</label>
				<?= $input('shippingByPost') ?>
				<label for="shippingByPost">
					<?= $shippings['post'] ?><br>
					<small><?= $shippings_infos['post'] ?></small>
				</label>
			</fieldset>

			<h1><?= __('shop.payment') ?></h1>

			<div class="group radio with-check">
				<?= $input('payIBAN') ?>
				<label for="payIBAN">
					<?= $payments['direct'] ?><br>
					<small><?= $payments_infos['direct'] ?></small>
				</label>
				<!-- <input type="radio" name="payment" id="payTwint" value="twint" {{ payment.twint }}/>
				<label for="payTwint">
					<?= $payments['twint'] ?><br>
					<small><?= $payments_infos['twint'] ?></small>
				</label> -->
				<?= $input('payPaypal') ?>
				<label for="payPaypal">
					<?= $payments['paypal'] ?><br>
					<small><?= $payments_infos['paypal'] ?></small>
				</label>
			</div>

			<hr />

			<div id="pay">
				<button id="payByInvoice" type="submit" class="white"><?= __('shop.checkout') ?></button>
				<div id="payByPaypal"></div>
			</div>

		</div>

	</div>
</form>
</block>
