import { Darkslide } from 'darkslide';

document.addEventListener('DOMContentLoaded', (e) => {
	document.querySelectorAll('[data-darkslide]').forEach((element) => {
		// Replace link of photos by their own picture if JavaScript is enabled so
		// Darkslide can takeover.
		element.querySelectorAll('a').forEach((link) => {
			link.outerHTML = link.innerHTML;
		});
		Darkslide(element);
	});
});