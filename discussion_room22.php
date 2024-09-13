<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$errors = [];
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $is_private = isset($_POST['is_private']) ? 1 : 0;
    $passcode = $is_private ? trim($_POST['passcode']) : null;
    $max_participants = $_POST['max_participants'];

    // Create new discussion room
    $stmt = $conn->prepare("INSERT INTO discussions (title, description, created_by, passcode, is_private, max_participants) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiisi", $title, $description, $_SESSION['user_id'], $passcode, $is_private, $max_participants);
    
    if ($stmt->execute()) {
        $success_message = "Discussion room created successfully!";
    } else {
        $errors[] = "Failed to create discussion room.";
    }
}

// Fetch existing discussions
$discussion_stmt = $conn->prepare("SELECT * FROM discussions WHERE is_private = 0 OR (is_private = 1 AND passcode IS NOT NULL)");
$discussion_stmt->execute();
$discussions = $discussion_stmt->get_result();

include 'dashboard_header.php';
?>

<div class="discussion-container">
    <h2>Discussion Rooms</h2>
    
    <?php if ($success_message): ?>
        <p class="success"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <form method="POST" action="discussion_room.php">
        <label for="title">Discussion Title</label>
        <input type="text" name="title" id="title" required>

        <label for="description">Description</label>
        <textarea name="description" id="description"></textarea>

        <label for="max_participants">Max Participants (up to 250)</label>
        <input type="number" name="max_participants" id="max_participants" max="250" value="250" required>

        <label for="is_private">
            <input type="checkbox" name="is_private" id="is_private"> Private Discussion
        </label>

        <div id="passcode-section" style="display: none;">
            <label for="passcode">Passcode (Required for private discussions)</label>
            <input type="text" name="passcode" id="passcode">
        </div>

        <button type="submit">Create Discussion</button>
    </form>

    <h3>Available Discussions</h3>
    <ul>
        <?php while ($discussion = $discussions->fetch_assoc()): ?>
            <li>
                <a href="join_discussion.php?id=<?php echo $discussion['id']; ?>">
                    <?php echo htmlspecialchars($discussion['title']); ?>
                </a>
                <?php if ($discussion['is_private']): ?>
                    <span>(Private, requires passcode)</span>
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
    </ul>
</div>

<script>
document.getElementById('is_private').addEventListener('change', function() {
    document.getElementById('passcode-section').style.display = this.checked ? 'block' : 'none';
});
</script>

<?php include 'dashboard_footer.php'; ?>

<!-- CSS -->
<style>
    .discussion-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 20px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }
    .success { color: green; }
    form {
        margin-bottom: 20px;
    }
    label {
        font-size: 1.1em;
        margin-bottom: 10px;
    }
    input, textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 6px;
        margin-bottom: 20px;
    }
    button {
        background-color: #007bff;
        color: #fff;
        padding: 12px 20px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
    }
    button:hover {
        background-color: #0056b3;
    }
</style>
