<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome to Ecom Store</title>
</head>
<body>
<h1>Welcome, <?= esc($user['name']) ?>!</h1>
<p>Your account has been created successfully at <strong>Ecom Store</strong>.</p>
<p>You can now log in using your email <strong><?= esc($user['email']) ?></strong>.</p>
<p><a href="<?= esc($loginUrl) ?>">Click here to log in</a></p>
</body>
</html>
