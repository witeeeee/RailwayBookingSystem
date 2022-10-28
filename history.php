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
$trainno = array();
$trainname = array();
$dates = array();
$seat = array();
$from = array();
$to = array();
$bid = array();

$sql = "select trainno, trainname, date, seatcount, src, dest, bid from bookings where active = 1 and id = $uid";
$res = mysqli_query($link, $sql);
$n1 = mysqli_num_rows($res);
while($row = mysqli_fetch_array($res)) {
    array_push($trainno, $row[0]);
    array_push($trainname, $row[1]);
    array_push($dates, $row[2]);
    array_push($seat, $row[3]);
    array_push($from, $row[4]);
    array_push($to, $row[5]);
    array_push($bid, $row[6]);
}

$_SESSION["activebid"] = $bid;

$itrainno = array();
$itrainname = array();
$idates = array();
$iseat = array();
$ifrom = array();
$ito = array();

$sql2 = "select trainno, trainname, date, seatcount, src, dest from bookings where active = 0 and id = $uid";
$res2 = mysqli_query($link, $sql2);
$n2 = mysqli_num_rows($res2);
while($row2 = mysqli_fetch_array($res2)) {
    array_push($itrainno, $row2[0]);
    array_push($itrainname, $row2[1]);
    array_push($idates, $row2[2]);
    array_push($iseat, $row2[3]);
    array_push($ifrom, $row2[4]);
    array_push($ito, $row2[5]);
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
        <div class = "item end" onclick = "loginLogout()"><?php echo $righttext; ?></div>
    </nav>
    <div> 
        <h1> Active bookings </h1>
        <div id = "active">

        </div>
        <h1> Past bookings </h1>
        <div id = "inactive">

        </div>
        <script defer>

            function cancellation(i) {
                document.cookie = escape("cancel") + "=" + escape(i);
                window.location.href = "cancel.php";
            }

            var n1 = <?php echo $n1; ?>;
            var n2 = <?php echo $n2; ?>;
            
            var trainno = <?php echo json_encode($trainno); ?>;
            var trainname = <?php echo json_encode($trainname); ?>;
            var dates = <?php echo json_encode($dates); ?>;
            var seat = <?php echo json_encode($seat); ?>;
            var from = <?php echo json_encode($from); ?>;
            var to = <?php echo json_encode($to); ?>;
 
            var itrainno = <?php echo json_encode($itrainno); ?>;
            var itrainname = <?php echo json_encode($itrainname); ?>;
            var idates = <?php echo json_encode($idates); ?>;
            var iseat = <?php echo json_encode($iseat); ?>;
            var ifrom = <?php echo json_encode($ifrom); ?>;
            var ito = <?php echo json_encode($ito); ?>;

            let active = document.getElementById("active");
            let inactive = document.getElementById("inactive");

            for(let i = 0; i<n1; i++) {
                let resbox = document.createElement("div");
                let tname = document.createElement("h3");
                tname.innerHTML = trainname[i];
                let tno = document.createElement("p");
                tno.innerHTML = trainno[i];
                let tdate = document.createElement("p");
                tdate.innerHTML = dates[i];
                let tseats = document.createElement("p");
                tseats.innerHTML = seat[i];
                let troute = document.createElement("P");
                troute.innerHTML = from[i] + " to " + to[i];
                let cancel = document.createElement("button");
                cancel.innerHTML = "Cancel";
                cancel.onclick = () => cancellation(i);
                resbox.appendChild(tname);
                resbox.appendChild(tno);
                resbox.appendChild(troute);
                resbox.appendChild(tdate);
                resbox.appendChild(tseats);
                resbox.appendChild(cancel);
                resbox.classList.add("resultBoxes");
                active.appendChild(resbox);
            }

            for(let j = 0; j<n2; j++) {
                let resbox2 = document.createElement("div");
                let tname2 = document.createElement("h3");
                tname2.innerHTML = itrainname[j];
                let tno2 = document.createElement("p");
                tno2.innerHTML = itrainno[j];
                let tdate2 = document.createElement("p");
                tdate2.innerHTML = idates[j];
                let tseats2 = document.createElement("p");
                tseats2.innerHTML = iseat[j];
                let troute2 = document.createElement("p");
                troute2.innerHTML = ifrom[j] + " to " + ito[j];
                resbox2.appendChild(tname2);
                resbox2.appendChild(tno2);
                resbox2.appendChild(troute2);
                resbox2.appendChild(tdate2);
                resbox2.appendChild(tseats2);
                resbox2.classList.add("resultBoxes");
                inactive.appendChild(resbox2);
            }
        </script>
    </div>
</body>
</html>