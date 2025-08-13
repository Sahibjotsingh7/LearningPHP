<?php

// Initialize variables
$fname = $lname = $fullname = $email = $mobile = $gender = $nationality = $education = $intro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $gender = $_POST['gender'];
    $nationality = $_POST['nationality'];
    $education = $_POST['study'];
    $intro = $_POST['intro'];

    $userData = [
        "fname" => $fname,
        "lname" => $lname,
        "email" => $email,
        "mobile" => $mobile,
        "gender" => $gender,
        "nationality" => $nationality,
        "education" => $education,
        "intro" => $intro,
        "datetime" => date("Y-m-d H:i:s")
    ];

    // Path to user JSON file
    $file = 'user.json';

    // If file doesn't exist, create an empty array
    if (!file_exists($file)) {
        file_put_contents($file, json_encode([]));
    }

    // Read existing users from file
    $existingData = json_decode(file_get_contents($file), true);

    // Check for duplicate mobile number
    $userExists = false;
    foreach ($existingData as $user) {
        if ($user['mobile'] === $mobile) {
            $userExists = true;
            break;
        }
    }

    if ($userExists) {
        echo "<h3>User with mobile number $mobile already exists.</h3>";
    } else {
        // Add new user to array
        $existingData[] = $userData;

        // Save back to file
        file_put_contents($file, json_encode($existingData, JSON_PRETTY_PRINT));

        echo "Welcome <h1>$fname $lname</h1> to our Website<br>";
        echo "User data saved successfully at " . date('Y/m/d H:i:s');
    }
}
?>
