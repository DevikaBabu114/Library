<?php
session_start();
require_once 'dbh.inc.php'; // Include your database connection file

// Handle the POST request for reservation
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['book_id'])) {
        $bookId = $_POST['book_id'];

        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        } else {
            echo json_encode(["error" => "User not logged in. Please log in to reserve books."]);
            exit;
        }

        try {
            // Insert reservation
            $sql = "INSERT INTO reservation (user_id, book_id, copy_id, date_reserved, status)
                    VALUES (:user_id, :book_id, NULL, CURRENT_TIMESTAMP, 'pending')";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['user_id' => $userId, 'book_id' => $bookId]);

            // Set session variable for success message
            $_SESSION['reservation_success'] = true;
            echo json_encode(["success" => "Book reserved successfully"]);
            exit;

        } catch (PDOException $e) {
            echo json_encode(["error" => "Error while reserving the book: " . $e->getMessage()]);
            exit;
        }
    } else {
        echo json_encode(["error" => "Book ID not found."]);
        exit;
    }
}

// Handle the GET request for displaying books
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Initialize variables for search and category
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $category = isset($_GET['category']) ? trim($_GET['category']) : '';

    try {
        // Start building the SQL query
        $sql = "SELECT book.book_id, name, author, publisher, price, category, rack_no, no_of_available_copies
                FROM book
                WHERE 1"; // Basic query to get books

        // Prepare dynamic parameters for filtering
        $params = [];

        // Add filtering conditions if the user performs a search
        if (!empty($search)) {
            $sql .= " AND (book.name LIKE ? OR author LIKE ?)";
            $params[] = "%$search%"; // For book name
            $params[] = "%$search%"; // For author name
        }

        // Add category filtering if selected
        if (!empty($category)) {
            $sql .= " AND category = ?";
            $params[] = $category; // For selected category
        }

        // Avoid duplicate books by only displaying each book once
        $sql .= " GROUP BY book.book_id";

        // Prepare and execute the query with parameters
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        // Fetch the results
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Display the books
        if (count($books) > 0) {
            foreach ($books as $book) {
                // Determine availability based on no_of_available_copies
                $availableCopies = (int)$book['no_of_available_copies'];
                if ($availableCopies > 0) {
                    $statusColor = 'green';
                    $statusText = 'Available (' . $availableCopies . ' copies available)';
                } else {
                    $statusColor = 'red';
                    $statusText = 'Not Available';
                }

                echo "<div class='grid-item'>
                        <h3>" . htmlspecialchars($book['name']) . "</h3>
                        <p>Author: " . htmlspecialchars($book['author']) . "</p>
                        <p>Publisher: " . htmlspecialchars($book['publisher']) . "</p>
                        <p>Category: " . htmlspecialchars($book['category']) . "</p>
                        <p>Rack No: " . htmlspecialchars($book['rack_no']) . "</p>
                        <p>Status: <span style='color: $statusColor; font-weight: bold;'>" . htmlspecialchars($statusText) . "</span></p>
                        <p>Price: RS " . htmlspecialchars($book['price']) . "</p>";

                // If the book is not available, display a Reserve button
                if ($availableCopies === 0) {
                    echo "<form method='POST'>
                            <input type='hidden' name='book_id' value='" . htmlspecialchars($book['book_id']) . "' />
                            <button type='submit' class='reserve-btn'>Reserve</button>
                          </form>";
                }

                echo "</div>";
            }
        } else {
            echo "<p>No books found matching your search criteria.</p>";
            echo "<form action='u-requestbook.php' method='GET'>
                    <button type='submit' class='request-btn'>Request Book</button>
                  </form>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    header("Location: ../index.php");
    exit; // Ensure to exit after redirecting
}
?>
