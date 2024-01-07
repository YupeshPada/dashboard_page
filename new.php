<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <style>
        .dashboard_heading {
            list-style-type: none;
            padding: 0;
        }

        .dashboard_heading li {
            cursor: pointer;
            display: inline-block;
            margin: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f0f0f0;
        }

        .content-section {
            display: none;
        }
    </style>
</head>
<body>

<div class="dashboard col-lg-12 col-md-12 p-3">
    <ul class="dashboard_heading text-center p-2">
        <li class="text-center m-4" onclick="showSection('dashboard')">
            <h4>Dashboard</h4>
        </li>
        <li class="text-center m-4" onclick="showSection('students')">
            <h4>Students</h4>
        </li>
        <li class="text-center m-4" onclick="showSection('alumni')">
            <h4>Alumni</h4>
        </li>
        <li class="text-center m-4" onclick="showSection('folders')">
            <h4>Manage Folders</h4>
        </li>
        <li class="text-center m-4" onclick="showSection('images')">
            <h4>Manage Images</h4>
        </li>
        <li class="text-center m-4" onclick="showSection('notes')">
            <h4>Notes</h4>
        </li>
        <li class="text-center m-4" onclick="showSection('papers')">
            <h4>Papers</h4>
        </li>
        <li class="text-center m-4" onclick="showSection('profile')">
            <h4>Profile</h4>
        </li>
        <li class="text-center m-4" onclick="showSection('logout')">
            <h4>Log Out</h4>
        </li>

        <a href="notesedit.php">
            <li class="text-center m-4">
                <h4>Notes Edit</h4>
            </li>
        </a>
    </ul>
</div>

<!-- Your content sections -->
<div id="dashboardSection" class="content-section">
    <h2>Dashboard Content</h2>
</div>

<div id="studentsSection" class="content-section" style="display: none;">
    <h2>Students Content</h2>
    <form id="studentsForm" action="submit.php">
        <label for="studentName">Student Name:</label>
        <input type="text" id="studentName" name="studentName">
        <br>
        <input type="submit" value="Submit" onclick="submitForm('studentsForm'); return false;">
    </form>
</div>

<!-- Repeat the pattern for other sections -->

<script>
    function showSection(sectionId) {
        // Hide all sections
        $(".content-section").hide();

        // Show the selected section
        $("#" + sectionId + "Section").show();
    }

    function submitForm(formId) {
        // Use AJAX to submit the form
        $.ajax({
            type: "POST",
            url: $("#" + formId).attr("action"),
            data: $("#" + formId).serialize(),
            success: function(response) {
                // Handle the response here
                console.log(response);
            }
        });
    }
</script>

