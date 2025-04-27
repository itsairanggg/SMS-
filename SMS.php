<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "dbContacts");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Add Record
if (isset($_POST['add'])) {
    $studno = $_POST['studno'];
    $name = $_POST['name'];
    $cpno = $_POST['cpno'];

    $sql = "INSERT INTO tblSMS (studno, name, cpno) VALUES ('$studno', '$name', '$cpno')";
    $conn->query($sql);
    header("Location: " . $_SERVER['PHP_SELF']);
}

// Update Record
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $studno = $_POST['studno'];
    $name = $_POST['name'];
    $cpno = $_POST['cpno'];

    $sql = "UPDATE tblSMS SET studno='$studno', name='$name', cpno='$cpno' WHERE sms_ID=$id";
    $conn->query($sql);
    header("Location: " . $_SERVER['PHP_SELF']);
}

// Delete Record
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM tblSMS WHERE sms_ID=$id");
    header("Location: " . $_SERVER['PHP_SELF']);
}

// Get data if editing
$edit = false;
$studno = $name = $cpno = "";
$id = 0;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM tblSMS WHERE sms_ID=$id");
    if ($result->num_rows > 0) {
        $edit = true;
        $row = $result->fetch_assoc();
        $studno = $row['studno'];
        $name = $row['name'];
        $cpno = $row['cpno'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SMS Record Management</title>
</head>
<body>

<!-- Menu Links -->
<div style="background: #f2f2f2; padding: 10px;">
    <a href="<?= $_SERVER['PHP_SELF'] ?>#addform">Add Record</a> |
    <a href="<?= $_SERVER['PHP_SELF'] ?>#list">Update Record</a> |
    <a href="<?= $_SERVER['PHP_SELF'] ?>#list">Delete Record</a>
</div>
<br>

<h2 id="<?= $edit ? 'updateform' : 'addform' ?>"><?= $edit ? "Update Record" : "Add Record" ?></h2>

<form method="post">
    <?php if ($edit): ?>
        <input type="hidden" name="id" value="<?= $id ?>">
    <?php endif; ?>
    Student No: <input type="text" name="studno" value="<?= $studno ?>" required><br><br>
    Name: <input type="text" name="name" value="<?= $name ?>" required><br><br>
    CP No: <input type="text" name="cpno" value="<?= $cpno ?>" required><br><br>
    <input type="submit" name="<?= $edit ? 'update' : 'add' ?>" value="<?= $edit ? 'Update' : 'Add' ?>">
</form>

<hr>

<h2 id="list">Records List</h2>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>Student No</th>
        <th>Name</th>
        <th>CP No</th>
        <th>Actions</th>
    </tr>

<?php
$res = $conn->query("SELECT * FROM tblSMS ORDER BY sms_ID DESC");
if ($res->num_rows > 0) {
    while ($r = $res->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $r['sms_ID'] . "</td>";
        echo "<td>" . $r['studno'] . "</td>";
        echo "<td>" . $r['name'] . "</td>";
        echo "<td>" . $r['cpno'] . "</td>";
        echo "<td>
                <a href='?edit=" . $r['sms_ID'] . "'>Edit</a> |
                <a href='?delete=" . $r['sms_ID'] . "' onclick=\"return confirm('Are you sure you want to delete this record?')\">Delete</a>
              </td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='5'>No records found.</td></tr>";
}
?>

</table>

</body>
</html>
