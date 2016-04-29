

<form method="post" action="index.php?page=login">
    <input type="text" name="username" value="" placeholder="Complete username"/>
    <input type="password" name="password" value="" placeholder="Complete password"/>
    <button type="submit" name="user_type" value="normal_user" >Login</button>
    <br>
    <?php if (false): ?> 
    <span class="error"></span>
    <span class="error"></span>
    <span class="error"></span>
    <?php endif; ?> 
</form>
<form method="post" action="index.php?page=registration">
    <input type="text" name="username" placeholder="Register username"/>
    <input type="password" name="password" placeholder="Register password"/>
    <button type="submit" name="user_type" value="normal_user" >Register</button>
</form>
