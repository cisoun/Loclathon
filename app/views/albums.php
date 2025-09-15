<?php
$albums = [
	'2024' => '_DSC7706',
	'2023' => '_DSC6733',
	'2022' => '_DSC5557',
	'2021' => '_DSC5036',
	'2020' => '_DSC4825',
	'2019' => '_DSC4627'
];
?>

<extend layouts/photos>

<block title>Photos</block>

<block css>
#photos #grid div a span { background-color: rgba(0, 0, 0, 0.8); }
</block>

<block header>
<h1>Albums</h1>
</block>

<block grid>
<?php foreach ($albums as $year => $file): ?>
	<div style="background-image: url('/static/photos/<?= $year ?>/min/<?= $file ?>.jpg')">
	<a href="/{{lang}}/photos/<?= $year ?>"><div><?= $year ?></div></a>
	</div>
<?php endforeach; ?>
</block>
