<?php
session_start();

// Check if user is logged in, else redirect to login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Initialize fertilizer cart and show_cart if not set
if (!isset($_SESSION['fertilizer_cart'])) {
    $_SESSION['fertilizer_cart'] = [];
}
if (!isset($_SESSION['show_fertilizer_cart'])) {
    $_SESSION['show_fertilizer_cart'] = false;
}

// Define fertilizers array
$fertilizers = [
    ["name" => "Urea", "usage" => "Provides nitrogen for plant growth", "market_price" => 300, "our_price" => 270, "image" => "fertilizerimg/urea1.png"],
    ["name" => "DAP", "usage" => "Supplies phosphorus and nitrogen", "market_price" => 1200, "our_price" => 1080, "image" => "fertilizerimg/dap1.png"],
    ["name" => "Muriate of Potash", "usage" => "Delivers potassium for root strength", "market_price" => 800, "our_price" => 720, "image" => "fertilizerimg/muriate1.png"],
    ["name" => "Super Phosphate", "usage" => "Boosts phosphorus for flowering", "market_price" => 600, "our_price" => 540, "image" => "fertilizerimg/super1.png"],
    ["name" => "Ammonium Sulphate", "usage" => "Nitrogen and sulfur for crops", "market_price" => 400, "our_price" => 360, "image" => "fertilizerimg/ammonium1.png"],
    ["name" => "NPK 20-20-20", "usage" => "Balanced nutrients for all crops", "market_price" => 1000, "our_price" => 900, "image" => "fertilizerimg/npk1.png"],
    ["name" => "Calcium Nitrate", "usage" => "Calcium and nitrogen for plant vigor", "market_price" => 700, "our_price" => 630, "image" => "fertilizerimg/calci1.png"],
    ["name" => "Magnesium Sulphate", "usage" => "Magnesium for photosynthesis", "market_price" => 500, "our_price" => 450, "image" => "fertilizerimg/epsom1.png"]
];

// Messages
$cart_msg = "";
$order_msg = "";

// Handle Add to Cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $fertilizer_index = $_POST['fertilizer_index'];
    if (isset($fertilizers[$fertilizer_index])) {
        $_SESSION['fertilizer_cart'][] = [
            'name' => $fertilizers[$fertilizer_index]['name'],
            'price' => $fertilizers[$fertilizer_index]['our_price'],
            'image' => $fertilizers[$fertilizer_index]['image']
        ];
        $_SESSION['show_fertilizer_cart'] = true; // Show cart after first add
        $cart_msg = "Item added to cart!";
    }
}

// Handle Book Now (show address form)
$show_address_form = false;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_order'])) {
    if (!empty($_SESSION['fertilizer_cart'])) {
        $show_address_form = true;
    } else {
        $cart_msg = "Cart is empty!";
    }
}

