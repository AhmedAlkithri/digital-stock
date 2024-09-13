<?php
// functions.php

// Include database configuration
include('configss.php');

// Function to fetch discussion details by ID
function getDiscussionDetails($discussion_id) {
    global $pdo;
    
    // Prepare and execute query
    $stmt = $pdo->prepare("SELECT * FROM discussions WHERE id = :id");
    $stmt->bindParam(':id', $discussion_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch and return result
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to check if a user is already in a discussion
function isUserInDiscussion($user_id, $discussion_id) {
    global $pdo;
    
    // Prepare and execute query
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM discussion_members WHERE user_id = :user_id AND discussion_id = :discussion_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':discussion_id', $discussion_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Check if the user is already a member
    return $stmt->fetchColumn() > 0;
}

// Function to add a user to a discussion
function joinDiscussion($user_id, $discussion_id) {
    global $pdo;
    
    // Prepare and execute query
    $stmt = $pdo->prepare("INSERT INTO discussion_members (user_id, discussion_id) VALUES (:user_id, :discussion_id)");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':discussion_id', $discussion_id, PDO::PARAM_INT);
    
    // Execute and return result
    return $stmt->execute();
}

// Function to remove a user from a discussion
function leaveDiscussion($user_id, $discussion_id) {
    global $pdo;
    
    // Prepare and execute query
    $stmt = $pdo->prepare("DELETE FROM discussion_members WHERE user_id = :user_id AND discussion_id = :discussion_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':discussion_id', $discussion_id, PDO::PARAM_INT);
    
    // Execute and return result
    return $stmt->execute();
}

// Function to get a list of discussions a user is part of
function getUserDiscussions($user_id) {
    global $pdo;
    
    // Prepare and execute query
    $stmt = $pdo->prepare("SELECT discussions.* FROM discussions
                           JOIN discussion_members ON discussions.id = discussion_members.discussion_id
                           WHERE discussion_members.user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Fetch and return results
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to create a new discussion
function createDiscussion($title, $description, $creator_id) {
    global $pdo;
    
    // Prepare and execute query
    $stmt = $pdo->prepare("INSERT INTO discussions (title, description, creator_id) VALUES (:title, :description, :creator_id)");
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':creator_id', $creator_id, PDO::PARAM_INT);
    
    // Execute and return result
    return $stmt->execute();
}

// Function to update discussion details
function updateDiscussion($discussion_id, $title, $description) {
    global $pdo;
    
    // Prepare and execute query
    $stmt = $pdo->prepare("UPDATE discussions SET title = :title, description = :description WHERE id = :id");
    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    $stmt->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt->bindParam(':id', $discussion_id, PDO::PARAM_INT);
    
    // Execute and return result
    return $stmt->execute();
}

// Function to delete a discussion
function deleteDiscussion($discussion_id) {
    global $pdo;
    
    // Prepare and execute query
    $stmt = $pdo->prepare("DELETE FROM discussions WHERE id = :id");
    $stmt->bindParam(':id', $discussion_id, PDO::PARAM_INT);
    
    // Execute and return result
    return $stmt->execute();
}
?>
