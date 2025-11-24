<?php
require 'db.php';

$error = '';
$success = '';
$newProjectId = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $members = $_POST['members'] ?? [];

    if (count($members) < 3) {
        $error = "Please select at least 3 members for the project.";
    } else {
        $stmt = $conn->prepare("SELECT projectId FROM projects WHERE name = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "A project with this name already exists!";
        } else {
            $stmt = $conn->prepare("INSERT INTO projects (name, description) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $description);
            $stmt->execute();
            $newProjectId = $stmt->insert_id;

            $stmtMember = $conn->prepare("INSERT INTO projectMembership (projectId, memberId) VALUES (?, ?)");
            foreach ($members as $memberId) {
                $stmtMember->bind_param("ii", $newProjectId, $memberId);
                $stmtMember->execute();
            }

            $success = "Project '$name' added successfully!";
        }
    }
}

// Get users
$usersResult = $conn->query("SELECT userId, firstName, lastName FROM users ORDER BY firstName");

// Get projects with members
$projectsResult = $conn->query("
    SELECT p.projectId, p.name, p.description, u.firstName, u.lastName
    FROM projects p
    JOIN projectMembership pm ON p.projectId = pm.projectId
    JOIN users u ON pm.memberId = u.userId
    ORDER BY p.projectId DESC
");
$projects = [];
while ($row = $projectsResult->fetch_assoc()) {
    $projects[$row['projectId']]['name'] = $row['name'];
    $projects[$row['projectId']]['description'] = $row['description'];
    $projects[$row['projectId']]['members'][] = $row['firstName'] . ' ' . $row['lastName'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Project</title>
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
        .form-container, .projects-container {
            background-color: #2c2c2c;
            padding: 20px;
            margin-bottom: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.5);
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 8px;
            margin-top: 4px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #555;
            background-color: #3c3c3c;
            color: #f0f0f0;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #0078d7;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #005a9e;
        }
        .error { color: #ff6b6b; }
        .success { color: #4ef04e; }

        .checkbox-group input[type="checkbox"] {
            margin-right: 8px;
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
        .highlight {
            border-color: #4ef04e;
            background-color: #2f4f2f;
        }
        .members-list {
            margin-left: 20px;
            list-style-type: disc;
        }
        label { display: block; margin-top: 5px; }
    </style>
</head>
<body>
<div class="form-container">
    <h2>Add Project</h2>
    <?php if($error) echo "<p class='error'>$error</p>"; ?>
    <?php if($success) echo "<p class='success'>$success</p>"; ?>

    <form method="post" action="">
        <label>Name:</label>
        <input type="text" name="name" required>

        <label>Description:</label>
        <textarea name="description" rows="4"></textarea>

        <label>Members (select at least 3):</label>
        <div class="checkbox-group">
            <?php while($user = $usersResult->fetch_assoc()): ?>
                <input type="checkbox" name="members[]" value="<?= $user['userId'] ?>">
                <?= htmlspecialchars($user['firstName'] . ' ' . $user['lastName']) ?><br>
            <?php endwhile; ?>
        </div>

        <br>
        <input type="submit" value="Add Project">
    </form>
</div>

<div class="projects-container">
    <h3>Existing Projects</h3>
    <?php foreach ($projects as $pid => $proj): ?>
        <?php $class = ($pid == $newProjectId) ? "project-card highlight" : "project-card"; ?>
        <div class="<?= $class ?>">
            <h4><?= htmlspecialchars($proj['name']) ?></h4>
            <p><?= htmlspecialchars($proj['description']) ?></p>
            <strong>Members:</strong>
            <ul class="members-list">
                <?php foreach ($proj['members'] as $m): ?>
                    <li><?= htmlspecialchars($m) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
