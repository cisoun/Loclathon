<?php
require_once('app/router.php');

# Serve static ressources.
if (extension('png|jpg|jpeg|gif|css|js|svg|pdf')) {
  return false;
}

switch (method()) {
  case 'GET':
    route('/', redirect('/fr'));
    route('/:lang', cached_view('loclathon'));
    route('/:lang/locloise', cached_view('locloise'));
    route('/:lang/contact', cached_view('contact'));
    route('/:lang/photos', cached_view('albums'));
    route('/:lang/photos/:year', cached_view('photos'));
    route('/:lang/shop', view('shop/shop'));
    break;
  case 'POST':
    route('/contact', cached_view('contact'));
    break;
}

header('Location: /');
?>
