<?php ?>

<h1>Home</h1>

<?php if (!empty($_SESSION['user'])): ?>
    <h2>Welcome <?= $_SESSION['user']['username'] ?></h2>
<?php endif; ?>





