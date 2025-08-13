<?php
// Connect to DB
$host = "localhost";
$user = "root"; // change if different
$password = ""; // change if your DB has a password
$db = "testDev";

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create
if (isset($_POST['create'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $stmt = $conn->prepare("INSERT INTO test1 (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);
    $stmt->execute();
    $stmt->close();
}

// Delete
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM test1 WHERE id=$id");
}

// Get all users
$users = $conn->query("SELECT * FROM test1");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple User CRUD</title>
    <style>
        body { font-family: Arial; margin: 40px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background: #f0f0f0; }
        form input { padding: 8px; margin: 5px; width: 200px; }
        form button { padding: 8px 16px; background: green; color: white; border: none; cursor: pointer; }
        .delete-btn { background: red; color: white; text-decoration: none; padding: 6px 10px; }
    </style>
</head>
<body>

<h2>Add User</h2>
<form method="post">
    <input type="text" name="username" placeholder="Username" required />
    <input type="email" name="email" placeholder="Email" required />
    <input type="password" name="password" placeholder="Password" required />
    <button type="submit" name="create">Add User</button>
</form>

<h2>All Users</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Password</th>
        <th>Action</th>
    </tr>
    <?php while ($row = $users->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($row['id']) ?></td>
        <td><?= htmlspecialchars($row['username']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['password']) ?></td>
        <td><a class="delete-btn" href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
