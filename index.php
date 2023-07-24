 <?php include "partials/menu.php"; ?>

 <!-- Main Content Section starts -->
 <div class="main-content ">
     <div class="wrapper">
         <h1>Dashbord</h1>
         <br><br>
         <?php

            if (isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }

            echo "<br><br>";
            ?>
         <div class="col-4 text-center">

             <?php

                //Sql Query
                $sql = "SELECT * FROM `tbl_category`";

                //Execute Query
                $result = mysqli_query($conn, $sql);

                //count Rows
                $count = mysqli_num_rows($result);
                ?>

             <h1><?php echo $count; ?></h1>
             Categories
         </div>
         <div class="col-4 text-center">

             <?php

                //Sql Query
                $sql2 = "SELECT * FROM `tbl_food`";

                //Execute Query
                $result2 = mysqli_query($conn, $sql2);

                //count Rows
                $count2 = mysqli_num_rows($result2);
                ?>

             <h1><?php echo $count2; ?></h1>
             Foods
         </div>
         <div class="col-4 text-center">

             <?php

                //Sql Query
                $sql3 = "SELECT * FROM `tbl_order`";

                //Execute Query
                $result3 = mysqli_query($conn, $sql3);

                //count Rows
                $count3 = mysqli_num_rows($result3);
                ?>

             <h1><?php echo $count3; ?></h1>
             Total Orders
         </div>
         <div class="col-4 text-center">

             <?php

                //Create Sql to Get Total Revenue Generated
                //Aggregate function in SQL
                $sql4 = "SELECT SUM(total) AS Total FROM `tbl_order` WHERE status = 'Delivered'";

                //Execute Query
                $result4 = mysqli_query($conn, $sql4);

                //Gat the Value
                $row4 = mysqli_fetch_assoc($result4);

                //Get the Total Revenue
                $total_revenue = $row4['Total'];
                ?>

             <h1><?php echo $total_revenue; ?></h1>
             Revenue Generated
         </div>
         <div class="clearfix"></div>
     </div>
 </div>
 <!-- Main Content Section Ends -->

 <?php include "partials/footer.php"; ?>