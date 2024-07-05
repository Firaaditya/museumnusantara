<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $amount = intval($_POST['amount']);
    $date = htmlspecialchars($_POST['date']);

    // Validation
    if (empty($name) || empty($email) || empty($phone) || empty($amount) || empty($date)) {
        $responseMessage = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $responseMessage = "Invalid email format.";
    } elseif (!is_numeric($phone)) {
        $responseMessage = "Phone number must be numeric.";
    } elseif ($amount < 1) {
        $responseMessage = "Amount must be at least 1.";
    } else {
        // Create a string to be written to the text file
        $orderData = "Name: $name\nEmail: $email\nPhone: $phone\nAmount: $amount\nDate: $date\n\n";
        $filePath = "save.txt";

        // Write to the text file
        file_put_contents($filePath, $orderData, FILE_APPEND);

        $responseMessage = "Order submitted successfully!";
    }

    echo "<script>alert('$responseMessage');</script>";
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Ticket</title>
    <link rel="stylesheet" href="style.css">
<body>
    <section class="order" id="order">
        <h1 class="heading"><span>Order</span> Ticket</h1>
        <div class="row">
            <form id="orderForm" method="post" action="">
                <input type="text" placeholder="Name" name="name" class="box" required>
                <input type="email" placeholder="E-mail" name="email" class="box" required>
                <input type="text" placeholder="Phone Number" name="phone" class="box" required>
                <input type="number" placeholder="Amount Ticket" name="amount" class="box" required min="1">
                <input type="date" placeholder="mm/dd/yyyy" name="date" class="box" required>
                <input type="submit" value="Send Message" class="btn">
            </form>
            <?php if (isset($responseMessage)): ?>
                <div id="responseMessage" class="response"><?php echo $responseMessage; ?></div>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>
