<?php
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit;
}

require 'db.php';

$userId = $_SESSION['userId'];
$stmt = $conn->prepare("
    SELECT p.projectId, p.name, p.description
    FROM projects p
    JOIN projectMembership pm ON p.projectId = pm.projectId
    WHERE pm.memberId = ?
");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$projects = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #1e1e1e;
            color: #e0e0e0;
            margin: 0;
            padding: 20px;
        }
        h2, h3, h4 {
            color: #ffffff;
        }
        a {
            color: #00bfff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        .options, .projects-container {
            background-color: #2c2c2c;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
        }
        .project-card {
            background-color: #3c3c3c;
            border: 1px solid #555;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .project-card:hover {
            transform: scale(1.02);
            box-shadow: 0 0 20px rgba(0,0,0,0.7);
        }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($_SESSION['firstName']); ?>!</h2>

    <div class="options">
        <h3>Options</h3>
        <ul>
            <li><a href="projects.php">Add / View Projects</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="projects-container">
        <h3>Your Projects</h3>
        <?php if (count($projects) > 0): ?>
            <?php foreach($projects as $proj): ?>
                <div class="project-card">
                    <h4><?php echo htmlspecialchars($proj['name']); ?></h4>
                    <p><?php echo htmlspecialchars($proj['description']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>You have no projects yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>
