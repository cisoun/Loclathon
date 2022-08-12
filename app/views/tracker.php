<extend>layouts/main</extend>

<block title>Tracker</block>

<block css>
:root {
	--tracker-active: var(--foreground);
	--tracker-inactive: var(--gray-500);
}

#tracker .info h1,
#tracker .info h3 { margin: 0; }
#tracker .info h1 { font-size: 2rem; line-height: 2rem; }
#tracker .info {
	background-color: var(--foreground);
	border-radius: var(--border-radius);
	color: var(--background);
	margin-bottom: 1rem;
	padding: 1rem;
}
#tracker .info b {
	border-bottom: 1px dashed var(--background);
	display: block;
	margin: -1rem -1rem 1rem -1rem;
	padding: 0.2rem 1rem;
}
#tracker .info a {
	display: block;
	margin-top: 1rem;
}
#tracker #warning {
	background: var(--yellow-500);
}

#container {
	height: 100%;
	max-width: 400px;
	width: 100%;
}
#progress { position: absolute; }
#progress line {
	stroke-dasharray: 3;
	stroke-width: 2px;
}
#progress_done { stroke: var(--tracker-inactive); }
#progress_total { stroke: var(--tracker-active); }
#progress_point {
	fill: var(--red-500);
	stroke: var(--red-200);
	stroke-width: 5px;
}
#progress .progress_step {
	stroke: var(--gray-500);
	stroke-width: 2px;
	transition: stroke 1s;
}
#progress .progress_step[data-active] {
	stroke: var(--tracker-active);
}
.fountain {
	color:  var(--tracker-inactive);
	height: 200px;
	padding: 30px 0 0 45px;
	transition: color 1s;
	width: 100%;
}
.fountain[data-active] {
	color: var(--tracker-active);
}
.fountain[data-active] circle {
	stroke: var(--tracker-active);
}
.fountain h1 {
	font-size: 20pt;
	font-weight: bold;
	line-height: 20pt;
	margin: 0;
}
.fountain h3 {
	font-size: 14pt;
	font-weight: normal;
	line-height: 14pt;
	margin: 0.2em 0 1em 0;
}
.fountain svg {
	height: 30px;
	position: absolute;
	width: 30px;
	margin-left: -50px;
	margin-top: -2px;
}
</block>

<block content>
<main id="tracker" class="dual container spaced padded">
<div>
	<div class="info">
		<b><?= __('tracker.current') ?></b>
		<h1 id="current"></h1>
		<h3 id="current_time"></h3>
		<a id="current_location" target="_blank" class="button"><?= __('tracker.where') ?></a>
	</div>
	<div class="info">
		<b><?= __('tracker.next') ?></b>
		<h1 id="next"></h1>
		<h3 id="next_time"></h3>
		<a id="next_location"target="_blank" class="button"><?= __('tracker.where') ?></a>
	</div>
	<div id="warning" class="info">
		<b><?= __('tracker.warning') ?></b>
		<?= __('tracker.warning_info') ?>
	</div>
</div>
<div id="container">
	<template id="fountain">
		<div class="fountain" data-active>
			<h1></h1>
			<h3></h3>
			<a target="_blank" class="button"><?= __('tracker.where') ?></a>
		</div>
	</template>
	<svg id="progress" viewBox="0 0 30 8000" xmlns="http://www.w3.org/2000/svg">
		<line id="progress_total" x1="15" y1="43" x2="15" y2="1000" />
		<line id="progress_done" x1="15" y1="43" x2="15" y2="1000" />
		<circle id="progress_point" cx="15" cy="0" r="6" />
	</svg>
</div>
</main>
</block>