// Handle address form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_order'])) {
    $_SESSION['fertilizer_cart'] = [];
    $_SESSION['show_fertilizer_cart'] = false; // Hide cart after order
    $order_msg = "Your order is placed!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Fertilizers - Agri Pool</title>
    <link rel="stylesheet" href="/src/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #addressModal {
            display: none;
        }
        #addressModal.show {
            display: flex;
        }
    </style>
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

    <div class="container mx-auto mt-24 p-8 flex">
        <!-- Fertilizers Grid -->
        <div class="flex-1">
            <h1 class="text-4xl text-green-900 font-bold text-center mb-8">Order Fertilizers</h1>
            <?php if ($cart_msg): ?>
                <p class="text-green-300 text-center mb-4"><?php echo htmlspecialchars($cart_msg); ?></p>
            <?php endif; ?>
            <div class="grid grid-cols-4 gap-6">
                <?php foreach ($fertilizers as $index => $fertilizer): ?>
                    <div class="p-4 bg-white text-green-900 rounded-2xl w-64 flex flex-col items-center">
                        <img src="<?php echo htmlspecialchars($fertilizer['image']); ?>" alt="<?php echo htmlspecialchars($fertilizer['name']); ?>" class="h-64 w-64 mb-4 object-contain" onerror="this.src='https://img.icons8.com/ios/100/fertilizer.png'">
                        <div class="w-full ml-1">
                            <h2 class="text-xl font-bold text-left mb-2"><?php echo htmlspecialchars($fertilizer['name']); ?></h2>
                            <p class="text-sm text-left mb-2"><strong>Usage:</strong> <?php echo htmlspecialchars($fertilizer['usage']); ?></p>
                            <p class="text-sm text-left mb-2"><strong>Market Price:</strong> ₹<?php echo htmlspecialchars($fertilizer['market_price']); ?></p>
                            <p class="text-sm text-left mb-4"><strong>Our Price:</strong> ₹<?php echo htmlspecialchars($fertilizer['our_price']); ?></p>
                            <form method="POST">
                                <input type="hidden" name="fertilizer_index" value="<?php echo $index; ?>">
                                <button type="submit" name="add_to_cart" class="w-full bg-green-900 text-white p-2 rounded-lg text-lg hover:bg-green-500 hover:shadow-lg hover:shadow-black/50 transition-shadow">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Cart Sidebar -->
        <div class="fixed right-0 top-24 w-80 bg-green-900 text-white p-4 h-[calc(100vh-8rem)] overflow-y-auto <?php echo $_SESSION['show_fertilizer_cart'] ? '' : 'hidden'; ?>">
            <h2 class="text-xl font-bold mb-4">Your Cart</h2>
            <?php if (empty($_SESSION['fertilizer_cart'])): ?>
                <p class="text-sm">Cart is empty</p>
            <?php else: ?>
                <?php $total = 0; ?>
                <?php foreach ($_SESSION['fertilizer_cart'] as $item): ?>
                    <div class="flex items-center mb-4">
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="h-12 w-12 mr-2 object-contain">
                        <div>
                            <p class="text-sm"><?php echo htmlspecialchars($item['name']); ?></p>
                            <p class="text-sm">₹<?php echo htmlspecialchars($item['price']); ?></p>
                        </div>
                    </div>
                    <?php $total += $item['price']; ?>
                <?php endforeach; ?>
                <div class="border-t border-white pt-2">
                    <p class="text-lg font-bold">Total: ₹<?php echo $total; ?></p>
                    <form method="POST">
                        <button type="submit" name="book_order" class="w-full bg-white text-green-900 p-2 rounded-lg text-lg hover:bg-gray-200 transition mt-2">
                            Book Now
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Address Modal -->
    <div id="addressModal" class="<?php echo $show_address_form ? 'show' : ''; ?> fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-green-900 text-white p-6 rounded-lg w-96">
            <h2 class="text-xl font-bold mb-4">Enter Your Address</h2>
            <form method="POST">
                <div class="mb-4">
                    <label class="block text-sm mb-1">Name</label>
                    <input type="text" name="name" class="w-full p-2 rounded-lg text-green-900" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-1">Address</label>
                    <textarea name="address" class="w-full p-2 rounded-lg text-green-900" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm mb-1">Phone</label>
                    <input type="tel" name="phone" class="w-full p-2 rounded-lg text-green-900" required>
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()" class="bg-gray-500 text-white p-2 rounded-lg hover:bg-gray-600">Cancel</button>
                    <button type="submit" name="confirm_order" class="bg-white text-green-900 p-2 rounded-lg hover:bg-gray-200">Confirm Order</button>
                </div>
            </form>
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
        // Show order confirmation popup
        <?php if ($order_msg): ?>
            alert("<?php echo htmlspecialchars($order_msg); ?>");
        <?php endif; ?>

        // Close address modal
        function closeModal() {
            document.getElementById('addressModal').classList.remove('show');
        }
    </script>
</body>
</html>