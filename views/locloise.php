<extend>layouts/main</extend>
<block title>La Locloise</block>
<block css>
#details h2 {
  margin: 3rem 0 2rem 0;
  text-decoration: smallcaps;
}
#details h1 { font-size: 2rem; }
</block>
<block content>
<main id="locloise" class="dual">
    <div>
      <picture>
        <source srcset="/static/img/locloise.webp" type="image/webp">
        <source srcset="/static/img/locloise.jpg" type="image/jpeg">
        <img src="/static/img/locloise.jpg" alt="La Locloise">
      </picture>
    </div>
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
<section id="details" class="tria padded spaced">
  <div>
    <img src="/static/img/locloise1.jpg" class="responsive"/>
    <h2>Une couleur particulière</h2>
    <p>Notre absinthe est facilement identifiable par sa superbe couleur verte tirant vers le jaune dû la cholorophyle qui lui donne ce teint si particulier.</p>
    <p>Toutefois, celle-ci est très sensible à la lumière. En effet, une exposition prolongée de la bouteille à la lumière du soleil lui confèrera une teinte brune.</p>
    <p><b>Afin de présérver sa couleur originelle, il est donc recommandé de la laisser dans un endroit sombre !</b></p>
  </div>
  <div>
    <img src="/static/img/locloise2.jpg" class="responsive"/>
    <h2>Quelque chose</h2>
    <p>Je dis quelque chose sur l'absinthe. Nom de dieu de bordel de merde je sais pas quoi mettre alors je mets le premier truc qui me vient à l'esprit.</p><p>C'est super mais la Gouadeloupe n'est toujours pas libérée. Allez bouffer vos morts.
    </p>
  </div>
  <div>
    <img src="/static/img/locloise3.jpg" class="responsive"/>
    <h2>Degré précis</h2>
    <p>La Locloise est distillée de manière précise à atteindre un degré d'alcool à 54% en l'honneur des fontaines de la ville du Locle.</p>
    <p>En effet, la ville comporte 27 fontaines. Multipliez ce nombre par 2 et vous obtenez 54 !</p>
  </div>
</section>
</block>
