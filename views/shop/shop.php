<?php
  function form($key, $default = NULL) {
    if (array_key_exists($key, $_POST)) {
      return $_POST[$key];
    } else if ($default) {
      return $default;
    }
    return '';
  }

  function checkbox($key) {
    if (array_key_exists($key, $_POST)) {
      echo('checked');
    }
  }

  function radio($key, $value, $checked = false) {
    $has_selection = array_key_exists($key, $_POST);
    $selected = $has_selection && $_POST[$key] === $value;
    if ($selected || (!$has_selection && $checked)) {
      echo('checked');
    }
  }


  $countries = [
    ['FR', 'France'],
    ['CH', 'Suisse'],
  ];
  $selected_country = form('country', 'CH');
  $units = min(6, 6); //units();

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = shop_check($units);

    if ($result == 0) {
      $error = '<b>Oups !</b> Les adresses mail ne sont pas valides.';
    }
    else if ($result == 1) {
      $error = '<b>Oups !</b> Les adresses mail ne correspondent pas.';
    }
    else if ($result == 2) {
      $error = "<b>Désolé !</b> Nous n'avons plus que $units bouteilles en stock !";
    }
    else if ($result == 3) {
      $error = "<b>Désolé !</b> Vous devez avoir au moins 18 ans pour acheter cet article !<br/>
        Avez-vous oublié de cocher la case de vérification d'âge en bas de la page ?";
    }
  }
?>

@extend('views/layouts/main');
@section('footer')
  <script src="/static/js/layout.js" type="module" defer></script>
  <script src="/static/js/fetch.js" type="module" defer></script>
  <script src="/static/js/shop.js" type="module" defer></script>
@endsection
@section('css')
    body {
      font-family: 'Raleway';
      text-align: justify;
    }

    h1 {
      font-size: 1.4rem;
      margin-top: 3rem;
    }

    hr {
      margin: 2rem 0;
      padding: 0;
    }

    form > div > div {
      padding: 0 3rem !important;
      min-height: 100%;
    }

    #logo {
      fill: var(--dark);
      display: block;
      margin: 3rem 0 0 3rem;
      height: 80px;
    }

    .alert { margin: 2rem 3rem 0 3rem; }

    .radio label { font-weight: bold; }
    .radio label small { font-weight: normal; }

    #shipping { font-size: 1rem; padding-bottom: 1rem; white-space: nowrap; }
    #shipping div:last-child { font-weight: bold; text-align: right; }

    #price { font-size: 1.4rem; padding-bottom: 1rem; white-space: nowrap; }
    #price div:first-child { line-height: 2rem; }
    #price div:last-child { font-size: 1.6rem; font-weight: bold; text-align: right; }

    #payByPaypal, #payByInvoice { display: block; margin-top: 1rem; width: 100%; }
    #pay .outline.dark { margin-right: 0.5rem; stroke: white; }
@endsection

