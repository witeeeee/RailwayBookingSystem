<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $righttext = "Hello, ".$_SESSION["username"];
}
else {
    header("location: login.php");
    exit;
}

require_once "config.php";

$uid = $_SESSION["id"];

$sql = "select fname, lname, age, email, phone from userprofile where id = $uid";
$res = mysqli_query($link, $sql);
$n = mysqli_num_rows($res);
if($n == 0) {
    header("location: profileadd.php");
}
else {
    $row = mysqli_fetch_array($res);
    $fname = $row[0];
    $lname = $row[1];
    $age = $row[2];
    $email = $row[3];
    $phone = $row[4];
}

$sql = "select * from bookings where id = $uid";
$res = mysqli_query($link, $sql);
$n = mysqli_num_rows($res);

$sql = "select timestamp from users where id = $uid";
$res = mysqli_query($link, $sql);
$row = mysqli_fetch_array($res);
$createdAt = $row[0];
$username = $_SESSION["username"];

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
        <div class = "item large" onclick = "window.location.href = 'index.php'"> Indian Railways </div>
        <div class = "item" onclick = "window.location.href = 'search.php'"> Search </div>
        <div class = "item" onclick = "window.location.href = 'history.php'"> History </div>
        <span class = "end">
            <span class = "item"  style = "margin-right: 50px" onclick = "window.location.href = 'profile.php'"><u>Profile</u> </span>
            <span class = "item" style = "margin-right: 50px" onclick = "loginLogout()"><?php echo $righttext ?></span>
        </span>
    </nav>
    <div class = "resultBoxes thicc">
        <h1> User Profile for <?php echo $username ?> (ID: <?php echo $uid ?>)</h1> 
        <p style = "font-size: 28px"> Created at: <?php echo $createdAt ?> IST </p>
        <br>
        <table>
            <tr>
                <td><b>Name:</b> <?php echo $fname . " " . $lname ?></td>
                <td><b>Age:</b> <?php echo $age ?> </td>
            </tr>
            <tr>
                <td><b>Email:</b> <?php echo $email ?></td>
                <td><b>Phone:</b> <?php echo $phone ?> </td>
            </tr>
            <tr>
                <td colspan = 2 style = "text-align: center"> <b>Total number of bookings:</b> <?php echo $n ?></td>        
            </tr>
            <tr style = "text-align: center">
                <td colspan = 2> <button class = "btn btn-primary" style = "width: 60%;" onclick = "window.location.href = 'updateprofile.php'" >Update Profile</td>
            </tr>
        </table>
    </div>
</body>
</html>