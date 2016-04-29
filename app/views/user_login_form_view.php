

<form method="post" action="index.php?page=login">
    <input type="text" name="username" value="{{username}}" placeholder="Complete username"/>
    <input type="password" name="password" value="{{password}}" placeholder="Complete password"/>
    <button type="submit" name="user_type" value="normal_user" >Login</button>
    <br>
    {%% if ({{error}}): %} 
    <span class="error">{{username_error}}</span>
    <span class="error">{{password_error}}</span>
    <span class="error">{{credential_error}}</span>
    {%% endif; %} 
</form>
<form method="post" action="index.php?page=registration">
    <input type="text" name="username" placeholder="Register username"/>
    <input type="password" name="password" placeholder="Register password"/>
    <button type="submit" name="user_type" value="normal_user" >Register</button>
</form>
