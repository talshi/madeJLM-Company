<!--****************************************************************************
********************************************************************************
********************************************************************************
***********************Login Page-PHP*******************************************
********************************************************************************
********************************************************************************
*****************************************************************************-->
<?php
require_once "../php/db_connect.php";
$databaseConnection =connect_to_db();

if(!empty($_POST['username']))
{
    $errMsg = '';
    //username and password sent from Form
    $username = trim($_POST['username']);
    //$email=trim($_POST['username']);
    $password = trim($_POST['password']);
    $password = md5($password);
    if ($username == '' || $password == '' || $username == 'Example@example.com' || $password == '688822292')
    {
        $errMsg .= 'empty Fields<br>';
        echo
        " <script>
                    localStorage.clear();
                    window.location='#/loginAdmin';
                    setTimeout(function(){ alert('Username or password required');},100);
                </script>";
        exit;

    }
    if($errMsg == '')
    {
        //echo "<br> in query :";
        $name_or_mail="SELECT * FROM  admin WHERE  email=:email";
        $records = $databaseConnection->prepare($name_or_mail);
        $records->bindParam(':email', $username);
        $records->execute();
        $results = $records->fetch(PDO::FETCH_ASSOC);

        if(count($results) > 0 && $password === $results['Password'] )
        {
            echo " OK ! trying to redirect you now...
                    <script>
                        window.location='../#/adminPage';
                    </script>";
            exit;
        } else
        {
            //TODO: edit message
            echo " <script>
                        localStorage.clear();
                        window.location='../#/loginAdmin';
                        setTimeout(function(){ alert('you shall not pass!');},100);
                    </script>";
            exit;
        }


    }
}
?>
