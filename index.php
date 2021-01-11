<?php
require_once('config.php');
require_once('app/app.php');

# Serve static ressources.
if (extension('png|jpg|jpeg|gif|css|js|svg|pdf')) {
  return false;
}

switch (method()) {
	case 'GET':
		route('/',						redirect('/fr'));
		route('/:lang',					view_cached('loclathon'));
		route('/:lang/locloise',		view_cached('locloise'));
		route('/:lang/photos',			view_cached('albums'));
		route('/:lang/photos/:year',	view_cached('photos'));
		route('/:lang/shop',			view('shop/shop'));
		route('/:lang/contact',			call('Contact::show'));
		break;
	case 'POST':
		route('/:lang/contact',			call('Contact::post'));
		route('/shop',					call('Shop::post'));
		break;
}

// Fallback: redirect to homepage.
header('Location: /');
?>
