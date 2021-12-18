<?php
// Kumar, A., 2021. Mobile Store Management System using PHP and MYSQL|PHPGurukul. [online video]. 25 August. Available from:
// https://www.youtube.com/watch?v=EuVuSFGZ2F0&list=LL&index=44&t=562s [Accessed 2 October 2021].

session_start();
error_reporting(0);
include_once ('includes/dbconnection.php');
if (isset($_POST['submit'])){
    $orderid=$_GET['oid'];
    $resseta="Order Cancelled";
    $remark=$_POST['restremark'];
    $canclbyuser=1;

    $query=mysqli_query($con,"insert into tbltracking(OrderId,remark,status,OrderCancelledByUser) value('$orderid', '$remark', '$resseta', '$canclbyuser')");
    $query=mysqli_query($con, "update tblorderaddresses set OrderFinalStatus='$resseta' where Ordernumber='$orderid'");
    if ($query) {
        $msg="Order Has been updated";
    }
    else{
        $msg="Something Went Wrong. Please try again";
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

    <title>Cancel Order</title>
</head>
<body>
<div>
    <?php
    $orderid=$_POST['oid'];
    $query=mysqli_query($con, "select Ordernumber,OrderFinalStatus from tblorderaddress where Ordernumber='$orderid'");
    $num=mysqli_num_rows($query);
    $cnt=1;
    ?>

    <table border="1" cellpadding="10" style="border-collapse: collapse; border-spacing: 0; width: 100%; text-align: center;">
        <tr align="center">
            <th colspan="4">
                Cancel Order #<?php echo $orderid;?>
            </th>
        </tr>
        <tr>
            <th>Order Number</th>
            <th>Current Status</th>
        </tr>
        <?php
        while ($row=mysqli_fetch_array($query)){

            ?>
        <tr>
            <td><?php echo $orderid;?></td>
            <td>
                <?php $status=$row['OrderFinalStatus'];
                if ($status==""){
                    echo "Waiting for Confirmation";
                }
                else{
                    echo $status;
                }
                ?></td>
        </tr>
        <?php }?>

    </table>
    <?php if ($status=="" || $status=="Order Accept"){?>
    <form method="post">
        <table>
            <tr>
                <th>Reason for Cancel</th>
                <td><textarea name="restremark" placeholder="" rows="12" cols="50" class="form-control wd-450" required="true"></textarea></td>
            </tr>
            <tr>
                <td colspan="2" align="center"><button type="submit" name="submit" class="btn btn--box btn--small btn--blue btn--uppercase btn--weight">Update Order</button></td>
            </tr>
        </table>
    </form>
    <?php } else{?>
    <?php if ($status=='Order Cancelled'){?>
    <p style="color: red; font-size: 20px;">Order Cancelled</p>
    <?php } else{?>
    <p style="color: red; font-size: 20px;">
        You can't cancel this. Order is on the way or delivered.
    </p>
    <?php }}?>
</div>

</body>
</html>
