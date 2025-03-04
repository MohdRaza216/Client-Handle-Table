<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "myclients";

// Create a connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = "";
$email = "";
$phone = "";
$address = "";
$alertMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name'] ?? "");
    $email = trim($_POST['email'] ?? "");
    $phone = trim($_POST['phone'] ?? "");
    $address = trim($_POST['address'] ?? "");

    do {
        if (empty($name) || empty($email) || empty($phone) || empty($address)) {
            $alertMessage = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>All fields are required.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            break;
        }

        // ✅ Step 1: Check if email already exists
        $checkStmt = $conn->prepare("SELECT id FROM clients WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkStmt->store_result();

        if ($checkStmt->num_rows > 0) {
            $alertMessage = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
            This email is already registered. Please use a different email.
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
            $checkStmt->close();
            break;
        }
        $checkStmt->close();

        // ✅ Step 2: Insert new client
        $stmt = $conn->prepare("INSERT INTO clients (name, email, phone, address) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $address);

        if ($stmt->execute()) {
            $stmt->close();
            // ✅ Redirect after successful insertion
            header("Location: /myclients/index.php");
            exit();
        } else {
            $alertMessage = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>Error: " . $stmt->error . 
            "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
        }
        $stmt->close();
    } while (false);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Clients</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>New Client</h2>
        <p>Please fill out the form to add a new client.</p>

        <?php echo $alertMessage; ?>

        <form method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?php echo htmlspecialchars($address); ?>">
            </div>
            <div class="text-center mb-3">
                <button type="submit" class="btn btn-primary">Save</button>
                <a class="btn btn-outline-primary" href="/myclients/index.php" role="button">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
