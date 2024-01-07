<?php 
include("dbcon.php");
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="wrapper">

            <!-- ========= Side Bars Starts Here ======== -->

                <aside id="sidebar" class="js-sidebar">
                    <!-- Content For Sidebar -->

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
                                    <li class="text-center m-4" onclick="showSection('notesdisplay')">
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

                                    <li class="text-center m-4" onclick="showSection('notesedit')">
                                        <h4>Notes Edit</h4>
                                    </li>
                                    
                                </ul>
                            </div>

                    <!--- Contents Ends Here ----->

                </aside>

            <!-- ========= Side Bars Ends Here ======== -->

        <div class="main">


                        <!-- ========== navbar Starts Here ============== -->
                            <nav class="navbar navbar-expand px-3 border-bottom">

                                <button class="btn" id="sidebar-toggle" type="button">
                                    <span class="navbar-toggler-icon"></span>
                                </button>

                                <div class="navbar-collapse navbar">
                                    <ul class="navbar-nav">
                                        <li class="nav-item dropdown">
                                            <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
                                                <img src=" " class="avatar img-fluid rounded" alt="">
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="#" class="dropdown-item">Profile</a>
                                                <a href="#" class="dropdown-item">Setting</a>
                                                <a href="#" class="dropdown-item">Logout</a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                            </nav>
                        <!-- ========== navbar Ends Here ============== -->

                    <div class="container-fluid" >
                        <div class="row">
                        

                                <!-- =========== Main Window Starts Here ============ -->

                                        <div class="main_window col-lg-12 col-md-12 text-center">


                                                <!-- ============= PHP Code For Count  Starts Here =========== -->

                                                                <?php

                                                                    include("dbcon.php");

                                                                    // Fetch roles from the database or define them as needed
                                                                    $roles = ["student", "alumni", "admin", "superadmin"];

                                                                    // Default role to show when the page loads
                                                                    $selectedRole = "all";

                                                                    // Fetch data based on the selected role or fetch all data if "All" is selected
                                                                    $query = ($selectedRole === 'all') ? "SELECT * FROM profile" : "SELECT * FROM profile WHERE Role=:role";
                                                                    $statement = $conn->prepare($query);

                                                                    if ($selectedRole !== 'all') {
                                                                        $statement->bindParam(":role", $selectedRole);
                                                                    }

                                                                    $statement->execute();
                                                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);

                                                                    // Count alumni
                                                                    $queryAlumniCount = "SELECT COUNT(*) as alumni_count FROM profile WHERE Role = 'alumni'";
                                                                    $statementAlumniCount = $conn->prepare($queryAlumniCount);
                                                                    $statementAlumniCount->execute();
                                                                    $alumniCount = $statementAlumniCount->fetch(PDO::FETCH_ASSOC)['alumni_count'];

                                                                    // Students
                                                                    $queryStudentCount = "SELECT COUNT(*) as student_count FROM profile WHERE Role = 'student'";
                                                                    $statementStudentCount = $conn->prepare($queryStudentCount);
                                                                    $statementStudentCount->execute();
                                                                    $studentCount = $statementStudentCount->fetch(PDO::FETCH_ASSOC)['student_count'];


                                                                    // Folders
                                                                    $queryFolderCount = "SELECT COUNT(*) as folder_count FROM folders";
                                                                    $statementFolderCount = $conn->prepare($queryFolderCount);
                                                                    $statementFolderCount->execute();
                                                                    $folderCount = $statementFolderCount->fetch(PDO::FETCH_ASSOC)['folder_count'];
                                                                    
                                                                    // SubFolders
                                                                    $querySubFolderCount = "SELECT COUNT(*) as subfolder_count FROM subfolder";
                                                                    $statementSubFolderCount = $conn->prepare($querySubFolderCount);
                                                                    $statementSubFolderCount->execute();
                                                                    $SubFolderCount = $statementSubFolderCount->fetch(PDO::FETCH_ASSOC)['subfolder_count'];
                                                                    
                                                                    
                                                                    // Images
                                                                    $queryImageCount = "SELECT COUNT(*) as image_count FROM images";
                                                                    $statementImageCount = $conn->prepare($queryImageCount);
                                                                    $statementImageCount->execute();
                                                                    $ImageCount = $statementImageCount->fetch(PDO::FETCH_ASSOC)['image_count'];

                                                                    // Notes
                                                                    $queryNotesCount = "SELECT COUNT(*) as notes_count FROM notes WHERE active=true";
                                                                    $statementNotesCount = $conn->prepare($queryNotesCount);
                                                                    $statementNotesCount->execute();
                                                                    $NotesCount = $statementNotesCount->fetch(PDO::FETCH_ASSOC)['notes_count'];
                                                                    




                                                                ?>
                                                <!-- ========== PHP Code Ends Here ========= -->

                                                <!-- ============= Dashboard Section Starts Here ============= -->
                                                                <div id="dashboard" style="display: block;">
                                                                
                                                                    <h3 class="my-4">Welcome to the Admin Dashboard</h3>
                                                                    <div class="row">
                                                                    <div class="col-md-4 mb-4">
                                                                        <div class="card" onclick="showSection('students')">
                                                                                <div class="card-body">
                                                                                    <h5 class="card-title"><?= $studentCount ?></h5>
                                                                                    <p class="card-text">Students</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Card for Alumni count -->
                                                                        <div class="col-md-4 mb-4">
                                                                            <div class="card" onclick="showSection('alumni')">
                                                                                <div class="card-body">
                                                                                    <h5 class="card-title"><?= $alumniCount ?></h5>
                                                                                    <p class="card-text">Alumnis</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- <div class="col-md-4 mb-4">
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <h5 class="card-title">7</h5>
                                                                                    <p class="card-text">Faculty</p>
                                                                                </div>
                                                                            </div>
                                                                        </div> -->

                                                                        <div class="col-md-4 mb-4">
                                                                            <div class="card" onclick="showSection('folders')">
                                                                                <div class="card-body">
                                                                                    <h5 class="card-title"><?= $folderCount ?></h5>
                                                                                    <p class="card-text">Folders</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4 mb-4">
                                                                            <div class="card" onclick="showSection('subfolders')">
                                                                                <div class="card-body">
                                                                                    <h5 class="card-title"><?= $SubFolderCount ?></h5>
                                                                                    <p class="card-text">Sub Folders</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4 mb-4">
                                                                            <div class="card" onclick="showSection('subfolders')">
                                                                                <div class="card-body">
                                                                                    <h5 class="card-title"><?= $ImageCount ?></h5>
                                                                                    <p class="card-text">Images</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4 mb-4">
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <h5 class="card-title"><?= $NotesCount ?></h5>
                                                                                    <p class="card-text">Notes</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4 mb-4">
                                                                            <div class="card">
                                                                                <div class="card-body">
                                                                                    <h5 class="card-title">104</h5>
                                                                                    <p class="card-text">Papers</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                                    
                                                            </div>

                                                <!-- ========== Dashboard Section Ends Here ========== -->

                                                <!-- ======== Students Section Starts Here======= -->
                                                            <div id="students" style="display: none;">
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

                                                            <div id="alumni" style="display: none;">
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


                                                <!-- ============= Manages Folders Starts Here =========== -->  

                                                        <div id="folders" style="display: none;">
                                                            <h3 class="my-4">Manage Folders</h3>
                                                            <div class="row">
                                                                <div class="col-md-4 mb-4">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title">140</h5>
                                                                            <p class="card-text">Current Students</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title">4159</h5>
                                                                            <p class="card-text">Alumni</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title">7</h5>
                                                                            <p class="card-text">Faculty</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title">29</h5>
                                                                            <p class="card-text">Folders</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title">30</h5>
                                                                            <p class="card-text">Subfolders</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title">5069</h5>
                                                                            <p class="card-text">Images</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title">506</h5>
                                                                            <p class="card-text">Notes</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 mb-4">
                                                                    <div class="card">
                                                                        <div class="card-body">
                                                                            <h5 class="card-title">104</h5>
                                                                            <p class="card-text">Papers</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                <!-- =============== Manages Folders Ends Here ============= -->

                                                <!-- =============== Manages Images Starts Here ============= -->

                                                        <div id="images" style="display: none;">
                                                            <h3 class="my-4">Manage Images</h3>
                                                        </div>

                                                <!-- ============ Manages Images Ends Here ============= -->
                                            
                                                <!-- ======== Notes Start Here ========= -->
                                                    <div id="notes" style="display: none;">
                                                                <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="profile-form">
                                                                                <h3 class="title text-center mt-3">Notes Section</h3>
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                                <!-- =======Button Stars Here======= -->
                                                                    <div class="row m-4">

                                                                            <div class="col--lg-12 mx-auto d-flex">
                                                                                <input type="submit" name="action" id="action" style="width: 100%;" class="btn btn-danger btn-lg mr-2" value="Edit">
                                                                                <input type="submit" name="action" id="action" style="width: 100%;" class="btn btn-success btn-lg ml-2" value="Uplaod">

                                                                            </div>                           

                                                                    </div>
                                                                <!-- =======Button Ends Here======= -->

                                                    </div>
                                                <!-- ======== Notes Ends Here ========= -->


                                                <!-- ======== Papers Start Here ========= -->
                                                    <div id="papers" style="display: none;">
                                                            <div class="row">
                                                                    <div class="col-lg-12">
                                                                        <div class="profile-form">
                                                                            <h3 class="title text-center mt-3">Papers</h3>
                                                                        </div>
                                                                    </div>
                                                            </div>
                                                            <!-- =======Button Stars Here======= -->
                                                                <div class="row m-4">

                                                                        <div class="col--lg-12 mx-auto d-flex">
                                                                            <input type="submit" name="action" id="action" style="width: 100%;" class="btn btn-danger btn-lg mr-2" value="Edit">
                                                                            <input type="submit" name="action" id="action" style="width: 100%;" class="btn btn-success btn-lg ml-2" value="Uplaod">

                                                                        </div>                           

                                                                </div>
                                                            <!-- =======Button Ends Here======= -->

                                                    </div>
                                                <!-- ======== Papers Ends Here ========= -->


                                                <!-- ================ Profile Starts Here =================== -->
                                                    <form id="profileForm" method="post" action="test_insert.php" enctype="multipart/form-data">

                                                            <div id="profile" style="display: none;">
                                                                <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="profile-form">
                                                                                <h3 class="title text-center mt-3">Profile</h3>
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                                <!-- <div class="form-group col-lg-4">
                                                                    <fieldset>
                                                                        <input type="hidden" id="profile_id" name="profile_id" value="10">
                                                                    </fieldset>
                                                                </div> -->
                                                                
                                                            <!-- =======Basic Information Stars Here======= -->

                                                                    <div class="row my-4">

                                                                    <div class="form-group col-lg-12">
                                                                        <h4 class="sub-title text-left">Personal Details:</h4>
                                                                    </div>
                                                                    <div class="form-group col-lg-3">
                                                                        <fieldset>
                                                                            <label class="control-label" for="first_name">First Name: </label>
                                                                            <input class="form-control input-sm" name="first_name" id="first_name" type="text" required="">
                                                                        </fieldset>
                                                                    </div>

                                                                    <div class="form-group col-lg-3">
                                                                        <fieldset>
                                                                            <label class="control-label" for="middle_name">Middle Name: </label>
                                                                            <input class="form-control input-sm" name="middle_name" id="middle_name" type="text" >
                                                                        </fieldset>
                                                                    </div>

                                                                    <div class="form-group col-lg-3">
                                                                        <fieldset>
                                                                            <label class="control-label" for="lastname">Last Name: </label>
                                                                            <input class="form-control input-sm" name="lastname" id="lastname" type="text" required="">
                                                                        </fieldset>
                                                                    </div>

                                                                    <div class="form-group col-lg-3">
                                                                                    <div class="mx-auto">
                                                                                    <fieldset>
                                                                                        <label class="control-label" for="profile_image">Profile_image </label>
                                                                                        <input class="form-control input-sm" name="profile_image" id="profile_image" type="file" required="">
                                                                                    </fieldset>
                                                                                    </div>
                                                                    </div>
                                                                    


                                                                    <div class="form-group col-lg-3">
                                                                        <fieldset>
                                                                            <label class="control-label" for="dateofbirth">Date of Birth: </label>
                                                                            <input class="form-control input-sm" name="dateofbirth" id="dateofbirth" type="date" required="">
                                                                        </fieldset>
                                                                    </div>
                                                                    <div class="form-group col-lg-3">
                                                                        <fieldset>
                                                                            <label class="control-label" for="gender">Gender: </label>
                                                                            <select class="form-control input-sm" name="gender" required="">
                                                                                        <option value=" ">Select Gender</option>
                                                                                        <option value="male">Male</option>
                                                                                        <option value="female">Female</option>
                                                                                        <option value="other">Other</option>
                                                                        </select>
                                                                        </fieldset>
                                                                    </div>
                                                                    <div class="form-group col-lg-3">
                                                                            <fieldset>
                                                                                <label class="control-label" for="year_of_graduation">Year of Graduation </label>
                                                                                <select class="form-control input-sm mb-3" name="yearofgraduation" required="">
                                                                                        <option value=" ">Select Year</option>
                                                                                        <option value="2">2</option>
                                                                                        <option value="3">3</option>
                                                                                </select>
                                                                                <div class="d-flex">
                                                                                    <input class="form-control input-sm" style=width:120px name="startYear" id="startYear" type="number" min="1990" placeholder="Start Year" required="">
                                                                                    <span class="mx-2">-</span>
                                                                                    <input class="form-control input-sm" style=width:120px name="endYear" id="endYear" type="number" min="1990" placeholder="End Year" required="">
                                                                                </div>
                                                                            </fieldset>
                                                                        </div>
                                                                    
                                                    
                                                                    </div>
                                                            <!-- =======Basic Information Ends Here======= -->

                                                            <!-- =======Login Information Stars Here======= -->
                                                                    <div class="row my-4">

                                                                            <div class="form-group col-lg-12">
                                                                                <h4 class="sub-title text-left">Login Information:</h4>
                                                                            </div>
                                                                            <div class="form-group col-lg-3">
                                                                                <fieldset>
                                                                                    <label class="control-label" for="user_name">User Name: </label>
                                                                                    <input class="form-control input-sm" name="user_name" id="user_name" type="text" required="">
                                                                                </fieldset>
                                                                            </div>

                                                                            <div class="form-group col-lg-3">
                                                                                <fieldset>
                                                                                    <label class="control-label" for="roll_number">Roll Number: </label>
                                                                                    <input class="form-control input-sm" name="roll_number" id="roll_number" type="text" >
                                                                                </fieldset>
                                                                            </div>

                                                                            <div class="form-group col-lg-3">
                                                                                <fieldset>
                                                                                    <label class="control-label" for="password">Password: </label>
                                                                                    <input class="form-control input-sm" name="password" id="password" type="text" required="">
                                                                                </fieldset>
                                                                            </div>
                                                    
                                                                            <div class="form-group col-lg-3">
                                                                                <fieldset>
                                                                                    <label class="control-label" for="role">Role: </label>
                                                                                    <select class="form-control input-sm" name="role" required="">
                                                                                                <option value=" ">Select Role</option>
                                                                                                <option value="superadmin">Superadmin</option>
                                                                                                <option value="admin">Admin</option>
                                                                                                <option value="student">Student</option>
                                                                                                <option value="alumni">Alumni</option>
                                                                                                <option value="teacher">Teacher</option>
                                                                                    </select>
                                                                                </fieldset>
                                                                            </div>

                                                                    </div>
                                                            <!-- =======Login Information Ends Here======= -->

                                                            <!-- =======Contact Information Stars Here======= -->
                                                                <div class="row my-4">

                                                                        <div class="form-group col-lg-12">
                                                                            <h4 class="sub-title text-left">Contact Information:</h4>
                                                                        </div>
                                                                        <div class="form-group col-lg-3">
                                                                            <fieldset>
                                                                                <label class="control-label " for="contact_email">Contact Email: </label>
                                                                                <input class="form-control input-sm" name="contact_email" id="contact_email" type="text" required="">
                                                                            </fieldset>
                                                                        </div>

                                                                        <div class="form-group col-lg-3">
                                                                            <fieldset>
                                                                                <label class="control-label" for="mobile_number">Mobile Number: </label>
                                                                                <input class="form-control input-sm" name="mobile_number" id="mobile_number" type="number" >
                                                                            </fieldset>
                                                                        </div>
                                                                        <div class="form-group col-lg-3">
                                                                            <fieldset>
                                                                                <label class="control-label" for="whatsapp_number">Whatsapp Number: </label>
                                                                                <input class="form-control input-sm" name="whatsapp_number" id="whatsapp_number" type="number" >
                                                                            </fieldset>
                                                                        </div>

                                                                        <div class="form-group col-lg-3">
                                                                            <fieldset>
                                                                                <label class="control-label" for="current_address">Current Address: </label>
                                                                                <input class="form-control input-sm" name="current_address" id="current_address" type="text" required="">
                                                                            </fieldset>
                                                                        </div>
                                                                        <div class="form-group col-lg-3 my-5">
                                                                            <fieldset>
                                                                                <label class="control-label" for="permanent_address">Permanent Address: </label>
                                                                                <input class="form-control input-sm" name="permanent_address" id="permanent_address" type="text" required="">
                                                                            </fieldset>
                                                                        </div>
                                                                
                                                                </div>
                                                            <!-- =======Contact Information Ends Here======= -->

                                                            <!-- =======Work Information Stars Here======= -->
                                                                <div class="row my-4">

                                                                        <div class="form-group col-lg-12">
                                                                            <h4 class="sub-title text-left">Work Information:</h4>
                                                                        </div>
                                                                        <div class="form-group col-lg-3">
                                                                            <fieldset>
                                                                                <label class="control-label" for="current_job">Current Job: </label>
                                                                                <input class="form-control input-sm" name="current_job" id="current_job" type="text">
                                                                            </fieldset>
                                                                        </div>

                                                                        <div class="form-group col-lg-3">
                                                                            <fieldset>
                                                                                <label class="control-label" for="position">Position: </label>
                                                                                <input class="form-control input-sm" name="position" id="position" type="text" >
                                                                            </fieldset>
                                                                        </div>
                                                                        <div class="form-group col-lg-3">
                                                                            <fieldset>
                                                                                <label class="control-label" for="company">Company: </label>
                                                                                <input class="form-control input-sm" name="company" id="company" type="text" >
                                                                            </fieldset>
                                                                        </div>

                                                                        <div class="form-group col-lg-3">
                                                                            <fieldset>
                                                                                <label class="control-label" for="organization">Organization: </label>
                                                                                <input class="form-control input-sm" name="organization" id="organization" type="text" >
                                                                            </fieldset>
                                                                        </div>


                                                                </div>
                                                            <!-- =======Work Information Ends Here======= -->

                                                            <!-- =======Button Stars Here======= -->
                                                                <div class="row m-4">

                                                                        <div class="col-lg-3 mx-auto d-flex">
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-12 gap-4 mx-auto d-flex">

                                                                            
                                                                                        
                                                                    

                                                                            <input type="submit" name="action" id="action" style="width: 50%;" class="btn btn-danger btn-lg mr-2" value="Edit">
                                                                            <input type="submit" name="action" id="action" style="width: 50%;" class="btn btn-success btn-lg ml-2" value="Save">
                                                                            
                                                                        </div>
                                                                        <div class="col-lg-3 mx-auto d-flex">
                                                                            
                                                                        </div>                           

                                                                </div>
                                                            <!-- =======Button Ends Here======= -->
                                                            
                                                                
                                                        </div>
                                                    </form>
                                                <!-- ================ Profile Ends Here =================== -->

                                                <!-- ======== Notes Display Start Here ========= -->
                                                    <div  div id="notesdisplay" style="display: none;">
                                                                <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="profile-form">
                                                                                <h3 class="title text-center mt-3">Display Notes Section</h3>
                                                                            </div>
                                                                        </div>
                                                                </div>
                                                            <!-- =========PHP Code Starts Here======== -->
                                                                <?php
                                                                    include("dbcon.php");

                                                                    $uploadMessage = ""; // Variable to store the upload message
                                                                    $deleteMessage = ""; // Variable to store the delete message

                                                                    // Handle file upload
                                                                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                                        // Check if the keys exist in $_POST and $_FILES
                                                                        $year = isset($_POST['year']) ? $_POST['year'] : null;
                                                                        $semester = isset($_POST['semester']) ? $_POST['semester'] : null;
                                                                        $subject = isset($_POST['subject']) ? $_POST['subject'] : null;

                                                                        // Check if a file was uploaded
                                                                        if (isset($_FILES['notes']) && $_FILES['notes']['error'] === UPLOAD_ERR_OK) {
                                                                            $uploadedFile = $_FILES['notes'];
                                                                            $fileName = $uploadedFile['name'];
                                                                            $tempFilePath = $uploadedFile['tmp_name'];

                                                                            // Move the uploaded file to a desired directory
                                                                            $targetDirectory = "notes/";
                                                                            $targetFilePath = $targetDirectory . $fileName;

                                                                            if (move_uploaded_file($tempFilePath, $targetFilePath)) {
                                                                                // File successfully uploaded, now insert into the database
                                                                                $query = "INSERT INTO notes (year, semester, subject, file_path) VALUES (?, ?, ?, ?)";
                                                                                $statement = $conn->prepare($query);
                                                                                $statement->execute([$year, $semester, $subject, $targetFilePath]);

                                                                                $uploadMessage = "Notes uploaded successfully!";
                                                                                // Redirect to a success page to avoid re-upload on refresh
                                                                                header("Location: success.php");
                                                                                exit(); // Make sure to exit after the header() call
                                                                            } else {
                                                                                $uploadMessage = "Failed to upload notes!";
                                                                            }
                                                                        }
                                                                    }

                                                                    // Fetch distinct years, semesters, and subjects for filtering
                                                                    $query = "SELECT DISTINCT year, semester, subject FROM notes";
                                                                    $statement = $conn->prepare($query);
                                                                    $statement->execute();
                                                                    $filterOptions = $statement->fetchAll(PDO::FETCH_OBJ);

                                                                    // Handle form submission for filtering
                                                                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                                        $selectedYear = isset($_POST['filter_year']) ? $_POST['filter_year'] : null;
                                                                        $selectedSemester = isset($_POST['filter_semester']) ? $_POST['filter_semester'] : null;
                                                                        $selectedSubject = isset($_POST['filter_subject']) ? $_POST['filter_subject'] : null;

                                                                        // Fetch data based on the selected filter options
                                                                        $query = "SELECT * FROM notes WHERE 
                                                                                (:year IS NULL OR year = :year) AND 
                                                                                (:semester IS NULL OR semester = :semester) AND 
                                                                                (:subject IS NULL OR subject = :subject) AND 
                                                                                active = true"; // Only fetch active notes
                                                                        $statement = $conn->prepare($query);
                                                                        $statement->bindParam(":year", $selectedYear);
                                                                        $statement->bindParam(":semester", $selectedSemester);
                                                                        $statement->bindParam(":subject", $selectedSubject);
                                                                        $statement->execute();
                                                                        $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                                                    } else {
                                                                        // Default values for filter options
                                                                        $selectedYear = null;
                                                                        $selectedSemester = null;
                                                                        $selectedSubject = null;

                                                                        // Fetch all active notes by default
                                                                        $query = "SELECT * FROM notes WHERE active = true";
                                                                        $statement = $conn->prepare($query);
                                                                        $statement->execute();
                                                                        $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                                                    }

                                                                    // Check if the form is submitted for delete
                                                                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Delete') {
                                                                        // Soft delete the note by setting "active" to false
                                                                        $noteId = isset($_POST['note_id']) ? $_POST['note_id'] : null;
                                                                        if ($noteId) {
                                                                            $query = "UPDATE notes SET active = false WHERE id = ?";
                                                                            $statement = $conn->prepare($query);
                                                                            $statement->execute([$noteId]);

                                                                            // Check if the note was deleted successfully
                                                                            $deleteMessage = $statement->rowCount() > 0 ? "Note deleted successfully!" : "Failed to delete note!";
                                                                        }
                                                                    }
                                                                    ?>
                                                            <!-- =========PHP Code Ends Here======== -->

                                                                <!-- ======== Display Filtered Notes Starts Here  ========= -->
                                                        
                                                                    <!-- Display Filtered Notes -->
                                                                    <div class="container mt-3">
                                                                        <h5>Filtered Notes</h5>

                                                                        <!-- Display upload message if available -->
                                                                        <?php if ($uploadMessage): ?>
                                                                            <div class="alert alert-success" role="alert">
                                                                                <?= $uploadMessage ?>
                                                                            </div>
                                                                        <?php endif; ?>

                                                                        <!-- Display delete message if available -->
                                                                        <?php if ($deleteMessage): ?>
                                                                            <div class="alert alert-info" role="alert">
                                                                                <?= $deleteMessage ?>
                                                                            </div>
                                                                        <?php endif; ?>

                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Year</th>
                                                                                    <th>Semester</th>
                                                                                    <th>Subject</th>
                                                                                    <th>File</th>
                                                                                    <th>Date Uploaded</th>
                                                                                    <th>Uploaded By</th>
                                                                                    
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php foreach ($result as $row): ?>
                                                                                    <tr>
                                                                                        <td><?= $row->year ?></td>
                                                                                        <td><?= $row->semester ?></td>
                                                                                        <td><?= $row->subject ?></td>
                                                                                        <td><a href="<?= $row->file_path ?>" target="_blank">View File</a></td>
                                                                                        <td><?= $row->created_at ?></td>
                                                                                        <td><?= $row->uploaded_by ?></td>
                                                                                    </tr>
                                                                                <?php endforeach; ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                <!-- ======== Display Filtered Notes Ends Here ========= -->

                                                                

                                                    </div>
                                                <!-- ======== Notes Display Ends Here ========= -->

                                                <!-- ======== Notes Edit Start Here ========= -->
                                                     <div  div id="notesedit" style="display: none;">
                                                                <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <div class="profile-form">
                                                                                <h3 class="title text-center mt-3">Notes Edit Section</h3>
                                                                            </div>
                                                                        </div>
                                                                </div>

                                                         <!-- =========PHP Code Starts Here =========== -->
                                                            <?php
                                                                include("dbcon.php");

                                                                $uploadMessage = ""; // Variable to store the upload message
                                                                $deleteMessage = ""; // Variable to store the delete message

                                                                // Handle file upload
                                                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                                    // Check if the keys exist in $_POST and $_FILES
                                                                    $year = isset($_POST['year']) ? $_POST['year'] : null;
                                                                    $semester = isset($_POST['semester']) ? $_POST['semester'] : null;
                                                                    $subject = isset($_POST['subject']) ? $_POST['subject'] : null;

                                                                    // Check if a file was uploaded
                                                                    if (isset($_FILES['notes']) && $_FILES['notes']['error'] === UPLOAD_ERR_OK) {
                                                                        $uploadedFile = $_FILES['notes'];
                                                                        $fileName = $uploadedFile['name'];
                                                                        $tempFilePath = $uploadedFile['tmp_name'];

                                                                        // Move the uploaded file to a desired directory
                                                                        $targetDirectory = "notes/";
                                                                        $targetFilePath = $targetDirectory . $fileName;

                                                                        if (move_uploaded_file($tempFilePath, $targetFilePath)) {
                                                                            // File successfully uploaded, now insert into the database
                                                                            $query = "INSERT INTO notes (year, semester, subject, file_path) VALUES (?, ?, ?, ?)";
                                                                            $statement = $conn->prepare($query);
                                                                            $statement->execute([$year, $semester, $subject, $targetFilePath]);

                                                                            $uploadMessage = "Notes uploaded successfully!";
                                                                            // Redirect to a success page to avoid re-upload on refresh
                                                                            header("Location: admin.php");
                                                                            exit(); // Make sure to exit after the header() call
                                                                        } else {
                                                                            $uploadMessage = "Failed to upload notes!";
                                                                        }
                                                                    }
                                                                }

                                                                // Fetch distinct years, semesters, and subjects for filtering
                                                                $query = "SELECT DISTINCT year, semester, subject FROM notes";
                                                                $statement = $conn->prepare($query);
                                                                $statement->execute();
                                                                $filterOptions = $statement->fetchAll(PDO::FETCH_OBJ);

                                                                // Handle form submission for filtering
                                                                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                                    $selectedYear = isset($_POST['filter_year']) ? $_POST['filter_year'] : null;
                                                                    $selectedSemester = isset($_POST['filter_semester']) ? $_POST['filter_semester'] : null;
                                                                    $selectedSubject = isset($_POST['filter_subject']) ? $_POST['filter_subject'] : null;

                                                                    // Fetch data based on the selected filter options
                                                                    $query = "SELECT * FROM notes WHERE 
                                                                            (:year IS NULL OR year = :year) AND 
                                                                            (:semester IS NULL OR semester = :semester) AND 
                                                                            (:subject IS NULL OR subject = :subject) AND 
                                                                            active = true"; // Only fetch active notes
                                                                    $statement = $conn->prepare($query);
                                                                    $statement->bindParam(":year", $selectedYear);
                                                                    $statement->bindParam(":semester", $selectedSemester);
                                                                    $statement->bindParam(":subject", $selectedSubject);
                                                                    $statement->execute();
                                                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                                                } else {
                                                                    // Default values for filter options
                                                                    $selectedYear = null;
                                                                    $selectedSemester = null;
                                                                    $selectedSubject = null;

                                                                    // Fetch all active notes by default
                                                                    $query = "SELECT * FROM notes WHERE active = true";
                                                                    $statement = $conn->prepare($query);
                                                                    $statement->execute();
                                                                    $result = $statement->fetchAll(PDO::FETCH_OBJ);
                                                                }

                                                                // Check if the form is submitted for delete
                                                                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Delete') {
                                                                    // Soft delete the note by setting "active" to false
                                                                    $noteId = isset($_POST['note_id']) ? $_POST['note_id'] : null;
                                                                    if ($noteId) {
                                                                        $query = "UPDATE notes SET active = false WHERE id = ?";
                                                                        $statement = $conn->prepare($query);
                                                                        $statement->execute([$noteId]);

                                                                        // Check if the note was deleted successfully
                                                                        $deleteMessage = $statement->rowCount() > 0 ? "Note deleted successfully!" : "Failed to delete note!";
                                                                    }
                                                                }
                                                                ?>

                                                        <!-- =========PHP Code Starts Here =========== -->

                                                              
                                                                    <div class="container mt-5">
                                                                        <div class="row">
                                                                            <div class="col-lg-12">
                                                                                <div class="profile-form">
                                                                                    
                                                                                    <!-- Add button to toggle the form visibility -->
                                                                                    <button class="btn btn-primary mb-3" onclick="toggleForm()">Add</button>

                                                                                    <!-- Upload Notes Form -->
                                                                                    <form method="post" enctype="multipart/form-data" id="notesForm" style="display: none;">
                                                                                        <div class="row">
                                                                                            <div class="col-lg-4">
                                                                                                <label class="control-label" for="year">Year</label>
                                                                                                <input class="form-control" type="number" name="year" id="year" placeholder="Enter Year">
                                                                                            </div>

                                                                                            <div class="col-lg-4">
                                                                                                <label class="control-label" for="semester">Semester</label>
                                                                                                <select class="form-control" name="semester" id="semester">
                                                                                                    <!-- Add options for different semesters -->
                                                                                                    <option value="1">1st Semester</option>
                                                                                                    <option value="2">2nd Semester</option>
                                                                                                    <option value="3">3rd Semester</option>
                                                                                                    <!-- Add more options as needed -->
                                                                                                </select>
                                                                                            </div>
                                                                                            <div class="col-lg-4">
                                                                                                <label class="control-label" for="subject">Subject</label>
                                                                                                <input class="form-control" type="text" name="subject" id="subject" placeholder="Enter Subject">
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="row mt-3">
                                                                                            <div class="col-lg-12">
                                                                                                <div class="upload-box">
                                                                                                    <fieldset>
                                                                                                        <label class="control-label text-left" for="notes">Upload Notes</label>
                                                                                                        <input class="form-control input-sm" style="width: 500px;" name="notes" id="notes" type="file">
                                                                                                    </fieldset>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <!-- =======Button Starts Here======= -->
                                                                                        <div class="row m-4">
                                                                                            <div class="col-lg-6 mx-auto d-flex">
                                                                                                <input type="submit" name="action" id="action" style="width: 100%;" class="btn btn-danger btn-lg mr-2" value="Edit">
                                                                                                <input type="submit" name="action" id="action" style="width: 100%;" class="btn btn-success btn-lg ml-2" value="Upload">
                                                                                            </div>
                                                                                        </div>
                                                                                        <!-- =======Button Ends Here======= -->
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Display Filtered Notes -->
                                                                    <div class="container mt-3">
                                                                        <h5>Filtered Notes</h5>

                                                                        <!-- Display upload message if available -->
                                                                        <?php if ($uploadMessage): ?>
                                                                            <div class="alert alert-success" role="alert">
                                                                                <?= $uploadMessage ?>
                                                                            </div>
                                                                        <?php endif; ?>

                                                                        <!-- Display delete message if available -->
                                                                        <?php if ($deleteMessage): ?>
                                                                            <div class="alert alert-info" role="alert">
                                                                                <?= $deleteMessage ?>
                                                                            </div>
                                                                        <?php endif; ?>

                                                                        <table class="table table-bordered">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Year</th>
                                                                                    <th>Semester</th>
                                                                                    <th>Subject</th>
                                                                                    <th>File</th>
                                                                                    <th>Date Uploaded</th>
                                                                                    <th>Uploaded By</th>
                                                                                    <th>Action</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                                <?php foreach ($result as $row): ?>
                                                                                    <tr>
                                                                                        <td><?= $row->year ?></td>
                                                                                        <td><?= $row->semester ?></td>
                                                                                        <td><?= $row->subject ?></td>
                                                                                        <td><a href="<?= $row->file_path ?>" target="_blank">View File</a></td>
                                                                                        <td><?= $row->created_at ?></td>
                                                                                        <td><?= $row->uploaded_by ?></td>
                                                                                        <td>
                                                                                            <form method="post">
                                                                                                <input type="hidden" name="note_id" value="<?= $row->id ?>">
                                                                                                <input type="submit" name="action" value="Edit" class="btn btn-primary">
                                                                                                <input type="submit" name="action" value="Delete" class="btn btn-danger">
                                                                                            </form>
                                                                                        </td>
                                                                                    </tr>
                                                                                <?php endforeach; ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                    <script>
                                                                        function toggleForm() {
                                                                            var form = document.getElementById("notesForm");
                                                                            form.style.display = (form.style.display === "none") ? "block" : "none";
                                                                        }
                                                                    </script>

                                                    </div>
                                                <!-- ======== Notes Edit Ends Here ========= -->

                                        
                                        </div>
                                
                                <!-- =========== Main Window Ends Here ============ -->


                                <div id="logout" style="display: none;">
                                    <h3 class="my-4">Log Out</h3>
                                </div>
                        </div>

                    </div>
  
        </div>

        
    </div>


    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
        function showSection(sectionId) {
            // Hide all sections
            document.getElementById('dashboard').style.display = 'none';
            document.getElementById('students').style.display = 'none';
            document.getElementById('alumni').style.display = 'none';
            document.getElementById('folders').style.display = 'none';
            document.getElementById('images').style.display = 'none';
            document.getElementById('notesdisplay').style.display = 'none';
            document.getElementById('papers').style.display = 'none';
            document.getElementById('profile').style.display = 'none';
            document.getElementById('logout').style.display = 'none';
            document.getElementById('notesedit').style.display = 'none';


            // Show the selected section
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
    <script>
        const sidebarToggle = document.querySelector("#sidebar-toggle");
sidebarToggle.addEventListener("click",function(){
    document.querySelector("#sidebar").classList.toggle("collapsed");
});
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="script.js"></script> -->
</body>

</html>