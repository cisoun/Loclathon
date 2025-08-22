<?php
$bubbles = __('loclathon.bubbles');
$next = __('loclathon.next');
$highlights = __('loclathon.highlights');
?>

<extend layouts/main>

<block title>La tournée des fontaines</block>

<block preload>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
</block>

<block css>
.bigger { font-size: 1.2rem; }
#tour_warning { font-weight: bold; }
#subscribe {
	color: white;
	display: block;
}
.modal {
	display: none;
	text-align: center;
}
.modal div {
	display: flex;
	gap: 1rem;
	justify-content: space-between;
}
.modal div a { width: 100%; }
@media only screen and (max-width: 992px) {
	.modal div {
		flex-wrap: wrap;
	}
}
:root {
	--highlights-gap: 0.5rem;
}
@media only screen and (max-width: 992px) {
	#highlights { margin-top: -6vw; }
	#highlights > div { flex-direction: column; }
	#highlights span { font-size: 1.6rem; padding: 1rem 2rem; }
	#highlights div:last-child span { font-size: 3rem; line-height: 3rem; }
}
</block>

<block js>
const now = new Date().toISOString();
if (now > '2023-08-19T09:00' && now < '2023-08-19T21:00') {
	const modal = document.getElementById('modal');
	modal.style.display = 'unset';
	modal.querySelector('[data-dismiss]').addEventListener('click', e => {
		modal.style.display = 'none';
	});
}
</block>

<block content>
<div id="modal" class="modal">
	<h1><?= __('loclathon.modal.title') ?></h1>
	<div>
		<a href="/{{lang}}/tracker" class="button"><?= __('loclathon.modal.see') ?></a>
		<a href="#" class="button white" data-dismiss><?= __('loclathon.modal.hide') ?></a>
	</div>
</div>
<section class="flex">
	<div id="loclathon" class="card">
		<img id="logo" class="container" src="/static/img/home_2025.svg" alt="Le Loclathon"/>
		<div id="highlights">
			<div><span><?= $highlights[0] ?></span><span><?= $highlights[1] ?></span><span><?= $highlights[2] ?></span></div>
			<div><span><?= $highlights[3] ?></span></div>
		</div>
	</div>
</section>
<section id="about" class="flex">
	<!-- Next tour -->
	<div class="card">
		<h1><?= __('loclathon.next.title') ?></h1>
		<p class="bigger">
			<?= $next[0] ?><br>
			<?= $next[1] ?>
		</p>
		<h1><?= __('loclathon.about.title') ?></h1>
		<?php foreach (__('loclathon.about') as $line): ?>
		<p><?= $line ?></p>
		<?php endforeach; ?>
	</div>
	<!-- FAQ -->
	<div class="card">
		<h1>F.A.Q</h1>
		<div id="faq">
			<div class="left"><span class="bubble"><?= $bubbles[0] ?></span></div>
			<div class="right"><span class="bubble"><?= $bubbles[1] ?></span><span class="logo"></span></div>
			<div class="left"><span class="bubble"><?= $bubbles[2] ?></span></div>
			<div class="right"><span class="bubble"><?= $bubbles[3] ?></span><span class="logo"></span></div>
			<div class="left"><span class="bubble"><?= $bubbles[4] ?></span></div>
			<div class="right"><span class="bubble"><?= $bubbles[5] ?></span><span class="logo"></span></div>
			<div class="left"><span class="bubble"><?= $bubbles[6] ?></span></div>
			<div class="right"><span class="bubble"><?= $bubbles[7] ?></span><span class="logo"></span></div>
			<div class="left"><span class="bubble"><?= $bubbles[8] ?></span></div>
			<div class="right"><span class="bubble"><?= $bubbles[9] ?></span><span class="logo"></span></div>
		</div>
	</div>
</section>
</block>
