<?php
// Month translations.
$months = __('months');
$august = $months['august'];
$september = $months['september'];

$dates = [
	'2025' => "23 $august 2025",
	'2024' => "24 $august 2024",
	'2023' => "19 $august 2023",
	'2022' => "20 $august 2022",
	'2021' => "21 $august 2021",
	'2020' => "5 $september 2020",
	'2019' => "24 $august 2019"
];

// Fetch JPEG files from folder of provided year.
$year = $params['year'];
$root = getcwd() . statics("photos/$year");
$files = scandir($root);
$files = array_filter($files, function ($file) use ($root) {
	return str_ends_with($file, '.jpg');
});
?>

<extend layouts/photos>

<block title>{{ year }}</block>

<block css>
#grid > img {
	aspect-ratio: 1;
	width: 100%;
}
</block>

<block header>
<h1><?= $dates[$params['year']]; ?></h1>
</block>

<block grid>
<?php foreach ($files as $file): ?>
<img src="<?= statics("photos/$year/min/$file") ?>" data-ds-target="<?= statics("photos/$year/$file") ?>"/>
<?php endforeach; ?>
</block>
