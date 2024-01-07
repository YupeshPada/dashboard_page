                                            <?php 
                                            include("dbcon.php");

                                            // Fetch distinct years, semesters, and subjects for filtering
                                            $query = "SELECT DISTINCT year, semester, subject FROM notes";
                                            $statement = $conn->prepare($query);
                                            $statement->execute();
                                            $filterOptions = $statement->fetchAll(PDO::FETCH_OBJ);





                                            // Handle form submission for filtering
                                            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                                                $selectedYear = $_POST['filter_year'];
                                                $selectedSemester = $_POST['filter_semester'];
                                                $selectedSubject = $_POST['filter_subject'];

                                                // Fetch data based on the selected filter options
                                                $query = "SELECT * FROM notes WHERE 
                                                        (:year IS NULL OR year = :year) AND 
                                                        (:semester IS NULL OR semester = :semester) AND 
                                                        (:subject IS NULL OR subject = :subject)";
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

                                                // Fetch all notes by default
                                                $query = "SELECT * FROM notes";
                                                $statement = $conn->prepare($query);
                                                $statement->execute();
                                                $result = $statement->fetchAll(PDO::FETCH_OBJ);

                                                // Define default values or fetch from user input
                                                $selectedYear = isset($_POST['filter_year']) ? $_POST['filter_year'] : ''; // Placeholder, adjust as needed
                                                $selectedSemester = isset($_POST['filter_semester']) ? $_POST['filter_semester'] : ''; // Placeholder, adjust as needed
                                                $selectedSubject = isset($_POST['filter_subject']) ? $_POST['filter_subject'] : ''; // Placeholder, adjust as needed

                                                  }
                                            ?>