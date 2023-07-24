<?php include "partials/menu.php"; ?>

<!-- Main Content Section starts -->
<div class="main-content ">
    <div class="wrapper wrapper-width" style="width:100% !important;">
        <h1>Manage Order</h1>
        <br><br>

        <?php

        if (isset($_SESSION["no-order-found"])) {
            echo $_SESSION["no-order-found"];
            unset($_SESSION["no-order-found"]);
            echo "<br><br>";
        }

        if (isset($_SESSION["updated"])) {
            echo $_SESSION["updated"];
            unset($_SESSION["updated"]);
            echo "<br><br>";
        }

        ?>

        <table class="tbl-full">
            <tr>
                <th>S.No.</th>
                <th>Food</th>
                <th>Price</th>
                <th>Qty.</th>
                <th>Total</th>
                <th>Order Date</th>
                <th>Status</th>
                <th>Customer Name</th>
                <th>Contact</th>
                <th>Email</th>
                <th>Adress</th>
                <th>Actions</th>
            </tr>

            <?php

            //Query to Get all the Orders from Database
            $sql = "SELECT * FROM `tbl_order` ORDER BY id DESC"; //Display the lastest Order at First

            //Execute Query
            $result = mysqli_query($conn, $sql);

            //count rows 
            $count = mysqli_num_rows($result);

            //check whether we have Data in Database or Not
            if ($count > 0) {

                //Order availabel
                $sno = 0;
                while ($row = mysqli_fetch_assoc($result)) {

                    $sno += 1;
                    $id = $row['id'];
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $total = $row['total'];
                    $order_date = $row['order_date'];
                    $status = $row['status'];
                    $customer_name = $row['customer_name'];
                    $customer_contact = $row['customer_contact'];
                    $customer_email = $row['customer_email'];
                    $customer_address = $row['customer_address'];

            ?>

                    <tr>
                        <td><?php echo $sno; ?></td>
                        <td><?php echo $food; ?></td>
                        <td><?php echo $price; ?></td>
                        <td><?php echo $qty; ?></td>
                        <td><?php echo $total; ?></td>
                        <td><?php echo $order_date; ?></td>
                        <td>
                            <?php
                             if($status == "Ordered"){
                                echo "<label>$status</label>";
                             }
                             elseif($status == "On Delivery"){
                                echo "<label style='color: orange;'>$status</label>";
                             }
                             elseif($status == "Delivered"){
                                echo "<label style='color: green;'>$status</label>";
                             }
                             elseif($status == "Cancelled"){
                                echo "<label style='color: red;'>$status</label>";
                             }
                             ?>
                             </td>
                        <td><?php echo $customer_name; ?></td>
                        <td><?php echo $customer_contact; ?></td>
                        <td><?php echo $customer_email; ?></td>
                        <td><?php echo $customer_address; ?></td>
                        <td>
                            <a href="<?php echo $siteurl; ?>admin/update-order.php?id=<?php echo $id; ?>" class="btn-secondary">Update Order</a>
                        </td>
                    </tr>

            <?php

                }
            } else {
                //Order not availabel
                echo "<tr><td class='error' colspan='12'>Order Not Availabel</td></tr>";
            }

            ?>

        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include "partials/footer.php"; ?>