<?php
$countries = $params['countries'];
$selected_country = $params['country'];
$units = $params['units'];
$errors = $params['errors'] ?? [];

$inputs = __('shop.inputs');
$payments = __('shop.payments');
$payments_infos = __('shop.payments.infos');
$shippings = __('shop.shippings');
$shippings_infos = __('shop.shippings.infos');

$form = [
  'firstName'      => ['name' => 'first_name', 'type' => 'text',     'value' => '{{first_name}}', 'required' => true, 'placeholder' => "Prénom"],
  'lastName'       => ['name' => 'last_name',  'type' => 'text',     'value' => '{{last_name}}',  'required' => true, 'placeholder' => "Nom"],
  'street'         => ['name' => 'street',     'type' => 'text',     'value' => '{{street}}',     'required' => true, 'placeholder' => "Rue"],
  'city'           => ['name' => 'city',       'type' => 'text',     'value' => '{{city}}',       'required' => true, 'placeholder' => "Ville"],
  'npa'            => ['name' => 'npa',        'type' => 'number',   'value' => '{{npa}}',        'required' => true, 'placeholder' => "1000", 'min' => 1000],
  'email1'         => ['name' => 'email1',     'type' => 'email',    'value' => '{{email1}}',     'required' => true, 'placeholder' => "Adresse email"],
  'email2'         => ['name' => 'email2',     'type' => 'email',    'value' => '{{email2}}',     'required' => true, 'placeholder' => "Adresse email"],
  'phone'          => ['name' => 'phone',      'type' => 'tel',      'value' => '{{phone}}',      'placeholder' => "Numéro de téléphone"],
  'age'            => ['name' => 'age',        'type' => 'checkbox', 'checked' => "$params[age]"],
  'units'          => ['name' => 'units',      'type' => 'number',   'value' => '{{units}}',      'required' => true, 'min' => 1, 'max' => 6],
  'shippingLocal'  => ['name' => 'shipping',   'type' => 'radio',    'value' => 'local',  'checked' => '{{shipping.local}}'],
  'shippingPickUp' => ['name' => 'shipping',   'type' => 'radio',    'value' => 'pickup', 'checked' => '{{shipping.pickup}}'],
  'shippingByPost' => ['name' => 'shipping',   'type' => 'radio',    'value' => 'post',   'checked' => '{{shipping.post}}'],
  'payIBAN'        => ['name' => 'payment',    'type' => 'radio',    'value' => 'direct', 'checked' => '{{payment.direct}}'],
  'payTwint'       => ['name' => 'payment',    'type' => 'radio',    'value' => 'twint',  'checked' => '{{payment.twint}}'],
  'payPaypal'      => ['name' => 'payment',    'type' => 'radio',    'value' => 'paypal', 'checked' => '{{payment.paypal}}'],
];

$input = function($id) use ($form) {
  $attrs = ["id=\"$id\""];
  foreach ($form[$id] as $key => $value) {
    switch($key) {
      case 'checked':  if ($value) { $attrs[] = 'checked'; } break;
      case 'required': if ($value) { $attrs[] = 'required'; } break;
      default: $attrs[] = "$key=\"$value\"";
    }
  }
  return '<input ' . join(' ', $attrs) . '/>';
}
?>

<extend>layouts/shop</extend>

<block title><?= __('menu.shop') ?></block>

<block preload>
<link rel="preload" href="/static/js/layout.js" as="script">
<link rel="preload" href="/static/js/fetch.js" as="script">
<link rel="preload" href="/static/js/shop.js" as="script">
</block>

<block footer>
<script src="/static/js/layout.js" type="module"></script>
<script src="/static/js/fetch.js" type="module"></script>
<script src="/static/js/shop.js" type="module"></script>
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
  <!-- <svg class="outline"><use href="../static/img/icons.svg#cross"/></svg> -->
  <ul>
  <?php foreach ($errors as $error): ?>
    <li><?= __('shop.errors')[$error] ?></li>
  <?php endforeach; ?>
  </ul>
