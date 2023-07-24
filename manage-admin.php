<?php include "partials/menu.php"; ?>

<!-- Main Content Section starts -->
<div class="main-content ">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br><br>
        <?php

        if (isset($_SESSION["add"])) {
            echo $_SESSION["add"]; //Displaying session massege
            unset($_SESSION["add"]); //Removing session massege
            echo "<br><br><br>";
        }

        if (isset($_SESSION["delete"])) {
            echo $_SESSION["delete"]; 
            unset($_SESSION["delete"]); 
            echo "<br><br><br>";
        }

        if (isset($_SESSION["update"])) {
            echo $_SESSION["update"]; 
            unset($_SESSION["update"]); 
            echo "<br><br><br>";
        }

        if (isset($_SESSION["user-not-found"])) {
            echo $_SESSION["user-not-found"]; 
            unset($_SESSION["user-not-found"]); 
            echo "<br><br><br>";
        }

        if (isset($_SESSION["pwd-not-match"])) {
            echo $_SESSION["pwd-not-match"];
            unset($_SESSION["pwd-not-match"]); 
            echo "<br><br><br>";
        }

        if (isset($_SESSION["change-pwd"])) {
            echo $_SESSION["change-pwd"]; 
            unset($_SESSION["change-pwd"]); 
            echo "<br><br><br>";
        }

        ?>

        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br><br>


        <table class="tbl-full">
            <tr>
                <th>S.No.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php

            // Query to Get All Admin

            $sql = "SELECT*FROM `tbl_admin`";

            //Execute the Query

            $result = mysqli_query($conn, $sql);

            //Check whether the Query Executed or not

            if ($result == true) {

                //Count Rows to Check Whether the Data in Database

                $count = mysqli_num_rows($result); //function to get all the rows in Database

                if ($count > 0) {

                    //We have Data in Database
                    $sno = 0;
                    while ($rows = mysqli_fetch_assoc($result)) {

                        //using while loop to get data from Database
                        //Get Individual Data

                        $sno += 1;
                        $id = $rows["id"];
                        $full_name = $rows["full_name"];
                        $username = $rows["username"];

                        // Display the values in our table
            ?>

                        <tr>
                            <td><?php echo $sno; ?></td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                                <a href="<?php echo $siteurl; ?>admin/change-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                <a href="<?php echo $siteurl; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                <a href="<?php echo $siteurl; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>
                            </td>
                        </tr>
            <?php
                    }
                } else {
                    //We do not have Data in Database
                }
            }

            ?>
        </table>
    </div>
</div>
<!-- Main Content Section Ends -->

<?php include "partials/footer.php"; ?>

.+
