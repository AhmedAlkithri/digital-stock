<?php
require_once 'config.php';  // Database connection

$response = [];

// Fetch total orders
$queryOrders = "SELECT COUNT(*) AS totalOrders FROM orders WHERE status = 'completed'";
$resultOrders = $conn->query($queryOrders);
$totalOrders = $resultOrders->fetch_assoc()['totalOrders'];

// Fetch total revenue
$queryRevenue = "SELECT SUM(total_amount) AS totalRevenue FROM orders WHERE status = 'completed'";
$resultRevenue = $conn->query($queryRevenue);
$totalRevenue = $resultRevenue->fetch_assoc()['totalRevenue'];

// Fetch monthly revenue data
$monthlyRevenueQuery = "
    SELECT MONTH(order_date) AS month, SUM(total_amount) AS revenue 
    FROM orders 
    WHERE YEAR(order_date) = YEAR(CURDATE()) AND status = 'completed'
    GROUP BY MONTH(order_date)";
$monthlyRevenueResult = $conn->query($monthlyRevenueQuery);
$revenueData = array_fill(1, 12, 0); // Default to 0 for all months

while ($row = $monthlyRevenueResult->fetch_assoc()) {
    $revenueData[(int)$row['month']] = (float)$row['revenue'];
}

// Fetch monthly order data
$monthlyOrderQuery = "
    SELECT MONTH(order_date) AS month, COUNT(*) AS orders 
    FROM orders 
    WHERE YEAR(order_date) = YEAR(CURDATE()) AND status = 'completed'
    GROUP BY MONTH(order_date)";
$monthlyOrderResult = $conn->query($monthlyOrderQuery);
$orderData = array_fill(1, 12, 0); // Default to 0 for all months

while ($row = $monthlyOrderResult->fetch_assoc()) {
    $orderData[(int)$row['month']] = (int)$row['orders'];
}

// Fetch recent activity
$recentActivityQuery = "
    SELECT activity, activity_date 
    FROM activity_log 
    ORDER BY activity_date DESC LIMIT 10";
$recentActivityResult = $conn->query($recentActivityQuery);
$recentActivity = [];

while ($row = $recentActivityResult->fetch_assoc()) {
    $recentActivity[] = [
        'activity' => $row['activity'],
        'date' => $row['activity_date']
    ];
}

// Compile the response data
$response = [
    'totalOrders' => $totalOrders,
    'totalRevenue' => $totalRevenue,
    'revenueData' => array_values($revenueData),
    'orderData' => array_values($orderData),
    'recentActivity' => $recentActivity
];

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
