<extend>layouts/main</extend>
<block title>La tournée des fontaines</block>
<block css>
#loclathon > div > img {
  width: 100%;
}
</block>
<block content>
<main id="loclathon">
  <div class="fade"></div>
  <img id="logo" class="container" src="/static/img/home.{{lang}}.svg" alt="Le Loclathon"/>
  <a href="#info" class="btn">En savoir plus <svg class="outline"><use xlink:href="static/img/icons.svg#circle-plus"/></svg></a>
</main>
<section id="info" class="dual">
  <div class="padded">
    <h1> Qu'est-ce que c'est ?</h1>
    <p>
      Le Loclathon est un événement annuel créé en 2015, organisé par trois comparses, qui depuis 2020, ont fondé une association éponyme à but non-lucratif autour de ce projet.
      Il réunit les amateurs d'absinthe pour une marche de 12 heures sur 25 kilomètres à travers la ville du Locle afin de ralier les 27 fontaines officielle de la cité horlogère.
    </p>
    <p>
      Un verre est dégusté par chacun autour de chaque fontaine afin de passer un agréable moment entre amis tout en visitant la ville du Locle.
    </p>
    <p>Êtes-vous amatrice ou amateur d'absinthe ? Alors rejoingnez-nous !</p>
  </div>
  <div class="padded">
    <h1>F.A.Q</h1>
    <div id="faq">
      <div class="left"><span class="bubble">À qui est ouvert l'événement ?</span></div>
      <div class="right"><span class="bubble">À tout le monde.</span><span class="logo"></span></div>
      <div class="left"><span class="bubble">Dois-je m'inscrire quelque part ?</span></div>
      <div class="right"><span class="bubble">Non. L'événement est libre d'accès.</span><span class="logo"></span></div>
      <div class="left"><span class="bubble">C'est donc gratuit ?</span></div>
      <div class="right"><span class="bubble">Carrément !</span><span class="logo"></span></div>
      <div class="left"><span class="bubble">Que dois-je prendre avec moi ?</span></div>
      <div class="right"><span class="bubble">Boisson de votre choix, un verre et de bonnes chaussures. À manger éventuellement.</span><span class="logo"></span></div>
    </div>
  </div>
</section>
</block>