</body>
</html>




    <!-- ======== Students Section Starts Here======= -->
    <div id="studentsSection" class="content-section" style="display: none;">
                                                    <?php
                                                                include("dbcon.php");

                                                                // Fetch roles from the database or define them as needed
                                                                $roles = ["student", "alumni", "admin", "superadmin"];

                                                                // Default role to show when the page loads
                                                                $selectedRole = "student";

                                                                // Fetch data based on the selected role or fetch all data if "All" is selected
                                                                $query = ($selectedRole === 'all') ? "SELECT * FROM profile" : "SELECT * FROM profile WHERE Role=:role";
                                                                $statement = $conn->prepare($query);

                                                                if ($selectedRole !== 'all') {
                                                                    $statement->bindParam(":role", $selectedRole);
                                                                }

                                                                $statement->execute();
                                                                $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                                    ?>
                                            <div class="container-fluid">
                                                            <div class="row">
                                                                <div class="col-lg-12 col-md-12 mt-4">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h3>Students List</h3>
                                                                    </div>
                                                                    <div class="card-body table-responsive">
                                                                        <!-- Table to display data -->
                                                                        <table class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <tr>
                                            
                                                                                    <th>First Name </th>
                                                                                    <th>Middle</th>
                                                                                    <th>Last Name</th>
                                                                                    <th>Birth Date</th>
                                                                                    <th>Gender</th>
                                                                                    <th>Yaer of Graduation</th>
                                                                                    <th>Start Year</th>
                                                                                    <th>End Year</th>
                                                                                    <th>User Name </th>
                                                                                    <th>Roll No</th>
                                                                                    <th>Password</th>
                                                                                    <th>Role</th>
                                                                                    <th>Contact Email</th>
                                                                                    <th>Mobile No</th>
                                                                                    <th>Whatsapp No</th>
                                                                                    <th>Current Address</th>
                                                                                    <th>Permanent Address</th>
                                                                                    <th>Current Job</th>
                                                                                    <th>Position</th>
                                                                                    <th>Company</th>
                                                                                    <th>Organization</th>
                                                                                    <th>Profile Image</th>                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    // Display data based on the selected role
                                                                                    if ($result) {
                                                                                        foreach ($result as $row) {
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td><?= $row->first_name; ?></td>
                                                                                                <td><?= $row->middle_name; ?></td>
                                                                                                <td><?= $row->last_name; ?></td>
                                                                                                <td><?= $row->date_of_birth ; ?></td>
                                                                                                <td><?= $row->gender; ?></td>
                                                                                                <td><?= $row->year_of_graduation; ?></td>
                                                                                                <td><?= $row->start_year; ?></td>
                                                                                                <td><?= $row->end_year; ?></td>
                                                                                                <td><?= $row->user_name; ?></td>
                                                                                                <td><?= $row->roll_number; ?></td>
                                                                                                <td><?= $row->password; ?></td>
                                                                                                <td><?= $row->role ; ?></td>
                                                                                                <td><?= $row->contact_email ; ?></td>
                                                                                                <td><?= $row->mobile_number; ?></td>
                                                                                                <td><?= $row->whatsapp_number; ?></td>
                                                                                                <td><?= $row->current_address; ?></td>
                                                                                                <td><?= $row->permanent_address; ?></td>
                                                                                                <td><?= $row->current_job; ?></td>
                                                                                                <td><?= $row->position; ?></td>
                                                                                                <td><?= $row->company; ?></td>
                                                                                                <td><?= $row->organization; ?></td>
                                                                                                <td><?= $row->profile_image; ?></td>
                                                                                            </tr>
                                                                                            <?php
                                                                                        }
                                                                                    } else {
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td colspan="5">No Record Found</td>
                                                                                        </tr>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        </div>
                                            </div>
                                        </div> 
                                <!-- ======== Students Section Ends Here======= -->
                                <!-- ======== Alumni Section Starts Here======= -->

                                        <div id="alumniSection" style="display: none;">
                                        <?php
                                                    include("dbcon.php");

                                                    // Fetch roles from the database or define them as needed
                                                    $roles = ["student", "alumni", "admin", "superadmin"];

                                                    // Default role to show when the page loads
                                                    $selectedRole = "alumni";

                                                    // Fetch data based on the selected role or fetch all data if "All" is selected
                                                    $query = ($selectedRole === 'all') ? "SELECT * FROM profile" : "SELECT * FROM profile WHERE Role=:role";
                                                    $statement = $conn->prepare($query);

                                                    if ($selectedRole !== 'all') {
                                                        $statement->bindParam(":role", $selectedRole);
                                                    }

                                                    $statement->execute();
                                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                        ?>
                                            <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-lg-12 col-md-12 mt-4">
                                                                <div class="card">
                                                                    <div class="card-header">
                                                                        <h3>Alumni List</h3>
                                                                    </div>
                                                                    <div class="card-body table-responsive">
                                                                        <!-- Table to display data -->
                                                                        <table class="table table-bordered table-striped">
                                                                            <thead>
                                                                                <tr>
                                                                                        <th>First Name </th>
                                                                                        <th>Middle</th>
                                                                                        <th>Last Name</th>
                                                                                        <th>Birth Date</th>
                                                                                        <th>Gender</th>
                                                                                        <th>Yaer of Graduation</th>
                                                                                        <th>Start Year</th>
                                                                                        <th>End Year</th>
                                                                                        <th>User Name </th>
                                                                                        <th>Roll No</th>
                                                                                        <th>Password</th>
                                                                                        <th>Role</th>
                                                                                        <th>Contact Email</th>
                                                                                        <th>Mobile No</th>
                                                                                        <th>Whatsapp No</th>
                                                                                        <th>Current Address</th>
                                                                                        <th>Permanent Address</th>
                                                                                        <th>Current Job</th>
                                                                                        <th>Position</th>
                                                                                        <th>Company</th>
                                                                                        <th>Organization</th>
                                                                                        <th>Profile Image</th>                              
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <?php
                                                                                    // Display data based on the selected role
                                                                                    if ($result) {
                                                                                        foreach ($result as $row) {
                                                                                            ?>
                                                                                            <tr>
                                                                                                <td><?= $row->first_name; ?></td>
                                                                                                <td><?= $row->middle_name; ?></td>
                                                                                                <td><?= $row->last_name; ?></td>
                                                                                                <td><?= $row->date_of_birth ; ?></td>
                                                                                                <td><?= $row->gender; ?></td>
                                                                                                <td><?= $row->year_of_graduation; ?></td>
                                                                                                <td><?= $row->start_year; ?></td>
                                                                                                <td><?= $row->end_year; ?></td>
                                                                                                <td><?= $row->user_name; ?></td>
                                                                                                <td><?= $row->roll_number; ?></td>
                                                                                                <td><?= $row->password; ?></td>
                                                                                                <td><?= $row->role ; ?></td>
                                                                                                <td><?= $row->contact_email ; ?></td>
                                                                                                <td><?= $row->mobile_number; ?></td>
                                                                                                <td><?= $row->whatsapp_number; ?></td>
                                                                                                <td><?= $row->current_address; ?></td>
                                                                                                <td><?= $row->permanent_address; ?></td>
                                                                                                <td><?= $row->current_job; ?></td>
                                                                                                <td><?= $row->position; ?></td>
                                                                                                <td><?= $row->company; ?></td>
                                                                                                <td><?= $row->organization; ?></td>
                                                                                                <td><?= $row->profile_image; ?></td>
                                                                                            </tr>
                                                                                            <?php
                                                                                        }
                                                                                    } else {
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td colspan="5">No Record Found</td>
                                                                                        </tr>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                        </div>

                                <!-- ======== Alumni Section Ends Here======= -->