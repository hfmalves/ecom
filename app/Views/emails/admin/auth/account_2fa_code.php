<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your One-Time Passkey</title>
</head>
<body>
<h1>One-Time Passkey</h1>
<p>Hello <?= esc($user['name']) ?>,</p>
<p>Here is your one-time passkey for login:</p>
<h2><?= esc($code) ?></h2>
<p>This code will expire in <strong>1 minute</strong>.</p>
</body>
</html>
