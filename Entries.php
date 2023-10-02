<h2><a href="form.php">
    Form
</a></h2>
<?php
include("dbconnect.php"); // Include your database connection file

// Fetch records from the 'users' table
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1>User Entries</h1>";
    echo "<table border='1'>";
    echo "<tr><th>Name</th><th>Gender</th><th>DOB</th><th>Address</th><th>Hobbies</th><th>Profile Pic</th></tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        // echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["name"] . "</td>";
        echo "<td>" . $row["gender"] . "</td>";
        echo "<td>" . $row["dob"] . "</td>";
        echo "<td>" . $row["address"] . "</td>";
        echo "<td>" . $row["hobbies"] . "</td>";
        echo "<td><img src='profile_pics/" . $row["profilePic"] . "' width='100'></td>";
        echo "<td><a href='edit.php?id=" . $row["id"] . "'>Edit</a></td>";
        // echo "<td><a href='delete.php?id=" . $row["id"] . "'>Delete</a></td>";
        echo "<td><a href='delete.php?id=" . $row["id"] . "' onclick='return confirmDelete();'>Delete</a></td>";
        echo "</tr>";
        
    }

    echo "</table>";
} else {
    echo "No records found.";
}

$conn->close();
?>
<script>
function confirmDelete() {
    return confirm("Are you sure you want to delete this item?");
}
</script>
