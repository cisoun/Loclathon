<!doctype html>
<html lang="fr">
<head>
  <title>Le Loclathon | <? title ?></title>

  <link rel="icon" type="image/svg" href="/static/img/logo.svg">

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="description" content="Site officiel du Loclathon et de l'absinthe La Locloise.">
  <meta name="keywords" content="loclathon,absinthe,le locle,locloise">
  <meta name="author" content="Comité du Loclathon">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <meta property="og:image" content="static/img/preview.jpg">
  <meta property="og:description" content="Site officiel du Loclathon et de l'absinthe La Locloise.">
  <meta property="og:title" content="Le Loclathon | La Locloise">

  <link href="https://fonts.googleapis.com/css?family=Raleway:200,400,600" rel="stylesheet" preload>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet" preload>

  <!-- CSS -->
  <link rel="preload" href="/static/css/layout.css" as="style">
  <link rel="preload" href="/static/css/style.css" as="style">

  <link rel="stylesheet" href="/static/css/layout.css">
  <link rel="stylesheet" href="/static/css/style.css">

  <link rel="stylesheet" media="screen and (max-width: 992px)" href="/static/css/phone.css" />
  <link rel="stylesheet" media="screen and (min-width: 992px)" href="/static/css/desktop.css" />

  <style type="text/css">
  <? css ?>
  </style>
</head>
<body>
  <!-- Header -->
  <nav id="menu" class="nojs">
    <a href="javascript:void(0);" class="trigger"><svg class="outline"><use xlink:href="/static/img/icons.svg#circle-menu"/></svg> Le Loclathon</a>
    <ul>
      <li><a href="/"><svg class="outline fill"><use xlink:href="/static/img/icons.svg#loclathon"/></svg> Le Loclathon</a></li>
      <li><a href="/{{lang}}/locloise">La Locloise</a></li>
      <li><a href="/{{lang}}/photos">Photos</a></li>
      <li><a href="/{{lang}}/shop">Shop</a></li>
      <li><a href="/{{lang}}/contact">Contact</a></li>
    </ul>
  </nav>

  <? content ?>

  <footer>
    <div class="quad container padded">
      <div>
        <div class="logo"></div>
        <small>
          Association du Loclathon<br/>
          2400 Le Locle<br/>
          &copy; 2019 - ∞
        </small>
      </div>
      <div>
        <h3><svg class="outline"><use xlink:href="/static/img/icons.svg#user"/></svg> Social</h3>
        <a href="https://instagram.com/loclathon">Instagram</a>
        <a href="https://fb.com/loclathon">Facebook</a>
      </div>
      <div>
        <h3><svg class="outline"><use xlink:href="/static/img/icons.svg#grid"/></svg> Ressources</h3>
        <a href="files/flyer.pdf">Plan du parcours</a>
        <a href="img/logo.svg">Logo</a>
      </div>
      <div>
        <h3><svg class="outline"><use xlink:href="/static/img/icons.svg#mail"/></svg> Contact</h3>
        <a href="/{{lang}}/contact">Nous écrire</a>
      </div>
    </div>
  </footer>

  <? footer ?>

  <script type="text/javascript">
    const nav = document.querySelector('nav');
    nav.classList.remove('nojs');
    nav.classList.add('transparent');

    window.onscroll = () => {
      if (window.pageYOffset < 100) {
        nav.classList.add('transparent');
      } else {
        nav.classList.remove('transparent');
      }
    };

    const navTrigger = document.querySelector('nav > .trigger');
    navTrigger.onclick = () => {
      nav.classList.toggle('toggled');
    }
  </script>
</body>
</html>
