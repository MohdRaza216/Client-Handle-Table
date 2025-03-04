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

$id = $_GET['id'] ?? "";
$name = "";
$email = "";
$phone = "";
$address = "";
$alertMessage = "";

// Fetch client data if ID exists
if (!empty($id)) {
    $sql = "SELECT name, email, phone, address FROM clients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row["name"];
        $email = $row["email"];
        $phone = $row["phone"];
        $address = $row["address"];
    } else {
        $alertMessage = "<div class='alert alert-danger'>Client not found.</div>";
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST["id"])) {
        header("Location: /myclients/index.php");
        exit();
    }

    $id = $_POST['id'];
    $name = $_POST['name'] ?? "";
    $email = $_POST['email'] ?? "";
    $phone = $_POST['phone'] ?? "";
    $address = $_POST['address'] ?? "";

    do {
        if (empty($name) || empty($email) || empty($phone) || empty($address)) {
            $alertMessage = "<div class='alert alert-danger'>All fields are required.</div>";
            break;
        }
        
        $sql = "UPDATE clients SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $email, $phone, $address, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: /myclients/index.php");
            exit();
        } else {
            $alertMessage = "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
    } while (false);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Client</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Edit Client</h2>

        <?php echo $alertMessage; ?>

        <form method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
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
                <a class="btn btn-outline-primary" href="/myclients/index.php">Cancel</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
