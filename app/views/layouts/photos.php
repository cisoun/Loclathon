<extend layouts/main>

<block title>Albums <? title ?></block>

<block css>
.photos { text-align: center; }
#photos { max-width: 800px; text-align: center; }
#grid {
	display: grid;
	grid-gap: 5px;
	grid-auto-rows: 1fr;
}

#grid::before {
	content: '';
	width: 0;
	padding-bottom: 100%;
	grid-row: 1 / 1;
	grid-column: 1 / 1;
}
#grid > *:first-child {
	grid-row: 1 / 1;
	grid-column: 1 / 1;
}
#grid > div {
	background-repeat: no-repeat;
	background-size:   cover;
	border-radius:     var(--border-radius);
	overflow:          hidden;
	transition:        border var(--transition);
}
#grid > div > a {
	align-items: center;
	background-color: rgba(0, 0, 0, 0.7);
	display: flex;
	height: 100%;
	justify-content: center;
	transition: all var(--transition);
	width: 100%;
}
#grid > div:hover > a {
	background-color: var(--foreground);
	color: var(--background);
	opacity: 0.7
}
#grid > div > a > div { font-size: 2rem; }

#grid img,
#grid a {
	border-radius: var(--border-radius);
}
@media screen and (min-width: 996px) {
	#grid {
		grid-template-columns: repeat(auto-fill, minmax(195px, 1fr));
	}
}
@media screen and (min-width: 400px) and (max-width: 996px) {
	#grid {
		grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
	}
}
@media screen and (max-width: 400px) {
	#grid {
		grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
	}
}
<? css ?>
</block>

<block content>
<main id="photos" class="container">
	<? header ?>
	<div id="grid">
	<? grid ?>
	</div>
</main>
</block>
