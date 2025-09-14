<?php
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
?>

<extend layouts/photos>

<block title>{{ year }}</block>

<block css>
h1 { margin-bottom: 0; }
#grid > img { height: 100%; width: 100%; }
</block>

<block header>
<h1><?= $dates[$params['year']]; ?></h1>
</block>

<block grid>
<?php
	$year = $params['year'];
	$root = getcwd() . "/static/photos/$year";
	$files = scandir($root);
	$files = array_filter($files, function ($file) use ($root) {
		return !is_dir($root . "/$file");
	});
	foreach ($files as $file):
?>
<a href="/static/photos/{{ year }}/<?php echo $file; ?>" target="_blank"><img src="/static/photos/{{ year }}/min/<?= $file; ?>"/></a>
<?php endforeach; ?>
</block>
