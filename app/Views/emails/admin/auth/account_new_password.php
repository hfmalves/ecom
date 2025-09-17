<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Your New Password</title>
</head>
<body>
<h1>Password Updated</h1>
<p>Hello <?= esc($user['name']) ?>,</p>
<p>Your password has been reset successfully.</p>
<p>If you did not request this change, please contact our support immediately.</p>
<p><a href="<?= esc($loginUrl) ?>">Log in with your new password</a></p>
</body>
</html>
