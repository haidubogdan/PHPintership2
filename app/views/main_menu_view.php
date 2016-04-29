<?php ?>
<menu class="menu_left">
    <ul>
        <li>
            <a href="index.php?page=home">Home</a>
        </li>
        <?php if (empty($_SESSION['logged']) || (!empty($_SESSION['admin']))): ?>
            <li>
                <a href="index.php?page=admin">Admin</a>
            </li>
        <?php endif; ?>
        <?php if (!empty($_SESSION['logged'])): ?>
            <li>
                <a href="index.php?page=quiz_test">Quiz Test</a>
            </li>
        <?php endif; ?>    
        <?php if (empty($_SESSION['logged'])): ?>
            <li>
                <a href="index.php?page=login">Login</a>
            </li>
        <?php endif; ?>
        <?php if (!empty($_SESSION['logged'])): ?>
            <li>
                <a href="index.php?page=profile">Profile</a>
            </li>
        <?php endif; ?>
        <?php if (!empty($_SESSION['logged'])): ?>
            <li>
                <a href="index.php?page=login&logout=1">Logout</a>
            </li>
        <?php endif; ?>
    </ul>
</menu>
