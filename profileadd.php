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

$form_err = "";
$id = $_SESSION["id"];
if($_SERVER["REQUEST_METHOD"] == "POST") {

    if(empty(trim($_POST["fname"]))){
        $form_err = "Please fill all fields";
    } else{
        $fname = trim($_POST["fname"]);
    }

    if(empty(trim($_POST["lname"]))){
        $form_err = "Please fill all fields";
    } else{
        $lname = trim($_POST["lname"]);
    }

    if(empty(trim($_POST["age"]))){
        $form_err = "Please fill all fields";
    } else{
        $age = trim($_POST["age"]);
    }

    if(empty(trim($_POST["email"]))) {
        $form_err = "Please fill all fields";
    } else {
        $email= trim($_POST["email"]);
    }

    if(empty(trim($_POST["phone"]))) {
        $form_err = "Please fill all fields";
    } else {
        $phone= trim($_POST["phone"]);
    }

    if(empty($form_err)) {
        $sql = "insert into userprofile(id, fname, lname, age, email, phone) values ($id, '$fname', '$lname', $age, '$email', '$phone')";
        if($res = mysqli_query($link, $sql)) {
            header("location: profile.php");
        }
    }
}

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
    <div class = "topleft">
            <h1>Fill Profile</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>First name</label>
                    <input type="text" name="fname" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?> blurInput">
                </div>    
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="lname" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?> blurInput">
                </div>
                <div class="form-group">
                    <label>Age</label>
                    <input type="number" name="age" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?> blurInput">
                </div>
                <div class = "form-group">
                    <label> Email </label>
                    <input type = "text" name = "email" class = "form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?> blurInput">
                </div>
                <div class = "form-group">
                    <label> Phone </label>
                    <input type = "number" name = "phone" min = 6000000000 max = 9999999999 value = 9876543210 class = "form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?> blurInput">
                </div>
                <span style = "color: red;"><?php echo $form_err; ?></span>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Register" style = "width: 100%">    
                </div>
            </form>
        </div>
</body>
</html>