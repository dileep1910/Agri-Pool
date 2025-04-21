<?php
session_start();

// Check if user is logged in, else redirect to login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Dummy message for Contact action
$contact_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contact_driver'])) {
    $contact_msg = "Your request delivered and the response is soon";
}

// Dummy drivers data with image paths
$drivers = [
    ["name" => "Dileep Kumar", "vehicle" => "Tractor", "price_per_hour" => 500, "our_price_per_hour" => 450, "image" => "driver.png"],
    ["name" => "Mahendra", "vehicle" => "Truck", "price_per_hour" => 800, "our_price_per_hour" => 720, "image" => "driver.png"],
    ["name" => "Ram charan", "vehicle" => "Mini Truck", "price_per_hour" => 600, "our_price_per_hour" => 540, "image" => "driver.png"],
    ["name" => "Siddharth", "vehicle" => "Bullock Cart", "price_per_hour" => 300, "our_price_per_hour" => 270, "image" => "driver.png"],
    ["name" => "Harsha", "vehicle" => "Trolley", "price_per_hour" => 400, "our_price_per_hour" => 360, "image" => "driver.png"],
    ["name" => "Narendra", "vehicle" => "Tractor", "price_per_hour" => 550, "our_price_per_hour" => 495, "image" => "driver.png"],
    ["name" => "Teja", "vehicle" => "Truck", "price_per_hour" => 850, "our_price_per_hour" => 765, "image" => "driver.png"],
    ["name" => "Karthik", "vehicle" => "Mini Truck", "price_per_hour" => 650, "our_price_per_hour" => 585, "image" => "driver.png"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Details - Agri Pool</title>
    <link rel="stylesheet" href="/src/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-fixed" style="background-image: url('main.jpg'); background-size: cover; background-position: center;">
    <header class="fixed top-0 w-full px-4 z-50 flex items-center justify-center p-4 text-white bg-green-900">
        <div class="flex items-center absolute left-4">
            <img src="logopro.png" alt="" class="h-12">
            <span class="ml-3 text-lg font-semibold"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
        </div>
        <h1 class="flex items-center text-4xl font-bold">
            Agri Pool
        </h1>
        <ul class="absolute right-7 flex space-x-5 items-center">
            <li><a href="index.php" class="hover:border-b-2 hover:border-white pb-1">Back to Home</a></li>
            <li>
                <a href="logout.php">
                    <button class="bg-white text-green-900 px-4 py-2 rounded-lg hover:bg-gray-200 transition">Logout</button>
                </a>
            </li>
        </ul>
    </header>

    <div class="container mx-auto mt-24 p-8">
        <h1 class="text-4xl text-green-900 font-bold text-center mb-8">Transport Details</h1>
        <div class="grid grid-cols-4 gap-6">
            <?php foreach ($drivers as $driver): ?>
                <div class="p-4 bg-green-900 text-white rounded-2xl w-64 flex flex-col items-center">
                    <img src="<?php echo htmlspecialchars($driver['image']); ?>" alt="<?php echo htmlspecialchars($driver['name']); ?>" class="h-64 w-64 mb-4 object-contain" onerror="this.src='https://img.icons8.com/ios/100/tractor.png'">
                    <div class="w-full ml-1">
                        <h2 class="text-xl font-bold text-left mb-2"><?php echo htmlspecialchars($driver['name']); ?></h2>
                        <p class="text-sm text-left mb-2"><strong>Type of Vehicle:</strong> <?php echo htmlspecialchars($driver['vehicle']); ?></p>
                        <p class="text-sm text-left mb-2"><strong>Price per Hour:</strong> ₹<?php echo htmlspecialchars($driver['price_per_hour']); ?></p>
                        <p class="text-sm text-left mb-4"><strong>Our Price per Hour:</strong> ₹<?php echo htmlspecialchars($driver['our_price_per_hour']); ?></p>
                        <form method="POST">
                            <button type="submit" name="contact_driver" class="w-full bg-white text-green-900 p-2 rounded-lg text-lg hover:bg-gray-200 hover:shadow-lg hover:shadow-black/50 transition-shadow">
                                Ask to Call
                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <footer class="bg-green-900 text-white p-6">
        <div class="flex justify-around">
            <div>
                <h3 class="text-lg font-bold mb-2">Contact Us</h3>
                <p>Phone: +91-98765-43210</p>
                <p>Email: <a href="mailto:support@agripool.com" class="text-blue-600 hover:underline">support@agripool.com</a></p>
            </div>
            <div>
                <h3 class="text-lg font-bold mb-2">Quick Links</h3>
                <ul>
                    <li><a href="index.php" class="hover:underline">Home</a></li>
                    <li><a href="about.html" class="hover:underline">About</a></li>
                    <li><a href="contact.html" class="hover:underline">Contact</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-bold mb-2">About AgriPool</h3>
                <p>Empowering Farmers, Growing Together</p>
                <p>AgriPool, Green Fields, India</p>
            </div>
        </div>
        <div class="text-center mt-4">
            <p>© 2025 AgriPool. All rights reserved.</p>
            <p>Unauthorized reproduction, distribution, or modification of any content on this site is strictly prohibited.</p>
        </div>
    </footer>

    <script>
        // Show contact confirmation popup
        <?php if ($contact_msg): ?>
            alert("<?php echo htmlspecialchars($contact_msg); ?>");
        <?php endif; ?>
    </script>
</body>
</html>