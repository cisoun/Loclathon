<?php
require_once('app/app.php');

# Serve static ressources.
if (extension('png|jpg|webp|ttf|css|js|svg|pdf|ico')) {
	return false;
}

switch (method()) {
	case 'GET':
		route('/',                        redirect('/' . Lang::user() . '/loclathon'));
		route('/locloise',                redirect('/' . Lang::user() . '/locloise'));
		route('/shop',                    redirect('/' . Lang::user() . '/shop'));
		route('/tracker',                 redirect('/' . Lang::user() . '/tracker'));
		route('/:lang/loclathon',         with_lang(view_cached('loclathon')));
		route('/:lang/locloise',          with_lang(view_cached('locloise')));
		route('/:lang/photos',            with_lang(view_cached('photos/albums')));
		route('/:lang/photos/:year',      with_lang(view_cached('photos/photos')));
		route('/:lang/shop',              with_lang(call('Shop::index')));
		route('/:lang/shop/cart',         with_lang(call('Shop::cart_show')));
		route('/:lang/shop/checkout',     with_lang(call('Shop::checkout')));
		route('/:lang/shop/product/:url', with_lang(call('Shop::show')));
		route('/:lang/shop/review',       with_lang(call('Shop::review')));
		route('/:lang/shop/confirm',      with_lang(call('Shop::confirm')));
		route('/:lang/contact',           with_lang(call('Contact::show')));
		route('/:lang/tracker',           with_lang(view('tracker')));
		break;
	case 'POST':
		route('/:lang/contact',           with_lang(call('Contact::post')));
		route('/:lang/shop',              with_trim(with_lang(call('Shop::checkout'))));
		route('/:lang/shop/cart/add/:id', call('Shop::cart_add'));
		route('/:lang/shop/cart',         with_lang(call('Shop::cart')));
		route('/:lang/shop/checkout',     with_lang(call('Shop::checkout')));
		route('/:lang/shop/pay',          with_lang(call('Shop::pay')));
		break;
}

// Fallback: redirect to homepage.
header('Location: /');
?>
