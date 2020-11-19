<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$ok = false;
$first_name = '';
$last_name  = '';
$city       = '';
$phone      = '';


if ($_POST) {
  $first_name = $_POST['first_name'];
  $last_name  = $_POST['last_name'];
  $city       = $_POST['city'];
  $phone      = str_replace(' ', '', $_POST['phone']);
  $ok = $_POST['check'] === $_SESSION['check'];

  if ($ok) {
    $data = array(
      $first_name,
      $last_name,
      $city,
      $phone
    );

    # Sanitize data.
    $exclude = array(';', '"');
    for ($i = 0; $i < count($data); $i++) {
      $data[$i] = str_replace($exclude, '', $data[$i]);
    }

    $csv = fopen('participants.csv', 'a+');
    fwrite($csv, join(';', $data) . "\n");
    fclose($csv);
  }
}

$min = rand(1, 5);
$max = rand(1, 5);
$_SESSION['check'] = strval($min + $max);

$finished = true;
?>
<!doctype html>
<html lang="fr">
<head>
  <title>Le Loclathon</title>

  <link rel="icon" type="image/svg" href="../img/logo.svg">

  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="description" content="Site officiel du Loclathon et de l'absinthe La Locloise.">
  <meta name="keywords" content="loclathon,absinthe,le locle,locloise">
  <meta name="author" content="Comité du Loclathon">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;800&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Raleway:200,400,600" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <style type="text/css">
    body {
      background-color: var(--gray-900);
      color: var(--gray-100);
      padding: 2rem;
      text-align: justify;
    }

    a, a:hover, a:visited { color: var(--gray-100); }
    a { text-decoration: underline; }

    q { font-style: italic; }

    .container {
      max-width: 600px !important;
      width: 100%;
    }

    .text-center { text-align: center; }
    .text-light { color: var(--gray-700); }

    #logo {
      height: 100px;
      display: block;
      margin: 2rem auto 2rem auto;
      width: 100px;
    }

    #logo path {
      fill: var(--gray-100) !important;
    }

    input[type="submit"] {
      background: var(--gray-100);
      border: 0;
      border-radius: 3px;
      color: var(--gray-900);
      display: block;
      font-size: 1rem;
      margin: 2rem auto 2rem auto;
      padding: 0.5rem 2rem;
    }

    li { padding: 1rem; }
  </style>
