<?php
return function ($params) {
	$lang = $params['lang'];
	if (in_array($lang, env('locales'))) {
		Lang::load($lang);
		return true;
	}
	return redirect('/' . env('locale'))($params);
}
?>
