<?php
define('ARTICLES', require_once('_store.php'));

class Articles {
	public static function all() {
		return ARTICLES;
	}

	public static function find($id) {
		foreach (ARTICLES as $key => $article) {
			if ($article['id'] == $id) {
				return $article;
			}
		}
	}

	public static function findByURL($url) {
		$id = array_search($url, array_column(ARTICLES, 'url'));
		if ($id !== false) {
			return ARTICLES[$id];
		}
	}

	public static function hasParent(&$article) {
		return isset($article['parent_id']);
	}

	public static function parent(&$article) {
		return self::find($article['parent_id']);
	}

	public static function pictures(&$article) {
		$pictures = $article['pictures'];
		if (count($pictures) > 0) {
			return $pictures;
		}
		// Get picture from parent instead, if possible.
		if (self::hasParent($article)) {
			$parent = self::parent($article);
			if ($parent) {
				return self::pictures($parent);
			}
		}
	}

	public static function preview(&$article) {
		$pictures = $article['pictures'];
		if (count($pictures) > 0) {
			return Statics::image('shop/small/' . $pictures[0]);
		}
		// Get picture from parent instead, if possible.
		if (self::hasParent($article)) {
			$parent = self::parent($article);
			if ($parent) {
				return self::preview($parent);
			}
		}
	}

	public static function variants(&$article) {
		$id = $article['id'];
		return array_filter(ARTICLES, function ($a) use ($id) {
			return $a['parent_id'] == $id;
		});
	}
}
?>
