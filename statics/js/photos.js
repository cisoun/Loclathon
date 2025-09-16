(()=>{var i=class extends HTMLElement{constructor(t,{theme:e="auto"}){super(),this.setAttribute("theme",e),this.attachShadow({mode:"open"}),this.shadowRoot.innerHTML=`
			<style type="text/css">
				:host {
					--bg: #fffe;
					--fg: #000e;
					--gap: 3vw;
					background-color: light-dark(var(--bg), var(--fg));
					color: light-dark(var(--fg), var(--bg));
					display: flex;
					flex-direction: column;
					height: 100vh;
					left: 0;
					opacity: 0;
					padding: var(--gap) var(--gap) 0 var(--gap);
					position: fixed;
					top: 0;
					transition: opacity 0.2s;
					visibility: hidden;
					width: 100vw;
					z-index: 1;
				}
				:host([theme="auto"]) { color-scheme: light dark; }
				:host([theme="dark"]) { color-scheme: dark; }
				:host([theme="light"]) { color-scheme: light; }
				:host(.active) {
					opacity: 1;
					visibility: visible;
				}
				:host img {
					cursor: zoom-out;
					flex-grow: 1;
					height: 100%;
					overflow: auto;
					object-fit: contain;
				}
				:host div {
					display: flex;
					flex-direction: row;
					height: 5rem;
					justify-content: center;
				}
				:host div a {
					cursor: pointer;
					height: 5rem;
					text-align: center;
					width: 5rem;
				}
				:host div svg {
					fill: none;
					height: 5rem;
					stroke-linecap: round;
					stroke-width: 0.4;
					stroke: currentColor;
					width: 2rem;
				}
			</style>
			<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
				<symbol id="close" viewBox="0 0 10 10">
					<path d="m2.5 2.5 5 5" />
					<path d="m2.5 7.5 5 -5" />
				</symbol>
				<symbol id="next" viewBox="0 0 10 10">
					<path d="m2 5 6 0" />
					<path d="m6 3 2 2 -2 2" />
				</symbol>
				<symbol id="previous" viewBox="0 0 10 10">
					<path d="m2 5 6 0" />
					<path d="m4 3 -2 2 2 2" />
				</symbol>
			</svg>
			<img />
			<div>
				<a><svg><use href="#previous"/></svg></a>
				<a><svg><use href="#close"/></svg></a>
				<a><svg><use href="#next"/></svg></a>
			</div>
		`,this.index=0,this.image=this.shadowRoot.querySelector("img"),this.source=t,this.touchX=0}connectedCallback(){document.addEventListener("keydown",this.handleKeydown.bind(this)),Array.from(this.source.querySelectorAll("img")).map(e=>{e.onclick=this.toggle.bind(this)}),this.onclick=this.toggle.bind(this),this.ontouchstart=e=>{e.changedTouches.length>1||(this.touchX=e.changedTouches[0].clientX)},this.ontouchend=e=>{e.changedTouches.length>1||(e.changedTouches[0].clientX-this.touchX>50?this.previous():e.changedTouches[0].clientX-this.touchX<-50&&this.next())};let t=this.shadowRoot.querySelectorAll("a");t[0].onclick=e=>{e.stopPropagation(),this.previous()},t[1].onclick=e=>{e.stopPropagation(),this.toggle()},t[2].onclick=e=>{e.stopPropagation(),this.next()}}disconnectedCallback(){document.removeEventListener("keydown",this.handleKeydown.bind(this))}handleKeydown(t){switch(t.keyCode){case 37:this.previous();break;case 39:this.next();break;case 27:this.toggle();break;default:break}}next(){this.show(this.current.nextElementSibling??this.source.firstElementChild)}previous(){this.show(this.current.previousElementSibling??this.source.lastElementChild)}show(t){this.current=t,this.image.src=t.dataset.dsTarget??t.src}toggle(t){t&&this.show(t.srcElement),this.classList.toggle("active")}};function o(s,t={}){let e=new i(s,t);return document.body.appendChild(e),e}customElements.define("x-darkslide",i);var h=document.createElement("style");document.head.appendChild(h);h.sheet.insertRule("body:has(x-darkslide.active) { overflow: hidden; }");o(document.querySelector("#grid"),{theme:"dark"});})();
