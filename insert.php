<?php
include("dbconnect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $gender = $_POST["gender"];
    $dob = $_POST["dob"];
    $address = $_POST["address"];
    $selectedHobbies = $_POST["hobbies"];
    $hobbies = implode(", ", $selectedHobbies);

    // Now, $hobbies contains a string of selected hobbies that exist in the $hobbyOptions array
    

    $uploadDir = "profile_pics/";

    $profilePic = uniqid() . "_" . $_FILES["profilePic"]["name"];
    $profilePicPath = $uploadDir . $profilePic;
    if (move_uploaded_file($_FILES["profilePic"]["tmp_name"],  $profilePicPath)) {
        echo "Successfully inserted photo";
    }
    else{
        echo "ERROR";
    }
    // Use a prepared statement to insert data
    $sql = "INSERT INTO users (name, gender, dob, address, hobbies, profilePic) VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $gender, $dob, $address, $hobbies, $profilePic);

    if ($stmt->execute()) {
        header("Location: Entries.php");
        // You can redirect to a success page or perform other actions
    } else {
        echo "Database error: " . $stmt->error;
        // Handle the database error as needed
    }
}


?>
