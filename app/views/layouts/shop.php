<extend layouts/main>

<block title><?= __('menu.shop') ?></block>

<block preload>
<link rel="preload" href="/static/js/layout.js" as="script">
<link rel="preload" href="/static/js/fetch.js" as="script">
<link rel="preload" href="/static/js/shop.js" as="script">
</block>

<block head>
<script src="/static/js/layout.js" type="module" defer></script>
<script src="/static/js/fetch.js" type="module" defer></script>
<? head ?>
</block>

<block css>
<? css ?>
</block>

<block ogd>
<? ogd ?>
</block>

<block subnav>
</block>

<block content>
<main id="shop" class="content">
<? content ?>
</main>
</block>
