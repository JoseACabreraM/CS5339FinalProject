<?php
session_start();

print "
    <!DOCTYPE html>
    <html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <title>Main Page</title>
    </head>
    <body style=\"background-color:lightgray;\">
    <div align='center'><h1> Main Page </h1></div>
    <div>
";

if (isset($_SESSION['uName'])) {
    $uName = $_SESSION['uName'];
    print "
        <div align='center'>
            <br>
            Logged in as: $uName
            <br> <br>
            <form action='logout.php' method='post' >   
                <input type='submit' name='Logout' value='Logout'> 
            </form>
        </div>
        
        <div align='center'> 
            <br>
            <form action='user.php'>   
                <button> User Page </button> 
            </form>
            <br>
        </div>
    ";
    $uType = $_SESSION['uType'];
    if ($uType == 0) {
        print "
            <div align='center'> 
                <form action='admin.php'>   
                    <button> Admin Page </button> 
                </form>
            </div>
        ";
    }
} else {
    print "
        <div align='center'>
            <form action='login.php' method='post' >   
                <input style='font-size: 25px;' type='submit' name='Login' value='Login'> 
            </form>
        </div>
    ";
}

print "
    </div>
    </body>
    </html>
";
