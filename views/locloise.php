<?php
$description = __('locloise.description');
$details = __('locloise.details');
?>
<extend>layouts/main</extend>
<block title>La Locloise</block>
<block css>
#details h2 {
  margin: 3rem 0 2rem 0;
  text-decoration: smallcaps;
}
</block>
<block content>
<main id="locloise" class="dual dark">
  <div>
    <picture>
      <source srcset="/static/img/locloise.webp" type="image/webp">
      <source srcset="/static/img/locloise.jpg" type="image/jpeg">
      <img src="/static/img/locloise.jpg" alt="La Locloise">
    </picture>
  </div>
  <div id="description" class="padded">
    <h1>La Locloise</h1>
    <div id="status"><span id="price">38</span> CHF</div>
    <p><?= $description[0] ?></p>
    <p><?= $description[1] ?></p>
    <p><?= $description[2] ?></p>
    <p>
      <ul class="breadcrumb">
        <li><?= $details[0] ?></li>
        <li><?= $details[1] ?></li>
        <li><?= $details[2] ?></li>
      </ul>
    </p>
    <a id="buy" class="button big responsive white" href="/{{lang}}/shop">
      <svg class="outline dark"><use xlink:href="/static/img/icons.svg#cart"/></svg>
      <?= __('locloise.buy') ?>
    </a>
  </div>
</main>
</block>
