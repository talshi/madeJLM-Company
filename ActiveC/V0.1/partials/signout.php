<?php

   /* session_start();

        unset($_SESSION['username']);

        // Unset all of the session variables.
        $_SESSION = array();

        //kill the session, also delete the session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finally, destroy the session.
        session_destroy();*/
       echo("
        <script>
            sessionStorage.removeAll();
            alert('Successfully Logout');
         </script>
          You are not logged in. <br> <br>
          <a id='re_route' href ='./#/login\'>
            Go Back
         </a>
           ");

 ?>
