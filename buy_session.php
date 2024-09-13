#### **`buy_session.php`**:

```php
<?php
session_start();
require_once 'config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$errors = [];
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = trim($_POST['product_name']);
    $quantity = trim($_POST['quantity']);
    $proposed_price = trim($_POST['proposed_price']);
    
    if (empty($product_name) || empty($quantity) || empty($proposed_price)) {
        $errors[] = "All fields are required.";
    } else {
        // Insert the buy request into the database
        $stmt = $conn->prepare("INSERT INTO product_requests (user_id, product_name, quantity, proposed_price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isid", $_SESSION['user_id'], $product_name, $quantity, $proposed_price);

        if ($stmt->execute()) {
            $success_message = "Product request posted successfully!";
        } else {
            $errors[] = "Failed to post the product request.";
        }

        $stmt->close();
    }
}

// Fetch all buy requests
$stmt = $conn->prepare("SELECT pr.*, u.username FROM product_requests pr JOIN users u ON pr.user_id = u.id WHERE pr.status = 'pending'");
$stmt->execute();
$buy_requests = $stmt->get_result();

include 'partials/header.php';
?>

<div class="market-session">
    <h2>Buy Session - Product Requests</h2>

    <?php if ($success_message): ?>
        <p class="success"><?php echo $success_message; ?></p>
    <?php elseif (!empty($errors)): ?>
        <div class="error-messages">
            <?php foreach ($errors as $error): ?>
                <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="buy_session.php">
        <label for="product_name">Product Name</label>
        <input type="text" name="product_name" id="product_name" required>

        <label for="quantity">Quantity</label>
        <input type="number" name="quantity" id="quantity" required>

        <label for="proposed_price">Proposed Price</label>
        <input type="text" name="proposed_price" id="proposed_price" required>

        <button type="submit">Post Request</button>
    </form>

    <h3>Available Product Requests</h3>
    <ul class="product-requests-list">
        <?php while ($request = $buy_requests->fetch_assoc()): ?>
            <li>
                <strong><?php echo htmlspecialchars($request['product_name']); ?></strong> 
                - Quantity: <?php echo htmlspecialchars($request['quantity']); ?>
                - Proposed Price: $<?php echo htmlspecialchars($request['proposed_price']); ?>
                - Posted by: <?php echo htmlspecialchars($request['username']); ?>
                <a href="add_to_cart.php?request_id=<?php echo $request['id']; ?>" class="btn">Add to Cart</a>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

<?php include 'partials/footer.php'; ?>

<!-- CSS -->
<style>
    .market-session {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }
    .success { color: green; }
    .error-messages { color: red; }
    form { margin-bottom: 30px; }
    label { font-size: 1.1em; }
    input, button {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border-radius: 6px;
    }
    button {
        background-color: #4CAF50;
        color: #fff;
        border: none;
        cursor: pointer;
    }
    .product-requests-list li {
        margin-bottom: 15px;
    }
    .btn {
        background-color: #007bff;
        color: #fff;
        padding: 10px;
        text-decoration: none;
        border-radius: 6px;
    }
</style>
