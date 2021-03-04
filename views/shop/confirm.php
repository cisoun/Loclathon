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

#pay > button {
  width: 100%;
}

#shop table tr td:first-child { font-weight: bold; text-align: left; }
#shop table tr td:last-child { text-align: right; }
</block>
<block content>
<h1>Résumé de la commande</h1>

<div class="dual spaced">
  <div>
    <h3>Adresse</h3>
    <p>
    {{ first_name }} {{ last_name }}<br>
    {{ street }}<br>
    {{ npa }} {{ city }}<br>
    <?= __('shop.countries')[$country] ?>
    </p>
    <p>
    Confirmation will be sent to:<br/>
    {{ email1 }}
    </p>
    <p><a href="/{{lang}}/shop">Changer mon adresse</a></p>
  </div>
  <div id="pay">
    <h3>Décompte</h3>
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
    <p><a href="/{{lang}}/shop">Changer ma commande</a></p>
    <h3>Paiement</h3>
    <button id="payByInvoice" type="submit"><svg class="outline"><use href="../static/img/icons.svg#card"/></svg>Vérifier la commande</button>
  </div>
<div>
</block>
