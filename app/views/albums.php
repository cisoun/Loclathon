<?php
$albums = [
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
	<div style="background-image: url('/static/photos/<?php echo $year ?>/min/<?php echo $file ?>.jpg')">
	<a href="/{{lang}}/photos/<?php echo $year ?>"><div><?php echo $year ?></div></a>
	</div>
<?php endforeach; ?>
</block>
