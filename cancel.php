<?php 

    session_start();

    require_once "config.php";

    $selected = $_COOKIE["cancel"];
    $bid = $_SESSION["activebid"][$selected];
    $sql = "update bookings set active = 0 where bid = $bid";
    if(mysqli_query($link, $sql)) {
        header("location: history.php");
    }
    else {
        echo '<script>alert("Failed to cancel"); </script>';
        header("location: history.php");
    }

?>