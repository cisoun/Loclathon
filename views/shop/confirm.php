@extend('views/layouts/shop');
@section('css')

#shop table {
  width: 100%;
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
@endsection
@section('content')
<form>

</form>
<main id="shop" class="container padded">
  <!-- <svg id="logo"><use href="/static/img/locloise.svg#logo"/></svg> -->

  <h1>Résumé de la commande</h1>

  <div class="dual spaced">
    <div>
      <h3>Adresse</h3>
      <p>
      Cyriaque Skrapits<br>
      Rue de France 14<br>
      2400 Le Locle<br>
      Suisse
      </p>
      <p><a href="#">— Changer mon adresse</a></p>
      <h3>Décompte</h3>
      <table>
        <tr>
          <td>3x La Locloise</td>
          <td>100 CHF</td>
        </tr>
        <tr>
          <td>
            Livraison<br>
            <small>Envoi postal</small>
          </td>
          <td>9.7 CHF</td>
        </tr>
        <tr>
          <td>
            Paiement<br>
            <small>Virement direct</small>
          </td>
          <td>2.4 CHF</td>
        </tr>
        <tr>
          <td>Total</td>
          <td>100 CHF</td>
        </tr>
      </table>
      <p><a href="#">— Changer ma commande</a></p>
    </div>
    <div id="pay">
      <h3>Paiement</h3>
      <button id="payByInvoice" type="submit"><svg class="outline dark"><use href="../static/img/icons.svg#card"/></svg>Vérifier la commande</button>
      <div class="separator"><span>Hello</span></div>

    </div>
  <div>
</main>
@endsection
