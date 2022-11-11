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
$class = array();

$sql = "select trainno, trainname, date, seatcount, src, dest, bid, class from bookings where active = 1 and id = $uid";
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
    array_push($class, $row[7]);
}

$_SESSION["activebid"] = $bid;

$itrainno = array();
$itrainname = array();
$idates = array();
$iseat = array();
$ifrom = array();
$ito = array();
$iclass = array();

$sql2 = "select trainno, trainname, date, seatcount, src, dest, class from bookings where active = 0 and id = $uid";
$res2 = mysqli_query($link, $sql2);
$n2 = mysqli_num_rows($res2);
while($row2 = mysqli_fetch_array($res2)) {
    array_push($itrainno, $row2[0]);
    array_push($itrainname, $row2[1]);
    array_push($idates, $row2[2]);
    array_push($iseat, $row2[3]);
    array_push($ifrom, $row2[4]);
    array_push($ito, $row2[5]);
    array_push($iclass, $row2[6]);
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
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
        <div class = "item" onclick = "window.location.href = 'history.php'"> <u>History</u> </div>
        <span class = "end">
            <span class = "item"  style = "margin-right: 50px" onclick = "window.location.href = 'profile.php'">Profile </span>
            <span class = "item" style = "margin-right: 50px" onclick = "loginLogout()"><?php echo $righttext ?></span>
        </span>
    </nav>
    <div> 
        <h1 class = "blur"> Active bookings </h1>
        <div id = "active">

        </div>
        <h1 class = "blur"> Past bookings </h1>
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
            var clas = <?php echo json_encode($class); ?>;
 
            var itrainno = <?php echo json_encode($itrainno); ?>;
            var itrainname = <?php echo json_encode($itrainname); ?>;
            var idates = <?php echo json_encode($idates); ?>;
            var iseat = <?php echo json_encode($iseat); ?>;
            var ifrom = <?php echo json_encode($ifrom); ?>;
            var ito = <?php echo json_encode($ito); ?>;
            var iclas = <?php echo json_encode($iclass); ?>;

            let active = document.getElementById("active");
            let inactive = document.getElementById("inactive");

            for(let i = 0; i<n1; i++) {
                let outerbox = document.createElement("div");
                let resbox = document.createElement("div");
                let bookbox = document.createElement("div");
                let tname = document.createElement("h3");
                tname.innerHTML = trainno[i] + " " + trainname[i];
                let tseats = document.createElement("p");
                tseats.innerHTML = "<b>No of tickets:</b> " + seat[i];
                let troute = document.createElement("P");
                troute.innerHTML = "<b>" + from[i] + "</b> to <b>" + to[i] + "</b> on <b>" + dates[i] + "</b>";
                let tclass = document.createElement("p");
                tclass.innerHTML = "<b>Class: </b>"+clas[i];
                let cancel = document.createElement("button");
                cancel.innerHTML = "Cancel";
                cancel.onclick = () => cancellation(i);
                resbox.appendChild(tname);
                resbox.appendChild(troute);
                resbox.appendChild(tseats);
                resbox.appendChild(tclass);
                bookbox.appendChild(cancel);
                resbox.classList.add("searchInfo");
                bookbox.classList.add("bookButton");
                outerbox.classList.add("resultBoxes");
                outerbox.appendChild(resbox);
                outerbox.appendChild(bookbox);
                active.appendChild(outerbox);
            }

            for(let j = 0; j<n2; j++) {
                let resbox2 = document.createElement("div");
                let outerbox2 = document.createElement("div");
                let tname2 = document.createElement("h3");
                tname2.innerHTML = itrainno[j] + " " + itrainname[j];
                let tseats2 = document.createElement("p");
                tseats2.innerHTML = "<b>No of tickets:</b> " + iseat[j];
                let troute2 = document.createElement("p");
                troute2.innerHTML = "<b>" + ifrom[j] + "</b> to <b>" + ito[j] + "</b> on <b>" + idates[j] + "</b>";
                let tclass2 = document.createElement("p");
                tclass2.innerHTML = "<b>Class: </b>"+iclas[j];
                resbox2.appendChild(tname2);
                resbox2.appendChild(troute2);
                resbox2.appendChild(tseats2);
                resbox2.appendChild(tclass2);
                resbox2.classList.add("searchInfo");
                outerbox2.appendChild(resbox2);
                outerbox2.classList.add("resultBoxes");
                inactive.appendChild(outerbox2);
            }
        </script>
    </div>
</body>
</html>