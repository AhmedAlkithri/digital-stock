<?php include 'dashboard_header.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders - Pending and Verified</title>
    <link rel="stylesheet" href="styles.css"> <!-- External CSS for better organization -->
    <style>
        /* General Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f6f7;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Header Styles */
        header {
            background: linear-gradient(to right, #28a745, #218838);
            color: #fff;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo img {
            height: 60px;
            transition: transform 0.3s;
        }

        .logo img:hover {
            transform: scale(1.1);
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            gap: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        nav ul li a:hover {
            background-color: #218838;
            color: #fff;
        }

        /* Orders Page Styles */
        .orders-container {
            padding: 30px;
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            margin: 20px;
        }

        .orders-container h2 {
            margin-bottom: 20px;
            color: #28a745;
        }

        .order-section {
            margin-bottom: 40px;
        }

        .order-header {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            margin: 0;
            transition: background-color 0.3s;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .order-header:hover {
            background-color: #ced4da;
        }

        .order-details {
            display: none;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
            margin-top: 10px;
        }

        .order-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 10px;
        }

        .order-actions button {
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .order-actions .approve {
            background-color: #28a745;
            color: #fff;
        }

        .order-actions .approve:hover {
            background-color: #218838;
        }

        .order-actions .reject {
            background-color: #dc3545;
            color: #fff;
        }

        .order-actions .reject:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <!-- Orders Page Content -->
    <div class="orders-container">
        <!-- Pending Orders Section -->
        <div class="order-section">
            <h2>Pending Orders</h2>

            <!-- Example Order 1 -->
            <div class="order-header">
                <span>Order #12345</span>
                <span>5 items - $500</span>
            </div>
            <div class="order-details">
                <p><strong>Customer:</strong> John Doe</p>
                <p><strong>Date:</strong> September 5, 2024</p>
                <p><strong>Status:</strong> Pending</p>
                <p><strong>Items:</strong> Product A (2), Product B (3)</p>
                <div class="order-actions">
                    <button class="approve">Approve</button>
                    <button class="reject">Reject</button>
                </div>
            </div>

            <!-- Example Order 2 -->
            <div class="order-header">
                <span>Order #12346</span>
                <span>3 items - $300</span>
            </div>
            <div class="order-details">
                <p><strong>Customer:</strong> Jane Smith</p>
                <p><strong>Date:</strong> September 4, 2024</p>
                <p><strong>Status:</strong> Pending</p>
                <p><strong>Items:</strong> Product C (1), Product D (2)</p>
                <div class="order-actions">
                    <button class="approve">Approve</button>
                    <button class="reject">Reject</button>
                </div>
            </div>
        </div>

        <!-- Verified Orders Section -->
        <div class="order-section">
            <h2>Verified Orders</h2>

            <!-- Example Order 3 -->
            <div class="order-header">
                <span>Order #12347</span>
                <span>7 items - $700</span>
            </div>
            <div class="order-details">
                <p><strong>Customer:</strong> Mike Johnson</p>
                <p><strong>Date:</strong> September 2, 2024</p>
                <p><strong>Status:</strong> Verified</p>
                <p><strong>Items:</strong> Product E (4), Product F (3)</p>
            </div>

            <!-- Example Order 4 -->
            <div class="order-header">
                <span>Order #12348</span>
                <span>2 items - $200</span>
            </div>
            <div class="order-details">
                <p><strong>Customer:</strong> Alice Williams</p>
                <p><strong>Date:</strong> September 1, 2024</p>
                <p><strong>Status:</strong> Verified</p>
                <p><strong>Items:</strong> Product G (1), Product H (1)</p>
            </div>
        </div>
    </div>

    <script>
        // Toggle Order Details
        document.querySelectorAll('.order-header').forEach(header => {
            header.addEventListener('click', () => {
                const details = header.nextElementSibling;
                details.style.display = details.style.display === 'block' ? 'none' : 'block';
            });
        });

        // Approve and Reject Order Actions
        document.querySelectorAll('.approve').forEach(button => {
            button.addEventListener('click', () => {
                alert('Order approved!');
                // Additional logic to handle order approval
            });
        });

        document.querySelectorAll('.reject').forEach(button => {
            button.addEventListener('click', () => {
                alert('Order rejected!');
                // Additional logic to handle order rejection
            });
        });
    </script>
</body>
</html>
