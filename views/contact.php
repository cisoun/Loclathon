<?php
require_once(getcwd() . '/app/mail.php');

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$ok = false;
$submit = false;
$name = '';
$mail = '';
$message = '';

if ($_POST) {
  $submit = true;
  $name = $_POST['name'];
  $mail  = $_POST['mail'];
  $message = $_POST['message'];
  $ok = $_POST['check'] === $_SESSION['check'];

  if ($ok) {
    $subject = 'Message de ' . $name;
    mail_send($subject, $mail, $message, false);
  }
}
$min = rand(1, 5);
$max = rand(1, 5);
$_SESSION['check'] = strval($min + $max);
?>
<extend>views/layouts/main</extend>
<block title>Contact</block>
<block css>
#contact { max-width: 600px; }
</block>
<block content>
<main id="contact" class="container dark">
  <!--a href="/"><svg id="logo"><use href="/static/img/logos.svg#loclathon"/></svg></a-->
  <h1>Formulaire de contact</h1>
  <?php if (!$ok) { ?>
    <form action="#" method="post">
      <div class="group">
        <label for="name">Prénom et nom :</label>
        <input type="text" id="name" name="name" placeholder="Prénom et nom" value="<?php echo $name; ?>" required>
      </div>
      <div class="group">
        <label for="mail">Email :</label>
        <input type="email" id="mail" name="mail" placeholder="Email" value="<?php echo $mail; ?>" required>
      </div>
      <div class="group">
        <label for="message">Message :</label>
        <textarea id="message" name="message" placeholder="message" rows="10" required><?php echo $message; ?></textarea>
      </div>
      <div class="group">
        <label for="check">Vérification :</label>
        <input type="number" id="check" name="check" placeholder="<?php echo "$min + $max ?" ?>" class="<?php if ($submit && !$ok) echo 'invalid'; ?>" required>
      </div>
      <div class="separator">
        <span>Confirmation</span>
      </div>
      <div class="group uni">
        <button type="submit">Envoyer</button>
      </div>
    </form>
  <?php } else { ?>
    <div class="text-center">
      <h1>Merci !</h1>
      <p>Nous essayerons de te répondre au plus vite !</p>
      <a href="..">Revenir au site <span>→</span></a>
    </div>
  <?php } ?>
</main>
</block>
