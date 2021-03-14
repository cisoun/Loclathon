<extend>layouts/main</extend>

<block title><?= __('menu.shop') ?></block>

<block preload>
<link rel="preload" href="/static/js/layout.js" as="script">
<link rel="preload" href="/static/js/fetch.js" as="script">
<link rel="preload" href="/static/js/shop.js" as="script">
</block>

<block footer>
<script src="/static/js/layout.js" type="module" defer></script>
<script src="/static/js/fetch.js" type="module" defer></script>
<script src="/static/js/shop.js" type="module" defer></script>
</block>

<block css><? css ?></block>

<block content>
<main id="shop" class="container padded dark">
  <? content ?>
</main>
</block>
