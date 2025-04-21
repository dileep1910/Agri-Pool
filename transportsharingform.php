<?php
session_start();

// Initialize local requests array for this page load
$requests = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $from = htmlspecialchars($_POST["from"]);
    $to = htmlspecialchars($_POST["to"]);
    $produce = htmlspecialchars($_POST["produce"]);
    $quantity = htmlspecialchars($_POST["quantity"]);
    $date = htmlspecialchars($_POST["date"]);
    
    // Generate prices
    $actual_cost = rand(15, 30); // Random actual cost between $15 and $30
    $discount = rand(3, 10);     // Random discount between $3 and $10
    $booked_price = $actual_cost - $discount; // Booked price after discount
    $savings = $discount;        // Savings is the discount amount

    // Add to local requests array
    $requests[] = [
        "from" => $from,
        "to" => $to,
        "produce" => $produce,
        "quantity" => $quantity,
        "date" => $date,
        "actual_cost" => $actual_cost,
        "booked_price" => $booked_price,
        "savings" => $savings
    ];
    
    // Set flag and date for popup
    $showPopup = true;
    $bookedDate = $date; // Store the booked date for popup
} else {
    $showPopup = false;
    $bookedDate = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Transport Sharing</title>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center text-green-900 mb-4">Transport Sharing</h1>

        <!-- Post Transport Request -->
        <h2 class="text-xl font-semibold text-gray-700">Need Transport?</h2>
        <form method="POST" class="space-y-3" id="transportForm">
            <input type="text" name="from" placeholder="From" class="w-full p-2 border rounded" required>
            <input type="text" name="to" placeholder="To" class="w-full p-2 border rounded" required>
            <input type="text" name="produce" placeholder="Produce" class="w-full p-2 border rounded" required>
            <input type="text" name="quantity" placeholder="Quantity in kg's" class="w-full p-2 border rounded" required>
            <input type="date" name="date" class="w-full p-2 border rounded" required>
            <button type="submit" class="w-full bg-green-900 text-white p-2 rounded hover:bg-green-700 hover:shadow-lg hover:shadow-black/50 transition-shadow">
                Post Request
            </button>
        </form>

        <!-- Find Transport (Only appears after posting, clears on refresh) -->
        <?php if (!empty($requests)): ?>
            <h2 class="text-xl font-semibold text-gray-700 mt-6">Find Transport</h2>
            <div class="bg-gray-200 p-3 rounded">
                <?php foreach ($requests as $request): ?>
                    <p class="mb-2">
                        <?= htmlspecialchars($request["from"]) ?> to <?= htmlspecialchars($request["to"]) ?> | 
                        <?= htmlspecialchars($request["produce"]) ?> (<?= htmlspecialchars($request["quantity"]) ?>) | 
                        Date: <?= htmlspecialchars($request["date"]) ?><br>
                        <span class="text-green-700 font-semibold">Your transport is booked for $<?= htmlspecialchars($request["booked_price"]) ?></span><br>
                        <span class="text-gray-600">Actual cost of your transport: $<?= htmlspecialchars($request["actual_cost"]) ?></span><br>
                        <span class="text-blue-600 font-semibold">You saved $<?= htmlspecialchars($request["savings"]) ?>!</span>
                    </p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Instructions -->
        <h2 class="text-xl font-semibold text-gray-700 mt-6">Instructions:</h2>
        <ul class="list-disc pl-6 text-gray-600">
            <li>Step 1: Post your request.</li>
            <li>Step 2: Check available transporters.</li>
            <li>Step 3: Review the price and proceed.</li>
        </ul>

        <!-- Contact Info -->
        <p class="text-center text-gray-700 mt-4">Need help? Call <strong>[9876543210]</strong> or email <strong>[support@agripool.com]</strong></p>
        
        <div class="flex justify-start mt-6">
            <div class="text-white bg-green-900 w-max p-2 rounded-md">
                <a href="index.php"><button class="ml-4 mr-4">Back</button></a>
            </div>
        </div>
    </div>

    <!-- Popup Script -->
    <script>
        <?php if ($showPopup): ?>
            alert("Your transport is booked on <?= htmlspecialchars($bookedDate) ?>.");
        <?php endif; ?>
    </script>
</body>
</html>