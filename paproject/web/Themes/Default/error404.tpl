<!DOCTYPE html>
<html>
<head>
  <title>The page you are looking for does not exist</title>
  <style type="text/css">
    body { background:#f9f9f9 url(/Themes/Default/skins/defaults/images/body_bg.gif); color: #666; text-align: center; font-size:67.5%;font-family: helvetica, arial, sans-serif; }
    div.dialog {
      text-align:left;
      background:#fff;
      width: 400px;
      padding: 0;
      margin: 6em auto 0 auto;
      border: 1px solid #ccc;
    }
    h1 { background:#CBE27C; padding:10px 15px; font-size:2em; margin-top:0; color: #000; line-height: 1.5em; }
    p { padding:0 15px; font-size:1.2em; margin-top:0;}
    a { color:#2C87B7; font-weight:bold; font-size:1.4em; }
  </style>
</head>

<body>
  <!-- This file lives in public/404.html -->
  <div class="dialog">
    <h1>This page could not be found</h1>

    <p>Sorry, but we can't find the page you are looking for.</p>
         <?php if(!empty($file_name)) : ?>
        <p>URL: <b><?= $file_name ?></b></p>
      <?php endif; ?>

    <p><a href="/">Browse the Civic Commons</a></p>
  </div>
</body>
</html>
