<?php
$bubbles = __('loclathon.bubbles');
?>
<extend>layouts/main</extend>
<block title>La tournée des fontaines</block>
<block css>
#loclathon > div > img {
  width: 100%;
}
#bottom {
margin-bottom: -2px; /* Dirty fix. */
width: 100%;
background: url('/static/img/bottom.svg');
height: 300px;
background-position-y: bottom;
background-repeat: no-repeat;
background-size: 100%;
}
</block>
<block content>
<main id="loclathon">
  <div class="fade"></div>
  <img id="logo" class="container" src="/static/img/home.{{lang}}.svg" alt="Le Loclathon"/>
  <a href="#about" class="btn">En savoir plus <svg class="outline"><use xlink:href="static/img/icons.svg#circle-plus"/></svg></a>
  <div id="bottom"></div>
</main>
<section id="about" class="dual padded spaced">
  <div>
    <h1><?= __('loclathon.about.title') ?></h1>
    <?php foreach (__('loclathon.about') as $line): ?>
    <p><?= $line ?></p>
    <?php endforeach; ?>
  </div>
  <div>
    <h1>F.A.Q</h1>
    <div id="faq">
      <div class="left"><span class="bubble"><?= $bubbles[0] ?></span></div>
      <div class="right"><span class="bubble"><?= $bubbles[1] ?></span><span class="logo"></span></div>
      <div class="left"><span class="bubble"><?= $bubbles[2] ?></span></div>
      <div class="right"><span class="bubble"><?= $bubbles[3] ?></span><span class="logo"></span></div>
      <div class="left"><span class="bubble"><?= $bubbles[4] ?></span></div>
      <div class="right"><span class="bubble"><?= $bubbles[5] ?></span><span class="logo"></span></div>
      <div class="left"><span class="bubble"><?= $bubbles[6] ?></span></div>
      <div class="right"><span class="bubble"><?= $bubbles[7] ?></span><span class="logo"></span></div>
    </div>
  </div>
</section>
</block>
