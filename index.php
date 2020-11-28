<?php
require_once('app/router.php');

# Serve static ressources.
if (extension('png|jpg|jpeg|gif|css|js|svg|pdf')) {
  return false;
}

switch (method()) {
  case 'GET':
    route('/', cached_view('loclathon'));
    route('/locloise', cached_view('locloise'));
    route('/contact', cached_view('contact'));
    route('/photos', cached_view('albums'));
    route('/photos/:year', cached_view('photos'));
    route('/shop', cached_view('shop/shop'));
    break;
  case 'POST':
    route('/contact', cached_view('contact'));
    break;
}

header('Location: /');
?>
