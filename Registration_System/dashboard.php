<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "student_db";

$conn = new mysqli($host, $user, $pass, $db);
$result = $conn->query("SELECT * FROM students ORDER BY reg_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f8f9fa; padding: 50px; margin: 0; }
        .container { max-width: 900px; margin: auto; }
        .header-box { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        h2 { color: #2c3e50; margin: 0; }
        .dashboard-table { 
            width: 100%; 
            border-collapse: collapse; 
            background: white; 
            border-radius: 10px; 
            overflow: hidden; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.05); 
        }
        th, td { padding: 18px; text-align: left; border-bottom: 1px solid #eee; }
        th { background-color: #34495e; color: white; text-transform: uppercase; font-size: 0.85em; letter-spacing: 1px; }
        tr:hover { background-color: #fcfcfc; }
        .btn-add { 
            text-decoration: none; 
            background: #3498db; 
            color: white; 
            padding: 10px 20px; 
            border-radius: 5px; 
            font-weight: bold;
            font-size: 0.9em;
        }
        .btn-add:hover { background: #2980b9; }
        .status-msg { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-size: 0.9em; }
    </style>
</head>
<body>

    <div class="container">
        <div class="header-box">
            <h2>Registered Students</h2>
            <a href="index.php" class="btn-add">+ New Registration</a>
        </div>

        <?php if(isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <div class="status-msg">Student registered successfully!</div>
        <?php endif; ?>

        <table class="dashboard-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?php echo $row['id']; ?></td>
                        <td><strong><?php echo $row['fullname']; ?></strong></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['course']; ?></td>
                        <td><?php echo date('M d, Y', strtotime($row['reg_date'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="5" style="text-align:center;">No students registered yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
<?php $conn->close(); ?>