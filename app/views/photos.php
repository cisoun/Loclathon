<?php
$date = [
	'2022' => '20 août 2022',
	'2021' => '21 août 2021',
	'2020' => '5 septembre 2020',
	'2019' => '24 août 2019'
];
?>

<extend layouts/photos>

<block title>{{ year }}</block>

<block css>
#grid > a > img { height: 100%; width: 100%; }
</block>

<block header>
<h1>{{ year }}</h1>
Tournée du <?php echo $date[$params['year']]; ?>.
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
<a href="/static/photos/{{ year }}/<?php echo $file; ?>" target="_blank"><img src="/static/photos/{{ year }}/min/<?php echo $file; ?>"/></a>
<?php endforeach; ?>
</block>
