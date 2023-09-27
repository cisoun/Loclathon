<?php
define('ARTICLES', require_once('_store.php'));

class Articles {
	private static array $STORE = [];

	public static function all() {
		return ARTICLES;
	}

	public static function get($articles, $id) {
		$article = Articles::find($articles, $id);
		$parent_id = $article['parent_id'];
		if ($parent_id) {
			$parent = Articles::find($articles, $parent_id);
			$article['variant'] = $article['title'];
			$article['title']   = $parent['title'];
			$article['preview']  = self::preview($parent);
			$article['pictures'] = self::pictures($article);
			$article['description'] = $article['description'] ?? $parent['description'];
		} else {
			$article['variant'] = NULL;
			$article['preview']  = self::preview($article);
			$article['pictures'] = self::pictures($article);
		}
		return $article;
	}

	public static function find($articles, $id) {
		foreach ($articles as $key => $article) {
			if ($article['id'] == $id) {
				return $article;
			}
		}
	}

	public static function findByURL($articles, $url) {
		$id = array_search($url, array_column($articles, 'url'));
		if ($id !== false) {
			return $articles[$id];
		}
	}

	public static function parent($articles, $article) {
		return self::find($articles, $article['parent_id']);
	}

	public static function preview($article) {
		$parent_id = $article['parent_id'];
		if ($parent_id) {
			return Statics::images('shop/small/' . $parent_id . '.png');
		}
		return Statics::images('shop/small/' . $article['id'] . '.png');
	}

	public static function pictures($article) {
		$pictures = $article['pictures'];
		return array_map(function ($p) {
			return $p;
		}, $pictures);
	}

	public static function variants($articles, $article) {
		$id = $article['id'];
		return array_filter($articles, function ($a) use ($id) {
			return $a['parent_id'] == $id;
		});
	}
}
?>
