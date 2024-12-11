<?php
include 'db.php';
if (isset($_GET['deleteid'])){
    $id = $_GET['deleteid']; // Define the $id variable
    $sql = "DELETE FROM students WHERE id = $id;";
    $result = mysqli_query($conn, $sql); // Use mysqli_query instead of mysql_query
    if ($result){
        header("location:students.php");
    }else{
        die(mysqli_error($conn));
    }
}
?>
