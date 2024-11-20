<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thank You!</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background: rgba(255, 255, 255, 0.9);
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            text-align: center;
            animation: fadeIn 1.5s ease-in-out;
        }

        .container h1 {
            color: #ff6ec7;
            font-size: 2.5rem;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .container p {
            font-size: 1.1rem;
            margin-bottom: 30px;
            color: #555;
        }

        .back-btn {
            background: linear-gradient(90deg, #ff6ec7, #ffa9d7);
            color: white;
            padding: 15px 35px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            transition: all 0.4s ease;
            display: inline-block;
        }

        .back-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(255, 110, 199, 0.6);
        }

        .footer {
            margin-top: 30px;
            font-size: 0.9rem;
            color: #ff6ec7;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <h1>Thank You for Your Order!</h1>
        <p>Your order has been successfully placed. We will send you an email with the order details soon.</p>
        <a href="index.php" class="back-btn">Back to Home</a>
    </div>

    <div class="footer">
        <p>&copy; 2024 Bookstore. All rights reserved.</p>
    </div>

</body>
</html>