<block js>
const data = [
	['Gare',                 '47.0578341',         '6.7462355',          '09:15', 33300],
	['Home',                 '47.05462248453078',  '6.739494924641472',  '09:46', 35160],
	['Cimetière',            '47.043184138834725', '6.717839015083018',  '10:28', 37680],
	['Molière',              '47.04726332830242',  '6.729165765470248',  '10:50', 39000],
	['Jeannerets',           '47.049568583111764', '6.737135554495482',  '11:07', 40020],
	['Corbusier',            '47.05066777631999',  '6.7404548017963934', '11:19', 40740],
	['Replattes',            '47.04309466797464',  '6.746021219652528',  '11:52', 42720],
	['Jaluse',               '47.04949637981128',  '6.751595938888112',  '12:15', 44100],
	['Rue du Midi',          '47.053371618638266', '6.745897836116353',  '12:33', 45180],
	['Maison du peuple',     '47.0563005307247',   '6.748982141947738',  '12:52', 46320],
	['Poste',                '47.057189793594446', '6.749406268001719',  '13:04', 47040],
	['Jardin Klaus (PAUSE)', '47.05705674082102',  '6.748540974675322',  '13:35', 48900],
	['Résidence',            '47.05679910021371',  '6.745686933174144',  '14:26', 51960],
	['Rue de la Côte',       '47.05636358116315',  '6.744272571045982',  '14:40', 52800],
	['Malpierres',           '47.0589493322147',   '6.73506003900116',   '15:02', 54120],
	['Monts',                '47.06161285171569',  '6.748128587071385',  '15:26', 55560],
	['Camping',              '47.05191098487866',  '6.760666743492716',  '16:31', 59460],
	['Communal',             '47.0544818092445',   '6.752567372923347',  '16:55', 60900],
	['Daniel-Jeanrichard',   '47.058568499411976', '6.750977230111017',  '17:15', 62100],
	['Croisette',            '47.06043209567127',  '6.754265722655855',  '17:31', 63060],
	['Droguerie',            '47.061121110742846', '6.754949794369141',  '17:49', 64140],
	['Quartier Neuf',        '47.06180619477007',  '6.758306400966289',  '18:06', 65160],
	['Combe-Girard',         '47.05974049391715',  '6.763426650607493',  '18:30', 66600],
	['SPA',                  '47.06914197765109',  '6.774716399201995',  '19:20', 69600],
	['Reçues',               '47.061318121077896', '6.753760367084344',  '20:04', 72240],
	['Crêt-vaillant',        '47.05985389755275',  '6.7510811782963644', '20:28', 73680],
	['Place du 29 Février',  '47.05848240315563',  '6.749403436984183',  '20:47', 74820],
	['Place du Marché',      '47.05769394803361',  '6.7483497010947255', '21:06', 75960],
];

const FOUNTAINS = data.length;
const HEIGHT    = 200;
const STEPS_TOP = 43;

const $ = (id) => document.getElementById(id);

const ui = {
	container:        $('container'),
	current:          $('current'),
	current_location: $('current_location'),
	current_time:     $('current_time'),
	dark:             $('progress_total'),
	done:             $('progress_done'),
	next:             $('next'),
	next_location:    $('next_location'),
	next_time:        $('next_time'),
	point:            $('progress_point'),
	progress:         $('progress'),
	template:         $('fountain'),

	fountains:        [],
	steps:            []
}

function add (fountain) {
	const node = document.importNode(ui.template.content, true);

    node.querySelector('h1').innerHTML = fountain[0];
    node.querySelector('h3').innerHTML = fountain[3];
    node.querySelector('a').href = url(fountain);

    // Steps
	const step = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
	step.classList.add('progress_step');
	step.setAttribute('cx', 15);
	step.setAttribute('cy', ui.fountains.length * HEIGHT + STEPS_TOP);
	step.setAttribute('r', 10);
	step.setAttribute('data-active', '');
	ui.steps.push(step);
	ui.progress.insertBefore(step, ui.point);

    ui.fountains.push(node.firstElementChild);
    ui.container.appendChild(node);
}

function deactivate (id) {
	ui.fountains[id].removeAttribute('data-active');
	ui.steps[id].removeAttribute('data-active');
}

function getCurrentFountainIndex (currentTime) {
	for (let i = 0; i < data.length - 1; i++) {
		const time = data[i + 1][4];
		if (time >= currentTime) {
			return i;
		}
	}
}

function getTime (time) {
	const h = parseInt(time.slice(0, 2));
	const m = parseInt(time.slice(3, 5));
	const s = time.length > 5 ? parseInt(time.slice(6, 8)) : 0;
	return h * 3600 + m * 60 + s;
}

function update () {
	const currentTime = getTime(new Date().toTimeString().slice(0, 8));
	const index = getCurrentFountainIndex(currentTime);

	// Deactivate done fountains.
	for (let i = 0; i < index + 1; i++) {
		deactivate(i);
	}

	const currentFountain = data[index];
	const nextFountain    = data[index + 1];

	const a = nextFountain[4]; 
	const b = currentFountain[4];
	const delta = (currentTime - b) / (a - b);
	const y = STEPS_TOP + (HEIGHT * index) + (HEIGHT * delta);

	ui.done.y2.baseVal.value  = 
	ui.point.cy.baseVal.value = Math.max(y, STEPS_TOP);

	ui.current.innerHTML      = currentFountain[0];
	ui.current_location.href  = url(currentFountain);
	ui.current_time.innerHTML = currentFountain[3];
	ui.next.innerHTML         = nextFountain[0];
	ui.next_location.href     = url(nextFountain);
	ui.next_time.innerHTML    = nextFountain[3];
}

function url (fountain) {
	const longitude = fountain[1];
	const latitude = fountain[2];
	return `https://www.google.com/maps/search/?api=1&query=${longitude}%2C${latitude}`;
}

data.map(f => add(f));

ui.dark.y2.baseVal.value           = HEIGHT * (FOUNTAINS - 1) + STEPS_TOP;
ui.progress.viewBox.baseVal.height = HEIGHT * FOUNTAINS;
ui.progress.style.height           = ui.progress.viewBox.baseVal.height + 'px';

update();

setInterval(() => update(), 1000);

</block>