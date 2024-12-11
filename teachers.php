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
$sql = "CREATE TABLE IF NOT EXISTS teachers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) !== TRUE) {
    echo "Error creating table: " . $conn->error;
}

// Handle form submission
if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];

    $sql = "INSERT INTO teachers (firstname, lastname, email) VALUES ('$firstname', '$lastname', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "Teacher added successfully";
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
    <title>Teacher Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="d-flex flex-column flex-md-row">
        <aside class="main-sidebar bg-dark text-white p-3 flex-shrink-0" style="width: 250px;">
            <h5 class="text-center">Dashboard</h5>
            <ul class="nav flex-column">
                <li class="nav-item"><a href="#" class="nav-link text-white"><i class="fa fa-bar-chart-o mr-2"></i>Statistics</a></li>
                <li class="nav-item"><a href="students.php" class="nav-link text-white"><i class="fa fa-users mr-2"></i>Student</a></li>
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

        <div class="content-wrapper p-4 flex-grow-1">
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3>Teacher List</h3>
                    <!-- Button to trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addTeacherModal">
                        Add New Teacher
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">First</th>
                                    <th scope="col">Last</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Operations</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Fetch teachers data from the database
                                $sql = "SELECT * FROM `teachers`";
                                $result = mysqli_query($conn, $sql);
                                if ($result) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $id = htmlspecialchars($row["id"]);
                                        $firstname = htmlspecialchars($row["firstname"]);
                                        $lastname = htmlspecialchars($row["lastname"]);
                                        $email = htmlspecialchars($row["email"]);
                                        echo 
                                        "<tr>
                                            <td>$id</td>
                                            <td>$firstname</td>
                                            <td>$lastname</td>
                                            <td>$email</td>
                                            <td>
                                            
                                                <button class='btn btn-primary'><a href='update.php?updateid=$id' class='text-light'>Update</a></button>
                                                <button class='btn btn-danger'><a href='deleteid.php?deleteid=$id' class='text-light'>Delete</a></button>
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

    <!-- Modal for adding a new teacher -->
    <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addTeacherModalLabel">Add a New Teacher</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- Form for adding a new teacher -->
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
                    <label for="inputEmail" class="form-label">EMAIL</label>
                    <input type="email" name="email" class="form-control" id="inputEmail" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                    <button class='btn btn-danger'>

                </div>
                <div>
                <a href='delete.php?deleteid=<?php echo $id; ?>&type=teacher' class='text-light'>Delete</a></button>
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
