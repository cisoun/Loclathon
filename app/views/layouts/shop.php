<extend layouts/main>

<block title><?= __('menu.shop') ?></block>

<block preload>
<link rel="preload" href="<?= statics('js/layout.js') ?>" as="script">
<link rel="preload" href="<?= statics('js/fetch.js') ?>" as="script">
<link rel="preload" href="<?= statics('js/shop.js') ?>" as="script">
</block>

<block head>
<script src="<?= statics('js/layout.js') ?>" type="module" defer></script>
<script src="<?= statics('js/fetch.js') ?>" type="module" defer></script>
<? head ?>
</block>

<block css>
<? css ?>
</block>

<block ogd>
<? ogd ?>
</block>

<block content>
<main id="shop" class="content">
<? content ?>
</main>
</block>
