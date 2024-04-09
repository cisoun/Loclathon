<?php

// STATES:
//   0: NORMAL
//   1: PREORDER
//   2: SOLD OUT
//   3: UNAVAILABLE (hidden)

return [
	[
		'id'          => 1,
		'url'         => 'la-locloise',
		'title'       => 'La Locloise',
		'price'       => 38,
		'state'       => 0,
		'description' => "L'absinthe officielle du Loclathon. Goût mentholé et doux.<br>54% vol. d'alcool.",
		'pictures'    => ['1a.jpg', '1b.jpg', '1c.jpg'],
		'parent_id'   => NULL,
	], [
		'id'          => 2,
		'url'         => 'la-locloise-05l',
		'title'       => '0.5L',
		'price'       => 38,
		'state'       => 0,
		'description' => NULL,
		'pictures'    => [],
		'parent_id'   => 1,
	], [
		'id'          => 3,
		'url'         => 'absinthe-des-anysetiers-07l',
		'title'       => 'Absinthe des Anysetiers 0.7L',
		'price'       => 55,
		'state'       => 2,
		'description' => "L'absinthe de la Commanderie des Anysetiers du canton de Neuchâtel.",
		'pictures'    => ['3a.jpg', '3b.jpg', '3c.jpg'],
		'parent_id'   => NULL,
	], [
		'id'          => 4,
		'url'         => 'hoodie-mathieu',
		'title'       => 'Hoodie Mathieu',
		'price'       => 89,
		'state'       => 2,
		'description' => "<b>Livraison estimée à début mai.</b> <p>
			Pull réalisé en partenariat avec Pzt Tact pour soutenir Mathieu Rubi dans sa participation aux championnats du monde de semi-ironman aux États-unis.
			Tient chaud et se porte agréablement.
			</p>
			<b>Informations</b>
			<ul>
			<li>Unisex</li>
			<li>Lavage à 30 °, ne pas mettre au séchoir</li>
			<li>100% polyester</li>
			</ul>",
		'pictures'    => ['4.png', '4a.jpg', '4b.jpg', '4c.jpg'],
		'parent_id'   => NULL,
	], [
		'id'          => 5,
		'url'         => 'hoodie-mathieu-s',
		'title'       => 'S',
		'price'       => 89,
		'state'       => 1,
		'description' => NULL,
		'pictures'    => [],
		'parent_id'   => 4,
	], [
		'id'          => 6,
		'url'         => 'hoodie-mathieu-m',
		'title'       => 'M',
		'price'       => 89,
		'state'       => 1,
		'description' => NULL,
		'pictures'    => [],
		'parent_id'   => 4,
	], [
		'id'          => 7,
		'url'         => 'hoodie-mathieu-l',
		'title'       => 'L',
		'price'       => 89,
		'state'       => 1,
		'description' => NULL,
		'pictures'    => [],
		'parent_id'   => 4,
	], [
		'id'          => 8,
		'url'         => 'hoodie-mathieu-xl',
		'title'       => 'XL',
		'price'       => 89,
		'state'       => 1,
		'description' => NULL,
		'pictures'    => [],
		'parent_id'   => 4,
	], [
		'id'          => 9,
		'url'         => 'hoodie-mathieu-xxl',
		'title'       => 'XXL',
		'price'       => 89,
		'state'       => 1,
		'description' => NULL,
		'pictures'    => [],
		'parent_id'   => 4,
	], [
		'id'          => 10,
		'url'         => 'trucker-hat-mathieu',
		'title'       => 'Casquette Mathieu',
		'price'       => 39,
		'state'       => 2,
		'description' => "<b>Livraison estimée à début mai.</b><p>Soutenez Mathieu Rubi dans sa participation aux championnats du monde de semi-ironman aux États-unis grâce à cette casquette.</p>",
		'pictures'    => [],
		'parent_id'   => NULL
	]
];

?>
