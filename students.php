<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "school";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if it doesn't exist
$sql = "CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    dob DATE NOT NULL,
    gender VARCHAR(10) NOT NULL,
    guardian VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    grade VARCHAR(50) NOT NULL
)";

if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}

// Handle form submission
if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $guardian = $_POST['guardian'];
    $phone = $_POST['phone'];
    $grade = $_POST['grade'];

    $sql = "INSERT INTO students (firstname, lastname, dob, gender, guardian, phone, grade) VALUES ('$firstname', '$lastname', '$dob', '$gender', '$guardian', '$phone', '$grade')";

    if ($conn->query($sql) === TRUE) {
        echo "New student added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="d-flex">
        <aside class="main-sidebar bg-dark text-white p-3" style="width: 250px; height: 100vh;">
            <h5 class="text-center">Dashboard</h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="#" class="nav-link text-white"><i class="fa fa-bar-chart-o mr-2"></i>Statistics</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white"><i class="fa fa-users mr-2"></i>Student</a></li>
                <li class="nav-item"><a href="teachers.php" class="nav-link text-white"><i class="fa fa-black-tie mr-2"></i>Teacher</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white"><i class="fa fa-female mr-2"></i>Parents</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white"><i class="fa fa-book mr-2"></i>Subject</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white"><i class="fa fa-bank mr-2"></i>Class Room</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white"><i class="fa fa-calendar-o mr-2"></i>Schedule</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white"><i class="fa fa-check mr-2"></i>Attendance</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white"><i class="fa fa-line-chart mr-2"></i>Exam</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white"><i class="fa fa-graduation-cap mr-2"></i>Exam Results</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white"><i class="fa fa-user-plus mr-2"></i>Users</a></li>
                <li class="nav-item"><a href="#" class="nav-link text-white"><i class="fa fa-envelope-o mr-2"></i>Notice</a></li>
            </ul>
        </aside>
        <div class="content-wrapper p-4 flex-grow-1" style="margin-left: 250px; min-height: 100vh;">
            <div class="card mt-4" style="width: 100%; max-width: 1200px; margin-left: 0;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Student List</h3>
                    <!-- Button to trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addStudentModal">
                        Add New Student
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Date of Birth</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Guardian Name</th>
                                    <th scope="col">Phone</th>
                                    <th scope="col">Grade</th>
                                    <th scope="col">Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch students data from the database
                                $sql = "SELECT * FROM students";
                                $result = mysqli_query($conn, $sql);
                                if ($result) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $id = htmlspecialchars($row["id"]);
                                        $firstname = htmlspecialchars($row["firstname"]);
                                        $lastname = htmlspecialchars($row["lastname"]);
                                        $dob = htmlspecialchars($row["dob"]);
                                        $gender = htmlspecialchars($row["gender"]);
                                        $guardian = htmlspecialchars($row["guardian"]);
                                        $phone = htmlspecialchars($row["phone"]);
                                        $grade = htmlspecialchars($row["grade"]);
                                        echo 
                                        "<tr>
                                            <td>$id</td>
                                            <td>$firstname</td>
                                            <td>$lastname</td>
                                            <td>$dob</td>
                                            <td>$gender</td>
                                            <td>$guardian</td>
                                            <td>$phone</td>
                                            <td>$grade</td>
                                            <td>
                                                <button class='btn btn-primary'><a href='update.php?updateid=$id' class='text-light'>Update</a></button>
                                                <button class='btn btn-danger'><a href='delete.php?deleteid=$id' class='text-light'>Delete</a></button>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "Error executing query: " . mysqli_error($conn);
                                }
                                mysqli_close($conn);
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for adding a new student -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addStudentModalLabel">Add a New Student</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Form for adding a new student -->
            <form method="POST" action="">
                <div class="form-group">
                    <label for="inputFirst" class="form-label">FIRST NAME</label>
                    <input type="text" name="firstname" class="form-control" id="inputFirst" required> 
                </div>
                <div class="form-group">
                    <label for="inputLast" class="form-label">LAST NAME</label>
                    <input type="text" name="lastname" class="form-control" id="inputLast" required>
                </div>
                <div class="form-group">
                    <label for="inputDate" class="form-label">DOB</label>
                    <input type="date" name="dob" class="form-control" id="inputDate" required>
                </div>
                <div class="form-group">
                    <label for="inputGender" class="form-label">GENDER</label>
                    <input type="text" name="gender" class="form-control" id="inputGender" required>
                </div>
                <div class="form-group">
                    <label for="inputGuardian" class="form-label">GUARDIAN NAME</label>
                    <input type="text" name="guardian" class="form-control" id="inputGuardian" required>
                </div>
                <div class="form-group">
                    <label for="inputPhone" class="form-label">PHONE NUMBER</label>
                    <input type="tel" name="phone" class="form-control" id="inputPhone" placeholder="+25474546471" required>
                </div>
                <div class="form-group">
                    <label for="inputGrade" class="form-label">GRADE LEVEL</label>
                    <select id="inputGrade" class="form-control" name="grade" required>
                        <option selected>Select grade</option>
                        <option>Grade 1</option>
                        <option>Grade 2</option>
                        <option>Grade 3</option>
                        <option>Grade 4</option>
                        <option>Grade 5</option>
                        <option>Grade 6</option>
                        <option>Grade 7</option>
                        <option>Grade 8</option>
                        <option>Grade 9</option>
                        <button class='btn btn-danger'>
                        <a href='delete.php?deleteid=<?php echo $id; ?>' class='text-light'>Delete</a></button>
                        <a href='update.php?updateid=<?php echo $id; ?>' class='text-light'>Update</a></button>
                      </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>