</div>
<?php endif; ?>

<form action="/{{lang}}/shop" method="POST" autocomplete="on">
  <div class="dual spaced">

    <!-- First column -->
    <div>

      <h1><?= __('shop.contact') ?></h1>

      <div class="dual">
        <div class="group">
          <label for="firstName"><?= $inputs['first_name'] ?>:</label>
          <?= $input('firstName') ?>
        </div>
        <div class="group">
          <label for="lastName"><?= $inputs['last_name'] ?>:</label>
          <?= $input('lastName') ?>
        </div>
      </div>
      <div class="group">
        <label for="street"><?= $inputs['street'] ?>:</label>
        <?= $input('street') ?>
      </div>
      <div class="tria">
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
      </div>
      <div class="group">
        <label for="email1"><?= $inputs['email1'] ?>:</label>
        <?= $input('email1') ?>
      </div>
      <div class="group">
        <label for="email2"><?= $inputs['email2'] ?>:</label>
        <?= $input('email2') ?>
      </div>
      <div class="group">
        <label for="phone"><?= $inputs['phone'] ?>:</label>
        <?= $input('phone') ?>
      </div>

      <div class="group checkbox">
        <?= $input('age') ?>
        <label for="age"><?= $inputs['age'] ?></label>
      </div>

    </div>

    <!-- Second column -->
    <div>

      <h1><?= __('shop.cart') ?></h1>

      <div class="group number">
        <label for="units"><?= $inputs['units'] ?>:</label>
        <div>
          <?= $input('units') ?>
          <button type="button" class="hidden">-</button>
          <button type="button" class="hidden">+</button>
        </div>
      </div>

      <h1><?= __('shop.shipping') ?></h1>

      <div class="group radio with-check">
        <input type="radio" name="shipping" id="shippingLocal" value="local" {{ shipping.local }}/>
        <label for="shippingLocal" id="shippingLocalLabel">
          <?= $shippings['local'] ?>
          <span class="label green"><?= __('shop.free') ?></span><br>
          <small><?= $shippings_infos['local'] ?></small>
        </label>
        <input type="radio" name="shipping" id="shippingPickUp" value="pickup" {{ shipping.pickup }}/>
        <label for="shippingPickUp">
          <?= $shippings['pickup'] ?>
          <span class="label green"><?= __('shop.free') ?></span><br>
          <small><?= $shippings_infos['pickup'] ?></small>
        </label>
        <input type="radio" name="shipping" id="shippingByPost" value="post" {{ shipping.post }}/>
        <label for="shippingByPost">
          <?= $shippings['post'] ?><br>
          <small><?= $shippings_infos['post'] ?></small>
        </label>
      </div>

      <h1><?= __('shop.payment') ?></h1>

      <div class="group radio with-check">
        <input type="radio" name="payment" id="payIBAN" value="direct" {{ payment.direct }}/>
        <label for="payIBAN">
          <?= $payments['direct'] ?>
          <span class="label green"><?= __('shop.free') ?></span><br>
          <small><?= $payments_infos['direct'] ?></small>
        </label>
        <input type="radio" name="payment" id="payTwint" value="twint" {{ payment.twint }}/>
        <label for="payTwint">
          <?= $payments['twint'] ?><br>
          <small><?= $payments_infos['twint'] ?></small>
        </label>
        <input type="radio" name="payment" id="payPaypal" value="paypal" {{ payment.paypal }}/>
        <label for="payPaypal">
          <?= $payments['paypal'] ?><br>
          <small><?= $payments_infos['paypal'] ?></small>
        </label>
      </div>

      <hr />

      <div id="pay">
        <button id="payByInvoice" type="submit"><svg class="outline fill dark"><use href="../static/img/icons.svg#card"/></svg><?= __('shop.checkout') ?></button>
        <div id="payByPaypal"></div>
      </div>

    </div>

  </div>
</form>
</block>
