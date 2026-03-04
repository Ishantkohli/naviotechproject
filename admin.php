
<?php
session_start();
include "db.php";

/* Protect Page */
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$userQuery = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'");
$currentUser = mysqli_fetch_assoc($userQuery);

if ($currentUser['role'] != 'admin') {
    header("Location: dashboard.php");
    exit();
}

/* Delete User */
if (isset($_GET['delete_user'])) {

    $delete_id = $_GET['delete_user'];

    mysqli_query($conn,"DELETE FROM users WHERE id='$delete_id'");
    mysqli_query($conn,"DELETE FROM tasks WHERE user_id='$delete_id'");

    header("Location: admin.php");
}

/* Fetch Data */
$users = mysqli_query($conn, "SELECT * FROM users");
$tasks = mysqli_query($conn, "
    SELECT tasks.*, users.name 
    FROM tasks 
    JOIN users ON tasks.user_id = users.id
");
/*Admin Stats*/
$totalUsers = mysqli_num_rows($users);
$totalTasks = mysqli_num_rows($tasks);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" href="dashboard.css">
</head>

<body class="dashboard-page">

<div class="navbar">
    <h2>Admin Panel</h2>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

<div class="dashboard-container">

    <h1>All Users</h1>

    <?php while ($row = mysqli_fetch_assoc($users)) { ?>
        <div class="task-card">
            <strong><?php echo $row['name']; ?></strong><br>
            <?php echo $row['email']; ?><br>
            Role: <?php echo $row['role']; ?>
        </div>
    <?php } ?>
    <br><br>
    <div class="stats-container">
    <div class="stat-card">
        <h3>Total Users</h3>
        <p><?php echo $totalUsers; ?></p>
    </div>
    <div class="stat-card">
        <h3>Total Tasks</h3>
        <p><?php echo $totalTasks; ?></p>
    </div>
</div>
    <h1>All Tasks</h1>

    <?php while ($task = mysqli_fetch_assoc($tasks)) { ?>
        <div class="task-card">
            <strong><?php echo $task['title']; ?></strong>
            <p><?php echo $task['description']; ?></p>
            <div class="task-meta">
                User: <?php echo $task['name']; ?> |
                Deadline: <?php echo $task['deadline']; ?> |
                Status: <?php echo $task['status']; ?>
            </div>
        </div>
    <?php } ?>

</div>

</body>
</html>