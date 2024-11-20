<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            background: linear-gradient(to right, pink, purple);
            font-family: Arial, sans-serif;
            text-align: center;
            color: white;
            margin: 0;
            padding: 0;
        }
        .container {
            margin-top: 15%;
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 15px;
            display: inline-block;
        }
        input, button {
            padding: 10px;
            border: none;
            margin: 10px 0;
            border-radius: 10px;
            width: 80%;
        }
        input {
            background: rgba(255, 255, 255, 0.8);
            color: #333;
        }
        button {
            background: purple;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background: pink;
            color: purple;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="process_login.php" method="post">
            <input type="email" name="email" placeholder="Enter Email" required><br>
            <input type="password" name="password" placeholder="Enter Password" required><br>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>

