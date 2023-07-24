<?php include "partials/menu.php" ?>

<div class="wrapper">
    <h1>Update Order</h1>
    <br><br>

    <?php

    //Check whether the id is set or not
    if (isset($_GET["id"])) {

        //Get the Id and all other Details
        $id = $_GET["id"];

        //Create SQL Query to get all other Details
        $sql = "SELECT * FROM `tbl_order` WHERE id = '$id'";

        //Execute the query
        $result = mysqli_query($conn, $sql);

        //Count the Rows to Check whether the id valid or not
        $count = mysqli_num_rows($result);

        if ($count == 1) {

            //Get all Data
            $row = mysqli_fetch_assoc($result);

            $food = $row['food'];
            $price = $row['price'];
            $qty = $row['qty'];
            $status = $row['status'];
            $customer_name = $row['customer_name'];
            $customer_contact = $row['customer_contact'];
            $customer_email = $row['customer_email'];
            $customer_address = $row['customer_address'];
        } else {

            //Redirect to massage Category with session massage
            $_SESSION["no-order-found"] = "<div class='error'>Category not Found.</div>";
            header("location:" . $siteurl . "admin/manage-order.php");
        }
    } else {

        //Redirect to Manage Category 
        header("location:" . $siteurl . "admin/manage-order.php");
    }

    ?>

    <form action="" method="POST">
        <table class="tbl-30">
            <tr>
                <td>Food Name:</td>
                <td><b><?php echo $food; ?></b></td>
            </tr>
            <tr>
                <td>Price:</td>
                <td><b><?php echo $price; ?></b></td>
            </tr>
            <tr>
                <td>Qty:</td>
                <td>
                    <input type="number" name="qty" value="<?php echo $qty; ?>">
                </td>
            </tr>
            <tr>
                <td>Status:</td>
                <td>
                    <select name="status">
                        <option <?php if ($status == "Ordered") {
                                    echo "selected";
                                } ?> value="Ordered">Ordered</option>
                        <option <?php if ($status == "On Delivery") {
                                    echo "selected";
                                } ?> value="On Delivery">On Delivery</option>
                        <option <?php if ($status == "Delivered") {
                                    echo "selected";
                                } ?> value="Delivered">Delivered</option>
                        <option <?php if ($status == "Cancelled") {
                                    echo "selected";
                                } ?> value="Cancelled">Cancelled</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Customer Name:</td>
                <td>
                    <input type="text" name="customer_name" value="<?php echo $customer_name; ?>">
                </td>
            </tr>
            <tr>
                <td>Customer Contact:</td>
                <td>
                    <input type="tel" name="customer_contact" value="<?php echo $customer_contact; ?>">
                </td>
            </tr>
            <tr>
                <td>Customer Email:</td>
                <td>
                    <input type="email" name="customer_email" value="<?php echo $customer_email; ?>">
                </td>
            </tr>
            <tr>
                <td>Customer Address:</td>
                <td>
                    <textarea name="customer_address" cols="30" rows="5"><?php echo $customer_address; ?></textarea>
                </td>
            </tr>
            <tr>
                <td class="colspan-2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="price" value="<?php echo $price; ?>">
                    <input type="submit" name="submit" value="Update Order" class="btn-secondary">
                </td>
            </tr>
        </table>
    </form>

    <?php

    if (isset($_POST['submit'])) {

        //1. Get all values from our form
        $id = $_POST["id"];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $tatal = $price * $qty;
        $status = $_POST['status'];
        $customer_name = $_POST['customer_name'];
        $customer_contact = $_POST['customer_contact'];
        $customer_email = $_POST['customer_email'];
        $customer_adress = $_POST['customer_address'];

        //2. Update the Database
        $sql2 = "UPDATE `tbl_order` SET `price`='$price',`qty`='$qty',`total`='$tatal',`status`='$status',`customer_name`='$customer_name',`customer_contact`='$customer_contact',`customer_email`='$customer_email',`customer_address`='$customer_adress' WHERE id='$id'";

        //Execute Query
        $result2 = mysqli_query($conn, $sql2);

        //3. Redirect to manage category with massage
        // Check whether Executed or not
        if ($result2 == true) {

            //Category Updated
            $_SESSION['updated'] = "<div class='success'>Order Updated Successfully.</div>";

            //Redirect to Manage Category
            header("location:" . $siteurl . "admin/manage-order.php");
        } else {

            //Failed to Update Category
            $_SESSION['updated'] = "<div class='error'>Failed to Updated Order.</div>";

            //Redirect to Manage Category
            header("location:" . $siteurl . "admin/manage-order.php");
        }
    }
    ?>

</div>

<?php include "partials/footer.php" ?>