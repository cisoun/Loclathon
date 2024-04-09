<extend layouts/shop>

<block css>
#shop { text-align: center; }
</block>

<block content>
<h1><?= __('shop.confirm.title') ?></h1>
<p><?= __('shop.confirm.message') ?>
<?php if ($params['payment'] == 'direct'): ?>
<br><?= __('shop.confirm.direct') ?></p>
<?php endif; ?>
</p>
</block>
