<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'bookstore_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    header('Location: cart.php'); // Redirect to cart if empty
    exit;
}

// Handle the checkout form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $email = htmlspecialchars($_POST['email']);

    // Check if all fields are filled
    if (empty($name) || empty($address) || empty($email)) {
        $error_message = "Please fill out all fields.";
    } else {
        // Prepare the SQL statement for inserting the order
        $stmt = $conn->prepare("INSERT INTO orders (customer_name, customer_email, shipping_address) 
                                VALUES (?, ?, ?)");
        
        // Check if prepare() succeeded
        if ($stmt === false) {
            die('Error preparing the query: ' . $conn->error);
        }

        // Bind parameters to the query
        $stmt->bind_param("sss", $name, $email, $address); // 's' for strings

        // Execute the query
        if ($stmt->execute()) {
            $order_id = $stmt->insert_id; // Get the newly inserted order ID

            // Clear the cart after successful order
            unset($_SESSION['cart']);

            // Redirect to the confirmation page with the order ID
            header('Location: order_confirmation.php?id=' . $order_id);
            exit;
        } else {
            $error_message = "Error processing the order. Please try again.";
        }

        // Close the prepared statement
        $stmt->close();
    }
}

// Start HTML output
echo "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Checkout - Bookstore</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(to right, #ff9a9e, #f1c4e1, #ff6ec7);
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 15px;
            width: 80%;
            max-width: 1200px;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 30px;
            color: #ff6ec7;
        }

        .checkout-item {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .checkout-item h3 {
            color: #ff6ec7;
            font-size: 1.6rem;
        }

        .checkout-item p {
            color: #555;
            font-size: 1.2rem;
        }

        .checkout-form input, .checkout-form textarea {
            width: 100%;
            padding: 14px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .checkout-btn {
            background-color: #ff6ec7;
            color: #fff;
            padding: 14px 30px;
            font-size: 1.2rem;
            border-radius: 25px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: background-color 0.3s ease;
        }

        .checkout-btn:hover {
            background-color: #ff3a6f;
        }

        .error-message {
            color: #ff3a6f;
            font-size: 1.2rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 1rem;
            color: #ff6ec7;
        }
    </style>
</head>
<body>

    <div class='container'>
        <header>
            Checkout - Bookstore
        </header>

        <div class='checkout-item'>
            <h3>Enter Your Information</h3>";

            if (isset($error_message)) {
                echo "<p class='error-message'>$error_message</p>";
            }

            echo "
            <form method='POST'>
                <input type='text' name='name' placeholder='Full Name' required>
                <input type='email' name='email' placeholder='Email Address' required>
                <textarea name='address' rows='4' placeholder='Shipping Address' required></textarea>
                <button type='submit' class='checkout-btn'>Confirm Order</button>
            </form>
        </div>
    </div>

    <div class='footer'>
        <p>&copy; 2024 Bookstore. All rights reserved.</p>
    </div>

</body>
</html>";
?>
