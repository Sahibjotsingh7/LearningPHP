<?php
// DB config
$host = "localhost";
$user = "root";
$pass = "";
$db = "testDev";

// Connect
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Create table if not exists
$conn->query("
    CREATE TABLE IF NOT EXISTS todo (
        id INT AUTO_INCREMENT PRIMARY KEY,
        task VARCHAR(255) NOT NULL,
        iscompleted BOOLEAN DEFAULT 0
    )
");

// Add task
if (isset($_POST['add'])) {
    $task = trim($_POST['task']);
    if ($task != "") {
        $stmt = $conn->prepare("INSERT INTO todo (task) VALUES (?)");
        $stmt->bind_param("s", $task);
        $stmt->execute();
    }
}

// Delete task
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM todo WHERE id = $id");
}

// Toggle completion
if (isset($_POST['toggle'])) {
    $id = $_POST['toggle'];
    $conn->query("UPDATE todo SET iscompleted = NOT iscompleted WHERE id = $id");
}

// Fetch tasks
$result = $conn->query("SELECT * FROM todo ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP To-Do List</title>
    <style>
        body { font-family: Arial; background: #f2f2f2; text-align: center; margin-top: 50px; }
        form { margin-bottom: 20px; }
        input[type="text"] { padding: 10px; width: 250px; }
        button { padding: 10px; background-color: #0581d4ff;  }
        ul { list-style: none; padding: 0; max-width: 400px; margin: auto; }
        li { background: #fff; margin: 5px 0; padding: 10px; border-radius: 5px; display: flex; justify-content: space-between; align-items: center; }
        .done { text-decoration: line-through; color: gray; }
    </style>
</head>
<body>

<h1>📝 My To-Do List</h1>

<form method="POST">
    <input type="text" name="task" placeholder="Enter task..." required>
    <button type="submit" name="add">Add Task</button>
</form>

<ul>
<?php while ($row = $result->fetch_assoc()): ?>
    <li>
        <form method="POST" style="display:inline;">
            <input type="hidden" name="toggle" value="<?= $row['id'] ?>">
            <input type="checkbox" onchange="this.form.submit()" <?= $row['iscompleted'] ? 'checked' : '' ?>>
        </form>

        <span class="<?= $row['iscompleted'] ? 'done' : '' ?>">
            <?= htmlspecialchars($row['task']) ?>
        </span>

        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this task?')">🗑️</a>
    </li>
<?php endwhile; ?>
</ul>

</body>
</html>
