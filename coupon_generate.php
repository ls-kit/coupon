<?php
    session_start();
    $conn = mysqli_connect("localhost", "root", "", "coupon_generater");
        
    if($conn === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    $start = $_REQUEST['serial_start'];
    $quantity = $_REQUEST['quantity'];
    $_SESSION['coupons'] = $quantity;

    
    while ($quantity) {
        $created_at = date("Y-m-d H:i:s");
        $sql = "INSERT INTO coupons VALUES (id, '$start', '$created_at')";

        $start++;
        $quantity--;

        mysqli_query($conn, $sql);
    }
 
    mysqli_close($conn);
    
    header("Location: http://coupon-design.test");
    die();
?>