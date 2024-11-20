<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'bookstore_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch books from the database
$query = "SELECT * FROM books";
$result = $conn->query($query);

// Start HTML output
echo "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Bookstore</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #ff6ec7, #ff9a9e, #f1c4e1, #b5a2f3);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 0 20px;
        }

        header {
            background: rgba(255, 255, 255, 0.2);
            padding: 30px 50px;
            border-radius: 10px;
            text-align: center;
            margin-top: 50px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(8px);
            width: 100%;
            max-width: 1200px;
            color: #fff;
        }

        header h1 {
            font-size: 3.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .navbar {
            margin-top: 20px;
            text-align: center;
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 20px;
            font-size: 1.2rem;
            font-weight: bold;
            text-transform: uppercase;
            position: relative;
            transition: color 0.3s ease;
        }

        .navbar a:hover {
            color: #ff6ec7;
        }

        .navbar a:before {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #ff6ec7;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .navbar a:hover:before {
            transform: scaleX(1);
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin-top: 40px;
            padding-bottom: 40px;
        }

        .book-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 30px;
            padding: 0 20px;
        }

        .book-item {
            background-color: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .book-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .book-item h3 {
            font-size: 1.6rem;
            color: #4b0082;
            margin-bottom: 15px;
        }

        .book-item p {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 15px;
        }

        .book-item a {
            background-color: #ff6ec7;
            color: #fff;
            padding: 12px 25px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 1.2rem;
            transition: background-color 0.3s ease;
        }

        .book-item a:hover {
            background-color: #ff3a6f;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            color: #fff;
            font-size: 1rem;
            padding: 10px 0;
            background-color: rgba(0, 0, 0, 0.1);
            width: 100%;
        }

    </style>
</head>
<body>

    <header>
        <h1>Welcome to the Bookstore</h1>
        <div class='navbar'>
            <a href='cart.php'>View Cart</a>";
            
            // Check if the user is logged in
            if (isset($_SESSION['username'])) {
                // Show user-specific links
                if ($_SESSION['role'] == 'admin') {
                    echo "<a href='admin_index.php'>Admin Dashboard</a>";
                } else {
                    echo "<a href='customer_dashboard.php'>Customer Dashboard</a>";
                }
                // Logout link
                echo "<a href='logout.php'>Logout</a>";
            } else {
                // Login/Register links if not logged in
                echo "<a href='login.php'>Login</a>
                      <a href='register.php'>Register</a>";
            }

        echo "</div>
    </header>

    <div class='container'>
        <h2 style='text-align: center; color: #4b0082;'>Available Books</h2>
        <div class='book-list'>";

        // Display books from the database
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "
                <div class='book-item'>
                    <h3>" . htmlspecialchars($row['name']) . "</h3>
                    <p>Author: " . htmlspecialchars($row['author']) . "</p>
                    <p>Price: $" . htmlspecialchars($row['price']) . "</p>
                    <a href='cart.php?id=" . $row['id'] . "'>Add to Cart</a>
                </div>
                ";
            }
        } else {
            echo "<p style='text-align: center; color: #555;'>No books available at the moment.</p>";
        }

        echo "
        </div>
    </div>

    <div class='footer'>
        <p>&copy; 2024 Bookstore. All rights reserved.</p>
    </div>

</body>
</html>";

$conn->close();
?>
