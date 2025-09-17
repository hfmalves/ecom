<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Account Recovery</title>
</head>
<body>
<h1>Account Recovery</h1>
<p>Hello <?= esc($user['name']) ?>,</p>
<p>We received a request to recover your account.</p>
<p>Click the link below to reset your password:</p>
<p><a href="<?= esc($recoveryUrl) ?>">Reset Password</a></p>
<p>If you did not request this, please ignore this message.</p>
</body>
</html>
