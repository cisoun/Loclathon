<?php
$bubbles = __('loclathon.bubbles');
$next = __('loclathon.next');
?>
<extend>layouts/main</extend>
<block title>La tournée des fontaines</block>
<block css>
#loclathon > div > img {
  width: 100%;
}
#bottom {
  background: url('/static/img/bottom.svg');
  background-position-y: bottom;
  background-repeat: no-repeat;
  background-size: 100%;
  height: 300px;
  margin-bottom: -2px; /* Dirty fix. */
  width: 100%;
}
#tour { font-size: 1.2rem; }
#tour_warning { font-weight: bold; }
</block>
<block content>
<main id="loclathon">
  <div class="fade"></div>
  <img id="logo" class="container" src="/static/img/home.{{lang}}.svg" alt="Le Loclathon"/>
  <a href="#about" class="button"><?= __('loclathon.learn_more') ?> <svg class="outline"><use xlink:href="static/img/icons.svg#circle-plus"/></svg></a>
  <div id="bottom"></div>
</main>
<section id="about" class="dual padded spaced">
  <div>
    <h1><?= __('loclathon.next.title') ?></h1>
    <p id="tour"><?= $next[0] ?></p>
    <p><?= $next[1] ?></p>
    <p id="tour_warning"><?= $next[2] ?></p>
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