</head>
<body>
  <div class="container">
    <svg id="logo" version="1.1" viewBox="0 0 13.229 13.229" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
     <g transform="translate(-3365.9 1697.5)">
      <path d="m3372.5-1697.5a6.6146 6.6145 0 0 0-6.6146 6.6144 6.6146 6.6145 0 0 0 6.6146 6.6148 6.6146 6.6145 0 0 0 6.6146-6.6148 6.6146 6.6145 0 0 0-6.6146-6.6144zm-0.033 2.5135c0.015 0 0.031 0 0.049 0.01 0.2578 0.1282 0.3773 0.2762 0.9649 0.3499 0.1467 0.063 0.2777 0.2176 0.2434 0.3855-0.1083 0.2095-0.314 0.3465-0.511 0.4659-0.285 0.1914-0.6421 0.1788-0.9622 0.2679-0.2824 0.075-0.2514 0.2545-0.3497 0.5418-0.052 0.5367-0.039 1.8023-0.019 2.3408 0.023 0.5246 0 1.0493 0.027 1.5736 0 0.1957 0.1439 0.4039 0.3296 0.4861 0.537 0.2163 0.6562 0.6111 1.1391 0.9188 0.1401 0.1017 0.3625 0.1288 0.4926 0 0.1432-0.2632 0.1278-0.5778 0.074-0.8631-0.074-0.3459-0.3566-0.5865-0.5169-0.8897-0.056-0.1014-0.1147-0.244-0.027-0.345 0.1968-0.1123 0.4407-0.1002 0.6496-0.029 0.2533 0.1148 0.5138 0.2403 0.7977 0.2487 0.1648-0.016 0.3594 0.039 0.4376 0.1972 0.06 0.2166 0.034 0.4458 0.019 0.6673-0.041 0.3828-0.042 0.7714 0.022 1.1519 0.029 0.2111 0.1105 0.3366 0.023 0.5443-0.046 0.1345-0.2049 0.1758-0.3327 0.161-0.4883-0.076-0.9518-0.162-1.4379-0.2494-0.5607-0.118-1.1385-0.1124-1.7069-0.064-0.2514 0-0.4948 0.081-0.7198 0.1876-0.1975 0.1046-0.4323 0.1964-0.6557 0.1201-0.2726-0.1085-0.4199-0.378-0.6284-0.5671-0.1443-0.1-0.2794-0.2627-0.2538-0.4491 0.068-0.2346 0.3261-0.3633 0.5585-0.3585 0.1289 0.046 0.3081-0.01 0.3424-0.1535 0.034-1.0933-0.053-2.185-0.097-3.2766-0.035-0.3358 0.023-1.4105-0.1-1.7332-0.075-0.2025-0.2861-0.2949-0.4543-0.4065-0.1324-0.066-0.245-0.2295-0.1772-0.3777 0.1465-0.1026 0.2878-0.2125 0.421-0.3319 0.1182-0.099 0.2268-0.2521 0.3981-0.2473 0.1589 0.037 0.227 0.2 0.3286 0.3092 0.201 0.1801 0.4926 0.2007 0.7489 0.1677 0.3229 0 0.6509-0.2217 0.7212-0.5451 0.022-0.084 0.058-0.2063 0.1623-0.2039z" fill="#fff" />
     </g>
    </svg>

	<?php if ($finished) { ?>
	<div class="text-center">
		<h3>Les inscriptions sont closes !</h3>
		<p>Merci à tous d'avoir participé !</p>
		<p>
			<b>Pas eu le temps de t'inscrire ?</b><br/>
			Pas de soucis. Rejoins-nous à la tournée, tu pourras toujours t'inscrire sur place.
		</p>
	</div>
    <?php } else if (!$ok) { ?>
    <p>
      Hello !
    </p>
    <p>
      Afin d'être en adéquation avec les restrictions imposées par le canton, merci de bien vouloir t'inscrire à l'événement via le formulaire ci-dessous.<br/>
      <b>Ces données ne seront conservées que 14 jours après l'événement. Une signature de confirmation te sera également demandée lorsque tu te joindras à la marche.</b>
    </p>
    <p>
      <q>
        Au travers de mon inscription, j’acquiesce les termes suivants :<br/>
        J’affirme que les données remplies sur le présent document sont véridiques.
        Également, je m’engage à respecter toutes les règles formulées par l’association du LOCLATHON ainsi que celles de l’OFSP.<br/>
        Je m’engage également à informer les organisateurs si je suis testé positif au nouveau coronavirus dans les
        14 jours suivant l’événement afin qu’ils puissent prendre les dispositions nécessaires.
      </q>
    </p>

    <form action="#" method="post">
      <div class="uni">
        <div class="group">
          <label for="formFirstName">Prénom: *</label>
          <input id="formFirstName" type="text" placeholder="Prénom" name="first_name" value="<?php echo $first_name; ?>" required>
        </div>
        <div class="group">
          <label for="formLastName">Nom: *</label>
          <input id="formLastName" type="text" placeholder="Nom" name="last_name" value="<?php echo $last_name; ?>" required>
        </div>
        <div class="group">
          <label for="formCity">Ville: *</label>
          <input id="formCity" type="text" placeholder="Ville" name="city" value="<?php echo $city; ?>" required>
        </div>
        <div class="group">
          <label for="formPhone">Numéro de téléphone: *</label>
          <input id="formPhone" type="tel" placeholder="+4178-000-0000" pattern="\+?[0-9]{1,3}\s?[0-9]{2,3}\s?[0-9]{3}\s?[0-9]{2}\s?[0-9]{2}" name="phone" value="<?php echo $phone; ?>" required>
        </div>

        <div class="group">
          <label for="formCheck">Combien font <?php echo "$min + $max"?> ?  *</label>
          <input id="formCheck" type="number" maxlength="2" name="check" required>
          <sub class="text-light">Vérification anti-spam</sub>
        </div>

        <input type="submit" value="S'inscrire" />
      </div>
    </form>
  <?php } else { ?>
  <div class="text-center">
    <h3>Merci pour ta participation !</h3>
    <i>- Le Loclathon</i>
  </div>
  <?php } ?>
  </div>
</body>
</html>