@section('content')
<main id="shop" class="container dark">
  <!-- <svg id="logo"><use href="../static/img/locloise.all.svg#logo"/></svg> -->

  <?php if (isset($error)) { ?>
  <div class="alert error"><svg class="outline"><use href="../static/img/icons.svg#cross"/></svg><div><?php echo($error); ?></div></div>
  <?php } ?>

  <form action="#" method="POST" autocomplete="on">
    <div class="dual">

      <!-- First column -->
      <div>

        <h1>Coordonnées</h1>

        <div class="dual">
          <div class="group">
            <label for="firstName">Prénom:</label>
            <input id="firstName" name="first_name" type="text" placeholder="Prénom" value="<?= form('first_name'); ?>" required>
          </div>
          <div class="group">
            <label for="lastName">Nom:</label>
            <input id="lastName" name="last_name" type="text" placeholder="Nom" value="<?= form('last_name'); ?>" required>
          </div>
        </div>
        <div class="group">
          <label for="street">Rue:</label>
          <input id="street" name="street" type="text" placeholder="Rue" value="<?= form('street'); ?>" required>
        </div>
        <div class="tria">
          <div class="group">
            <label for="city">Ville:</label>
            <input id="city" name="city" type="text" placeholder="Ville" value="<?= form('city'); ?>" required>
          </div>
          <div class="group">
            <label for="npa">NPA:</label>
            <input id="npa" name="npa" type="number" placeholder="1000" value="<?= form('npa'); ?>" required>
          </div>
          <div class="group dropdown">
            <label for="country">Pays:</label>
            <select name="country" id="country" required>
              <?php foreach ($countries as $country) { ?>
                <option value="<?= $country[0] ?>" <?= $country[0] == $selected_country ? 'selected' : ''; ?>><?= $country[1] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="group">
          <label for="email1">Adresse email:</label>
          <input id="email1" name="email1" type="email" placeholder="Adresse email" value="<?= form('email1'); ?>" required>
        </div>
        <div class="group">
          <label for="email2">Adresse email (confirmation):</label>
          <input id="email2" name="email2" type="email" placeholder="Adresse email" value="<?= form('email2'); ?>" required>
        </div>
        <div class="group">
          <label for="phone">Téléphone (facultatif):</label>
          <input id="phone" name="phone" type="tel" placeholder="Numéro de téléphone" value="<?= form('phone'); ?>">
        </div>

        <div class="group checkbox">
          <input type="checkbox" id="age" name="age" <?php checkbox('age'); ?>>
          <label for="age">Je certifie avoir plus de 18 ans.</label>
        </div>

      </div>

      <!-- Second column -->
      <div>

        <h1>Panier</h1>

        <div class="group number">
          <label for="units">Nombre de bouteilles</label>
          <div>
            <input type="number" id="units" name="units" min=1 max=<?php echo($units); ?> value=<?= form('units', 1); ?> required>
            <button type="button" class="hidden">-</button>
            <button type="button" class="hidden">+</button>
          </div>
        </div>

        <h1>Livraison</h1>

        <div class="group radio with-check">
          <input type="radio" name="shipping" id="shippingByCar" value="paypal" <?php radio('shipping', 'paypal', true); ?> disabled/>
          <label for="shippingByCar" id="shippingByCarLabel">Livraison locale <span class="label">gratuit</span><br/><small>Uniquement pour Le Locle et La Chaux-de-Fonds.</small></label>
          <input type="radio" name="shipping" id="shippingOnSite" value="onsite" <?php radio('shipping', 'onsite'); ?>/>
          <label for="shippingOnSite">Sur place <span class="label">gratuit</span><br><small>Vous venez cherchez la bouteille au dépôt.<br>Les instructions vous seront transmises par mail.</small></label>
          <input type="radio" name="shipping" id="shippingByPost" value="paypal" <?php radio('shipping', 'paypal', true); ?>/>
          <label for="shippingByPost">Envoi postal</label>
        </div>

        <h1>Paiement</h1>

        <div class="group radio with-check">
          <input type="radio" name="payment" id="payTruc" value="direct" <?php radio('payment', 'direct', true); ?>/>
          <label for="payTruc">Virement direct<br><small>Les données IBAN vous seront transmises par mail.</small></label>
          <input type="radio" name="payment" id="payTwint" value="twint" <?php radio('payment', 'twint'); ?>/>
          <label for="payTwint">Twint / carte de crédit</label>
          <input type="radio" name="payment" id="payYolo" value="paypal" <?php radio('payment', 'paypal'); ?>/>
          <label for="payYolo">Paypal</label>
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
          <button id="payByInvoice" type="submit"><svg class="outline dark"><use href="../static/img/icons.svg#card"/></svg>Passer au paiement</button>
          <div id="payByPaypal"></div>
        </div>

      </div>

    </div>
  </form>
</main>
@endsection
