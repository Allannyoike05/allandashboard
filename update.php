<?php
include 'db.php';

// Get the student's ID
if (isset($_GET['updateid'])) {
    $id = $_GET['updateid'];

    // Fetch the current student data
    $sql = "SELECT * FROM students WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $student = mysqli_fetch_assoc($result);
    } else {
        die("Error fetching student data: " . mysqli_error($conn));
    }
}

// Handle the form submission
if (isset($_POST['submit'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $guardian = $_POST['guardian'];
    $phone = $_POST['phone'];
    $grade = $_POST['grade'];

    // Update the student data in the database
    $sql = "UPDATE students SET firstname = '$firstname', lastname = '$lastname', dob = '$dob', gender = '$gender', guardian = '$guardian', phone = '$phone', grade = '$grade' WHERE id = $id";
    if (mysqli_query($conn, $sql)) {
        header("Location: students.php");
    } else {
        die("Error updating student data: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header">
                <h3>Update Student</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="inputFirst" class="form-label">FIRST NAME</label>
                        <input type="text" name="firstname" class="form-control" id="inputFirst" value="<?php echo htmlspecialchars($student['firstname']); ?>" required> 
                    </div>
                    <div class="form-group">
                        <label for="inputLast" class="form-label">LAST NAME</label>
                        <input type="text" name="lastname" class="form-control" id="inputLast" value="<?php echo htmlspecialchars($student['lastname']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="inputDate" class="form-label">DOB</label>
                        <input type="date" name="dob" class="form-control" id="inputDate" value="<?php echo htmlspecialchars($student['dob']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="inputGender" class="form-label">GENDER</label>
                        <input type="text" name="gender" class="form-control" id="inputGender" value="<?php echo htmlspecialchars($student['gender']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="inputGuardian" class="form-label">GUARDIAN NAME</label>
                        <input type="text" name="guardian" class="form-control" id="inputGuardian" value="<?php echo htmlspecialchars($student['guardian']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="inputPhone" class="form-label">PHONE NUMBER</label>
                        <input type="tel" name="phone" class="form-control" id="inputPhone" placeholder="+25474546471" value="<?php echo htmlspecialchars($student['phone']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="inputGrade" class="form-label">GRADE LEVEL</label>
                        <select id="inputGrade" class="form-control" name="grade" required>
                            <option selected><?php echo htmlspecialchars($student['grade']); ?></option>
                            <option>Grade 1</option>
                            <option>Grade 2</option>
                            <option>Grade 3</option>
                            <option>Grade 4</option>
                            <option>Grade 5</option>
                            <option>Grade 6</option>
                            <option>Grade 7</option>
                            <option>Grade 8</option>
                            <option>Grade 9</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
                        <a href="students.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
