<?php
session_start();
include "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* ADD TASK */
if (isset($_POST['add_task'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $deadline = $_POST['deadline'];

    mysqli_query($conn, "INSERT INTO tasks (user_id, title, description, deadline)
                         VALUES ('$user_id', '$title', '$description', '$deadline')");
}

/* DELETE TASK */
if (isset($_GET['delete'])) {
    $task_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM tasks WHERE id='$task_id' AND user_id='$user_id'");
}

/* COMPLETE TASK */
if (isset($_GET['complete'])) {

    $task_id = $_GET['complete'];

    mysqli_query($conn,
        "UPDATE tasks 
         SET status='Completed' 
         WHERE id='$task_id' 
         AND user_id='$user_id'"
    );
}

/* FETCH TASKS */
$tasks = mysqli_query($conn, "SELECT * FROM tasks WHERE user_id='$user_id' ORDER BY created_at DESC");
$totalTasks = mysqli_num_rows($tasks);

$completedTasksQuery = mysqli_query($conn,
"SELECT * FROM tasks WHERE user_id='$user_id' AND status='Completed'");
$completedTasks = mysqli_num_rows($completedTasksQuery);

$pendingTasksQuery = mysqli_query($conn,
"SELECT * FROM tasks WHERE user_id='$user_id' AND status='Pending'");
$pendingTasks = mysqli_num_rows($pendingTasksQuery);

$user_result = mysqli_query($conn, "SELECT name FROM users WHERE id='$user_id'");
$user = mysqli_fetch_assoc($user_result);
?>


<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>

<body class="dashboard-page">

<div class="navbar">
    <h2>Task Manager</h2>
    <a href="logout.php">Logout</a>
</div>

<div class="dashboard-container">
<div class="welcome-card">
    <h1>Welcome, <?php echo $user['name']; ?> 👋</h1>
    <p>Manage your tasks efficiently.</p>
</div>
<div class="stats-container">

<div class="stat-card">
<h3>Total Tasks</h3>
<p><?php echo $totalTasks; ?></p>
</div>

<div class="stat-card">
<h3>Completed</h3>
<p><?php echo $completedTasks; ?></p>
</div>

<div class="stat-card">
<h3>Pending</h3>
<p><?php echo $pendingTasks; ?></p>
</div>

</div>

<!-- Add Task Form -->
<div class="task-card">
    <h3>Add New Task</h3>
    <form method="POST">
        <input type="text" name="title" placeholder="Task Title" required><br><br>
        <textarea name="description" placeholder="Task Description" required></textarea><br><br>
        <input type="date" name="deadline" required><br><br>
        <button type="submit" name="add_task">Add Task</button>
    </form>
</div>

<!-- Display Tasks -->
<?php while ($row = mysqli_fetch_assoc($tasks)) { ?>
    <div class="task-card">
        <h3><?php echo $row['title']; ?></h3>
        <p><?php echo $row['description']; ?></p>
        <div class="task-meta">
            Deadline: <?php echo $row['deadline']; ?> |
            <span class="status <?php echo strtolower($row['status']); ?>">
            <?php echo $row['status']; ?>
</span>
        </div>
        <br>
        <a href="?complete=<?php echo $row['id']; ?>" 
        style="color:green; text-decoration:none;">Complete</a>
        <a href="?delete=<?php echo $row['id']; ?>" 
           style="color:red; text-decoration:none;">Delete</a>
    </div>
<?php } ?>