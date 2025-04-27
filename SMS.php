<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "dbContacts");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Variables
$studno_add = "";
$name_add = "";
$cpno_add = "";

$studno_update = "";
$name_update = "";
$cpno_update = "";

$studno_delete = "";
$name_delete = "";
$cpno_delete = "";

// ADD -> Save New Record
if (isset($_POST['save'])) {
    $studno = $_POST['studno'];
    $name = $_POST['name'];
    $cpno = $_POST['cpno'];

    $conn->query("INSERT INTO tblSMS (studno, name, cpno) VALUES ('$studno', '$name', '$cpno')");
    echo "<script>alert('Record Added Successfully!'); window.location.href='".$_SERVER['PHP_SELF']."';</script>";
}

// UPDATE -> Search Record
if (isset($_POST['search_update'])) {
    $studno_update = $_POST['studno_update'];
    $res = $conn->query("SELECT * FROM tblSMS WHERE studno='$studno_update'");
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $name_update = $row['name'];
        $cpno_update = $row['cpno'];
    } else {
        echo "<script>alert('Record Not Found');</script>";
    }
}

// UPDATE -> Save Updated Record
if (isset($_POST['update'])) {
    $studno = $_POST['studno_update'];
    $name = $_POST['name_update'];
    $cpno = $_POST['cpno_update'];

    $conn->query("UPDATE tblSMS SET name='$name', cpno='$cpno' WHERE studno='$studno'");
    echo "<script>alert('Record Updated Successfully!'); window.location.href='".$_SERVER['PHP_SELF']."';</script>";
}

// DELETE -> Search Record
if (isset($_POST['search_delete'])) {
    $studno_delete = $_POST['studno_delete'];
    $res = $conn->query("SELECT * FROM tblSMS WHERE studno='$studno_delete'");
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $name_delete = $row['name'];
        $cpno_delete = $row['cpno'];
    } else {
        echo "<script>alert('Record Not Found');</script>";
    }
}

// DELETE -> Delete Record
if (isset($_POST['delete'])) {
    $studno = $_POST['studno_delete'];

    $conn->query("DELETE FROM tblSMS WHERE studno='$studno'");
    echo "<script>alert('Record Deleted Successfully!'); window.location.href='".$_SERVER['PHP_SELF']."';</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SMS Record Management</title>
</head>
<body>

<!-- Menu Links -->
<b>Menu Links:</b><br>
<a href="#add">Add Record</a> | 
<a href="#update">Update Record</a> | 
<a href="#delete">Delete Record</a>
<br><br>

<!-- ADD RECORD -->
<h3 id="add">Add Record</h3>
<form method="post">
    Student Number: <input type="text" name="studno" required><br><br>
    Name: <input type="text" name="name" required><br><br>
    CP No.: <input type="text" name="cpno" value="63" required> (ex. 639201234567)<br><br>
    <input type="submit" name="save" value="Save">
</form>

<hr>

<!-- UPDATE RECORD -->
<h3 id="update">Update Record</h3>
<form method="post">
    Student Number: <input type="text" name="studno_update" value="<?= $studno_update ?>" required>
    <input type="submit" name="search_update" value="Search"><br><br>
    Name: <input type="text" name="name_update" value="<?= $name_update ?>"><br><br>
    CP No.: <input type="text" name="cpno_update" value="<?= $cpno_update ?>"> (ex. 639201234567)<br><br>
    <input type="submit" name="update" value="Update">
</form>

<hr>

<!-- DELETE RECORD -->
<h3 id="delete">Delete Record</h3>
<form method="post">
    Student Number: <input type="text" name="studno_delete" value="<?= $studno_delete ?>" required>
    <input type="submit" name="search_delete" value="Search"><br><br>
    Name: <input type="text" name="name_delete" value="<?= $name_delete ?>" readonly><br><br>
    CP No.: <input type="text" name="cpno_delete" value="<?= $cpno_delete ?>" readonly> (ex. 639201234567)<br><br>
    <input type="submit" name="delete" value="Delete">
</form>

</body>
</html>
