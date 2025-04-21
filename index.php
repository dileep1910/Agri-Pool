<?php
session_start();

// Check if user is logged in, else redirect to login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Dummy messages for button actions
$transport_check_msg = "";
$market_check_msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check_transport'])) {
    $transport_check_msg = "Transport details will be shown here soon!";
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check_markets'])) {
    $market_check_msg = "Market info coming soon!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agri Pool</title>
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
            <li><a href="index.php" class="hover:border-b-2 hover:border-white pb-1">Home</a></li>
            <li><a href="about.html" class="hover:border-b-2 hover:border-white pb-1">About</a></li>
            <li><a href="contact.html" class="hover:border-b-2 hover:border-white pb-1">Contact</a></li>
            <li><a href="gallery.html" class="hover:border-b-2 hover:border-white pb-1">Gallery</a></li>
            <li>
                <a href="logout.php">
                    <button class="bg-white text-green-900 px-4 py-2 rounded-lg hover:bg-gray-200 transition">Logout</button>
                </a>
            </li>
        </ul>
    </header>
    
    <div class="flex">
        <div class="p-8 bg-green-900 text-white w-max mt-40 ml-10 rounded-2xl">
            <h class="text-4xl font-bold">About Us</h><br><br>
            <p class="text-2xl text-white font-semibold ">Agri Pool is a platform designed to empower farmers by connecting<br> them for shared transport and optimized farming inputs.Our mission is to<br>reduce costs, increase efficiency, and promote sustainable agriculture. <br> Whether it's pooling produce to lower transport expenses or planning <br>the perfect fertilizer mix. Agri Pool supports farmers every step of the way<br> to build a stronger, smarter farming community.</p>
        </div>
        <div class="p-8 mt-40 ml-40 ">
            <img src="logopro.png" alt="" class="w-80 h-auto">
        </div>
    </div>
    <div class="flex justify-center items-center mt-14">
        <h1 class="text-4xl text-white font-bold">FEATURES AVAILABLE</h1>
    </div>
    <div class="flex m-10 justify-around">
        <div class="p-6 w-max bg-green-900 text-white rounded-2xl">
            <h1 class="text-4xl font-bold">Transport Sharing</h1>
            <p class="p-2 text-xl font-semibold">AgriPool's transport sharing option helps farmers share vehicles to take their goods to the market at a lower cost. By pooling their produce, they can split expenses, reach markets faster, and reduce waste. This makes transportation cheaper, easier, and more efficient, especially for small farmers.</p>
            <div class="p-4 ml-48">
                <a href="transportsharingform.php">
                    <button class="text-green-900 bg-white p-4 rounded-lg text-2xl hover:shadow-lg hover:shadow-black/50 transition-shadow">
                        Transport Sharing
                    </button>
                </a>
            </div>
        </div>
        <div class="p-6 w-max bg-green-900 text-white ml-10 rounded-2xl">
            <h1 class="text-4xl font-bold">Fertilizer Analysis</h1>
            <p class="p-2 text-xl font-semibold">Fertilizer Analysis helps farmers understand the nutrient content of fertilizers, ensuring the right balance of nitrogen (N), phosphorus (P), and potassium (K) for healthy crops. By analyzing fertilizers, farmers can reduce waste, lower costs, and improve soil fertility, leading to better yields and sustainable farming.</p>
            <div class="p-4 ml-48">
                <a href="fertilizer.php">
                    <button class="text-green-900 bg-white p-4 rounded-lg text-2xl hover:shadow-lg hover:shadow-black/50 transition-shadow">
                        Fertilizer Analyzer
                    </button>
                </a>
            </div>
        </div>
    </div>
    <div class="flex justify-center items-center mt-14">
        <h1 class="text-4xl text-white font-bold">MORE FOR FARMERS</h1>
    </div>
    <div class="flex m-10 justify-around">
        <div class="p-4 w-64 bg-green-900 text-white rounded-2xl">
            <div class="flex items-center">
                <img src="tool1.png" alt="Tools Icon" class="h-8 w-8 mr-2">
                <h1 class="text-2xl">Order Tools</h1>
            </div>
            <div class="p-4">
                <a href="order_tools.php">
                    <button class="w-full bg-white text-green-900 p-2 rounded-lg text-lg hover:bg-gray-200 hover:shadow-lg hover:shadow-black/50 transition-shadow">
                       <a href="tools.php">Order Now</a> 
                    </button>
                </a>
            </div>
        </div>
        <div class="p-4 w-64 bg-green-900 text-white rounded-2xl">
            <div class="flex items-center">
                <img src="transport.png" alt="Transport Icon" class="h-8 w-8 mr-2">
                <h1 class="text-2xl">Transport Details</h1>
            </div>
            
            <div class="p-4">
                <form method="POST">
                    <button type="submit" name="check_transport" class="w-full bg-white text-green-900 p-2 rounded-lg text-lg hover:bg-gray-200 hover:shadow-lg hover:shadow-black/50 transition-shadow">
                        <a href="transportcheck.php">Check</a> 
                    </button>
                </form>
            </div>
        </div>
        <div class="p-4 w-64 bg-green-900 text-white rounded-2xl">
            <div class="flex items-center">
                <img src="ferti.png" alt="Fertilizer Icon" class="h-8 w-8 mr-2">
                <h1 class="text-2xl">Order Fertilizers</h1>
            </div>
            <div class="p-4">
                <a href="order_fertilizers.php">
                    <button class="w-full bg-white text-green-900 p-2 rounded-lg text-lg hover:bg-gray-200 hover:shadow-lg hover:shadow-black/50 transition-shadow">
                       <a href="ferti.php">Order Now</a> 
                    </button>
                </a>
            </div>
        </div>
        <div class="p-4 w-64 bg-green-900 text-white rounded-2xl">
            <div class="flex items-center">
                <img src="market.png" alt="Market Icon" class="h-8 w-8 mr-2">
                <h1 class="text-2xl">View Markets</h1>
            </div>
            
            <div class="p-4">
                <form method="POST">
                    <button type="submit" name="check_markets" class="w-full bg-white text-green-900 p-2 rounded-lg text-lg hover:bg-gray-200 hover:shadow-lg hover:shadow-black/50 transition-shadow">
                       <a href="market.php">Check Now</a> 
                    </button>
                </form>
            </div>
        </div>
    </div>
    <footer class="text-center text-white p-4 bg-green-900">
        © 2025 AgriPool. All rights reserved.  
        <br>Unauthorized reproduction, distribution, or modification of any content on this site is strictly prohibited.  
        <br>For inquiries, contact us at <a href="mailto:support@agripool.com" class="text-blue-600 hover:underline">support@agripool.com</a>.
    </footer>
</body>
</html>