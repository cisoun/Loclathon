<?php
$country = $params['country'];
$payment = $params['payment'];
$shipping = $params['shipping'];
?>
<extend>layouts/shop</extend>
<block css>
#shop table {
  width: 100%;
}
#shop tr {
  background-color: var(--input-background);
}
#shop table tr:last-child {
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

#shop table tr td:first-child { font-weight: bold; text-align: left; }
#shop table tr td:last-child { text-align: right; }
</block>
<block content>
<h1><?= __('shop.order_summary') ?></h1>

<div class="dual spaced">
  <div>
    <h3><?= __('shop.address') ?></h3>
    <p>
      {{ first_name }} {{ last_name }}<br>
      {{ street }}<br>
      {{ npa }} {{ city }}<br>
      <?= __('shop.countries')[$country] ?>
    </p>
    <p>
    <b>
      <?= __('shop.confirmation_to') ?></b>:<br/>
      {{ email }}
    </p>
    <p><a href="/{{lang}}/shop"><?= __('shop.change_address') ?></a></p>
  </div>
  <div id="pay">
    <h3><?= __('shop.payment') ?></h3>
    <table>
      <tr>
        <td>{{ units }} x La Locloise</td>
        <td>{{ price }} CHF</td>
      </tr>
      <tr>
        <td>
          <?= __('shop.shippings')[$shipping] ?><br>
          <small><?= __('shop.shipping') ?></small>
        </td>
        <td>{{ shipping_fees }} CHF</td>
      </tr>
      <tr>
        <td>
          <?= __('shop.payments')[$payment] ?><br>
          <small><?= __('shop.payment') ?></small>
        </td>
        <td>{{ payment_fees }} CHF</td>
      </tr>
      <tr>
        <td>Total</td>
        <td>{{ total }} CHF</td>
      </tr>
    </table>
    <p><a href="/{{lang}}/shop"><?= __('shop.change_order') ?></a></p>
    <h3><?= __('shop.shipping') ?></h3>
    <a href="/{{lang}}/shop/confirm" class="button"><svg class="outline"><use href="../static/img/icons.svg#card"/></svg><?= __('shop.pay') ?></a>
  </div>
<div>
</block>
