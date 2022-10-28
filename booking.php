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
$trainindex = $_COOKIE["selected"];
$trainno = $_SESSION["foundTrains"][$trainindex];
$trainname = $_SESSION["trainNames"][$trainindex];

$form_err = "";

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
        $when = trim($_POST["age"]);
    }

    if(empty(trim($_POST["seatcount"]))) {
        $form_err = "Please fill all fields";
    } else {
        $seatcount = trim($_POST["seatcount"]);
    }

    $from = $_SESSION["from"];
    $to = $_SESSION["to"];

    if(empty($form_err)) {
        $sql = "select seats from traindet where trainnumber = $trainno";
        $res = mysqli_query($link, $sql);
        $row = mysqli_fetch_array($res);
        if($seatcount > $row[0]) {
            $form_err = "Seats not available";
        }
        else {
            $sql2 = "update traindet set seats = seats - $seatcount where trainnumber = $trainno";
            $res2 = mysqli_query($link, $sql2);
            if($res2) {
                $id = $_SESSION["id"];
                $when = $_SESSION["date"];
                $sql3 = "insert into bookings (id, trainno, trainname, seatcount, date, src, dest) values ($id, $trainno, '$trainname', $seatcount, '$when', '$from', '$to')";
                if(mysqli_query($link, $sql3)) {
                    header("location: index.php");
                }
                else {
                    $form_err = "Failed";
                }
            }
            else {
                $form_err = "Fail";
            }
        }
    }
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
        <div class = "item" onclick = "window.location.href = 'history.php'"> <u>History</u> </div>
        <div class = "item end" onclick = "loginLogout()"><?php echo $righttext ?></div>
    </nav>
        <div class = "topleft">
            <h1>Passenger Information</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>First name</label>
                    <input type="text" name="fname" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>">
                </div>    
                <div class="form-group">
                    <label>Last Name</label>
                    <input type="text" name="lname" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>">
                </div>
                <div class="form-group">
                    <label>Age</label>
                    <input type="number" name="age" class="form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>">
                </div>
                <div class = "form-group">
                    <label> Number of seats </label>
                    <input type = "number" name = "seatcount" class = "form-control <?php echo (!empty($form_err)) ? 'is-invalid' : ''; ?>">
                </div>
                <span style = "color: red;"><?php echo $form_err; ?></span>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Search" style = "width: 100%">
                </div>
            </form>
        </div>
</body>
</html>