<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=yes">
<?php echo"ldld";?>
//start html code
 

    <div id ="login_container">

        <div id="login_form">
            <br>
            <h3>Login</h3>
            <?php
                if(isset($msg)){
                   echo "<script>console.log({$msg[0]} {$msg[1]})</script>";
                }
            ?>
            <form class="login"  action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <p>
                    <label for="login">Email: </label>
                    <input type="text" name="user_name" id="login"   value="Example@example.com" onfocus="if($(this).val()=='Example@example.com')$(this).val('')" onblur="if($(this).val()=='')$(this).val('Example@example.com')">
                </p>

                <p>
                    <label for="password">Password: </label>
                    <input type="password" name="user_password" id="password" value="688822292" onfocus="if($(this).val()=='688822292')$(this).val('')" onblur="if($(this).val()=='')$(this).val('688822292')">
                </p>

                <div class="checkbox">
                       <label>
                        <input type="checkbox" name="remember_me"> Remember me
                    </label>
                </div>

                <p class="login-submit">
                    <button class="login-button" name="action_login">Log In</button>
                </p>

                <p class="forgot-password"><a href="#/forgot">Forgot your password?</a></p>
            </form>
        </div>

    </div>
