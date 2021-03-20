<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Le Loclathon</title>
  <style>
  body {
    border:0;
    color: #333;
    font-family: sans-serif;
    font-size: 12px;
    line-height: 1.2em;
    margin: 0;
    padding: 0;
  }
  h1 { font-weight: 500; }
  table { border-collapse: collapse; }
  #main { background-color: #eee; width: 100%; }
  #content {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 0 20px #ddd;
    margin: 3em 0;
    overflow: clip;
    width: 100%;
  }
  #content > thead > tr > td,
  #content > tbody > tr > td,
  #content > tfoot > tr > td {
    background-color: #fff;
    border-bottom: 1px solid #eee;
    padding: 2em 3em;
  }
  #content > thead > tr > td { font-weight: bold; }
  #content > tfoot > tr > td {
    background-color: #111 !important;
    border-bottom: unset;
    border-top: 1px solid #eee;
    color: #fff;
  }
  .social {text-align: center;}
  .social a { color: #fff; }
  .footer {
    color: #aaa;
    line-height: 1em;
    padding-bottom: 3em;
  }
  .center { text-align: center; }
  .justify { text-align: justify; }
  <? css ?>
  </style>
</head>
<body>
  <table id="main">
    <tr>
      <td></td>
      <td class="center">
        <br><br>
        <img id="logo" src="https://dev.loclathon.ch/static/img/email/logo.png" alt="Logo" height="120"/>
      </td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td width="400">
        <table id="content" cellspacing="0" cellpadding="0" border="0">
          <thead>
            <tr>
              <td align="center">
                <? header ?>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
                <? body ?>
              </td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td class="center">
                <?= __('email.see_you') ?><br>
                <small class="social">
                  <a href="https://loclathon.ch">loclathon.ch</a> |
                  <a href="https://instagram.com/loclathon">Instagram</a> |
                  <a href="https://facebook.com/Loclathon">Facebook</a> |
                  <a href="https://loclathon.ch/fr/contact"><?= __('email.contact') ?></a>
                </small>
              </td>
            </tr>
          </tfoot>
        </table>
      </td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td class="footer center">
        <small>
          Association du Loclathon, Nicolas Huguenin<br>
          Rue de France 4<br>
          2400 Le Locle<br>
          <?= __('shop.countries')['CH'] ?>
        </small>
      </td>
      <td></td>
    </tr>
  </table>
</body>
</html>
