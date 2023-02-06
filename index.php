<?php
    session_start();
    $conn = mysqli_connect("localhost", "root", "", "coupon_generater");
        
    if($conn === false) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .coupon_wrapper {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
        }
        .coupon-field > div {
            background: url(./coupon.png) no-repeat center / cover;
            width: 320px;
            height: 122px;
            position: relative;
            margin: 15px;
        }
        .coupon-field span {
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-59%);
            writing-mode: vertical-rl;
        }
    </style>
</head>
<body>
    <?php
        $sql = "SELECT coupon_number FROM coupons ORDER BY id DESC LIMIT 1";
        $result = $conn->query($sql);
        $result = $result->fetch_assoc();

        if (isset($result['coupon_number'])) {
            $start = $result['coupon_number'] + 1;
        } else {
            $start = 1;
        }
        
    ?>

    <form action="coupon_generate.php" method="POST">
        <div>
            <label for="">Start Number</label>
            <input type="number"  name="serial_start" id="" placeholder="0000001" value="<?php echo sprintf('%07d', $start) ?>" readonly>
        </div>
        
        <!-- <div>
            <label for="">End Number</label>
            <input type="number"  name="serial_end" id="" placeholder="00000030">
        </div> -->

        <div>
            <label for="">How many generate</label>
            <input type="number" name="quantity" id="" placeholder="25">
        </div>

        <button type="submit"> Generate </button>
    </form>


    <br><br><br>



    <?php
        $number = $_SESSION['coupons'];
        $sql = "SELECT coupon_number FROM coupons ORDER BY id DESC LIMIT $number";
        $result = $conn->query($sql);
        echo '<div class="coupon_wrapper">';
            while ($row = $result->fetch_assoc()) {
                echo
                    "<div class='coupon-field'>
                        <div><span>" . sprintf('%07d', $row['coupon_number']) . "</span></div>
                    </div>"
                ;
            }
        echo '</div>';
        mysqli_close($conn);
    ?>

</body>
</html>