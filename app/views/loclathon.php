<?php
$bubbles = __('loclathon.bubbles');
$next = __('loclathon.next');
$highlights = __('loclathon.highlights');
?>

<extend layouts/main>

<block title>La tournée des fontaines</block>

<block preload>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
</block>

<block css>
#loclathon > div > img { width: 100%; }
.bigger { font-size: 1.2rem; }
#tour_warning { font-weight: bold; }
@keyframes clouds {
  from {transform: translateX(0px);}
  to {transform: translateX(10px);}
}
@keyframes sun {
  from {transform: translateY(0px);}
  to {transform: translateY(3px);}
}
#cloud1 { animation: clouds 10s infinite; }
#cloud2 { animation: clouds 14s infinite; }
#sun, #sun_halo { animation: sun 12s infinite; }
#sun, #sun_halo, #cloud1, #cloud2 {
	animation-direction: alternate;
	animation-timing-function: ease-in-out;
}
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
#highlights {
	display: flex;
	flex-direction: column;
	gap: var(--highlights-gap);
	margin: auto;
	margin-bottom: 6rem;
	margin-top: -6rem;
	max-width: 880px;
	transform: skewY(-3deg);
	width: 100%;
}
#highlights > div {
	display: flex;
	gap: var(--highlights-gap);
}
#highlights span {
	background-color: black;
	color: white;
	flex-grow: 1;
	font-family: 'Bebas Neue', impact, sans-serif;
	font-size: 2.4rem;
	padding: 1rem 0;
}
@media only screen and (max-width: 992px) {
	#highlights { margin-top: -5vw; }
	#highlights > div { flex-direction: column; padding: 0 2rem; }
	#highlights span { font-size: 1.6rem; padding: 1rem 2rem; }
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

<block ogd>
<meta property="og:description" content="Site officiel du Loclathon et de l'absinthe La Locloise.">
<meta property="og:image" content="/static/img/preview.jpg">
<meta property="og:title" content="Le Loclathon | La Locloise">
</block>

<block content>
<div id="modal" class="modal">
	<h1><?= __('loclathon.modal.title') ?></h1>
	<div>
		<a href="/{{lang}}/tracker" class="button"><?= __('loclathon.modal.see') ?></a>
		<a href="#" class="button white" data-dismiss><?= __('loclathon.modal.hide') ?></a>
	</div>	
</div>
<main id="loclathon">
	<div class="fade"></div>

	<img id="logo" class="container" src="/static/img/home.svg" alt="Le Loclathon" width="100%" height="100%"/>
	<div id="highlights">
		<div><span><?= $highlights[0] ?></span><span><?= $highlights[1] ?></span><span><?= $highlights[2] ?></span></div>
		<div><span><?= $highlights[3] ?></span><span><?= $highlights[4] ?></span></div>
	</div>
	<a id="learn_more" href="#about" class="button big"><?= __('loclathon.learn_more') ?> <svg class="outline"><use xlink:href="static/img/icons.svg#circle-plus"/></svg></a>

	<div id="bottom">
		<svg version="1.1" viewBox="0 0 158.75 26.458" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
			<defs>
				<linearGradient id="gradient" x1="158.75" x2="158.75" y1="26.458" y2="14.784" gradientUnits="userSpaceOnUse">
					<stop stop-color="#fff" offset="0"/>
					<stop stop-color="#fff" stop-opacity="0" offset="1"/>
				</linearGradient>
			</defs>
			<rect id="sky" width="158.75" height="26.458" fill="url(#gradient)"/>
			<path id="mountain_light" d="m159.28 26.458-159.81 0.52917v-6.0098c57.631-22.498 70.911 17.649 159.81-0.52917z" fill="#fff"/>
			<circle id="sun_halo" cx="112.45" cy="21.828" r="11.15" fill="#fff6"/>
			<circle id="sun" cx="112.45" cy="21.828" r="7.7485" fill="#fff"/>
			<path id="gilbert" d="m34.245 9.8556-0.401 0.10025-0.13332 0.73482-0.50125-0.10025-0.23099 0.20774-0.3266 0.06718-0.54932 0.23151-0.11782 0.0925 0.22996 0.08061 0.14366-0.08888 0.03979 0.06873 0.10077-0.17415 0.33744-0.0052-0.12816 0.58911 0.23409 0.10025 0.10025 0.73482-0.13384 0.66817-0.36742 0.13384-0.2005-0.06718-0.30075 0.50125 0.13384 0.16691 0.2005-0.2005 0.80149-0.33382 0.30075-0.56792 0.30075 0.26717 0.401 0.70174 0.16691 0.36742 0.78443-0.17725-0.19431-0.24133-0.35192 0.04289-0.27181-0.42633-0.30075-0.80149-0.16691-0.70175 0.13074-0.50435 0.32866 0.41237 0.36742 0.1757 0.04186 0.06666-0.08372 0.15864 0.02532 0.05839 0.10852-0.10025 0.15038 0.13384 0.20877-0.0083-0.10852-0.06718-0.11679-0.27543-0.52657-0.45939-0.19172-0.55964 0.26717-0.23357 0.10025-0.33435-0.30075-0.43407z" fill="#111" stroke="#fff" stroke-linecap="square" stroke-linejoin="round" stroke-width=".5" style="paint-order:markers stroke fill"/>
			<path id="robert" d="m38.806 10.167-0.12557 0.19947-0.02119 0.37724 0.04186 0.0832-0.13591-0.01964-0.54363 0.14211-0.25941 0.96842 0.32969 0.1664 0.01603 0.47852 0.51572 0.46198 0.01188 0.05064-0.57309 0.03824-0.30851-0.07751-0.06304 0.18085 0.10645 0.49609 0.16536 0.04702 0.08268-0.33072 0.9803 0.09457 0.0041-0.0708 0.41444 0.68264 0.47489-0.23771 0.03928-0.14521-0.3824-0.05271-0.39584-0.65939-0.1173-0.14211 0.02169-0.36689-0.07028-0.29403 0.42788-0.29559 0.25684 0.01088 0.01138-0.38965-0.1018-0.12121-0.35553-0.43895 0.04392-0.0894-0.04031-0.0057 0.14676-0.36327-0.05219-0.35657-0.54519-0.02119zm0.38343 0.96529 0.27077 0.45682-0.03307 0.03307-0.47233-0.01188 0.23461-0.47799zm0.02119 0.83197-0.22841 0.13901-0.02739-0.11472z" fill="#111" stroke="#fff" stroke-linecap="square" stroke-linejoin="round" stroke-width=".5" style="paint-order:markers stroke fill"/>
			<path id="claire" d="m61.296 15.483-0.14056 0.12557-0.11162 0.23099-0.06253 0.32607-0.27905 0.4005-0.01035 0.14572-0.2191 0.37205 0.09508 0.27596 0.12506 0.13591-0.15864 0.34417 0.0801 0.20567 0.66145 0.21446 0.33848-0.1943-0.0062 0.25631 0.47646 0.12144-0.02119-0.14107-0.01394-0.0088 0.14521-0.53588 0.10387-0.05684 0.08062 0.56689-0.11266 0.23306 0.76842 0.2098-0.06098-0.22479-0.36845-0.21704-0.0078-0.94669-0.23409-0.1018-0.01654-0.02429 0.26511-0.97926 0.72707 0.05943-0.63407-0.40306 0.0072-0.02584-0.04909-0.0088-0.3607 1.294-0.06976-0.1018-0.4811-0.64854 0.29713-0.06563-0.21394-0.17983-0.0584-0.24081 0.01035-0.26614-0.16484-0.14314-0.32607-0.0036zm0.42322 1.3901 0.39634 0.41703-0.30078 0.08161-0.06149-0.07906-0.23564 0.0047 0.01344-0.09818 0.20154-0.10542-0.01344-0.22066zm0.3974 0.92759-0.12661 0.45423-0.1142-0.07441-0.0217-0.23616z" fill="#111" stroke="#fff" stroke-linecap="square" stroke-linejoin="round" stroke-width=".5" style="paint-order:markers stroke fill"/>
			<path id="mountain" d="m159.28 26.987h-159.81v-6.539c59.733-21.326 69.286 19.528 159.81 0z" fill="#111"/>
			<path id="fountain" d="m110.66 19.475v0.63769h0.36586v0.49609h0.42529v0.81493h-0.24805v0.37774h-1.1338v0.21601c-0.78501 0.34596-0.97443 1.1711-1.0346 1.5007h-1.7498l0.64647 2.9397h8.8346l0.64698-2.9397h-1.7508c-0.0601-0.32961-0.24953-1.1547-1.0346-1.5007v-0.21601h-1.1338v-0.37774h-0.24804l5e-4 -0.81493h0.42528v-0.49609h0.3664v-0.63769h-3.3782zm-0.59065 2.7398h1.1338v0.40153h0.24804v0.90174h-1.9244c0-0.52005 0.32692-1.3033 0.54257-1.3033zm5.1008 1.3033h-1.9239l-5e-4 -0.90174h0.24804v-0.40153h1.1338c0.22357 0 0.54258 0.75836 0.54258 1.3033z" fill="#111"/>
			<path id="cloud1" d="m95.181 17.729c-0.19348 0.02254-0.35429 0.14068-0.51495 0.24057-0.5087-0.02918-1.0223-0.22057-1.5293-0.07434-0.21926 0.05029-0.42637 0.15575-0.59419 0.3058-0.04968 0.18672-0.34363 0.23627-0.44473 0.06762-0.38332-0.2585-0.91051-0.2886-1.3199-0.07412-0.2094 0.13576-0.35564 0.40831-0.26268 0.65539 0.09485 0.17126 0.31327 0.23064 0.38848 0.41773 0.24635 0.44166 0.96845 0.46684 1.2478 0.04795 0.03979-0.13381 0.11804-0.3974 0.30862-0.29915 0.17131 0.06534 0.23332 0.2968 0.08308 0.41846-0.09706 0.16552-0.07867 0.40912 0.09476 0.5172 0.16699 0.15765 0.41518 0.22053 0.63798 0.16699 0.25403 0.01147 0.45575 0.27494 0.72041 0.19636 0.5844-0.19459 1.2324-0.08605 1.801-0.342 0.19742-0.07437 0.40064 0.01013 0.59037 0.06372 0.18147 0.02523 0.31274-0.12503 0.45383-0.20936 0.18738-0.0719 0.30578 0.14959 0.47456 0.18248 0.36109 0.10072 0.73707-0.13897 0.90644-0.45165 0.1425-0.15335 0.38147-0.10296 0.55006-0.02471 0.36883 0.11071 0.77998-0.29743 0.64238-0.66579-0.1068-0.23004-0.43425-0.31522-0.63979-0.16645-0.1839 0.07224-0.35448-0.0658-0.52665-0.10923-0.20502-0.11458-0.30659-0.39991-0.56566-0.41482-0.286-0.01939-0.5698-0.22183-0.85565-0.09363-0.17658 0.07303-0.30176 0.22476-0.41222 0.37451-0.14004 0.10631-0.38482 0.01677-0.40962-0.16125-0.12448-0.33086-0.46043-0.59707-0.82444-0.56826zm-6.4317 0.97138c-0.30672 0.0116-0.44815 0.48133-0.18726 0.65149 0.31981 0.26658 0.82363 0.3285 1.1703 0.07803 0.09292-0.36424-0.25648-0.7052-0.60801-0.7154-0.12405-0.01853-0.25001-0.01845-0.37508-0.01411z" fill="#fff"/>
			<path id="cloud2" d="m125.84 15.618c-0.28625 0.0625-0.43032 0.31232-0.33636 0.50663-0.58176 0.08411-0.91261-0.45975-1.4823-0.38442-0.33182 0.06695-0.41932 0.33001-0.53846 0.5198-0.12781 0.07042-0.16546 0.31336-0.28796 0.29304-0.34298-0.19881-0.98358-0.10429-1.0912 0.22062-0.26978 0.01723-0.6278-0.04647-0.80849 0.13628-0.12344-0.0624-0.13375-0.212-0.31183-0.24694-0.33964-0.14924-0.89414 0.04096-0.79669 0.34839 0.0648 0.29223 0.38345 0.51615 0.61998 0.74559 0.30671 0.17252 0.72977 0.04812 0.98136-0.12048 0.27232-0.12925 0.7161-0.11533 0.84645 0.12849 0.2175 0.22616 0.68323 0.28457 1.0022 0.13645 0.25425-0.05515 0.53136 0.10364 0.45692 0.29239 0.0561 0.37198 0.76647 0.5447 1.1636 0.31241 0.31511-0.11007 0.65424 0.01775 0.98403 0.0024 0.29179 0.03151 0.4839 0.27107 0.81193 0.20595 0.3912-0.03169 0.27523-0.47129 0.68137-0.4773 0.71212 0.10237 1.3674-0.2325 1.9066-0.51947 0.20923-0.11696 0.41009-0.41169 0.71482-0.26 0.25492 0.11315 0.57959 0.29161 0.88179 0.14131 0.30836-0.10846 0.64862-0.02691 0.93867 0.05941 0.42484 0.03267 0.71662-0.30383 0.59217-0.57348-0.0681-0.34438-0.66512-0.6451-1.116-0.42223-0.16578 0.06209-0.39148 0.17594-0.57084 0.07411 0.0154-0.28098-0.38449-0.6244-0.80417-0.46813-0.21342 0.0817-0.24228 0.29637-0.47816 0.3569-0.29232-0.19531-0.69819-0.39488-1.1146-0.2744-0.14105 0.02961 0.0403-0.12305-0.0164-0.16928 0.0124-0.30207-0.50173-0.62022-0.88803-0.3948-0.17945 0.10145-0.40706 0.32183-0.65976 0.18823-0.2542-0.06337-0.55613 0.0157-0.70301 0.17295-0.0341-0.22742-0.1772-0.54426-0.5776-0.53047z" fill="#fff"/>
		</svg>
	</div>
</main>
<section id="about" class="dual padded spaced">
	<div>
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
	<div>
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
		</div>
	</div>
</section>
</block>
