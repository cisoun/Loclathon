<?php
require_once('app/app.php');

# Serve static ressources.
if (extension('png|jpg|webp|ttf|css|js|svg|pdf|ico')) {
	return false;
}

switch (method()) {
	case 'GET':
		route('/',						redirect('/' . Lang::user()));
		route('/locloise',              redirect('/' . Lang::user() . '/locloise'));
		route('/:lang',					with_lang(view_cached('loclathon')));
		route('/:lang/locloise',		with_lang(view_cached('locloise')));
		route('/:lang/photos',			with_lang(view_cached('albums')));
		route('/:lang/photos/:year',	with_lang(view_cached('photos')));
		route('/:lang/shop',			with_lang(call('Shop::show')));
		route('/:lang/shop/pay',        with_lang(call('Shop::pay')));
		route('/:lang/shop/confirm',    with_lang(call('Shop::confirm')));
		route('/:lang/contact',			with_lang(call('Contact::show')));
		break;
	case 'POST':
		route('/:lang/contact',			with_lang(call('Contact::post')));
		route('/:lang/shop',			with_trim(with_lang(call('Shop::checkout'))));
		break;
}

// Fallback: redirect to homepage.
header('Location: /');
?>
