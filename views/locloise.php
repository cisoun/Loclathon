@extend('views/layouts/main')
@data('title', 'La Locloise')
@section('content')
<main id="locloise" class="dual">
  <div id="bottle"></div>
  <div class="padded">
    <h1>La Locloise</h1>
    <div id="status"><span id="price">-</span> CHF</div>
    <p>
      La Locloise est une absinthe conçue spécialement à l'occasion du Loclathon.<br/>
      Son goût mentholé et doux procure une sensation rafraîchissante qui réjouira toute personne motivée à l'emporter avec elle lors de sa marche.
    </p>
    <p>
      Les bénéfices seront réutilisés pour la réalisation d'autres cuvées ainsi qu'à la création de marchandises à l'effigie du Loclathon.
      Merci pour votre soutien !
    </p>
    <p>
      Distillée à Môtiers dans le Val-de-Travers.<br>
      <strong>
        Volume : 0.5 L | Alcool : 54 %
      </strong>
    </p>
    <div id="buy" class="hidden">
      <p>Il reste actuellement <span id="units">0</span> bouteilles.</p>
      <a class="btn btn-light-outline" href="#">J'en veux une !</a>
    </div>
  </div>
</main>
@endsection
