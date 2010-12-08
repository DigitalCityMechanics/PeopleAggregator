<!DOCTYPE html>
<html>
<head>
  <title>An Exception was Thrown</title>
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
  <div class="dialog">
    <h1>An Exception was Thrown</h1>
	<p>Code: <b><?= $code_esc ?></b></p>
    <p><?= $msg_esc ?></p>
    <p><a href="/">Browse the Civic Commons</a></p>
  </div>
</body>
</html>
