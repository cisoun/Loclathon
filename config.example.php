<?php

$CONFIG = [
  # Mail address of the agents.
  #   Agents will receive contact forms.
  'agents'        => ['john@doe.com'],

  # Environment.
  #   Set variable to false for a production environment.
  #   Debug environment will disable cached views.
	'debug'         => true,

  # Default locale.
  'locale'        => 'fr',

  # Available locales.
  'locales'       => ['en', 'fr'],

  # Logo URL that will be included in the confirmation.
	'logo'          => '',

  # Mail host for outgoing mails.
	'mail_host'     => gethostbyname('my.host.com'),

  # Password for the mail address.
	'mail_password' => '',

  # Mail address for outgoing mails.
	'mail_user'     => 'jane@doe.com',

  # Client ID from the PayPal's account (seller).
	'paypal_id'     => '...',

  # Title of the app.
	'title'         => 'My app',
];

?>
