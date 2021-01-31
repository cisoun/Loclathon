<?php
$countries = $params['countries'];
$selected_country = $params['country'];
$units = $params['units'];
$confirm = false;
$error = $params['error'];
?>

<extend>layouts/main</extend>

<block title><?= __('menu.shop') ?></block>

<block footer>
  <script src="/static/js/layout.js" type="module" defer></script>
  <script src="/static/js/fetch.js" type="module" defer></script>
  <script src="/static/js/shop.js" type="module" defer></script>
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
<main id="shop" class="container padded dark">
  <!-- <svg id="logo"><use href="/static/img/locloise.svg#logo"/></svg> -->

  <?php if ($error > 0): ?>
  <div class="alert error">
    <!-- <svg class="outline"><use href="../static/img/icons.svg#cross"/></svg> -->
    <?php echo(__('shop.error')[$error - 1]); ?></div>
  <?php endif; ?>

  <form action="/{{lang}}/shop" method="POST" autocomplete="on">
    <div class="dual spaced">

      <!-- First column -->
      <div>

        <h1>Coordonnées</h1>

        <div class="dual">
          <div class="group">
            <label for="firstName">Prénom:</label>
            <input id="firstName" name="first_name" type="text" placeholder="Prénom" value="{{ first_name }}" required>
          </div>
          <div class="group">
            <label for="lastName">Nom:</label>
            <input id="lastName" name="last_name" type="text" placeholder="Nom" value="{{ last_name }}" required>
          </div>
        </div>
        <div class="group">
          <label for="street">Rue:</label>
          <input id="street" name="street" type="text" placeholder="Rue" value="{{ street }}" required>
        </div>
        <div class="tria">
          <div class="group">
            <label for="city">Ville:</label>
            <input id="city" name="city" type="text" placeholder="Ville" value="{{ city }}" required>
          </div>
          <div class="group">
            <label for="npa">NPA:</label>
            <input id="npa" name="npa" type="number" placeholder="1000" value="{{ npa }}" required>
          </div>
          <div class="group dropdown">
            <label for="country">Pays:</label>
            <select name="country" id="country" required>
              <?php foreach ($countries as $country) { ?>
                <option value="<?= $country ?>" <?= $country == $selected_country ? 'selected' : ''; ?>><?= __('shop.countries')[$country] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="group">
          <label for="email1">Adresse email:</label>
          <input id="email1" name="email1" type="email" placeholder="Adresse email" value="{{ email1 }}" required>
        </div>
        <div class="group">
          <label for="email2">Adresse email (confirmation):</label>
          <input id="email2" name="email2" type="email" placeholder="Adresse email" value="{{ email2 }}" required>
        </div>
        <div class="group">
          <label for="phone">Téléphone (facultatif):</label>
          <input id="phone" name="phone" type="tel" placeholder="Numéro de téléphone" value="{{ phone }}">
        </div>

        <div class="group checkbox">
          <input type="checkbox" id="age" name="age" {{ age }}>
          <label for="age">Je certifie avoir plus de 18 ans.</label>
        </div>

      </div>

      <!-- Second column -->
      <div>

        <h1>Panier</h1>

        <div class="group number">
          <label for="units">Nombre de bouteilles</label>
          <div>
            <input type="number" id="units" name="units" min=1 max=<?= $units ?> value="{{ units }}" required>
            <button type="button" class="hidden">-</button>
            <button type="button" class="hidden">+</button>
          </div>
        </div>

        <h1>Livraison</h1>

        <div class="group radio with-check">
          <input type="radio" name="shipping" id="shippingLocal" value="local" {{ shipping.local }}/>
          <label for="shippingLocal" id="shippingLocalLabel">
            Livraison locale <span class="label green">gratuit</span><br/>
            <small>Uniquement pour Le Locle et La Chaux-de-Fonds (Suisse).</small>
          </label>
          <input type="radio" name="shipping" id="shippingPickUp" value="pickup" {{ shipping.pickup }}/>
          <label for="shippingPickUp">
            Sur place <span class="label green">gratuit</span><br>
            <small>Vous venez cherchez la bouteille au dépôt.<br>Les instructions vous seront transmises par mail.</small>
          </label>
          <input type="radio" name="shipping" id="shippingByPost" value="post" {{ shipping.post }}/>
          <label for="shippingByPost">Envoi postal</label>
        </div>

        <h1>Paiement</h1>

        <div class="group radio with-check">
          <input type="radio" name="payment" id="payIBAN" value="direct" {{ payment.direct }}/>
          <label for="payIBAN">
            Virement direct<br>
            <small>Les données IBAN vous seront transmises par mail.</small>
          </label>
          <input type="radio" name="payment" id="payTwint" value="twint" {{ payment.twint }}/>
          <label for="payTwint">Twint / carte de crédit</label>
          <input type="radio" name="payment" id="payPaypal" value="paypal" {{ payment.paypal }}/>
          <label for="payPaypal">Paypal</label>
        </div>

        <hr />

        <!-- <div id="shipping">
          <div class="w-50">Shipping</div>
          <div class="w-50"><span id="total">7.90</span> CHF</div>
        </div>
        <div id="price">
          <div class="w-50">Total</div>
          <div class="w-50"><span id="total">35</span> CHF</div>
        </div> -->

        <div id="pay">
          <button id="payByInvoice" type="submit"><svg class="outline dark"><use href="../static/img/icons.svg#card"/></svg>Vérifier la commande</button>
          <div id="payByPaypal"></div>
        </div>

      </div>

    </div>
  </form>

</main>
</block>
