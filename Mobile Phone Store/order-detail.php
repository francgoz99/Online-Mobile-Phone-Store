<?php
// Kumar, A., 2021. Mobile Store Management System using PHP and MYSQL|PHPGurukul. [online video]. 25 August. Available from:
// https://www.youtube.com/watch?v=EuVuSFGZ2F0&list=LL&index=44&t=562s [Accessed 2 October 2021].

session_start();
error_reporting(0);
include_once ('includes/dbconnection.php');
if (strlen($_SESSION['msmsuid']==0)){
    header('location:logout.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Online Mobile Phone Store||My Orders</title>
    <!-- Vendor CSS Files -->
    <link rel="stylesheet" href="assets/css/vendor/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/css/vendor/fontawesome.css">
    <link rel="stylesheet" href="assets/css/vendor/plaza-icon.css">
    <link rel="stylesheet" href="assets/css/vendor/bootstrap.min.css">

    <!-- Plugin CSS Files -->
    <link rel="stylesheet" href="assets/css/plugin/swiper.min.css">
    <link rel="stylesheet" href="assets/css/plugin/material-scrolltop.css">
    <link rel="stylesheet" href="assets/css/plugin/price_range_style.css">
    <link rel="stylesheet" href="assets/css/plugin/in-number.css">
    <link rel="stylesheet" href="assets/css/plugin/venobox.min.css">

    <!-- Use the minified version files listed below for better performance and remove the files listed above -->
    <!-- <link rel="stylesheet" href="assets/css/vendor/vendor.min.css"/>
    <link rel="stylesheet" href="assets/css/plugin/plugins.min.css"/>
    <link rel="stylesheet" href="assets/css/main.min.css"> -->

    <!-- Main Style CSS File -->
    <link rel="stylesheet" href="assets/css/main.css">
    <script language="javascript" type="text/javascript">
        var popUpWin=0;
        function popUpWindow(URLStr, left, top, width, height)
        {
            if (popUpWin){
                if (!popUpWin.closed) popUpWin.close();
            }
            popUpWin=open(URLStr, 'popUpWin', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizeable=no,copyhistory=yes,width='+600+',height='+600+', left='+left+', top='+top+',screenX='+left+', screenY='+top+'');
        }


    </script>
</head>
<body>
<?php include_once ('includes/header.php');?>
<!-- ::::::  Start  Breadcrumb Section  ::::::  -->
<div>
    <div>
        <div>
            <div>
                <ul>
                    <li class="page-breadcrumb__nav"><a href="index.php">Home</a></li>
                    <li class="page-breadcrumb__nav active">Single Order Page</li>
                </ul>
            </div>
        </div>
    </div>
</div><!-- ::::::  End  Breadcrumb Section  ::::::  ->

<!-- ::::::  Start  Main Container Section  ::::::  -->
<main>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-content">
                    <h5 class="section-content__title">Single Order Detail</h5>
                </div>
                <!-- Start Cart Table -->
                <div class="table-content table-responsive cart-table-content m-t-30">
                    <h3>#<?php $oid=$_GET['orderid']; ?>
                        <?php
                        //Getting Url
                        $link="http";
                        $link.="://";
                        $link.=$_SERVER['HTTP_HOST'];

                        //Getting order Details
                        $userid=$_SESSION['msmsuid'];
                        $ret=mysqli_query($con, "select OrderTime,OrderFinalStatus from tbladdresses where UserId='$userid' and Ordernumber='$oid'");
                        while ($result=mysqli_fetch_array($ret)){
                            ?>
                        <p style="color: #000"><b>Order #</b><?php echo $oid;?></p>
                        <p style="color: #000"><b>Order Date</b><?php echo $od=$result['OrderTime'];?></p>
                        <p style="color: #000"><b>Order Status:</b><?php if ($result['OrderFinalStatus']=="") {
                        echo "Not Accepted Yet";

                        } else{
                            echo $result['OrderFinalStatus'];
                        }?> &nbsp;
                            <a href="javascript:void (0);" onclick="popUpWindow('trackorder.php?oid=<?php echo $oid;?>');" title="Track order" style="color: #000" class="btn btn--box btn--small btn--blue btn--uppercase
                            btn--weight">Track Order</a>
                        </p>
                        <?php } ?>

                        <!-- Generate Invoice -->
                        <p><a href="javascript:void(0);" onclick="popUpWindow('invoice.php?oid=<?php echo $oid;?> && odate=<?php echo $od; ?>');" title="Order Invoice" style="color: #000" class="btn btn--box btn--small btn--blue btn--uppercase btn--weight">Invoice</a></p>
                        <?php
                        $userid=$_SESSION['msmsuid'];
                        $query=mysqli_query($con, "select tblproducts.Image1,tblproducts.ProductName,tblproducts.Color,tblproducts.Price,tblproducts.PId,tblorders.OrderNumber,tblorders.CashonDelivery from tblorders join tblproducts on tblproducts.ID=tblorders.PId where tblorders.UserID='$userid' and tblorders.OrderNumber=$oid" );
                        $num=mysqli_num_rows($query);
                        if ($num>0){
                            $cnt=1;
                            ?>
                        <table>
                            <thead class="gray-bg">
                            <tr>
                                <th>#</th>
                                <th>Order ID</th>
                                <th>Image</th>
                                <th>Item Name</th>
                                <th>Color</th>
                                <th>Delivery</th>
                                <th>Price</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php while ($row=mysqli_fetch_array($query)){
                             ?>
                            <tr>
                                <td><?php echo $cnt;?></td>
                                <td><?php echo $row['OrderName']?></td>
                                <td><img class="b-goods-f__img img-scale" src="admin/images/<?php echo $row['Image1'];?>"
                                    alt="<?php echo $row['Image'];?>" width='100' height='100'></td>
                                <td><?php echo $row['ProductName'];?></td>
                                <td><?php echo $row['Color'];?></td>
                                <td><?php echo $row['CashonDelivery']; ?></td>
                                <td>$<?php echo $total=$row['Price'];?>
                                    <?php
                                    $grandtotal+=$total;
                                    $cnt=$cnt+1;
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php } ?>
                            <tr>
                                <th colspan="5" style="text-align: center;">Grand Total</th>
                                <th>$<?php echo $grandtotal; ?></th>
                            </tr>
                            </tbody>
                        </table>
                        <p>
                            <a href="javascript:void(0);" onclick="popUpWindow('cancelorder.php?oid=<?php echo $oid;?>');" title="Cancel this order" style="color: red" class="btn btn--box btn--small btn--blue btn--uppercase btn--weight">Cancel this order</a>
                        </p>

                </div><!-- End Cart Table -->
                <!-- Start Cart Table Button -->
            </div>
        </div>
    </div>
</main> <!-- ::::::  End  Main Container Section  ::::::  -->

<?php include_once ('includes/footer.php');?>

<!-- material-scrolltop button -->
<button class="material-scrolltop" type="button"></button>

<!-- ::::::::::::::All Javascripts Files here ::::::::::::::-->

<!-- Vendor JS Files -->
<script src="assets/js/vendor/jquery-3.5.1.min.js"></script>
<script src="assets/js/vendor/modernizr-3.7.1.min.js"></script>
<script src="assets/js/vendor/jquery-ui.min.js"></script>
<script src="assets/js/vendor/bootstrap.bundle.js"></script>

<!-- Plugins JS Files -->
<script src="assets/js/plugin/swiper.min.js"></script>
<script src="assets/js/plugin/jquery.countdown.min.js"></script>
<script src="assets/js/plugin/material-scrolltop.js"></script>
<script src="assets/js/plugin/price_range_script.js"></script>
<script src="assets/js/plugin/in-number.js"></script>
<script src="assets/js/plugin/jquery.elevateZoom-3.0.8.min.js"></script>
<script src="assets/js/plugin/venobox.min.js"></script>

<!-- Use the minified version files listed below for better performance and remove the files listed above -->
<!-- <script src="assets/js/vendor/vendor.min.js"></script>
<script src="assets/js/plugin/plugins.min.js"></script> -->

<!-- Main js file that contents all jQuery plugins activation. -->
<script src="assets/js/main.js"></script>



</body>
</html>