<?php
include("dbconnect.php"); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
    $id = $_GET["id"];
    
    // Retrieve user data based on the ID
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Display the edit form with pre-filled data
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
</head>
<body>
    <h2>Edit User</h2>    
    <form action="update.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo $row['name']; ?>"><br><br>

        <label for="gender">Gender:</label>
<input type="radio" name="gender" value="male" <?php if ($row['gender'] === 'male') echo 'checked'; ?>> Male
<input type="radio" name="gender" value="female" <?php if ($row['gender'] === 'female') echo 'checked'; ?>> Female<br><br>


        <label for="address">Address:</label><br>
        <input id="address" type="text" name="address" rows="4" cols="50" value="<?php echo $row['address'];?>"><br><br>

        <div class="form-group">
    <label for="hobbies">Hobbies:</label>
    <select name="hobbies[]" size="3" class="form-control" id="exampleFormControlSelect1" multiple>
        <?php
        $hobbyOptions = array(
            "Reading" => "Reading",
            "Gaming" => "Gaming",
            "Cooking" => "Cooking",
            "Music" => "Music",
            "Travel" => "Travel"
            // Add more hobby options here
        );

        foreach ($hobbyOptions as $value => $label) {
            $selected = in_array($value, explode(", ", $row['hobbies'])) ? 'selected' : '';
            echo '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
        }
        ?>
    </select><br><br>
</div>

        <label for="profilePic">Profile Picture:</label>
        <input type="file" name="profilePic"><br><br>
        <?php if (!empty($row['profilePic'])) : ?>
            <img src="<?php echo 'profile_pics/' . $row['profilePic']; ?>" width="100"><br><br>
        <?php endif; ?>
        <input type="submit" value="Update">
    </form>
</body>
</html>
<?php
        } else {
            echo "User not found.";
        }
    } else {
        echo "Database error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>

