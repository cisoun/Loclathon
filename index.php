<?php require_once('api/config.php'); ?>
<!doctype html>
<html lang="fr">
<head>
  <title>Le Loclathon</title>

  <link rel="icon" type="image/svg" href="img/logo.svg">

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="description" content="Site officiel du Loclathon et de La Locloise.">
  <meta name="keywords" content="loclathon,absinthe,le locle,locloise">
  <meta name="author" content="Comité du Loclathon">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <!--link href="https://fonts.googleapis.com/css?family=Fira+Sans:200,400,500" rel="stylesheet"-->
  <link href="https://fonts.googleapis.com/css?family=Raleway:200,400,600" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <!-- Header -->
  <nav id="navbar" class="navbar navbar-expand-lg fixed-top p-3">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-md-center" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link mx-3" href="#locloise">La Locloise</a>
        <a class="nav-item mx-3 d-lg-none" href="#">Le Loclathon</a>
        <a class="nav-item mx-3 d-none d-lg-block navbar-brand image" href="#"></a>
        <a class="nav-item nav-link mx-3" href="#a-propos">À propos</a>
      </div>
    </div>
  </nav>

  <div id="loclathon" class="w-100 text-center d-flex align-items-center justify-content-center">
    <div class="background"></div>
    <div class="position-absolute">
      <h1 class="display-4 font-weight-light">Paré·e à marcher ?</h1>
      <h3>
        Le Loclathon c'est
      </h3>
      <ul>
        <li><b>27</b> fontaines</li>
        <li><b>~25 kilomètres</b> de marche</li>
        <li><b>12 heures</b> de marche à travers Le Locle</li>
      </ul>
      <a class="btn btn-outline-light my-5" href="#a-propos">En savoir plus</a>
    </div>
  </div>

  <div id="locloise" class="w-100">
    <div class="row w-100">
      <div id="bottle" class="col-md-6">
        <div class="background"></div>
      </div>
      <div class="col-md-6 d-flex flex-column justify-content-center p-5">
        <div>
          <div class="h1">La Locloise</div>
          <div id="status" class="h3 pb-5"><span id="price">-</span> CHF</div>
          <p>
            La Locloise est une absinthe conçue spécialement à l'occasion du Loclathon.<br/>
            Son goût mentholé et doux procure une sensation rafraîchissante qui ne déplaîra pas au randonneur motivé à l'emporter avec lui lors de sa marche.
          </p>
          <p>
            Distillée à Môtiers dans le Val-de-Travers.<br>
            <strong>
              Volume : 0.5 L | Alcool : 54 %
            </strong>
          </p>
          <div id="buy" class="d-none">
            <p class="mt-5">Il reste actuellement <span id="units" class="font-weight-bold">0</span> bouteilles.</p>
            <a class="btn btn-outline-light" href="#" data-toggle="modal" data-target="#modal">Acheter</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div id="a-propos" class="w-100 text-center d-flex align-items-center justify-content-center">
    <div class="background"></div>

    <div class="position-absolute">
      <div class="d-flex align-content-center justify-content-center">
        <div class="col-sm-12 col-md-8 text-center">
          <h1> Qu'est-ce que c'est ?</h1>
          <p>
            Le Loclathon est un événement annuel organisé par trois comparses depuis 2015.<br/>
            Il réunit les amateurs d'abinsthe pour une marche de 12 heures sur 25 kilomètres à travers la ville du Locle afin de ralier les 27 fontaines officielle de la cité horlogère.
          </p>
          <p>
            Un verre est dégusté par chacun autour de chaque fontaine afin de passer un agréable moment entre amis tout en visitant la ville du Locle.
          </p>
          <p>Êtes-vous amatrice ou amateur d'absinthe ? Alors rejoingnez-nous !</p>
        </div>
      </div>
    </div>
  </div>

  <footer class="container py-5">
    <div class="row">
      <div class="col-md-3">
        <div class="image logo"></div>
        <small class="d-block mb-3 text-muted">&copy; 2019 - ∞</small>
      </div>
      <div class="col-md-3">
        <h5>Social</h5>
        <ul class="list-unstyled text-small">
          <li><a class="text-muted" href="https://instagram.com/loclathon">Instagram</a></li>
          <li><a class="text-muted" href="https://fb.com/loclathon">Facebook</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h5>Ressources</h5>
        <ul class="list-unstyled text-small">
          <li><a class="text-muted" href="files/flyer.pdf">Plan du parcours</a></li>
          <li><a class="text-muted" href="img/logo.svg">Logo</a></li>
          <li><a class="text-muted" href="#">Photos (à venir)</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h5>Contact</h5>
        <ul class="list-unstyled text-small">
          <li><a class="text-muted" href="https://fb.com/loclathon">Nous écrire</a></li>
        </ul>
      </div>
    </div>
  </footer>

  <!-- Modals -->
  <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modal-label" aria-hidden="true">
    <div class="modal-dialog text-dark" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal-title">Acheter</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="buy-step">
            <div class="alert border-dark alert-dismissible fade show" role="alert">
              <b>Attention !</b> L'article sera envoyé à l'adresse définie sur Paypal.
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form>
              <div class="form-group">
                <label for="formAmount">Nombre de bouteilles *</label>
                <div class="form-inline form-row">
                  <input type="number" class="form-control col-12 col-md-6" id="formAmount" min="1" max="6" value="1" required>
                  <span class="col-12 col-md-6 pl-md-3 font-weight-bold"><span id="amount">0</span> CHF</span>
                </div>
              </div>
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="formAgeCheck">
                <label class="form-check-label" for="formAgeCheck">Je certifie être majeur·e (+18 ans).</label>
              </div>
            </form>
          </div>
          <div class="buy-step text-center m-5">
            <div class="spinner-border" role="status">
              <span class="sr-only">Loading...</span>
            </div>
          </div>
          <div class="buy-step">
            <p>Un mail de confirmation vous a été envoyé à <span id="email" class="font-weight-bold"></span>.</p>
            <div class="alert alert-warning" role="alert">
              <b>Attention !</b> Si vous ne recevez rien, merci de vérifier qu'il ne soit pas réceptionné en tant que courrier indésirable (spam) !
            </div>
          </div>
          <div class="buy-step">
            Quelque chose s'est mal déroulé pendant le paiement...
          </div>
        </div>
        <div class="modal-footer">
          <button id="finish-button" type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
          <button id="retry-button" type="button" class="btn btn-dark">Réessayer</button>
          <div id="paypal-button"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.0.min.js" integrity="sha384-JUMjoW8OzDJw4oFpWIB2Bu/c6768ObEthBMVSiIx4ruBIEdyNSUQAjJNFqT5pnJ6" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://www.paypal.com/sdk/js?client-id=<?php echo($CONFIG['paypal_id']) ?>&currency=CHF"></script>
  <script src="app.js"></script>
</body>
</html>
