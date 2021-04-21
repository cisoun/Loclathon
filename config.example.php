<?php

$CONFIG = [
    # Mail address of the agents.
    #   Agents will receive contact forms.
    'agents'         => ['john@doe.com'],

    # Environment.
    #   Set variable to false for a production environment.
    #   Debug environment will disable cached views.
    'debug'          => true,

    # Default locale.
    'locale'         => 'fr',

    # Available locales.
    'locales'        => ['en', 'fr'],

    # Logo URL that will be included in the confirmation.
    'logo'           => '',

    # Mail host for outgoing mails.
    'mail_host'      => gethostbyname('my.host.com'),

	# A noreply mail address for outgoing mails.
	'mail_noreply'   => 'noreply@doe.com',

    # Password for the mail address.
    'mail_password'  => '',

    # Mail address for outgoing mails.
    'mail_user'      => 'jane@doe.com',

    # Client ID from the PayPal's account (seller).
    'paypal_id'      => '...',

    # Secret key for the PayPal client ID.
    'paypal_secret'  => '...',

    # Title of the app.
    'title'          => 'Le Loclathon',
];

?>
