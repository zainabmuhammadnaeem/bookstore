<?php
session_start();

// Database connection
$conn = new mysqli('localhost', 'root', '', 'bookstore_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize the cart if it's not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add book to cart
if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Check if the book is already in the cart
    if (array_key_exists($book_id, $_SESSION['cart'])) {
        $_SESSION['cart'][$book_id]++;
    } else {
        $_SESSION['cart'][$book_id] = 1;
    }
}

// Get books in cart
$cart_items = [];
$total_price = 0;

if (count($_SESSION['cart']) > 0) {
    foreach ($_SESSION['cart'] as $book_id => $quantity) {
        $query = "SELECT * FROM books WHERE id = $book_id";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $cart_items[] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'author' => $row['author'],
                'price' => $row['price'],
                'quantity' => $quantity
            ];
            $total_price += $row['price'] * $quantity;
        }
    }
}

// Start HTML output
echo "
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Cart - Bookstore</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #f1c4e1, #ff6ec7, #ff9a9e);
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
            font-size: 3rem;
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

        .cart-container {
            width: 100%;
            max-width: 1200px;
            margin-top: 40px;
            padding-bottom: 40px;
        }

        .cart-item {
            background-color: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-item h3 {
            font-size: 1.5rem;
            color: #4b0082;
        }

        .cart-item p {
            font-size: 1.1rem;
            color: #555;
        }

        .total {
            font-size: 1.6rem;
            color: #4b0082;
            text-align: right;
            margin-top: 30px;
        }

        .checkout-btn {
            background-color: #ff6ec7;
            color: #fff;
            padding: 12px 25px;
            border-radius: 30px;
            font-size: 1.2rem;
            text-decoration: none;
            text-align: center;
            display: block;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .checkout-btn:hover {
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
        <h1>Your Shopping Cart</h1>
        <div class='navbar'>
            <a href='index.php'>Back to Shop</a>
            <a href='logout.php'>Logout</a>
        </div>
    </header>

    <div class='cart-container'>
        <h2 style='text-align: center; color: #4b0082;'>Items in your cart</h2>";

        if (count($cart_items) > 0) {
            foreach ($cart_items as $item) {
                echo "
                <div class='cart-item'>
                    <div>
                        <h3>" . htmlspecialchars($item['name']) . "</h3>
                        <p>Author: " . htmlspecialchars($item['author']) . "</p>
                        <p>Price: $" . htmlspecialchars($item['price']) . "</p>
                    </div>
                    <div>
                        <p>Quantity: " . $item['quantity'] . "</p>
                        <p>Total: $" . ($item['price'] * $item['quantity']) . "</p>
                    </div>
                </div>
                ";
            }

            echo "
            <div class='total'>
                <p><strong>Total Price: $" . $total_price . "</strong></p>
            </div>
            <a href='checkout.php' class='checkout-btn'>Proceed to Checkout</a>";

        } else {
            echo "<p style='text-align: center; color: #555;'>Your cart is empty.</p>";
        }

    echo "
    </div>

    <div class='footer'>
        <p>&copy; 2024 Bookstore. All rights reserved.</p>
    </div>

</body>
</html>";

$conn->close();
?>
