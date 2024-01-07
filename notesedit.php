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

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Notes Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <!-- ======== Notes Start Here ========= -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-lg-12">
                <div class="profile-form">
                    <h3 class="title text-center mt-3">Notes</h3>

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

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
