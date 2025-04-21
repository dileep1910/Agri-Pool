<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $location = htmlspecialchars($_POST["location"]);
    $land_size = htmlspecialchars($_POST["land_size"]);
    $soil_type = htmlspecialchars($_POST["soil_type"]);
    $crop_type = htmlspecialchars($_POST["crop_type"]);
    $season = htmlspecialchars($_POST["season"]);

    $recommendation = "";
    $cost = 0;
    if ($crop_type == "Rice") {
        $recommendation = "50 kg Nitrogen, 20 kg Phosphorus";
        $cost = 15;
    } elseif ($crop_type == "Wheat") {
        $recommendation = "30 kg Nitrogen, 15 kg Potassium";
        $cost = 10;
    } else {
        $recommendation = "40 kg General Fertilizer Mix";
        $cost = 12;
    }

    $_SESSION['fertilizer_plans'] = [[
        "location" => $location,
        "land_size" => $land_size,
        "soil_type" => $soil_type,
        "crop_type" => $crop_type,
        "season" => $season,
        "recommendation" => $recommendation,
        "cost" => $cost
    ]];
    // Set a flag to trigger popup
    $showPopup = true;
} else {
    $_SESSION['fertilizer_plans'] = [];
    $showPopup = false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Fertilizer Analysis</title>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-2xl mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold text-center text-green-900 mb-4">Fertilizer Analysis</h1>

        <h2 class="text-xl font-semibold text-gray-700">Enter Your Land Details</h2>
        <form method="POST" class="space-y-3" id="fertilizerForm">
            <input type="text" name="location" placeholder="Location" class="w-full p-2 border rounded" required>
            <input type="text" name="land_size" placeholder="Land Size (e.g., 2 acres)" class="w-full p-2 border rounded" required>
            <input type="text" name="soil_type" placeholder="Soil Type (e.g., sandy soil, black soil)" class="w-full p-2 border rounded" required>
            <input type="text" name="crop_type" placeholder="Crop Type (e.g., rice, wheat)" class="w-full p-2 border rounded" required>
            <input type="text" name="season" placeholder="Season/Weather (e.g., rainy season, dry season)" class="w-full p-2 border rounded" required>
            <button type="submit" class="w-full bg-green-900 text-white p-2 rounded hover:bg-green-700 hover:shadow-lg hover:shadow-black/100 transition-shadow">
                Analyze and Book
            </button>
        </form>

        <h2 class="text-xl font-semibold text-gray-700 mt-6">Your Fertilizer Plan</h2>
        <div class="bg-gray-200 p-3 rounded">
            <?php if (!empty($_SESSION['fertilizer_plans'])): ?>
                <?php foreach ($_SESSION['fertilizer_plans'] as $plan): ?>
                    <p class="mb-2">
                        <?= htmlspecialchars($plan["crop_type"]) ?> | <?= htmlspecialchars($plan["land_size"]) ?> | 
                        <?= htmlspecialchars($plan["recommendation"]) ?> | 
                        Estimated Cost: $<?= htmlspecialchars($plan["cost"]) ?> | 
                        <span class="text-green-700 font-bold">Your fertilizer is booked</span>
                    </p>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No fertilizer recommendations yet.</p>
            <?php endif; ?>
        </div>

        <h2 class="text-xl font-semibold text-gray-700 mt-6">Instructions:</h2>
        <ul class="list-disc pl-6 text-gray-600">
            <li>Step 1: Enter your land details.</li>
            <li>Step 2: Click "Analyze Now" to get your customized fertilizer plan.</li>
            <li>Step 3: Review the recommendations and apply them.</li>
        </ul>

        <p class="text-center text-gray-700 mt-4">Need help? Call <strong>[9876543210]</strong> or email <strong>[support@agripool.com]</strong></p>
        <div class="flex justify-start mt-6">
            <div class="text-white bg-green-900 w-max p-2 rounded-md">
                <a href="index.php"><button class="ml-4 mr-4 ">Back</button></a>
            </div>
        </div>
    </div>

    <!-- Popup Script -->
    <script>
        <?php if (isset($showPopup) && $showPopup): ?>
            alert("Your fertilizer is booked. Thank you!");
        <?php endif; ?>
    </script>
</body>
</html>