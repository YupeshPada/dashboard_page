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

            

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>
