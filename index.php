<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $righttext = "Hello, ".$_SESSION["username"];
}
else {
    $righttext = "Login/Signup";
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class = "topbar">
        <div class = "item large"> Indian Railways </div>
        <div class = "item"> Search </div>
        <div class = "item"> History </div>
        <div class = "item end" onclick = "window.location.href = 'login.php'"><?php echo $righttext ?></div>
    </nav>
</body>
</html>