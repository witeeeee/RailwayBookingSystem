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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function loginLogout() {
            var currentText = '<?php echo $righttext; ?>';
            if(currentText != "Login/Signup") {
                return window.location.href = 'logout.php';
            }
            else {
                return window.location.href = 'login.php';
            }
        }
    </script>
</head>
<body>
    <nav class = "topbar">
        <div class = "item large"> Indian Railways </div>
        <div class = "item" onclick = "window.location.href = 'search.php'"> Search </div>
        <div class = "item" onclick = "window.location.href = 'history.php'"> History </div>
        <span class = "end">
            <span class = "item"  style = "margin-right: 50px" onclick = "window.location.href = 'profile.php'">Profile </span>
            <span class = "item" style = "margin-right: 50px" onclick = "loginLogout()"><?php echo $righttext ?></span>
        </span>
    </nav>
</body>
</html>