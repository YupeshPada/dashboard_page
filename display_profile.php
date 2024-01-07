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

// Count alumni
$queryAlumniCount = "SELECT COUNT(*) as alumni_count FROM profile WHERE Role = 'alumni'";
$statementAlumniCount = $conn->prepare($queryAlumniCount);
$statementAlumniCount->execute();
$alumniCount = $statementAlumniCount->fetch(PDO::FETCH_ASSOC)['alumni_count'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
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
   <!-- <th>ID</th> -->
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

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
