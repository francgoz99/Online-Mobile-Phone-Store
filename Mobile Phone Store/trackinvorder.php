<?php
// Kumar, A., 2021. Mobile Store Management System using PHP and MYSQL|PHPGurukul. [online video]. 25 August. Available from:
// https://www.youtube.com/watch?v=EuVuSFGZ2F0&list=LL&index=44&t=562s [Accessed 2 October 2021].

session_start();
error_reporting(0);
include_once ('includes/dbconnection.php');

?>
<script language="javascript" type="text/javascript">
    function f2(){
        window.close();
    }
    function f3(){
        window.print();
    }

</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <title>Track Order-Invoice</title>
</head>
<body>
<div style="margin-left: 50px;">
    <?php
    $orderid=intval($_GET['oid']);
    $ret=mysqli_query($con,"select tbltracking.OrderCanclledByUser,tbltracking.remark,tbltracking.status as bstatus,tbltracking.StatusDate from tbltracking where tbltracking.OrderId ='$orderid'");

$cnt=1;

    ?>
    <table border="1" cellpadding="10" style="border-collapse: collapse: collapse; border-spacing: 0; width: 100%; text-align: center;">
        <tr>
            <th></th>
        </tr>
        <tr>
            <th>#</th>
            <th>Remark</th>
            <th>Status</th>
            <th>Time</th>
        </tr>
        <?php
        while ($row=mysqli_fetch_array($ret)){
            $cancelledby=$row['OrderCancelledByUser'];
            ?>
        <tr>
            <td><?php echo $cnt;?></td>
            <td><?php echo $row['remark'];?></td>
            <td><?php echo $row['bstatus'];
            ?></td>
            <td></td>
        </tr>
        <?php $cnt=$cnt+1;} ?>
    </table>
    <p>
        <input name="Submit2" type="submit" class="txtbox4" value="Close" onclick="return f2();" style="cursor: pointer;"/>
        <input name="Submit2" type="submit" class="txtbox4" value="Print" onclick="return f3();" style="cursor: pointer;"/>
    </p>
</div>

</body>
</html>
