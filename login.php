<?php
session_start();

print "
    <!DOCTYPE html>
    <html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <title>Login</title>
    </head>
    <body style='background-color:lightgray;'>
    <div align='center'><h1> Login </h1></div>
";

if (isset($_SESSION['uName'])) {
    $uName = $_SESSION['uName'];
    print "
        <div align='center'>
            Already logged in as: $uName             
            <br><br>
            <form action='logout.php' method='post' >   
                <input type='submit' name='Logout' value='Logout'> 
            </form>
        </div>
    ";
} else {
    print "
        <div align='center'>
        <form action='retrieveUser.php' method='POST'>
            <br> Username<br>
            <input type='text' name='uName'>
            <br> Password<br>
            <input type='password' name='pWord'>
            <br><br>
            <input type='submit' name = 'login' value='Submit'>
        </form>
    ";
    if (isset($_GET['error'])) {
        print "
            <br>
            <div align='center'>
                Invalid Username/Password
            </div>
         ";
    }
}

print "    
       <div align='center'>
            <br>
            <form action='index.php'>   
                <button> Home </button> 
            </form>
            <br>
        </div>
        </body>
        </html>
";