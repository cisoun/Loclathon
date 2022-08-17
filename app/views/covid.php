<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$finished = false;

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
?>

<extend layouts/main>

<block title>Inscription</block>

<block css>
#covid { max-width: 700px; }
#covid h1 { text-align: center; }
#submit { margin-top: 2rem; }
</block>

<block content>
<main id="covid" class="container padded dark">
	<h1>Inscription</h1>
	<?php if ($_POST && !$ok): ?>
	<div class="alert error">Un des champs, ou le code de vérification, est érroné.</div>
	<?php endif; ?>
<?php if ($finished): ?>
	<div class="text-center">
		<h3>Les inscriptions sont closes !</h3>
		<p>Merci à tous d'avoir participé !</p>
		<p>
			<b>Pas eu le temps de t'inscrire ?</b><br/>
			Pas de soucis. Rejoins-nous à la tournée, tu pourras toujours t'inscrire sur place.
		</p>
	</div>
<?php elseif (!$ok): ?>
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

    <form action="/{{lang}}/inscription" method="post">
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

        <button id="submit" type="submit">S'inscrire</button>
      </div>
    </form>
<?php else: ?>
  <div class="text-center">
    <h3>Merci pour ta participation !</h3>
    <i>- Le Loclathon</i>
  </div>
<?php endif; ?>
</main>
</block>
