<?php
// Initialize variables for form data
$first_name = '';
$last_name = '';
$email = '';
$mobile = '';
$errors = [];
$submitted = false;

// Handle form submission (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : '';

    // Basic validation
    if (empty($first_name)) {
        $errors[] = 'First name is required.';
    }
    if (empty($last_name)) {
        $errors[] = 'Last name is required.';
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Valid email is required.';
    }
    if (empty($mobile) || !preg_match('/^[0-9]{10}$/', $mobile)) {
        $errors[] = 'Valid 10-digit mobile number is required.';
    }

    // If no errors, mark as submitted
    if (empty($errors)) {
        $submitted = true;
        // Sanitize inputs for display
        $first_name = htmlspecialchars($first_name);
        $last_name = htmlspecialchars($last_name);
        $email = htmlspecialchars($email);
        $mobile = htmlspecialchars($mobile);
    }
}

// Dynamic content
$current_time = date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="https://static.vecteezy.com/system/resources/previews/015/153/047/original/world-wide-web-icon-design-for-web-interfaces-and-applications-png.png" type="image/png">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .form-container {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            margin: 20px;
        }
        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 20px;
            font-size: 28px;
            font-weight: 600;
        }
        p {
            color: #34495e;
            font-size: 16px;
            text-align: center;
            margin-bottom: 15px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            color: #2c3e50;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        input:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.3);
        }
        button {
            width: 100%;
            padding: 12px;
            background: #3498db;
            border: none;
            border-radius: 6px;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        button:hover {
            background: #2980b9;
        }
        .error {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 10px;
            text-align: left;
        }
        .error ul {
            list-style: none;
        }
        .details {
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #e0e0e0;
        }
        .details h3 {
            color: #2c3e50;
            font-size: 20px;
            margin-bottom: 15px;
        }
        .details p {
            font-size: 15px;
            color: #34495e;
            margin: 8px 0;
            text-align: left;
        }
        .details p strong {
            color: #2c3e50;
        }
        .php-version {
            margin-top: 20px;
            font-size: 14px;
            color: #7f8c8d;
        }
        @media (max-width: 600px) {
            .form-container {
                padding: 20px;
            }
            h1 {
                font-size: 24px;
            }
            input, button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>User Registration Form</h1>
        <p>Current Server Time: <?php echo $current_time; ?></p>
        <form method="POST">
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" placeholder="Enter first name" value="<?php echo $first_name; ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" placeholder="Enter last name" value="<?php echo $last_name; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter email" value="<?php echo $email; ?>">
            </div>
            <div class="form-group">
                <label for="mobile">Mobile Number</label>
                <input type="tel" id="mobile" name="mobile" placeholder="Enter 10-digit mobile" pattern="[0-9]{10}" inputmode="numeric" value="<?php echo $mobile; ?>">
            </div>
            <button type="submit">Submit</button>
        </form>

        <?php if (!empty($errors)): ?>
            <div class="error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if ($submitted): ?>
            <div class="details">
                <h3>Submitted Details</h3>
                <p><strong>First Name:</strong> <?php echo $first_name; ?></p>
                <p><strong>Last Name:</strong> <?php echo $last_name; ?></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
                <p><strong>Mobile Number:</strong> <?php echo $mobile; ?></p>
            </div>
        <?php endif; ?>

        <p class="php-version">Running on PHP version: <?php echo phpversion(); ?></p>
    </div>
</body>
</html>