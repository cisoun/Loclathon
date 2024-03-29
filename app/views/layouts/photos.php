<extend layouts/main>

<block title>Albums <? title ?></block>

<block css>
.photos { text-align: center; }
#photos { max-width: 800px; text-align: center; }
#photos h1 { margin-bottom: 0; }
#grid {
	display: grid;
	grid-gap: 5px;
	grid-template-columns: repeat(auto-fill, minmax(195px, 1fr));
	grid-auto-rows: 1fr;
	margin: 6rem 0;
}
@media screen and (max-width: 400px) {
	#grid {
		grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
	}
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
	background-size: cover;
	border-radius: var(--border-radius);
	overflow: hidden;
	transition: border var(--transition);
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
	background-color: #ffffff99;
	color: var(--background);
}
#grid > div > a > div { font-size: 2rem; }
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
