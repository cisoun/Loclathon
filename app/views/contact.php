<?php
$name    = $params['name'];
$mail    = $params['mail'];
$message = $params['message'];
$error   = $params['error'];
$sent    = $params['sent'];
$min     = $params['min'];
$max     = $params['max'];
?>

<extend>layouts/main</extend>

<block title>Contact</block>

<block css>
#contact { max-width: 700px; }
#confirm { padding: 5rem 0; }
</block>

<block content>
<main id="contact" class="container padded dark">
	<?php if (!$sent): ?>
		<h1><?= __('contact.title') ?></h1>
		<?php if ($error > 0): ?>
		<div class="alert error">
			<?= __('contact.error')[$error - 1] ?>
		</div>
		<?php endif; ?>
		<form action="/{{lang}}/contact" method="post">
			<div class="group">
				<label for="name"><?= __('contact.name') ?> :</label>
				<input type="text" id="name" name="name" placeholder="<?= __('contact.name') ?>" value="<?= $name ?>" required>
			</div>
			<div class="group">
				<label for="mail"><?= __('contact.mail') ?> :</label>
				<input type="email" id="mail" name="mail" placeholder="<?= __('contact.mail') ?>" <?= $error == 1 ? 'autofocus' : '' ?> value="<?= $mail ?>" required>
			</div>
			<div class="group">
				<label for="message"><?= __('contact.message') ?> :</label>
				<textarea id="message" name="message" placeholder="<?= __('contact.message') ?>" rows="10" <?= $error == 2 ? 'autofocus' : '' ?> required><?= $message ?></textarea>
			</div>
			<div class="group">
				<label for="check"><?= __('contact.check') ?> :</label>
				<input type="number" id="check" name="check" placeholder="<?= "$min + $max ?" ?>" <?= $error == 3 ? 'autofocus' : '' ?> required>
			</div>
			<div class="separator">
				<span><?= __('contact.confirmation') ?></span>
			</div>
			<div class="group uni">
				<button type="submit"><?= __('contact.send') ?></button>
			</div>
		</form>
	<?php else: ?>
		<div id="confirm" class="text-center">
			<h1><?= __('contact.thanks') ?></h1>
			<p><?= __('contact.reply') ?></p>
		</div>
	<?php endif ?>
</main>
</block>
