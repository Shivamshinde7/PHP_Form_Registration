<?php
include("dbconnect.php"); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $name = $_POST["name"];
    $gender = $_POST["gender"];
    $hobbies = $_POST["hobbies"];
    $address = $_POST["address"];

    $selectedHobbies = $_POST["hobbies"];
    $hobbies = implode(", ", $selectedHobbies);
    
    // Handle image upload
    if ($_FILES["profilePic"]["size"] > 0) {
        $uploadDir = "profile_pics/";
        $profilePic = uniqid() . "_" . $_FILES["profilePic"]["name"];
        $profilePicPath = $uploadDir . $profilePic;

        if (move_uploaded_file($_FILES["profilePic"]["tmp_name"], $profilePicPath)) {
            // Update the user's profile picture in the database
            $updateSql = "UPDATE users SET name = ?, gender = ?, hobbies = ?, address = ?, profilePic = ? WHERE id = ?";
            $stmt = $conn->prepare($updateSql);
            $stmt->bind_param("sssssi", $name, $gender, $hobbies, $address, $profilePic, $id);
        } else {
            echo "Error uploading profile picture.";
        }
    } else {
        // If no new image was uploaded, update other user data without changing the profile picture
        $updateSql = "UPDATE users SET name = ?, gender = ?, hobbies = ?, address = ? WHERE id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("ssssi", $name, $gender, $hobbies, $address, $id);
    }

    if ($stmt->execute()) {
        header("Location: entries.php"); // Redirect back to the entries list page
        exit();
    } else {
        echo "Database error: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}
?>

