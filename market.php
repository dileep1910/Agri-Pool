<?php
session_start();

// Check if user is logged in, else redirect to login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Dummy message for Contact action
$contact_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contact_market'])) {
    $contact_msg = "Your request delivered and the response is soon";
}

// Dummy markets data with updated fields
$markets = [
    ["name" => "Guntur Market", "type" => "Wholesale", "distance" => "5 km", "hours" => "6 AM - 6 PM", "image" => "market1.png"],
    ["name" => "Rythu Bazaar", "type" => "Retail", "distance" => "8 km", "hours" => "7 AM - 8 PM", "image" => "market1.png"],
    ["name" => "Rajiv gandhi Wholesale market", "type" => "Local", "distance" => "3 km", "hours" => "5 AM - 5 PM", "image" => "market1.png"],
    ["name" => "Kaleswar rao market", "type" => "Wholesale", "distance" => "12 km", "hours" => "6 AM - 7 PM", "image" => "market1.png"],
    ["name" => "VSR market", "type" => "Retail", "distance" => "15 km", "hours" => "8 AM - 9 PM", "image" => "market1.png"],
    ["name" => "Tirupati vegetable market", "type" => "Local", "distance" => "6 km", "hours" => "5 AM - 6 PM", "image" => "market1.png"],
    ["name" => "Mangalagiri market", "type" => "Wholesale", "distance" => "10 km", "hours" => "6 AM - 8 PM", "image" => "market1.png"],
    ["name" => "Rural Mart", "type" => "Retail", "distance" => "18 km", "hours" => "7 AM - 9 PM", "image" => "market1.png"]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Markets - Agri Pool</title>
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
        <h1 class="text-4xl text-green-900 font-bold text-center mb-8">Nearby Markets</h1>
        <div class="grid grid-cols-4 gap-6">
            <?php foreach ($markets as $market): ?>
                <div class="p-4 bg-green-900 text-white rounded-2xl w-64 flex flex-col items-center">
                    <img src="<?php echo htmlspecialchars($market['image']); ?>" alt="<?php echo htmlspecialchars($market['name']); ?>" class="h-64 w-64 mb-4 object-contain" onerror="this.src='https://img.icons8.com/ios/100/market.png'">
                    <div class="w-full ml-1">
                        <h2 class="text-xl font-bold text-left mb-2"><?php echo htmlspecialchars($market['name']); ?></h2>
                        <p class="text-sm text-left mb-2"><strong>Market Type:</strong> <?php echo htmlspecialchars($market['type']); ?></p>
                        <p class="text-sm text-left mb-2"><strong>Distance:</strong> <?php echo htmlspecialchars($market['distance']); ?></p>
                        <p class="text-sm text-left mb-4"><strong>Operating Hours:</strong> <?php echo htmlspecialchars($market['hours']); ?></p>
                        <form method="POST">
                            <button type="submit" name="contact_market" class="w-full bg-white text-green-900 p-2 rounded-lg text-lg hover:bg-gray-200 hover:shadow-lg hover:shadow-black/50 transition-shadow">
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