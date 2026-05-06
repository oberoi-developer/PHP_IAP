<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background: #eef2f3; 
            display: flex; 
            justify-content: center; 
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .form-container { 
            background: white; 
            padding: 40px; 
            border-radius: 12px; 
            box-shadow: 0 8px 30px rgba(0,0,0,0.1); 
            width: 100%;
            max-width: 400px; 
        }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 25px; }
        label { font-size: 0.9em; color: #7f8c8d; margin-bottom: 5px; display: block; }
        input, select { 
            width: 100%; 
            padding: 12px; 
            margin-bottom: 20px; 
            border: 1px solid #dcdde1; 
            border-radius: 6px; 
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        input:focus { border-color: #3498db; outline: none; }
        button { 
            width: 100%; 
            padding: 14px; 
            background: #2ecc71; 
            border: none; 
            color: white; 
            font-size: 16px; 
            font-weight: bold;
            cursor: pointer; 
            border-radius: 6px; 
            transition: background 0.3s;
        }
        button:hover { background: #27ae60; }
        .link { 
            display: block; 
            text-align: center; 
            margin-top: 20px; 
            color: #3498db; 
            text-decoration: none; 
            font-size: 0.9em;
        }
        .link:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Student Registration</h2>
    <form id="regForm" action="process.php" method="POST">
        <label>Full Name</label>
        <input type="text" name="fullname" placeholder="John Doe" required>
        
        <label>Email Address</label>
        <input type="email" name="email" placeholder="john@example.com" required>
        
        <label>Select Course</label>
        <select name="course">
            <option value="Software Development">Software Development</option>
            <option value="Networking">Networking</option>
            <option value="Digital Media">Digital Media</option>
            <option value="Cyber Security">Cyber Security</option>
        </select>
        
        <button type="submit" name="register">Register Now</button>
    </form>
    <a href="dashboard.php" class="link">View Registered Students</a>
</div>

<script>
    document.getElementById('regForm').onsubmit = function(e) {
        const email = document.querySelector('input[type="email"]').value;
        if (!email.includes('@')) {
            alert("Please enter a valid email address.");
            e.preventDefault();
            return false;
        }
        return true;
    };
</script>

</body>
</html>