<?php
session_start();

// Check if user is logged in, else redirect to login
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Initialize cart and show_cart if not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (!isset($_SESSION['show_cart'])) {
    $_SESSION['show_cart'] = false;
}

// Define tools array
$tools = [
    ["name" => "Hand Hoe", "usage" => "Weeding and soil loosening", "market_price" => 500, "our_price" => 450, "image" => "toolimg/hoe.png"],
    ["name" => "Plough", "usage" => "Tilling soil for planting", "market_price" => 2000, "our_price" => 1800, "image" => "toolimg/plough.png"],
    ["name" => "Sickle", "usage" => "Harvesting crops", "market_price" => 300, "our_price" => 270, "image" => "toolimg/sickle.png"],
    ["name" => "Sprayer", "usage" => "Applying pesticides", "market_price" => 1500, "our_price" => 1350, "image" => "toolimg/sprayer.png"],
    ["name" => "Shovel", "usage" => "Digging and moving soil", "market_price" => 600, "our_price" => 540, "image" => "toolimg/shovel.png"],
    ["name" => "Rake", "usage" => "Gathering leaves and debris", "market_price" => 400, "our_price" => 360, "image" => "toolimg/rake.png"],
    ["name" => "Trowel", "usage" => "Planting small crops", "market_price" => 200, "our_price" => 180, "image" => "toolimg/trowel.png"],
    ["name" => "Wheelbarrow", "usage" => "Transporting materials", "market_price" => 2500, "our_price" => 2250, "image" => "toolimg/wheel.png"],
    ["name" => "Pruner", "usage" => "Trimming branches", "market_price" => 800, "our_price" => 720, "image" => "tool1.png"],
    ["name" => "Watering Can", "usage" => "Watering plants", "market_price" => 350, "our_price" => 315, "image" => "toolimg/can.png"],
    ["name" => "Fork", "usage" => "Aerating soil", "market_price" => 550, "our_price" => 495, "image" => "toolimg/fork.png"],
    ["name" => "Seed Drill", "usage" => "Sowing seeds evenly", "market_price" => 3000, "our_price" => 2700, "image" => "toolimg/seeddrill.png"],
    ["name" => "Cultivator", "usage" => "Preparing soil beds", "market_price" => 2200, "our_price" => 1980, "image" => "toolimg/cultivator.png"],
    ["name" => "Hedge Shears", "usage" => "Shaping bushes", "market_price" => 700, "our_price" => 630, "image" => "toolimg/shear.png"],
    ["name" => "Post Hole Digger", "usage" => "Digging fence post holes", "market_price" => 900, "our_price" => 810, "image" => "toolimg/holedrill.png"],
    ["name" => "Hand Weeder", "usage" => "Removing weeds", "market_price" => 250, "our_price" => 225, "image" => "toolimg/handweeder.png"]
];

// Messages
$cart_msg = "";
$order_msg = "";

// Handle Add to Cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_cart'])) {
    $tool_index = $_POST['tool_index'];
    if (isset($tools[$tool_index])) {
        $_SESSION['cart'][] = [
            'name' => $tools[$tool_index]['name'],
            'price' => $tools[$tool_index]['our_price'],
            'image' => $tools[$tool_index]['image']
        ];
        $_SESSION['show_cart'] = true; // Show cart after first add
        $cart_msg = "Item added to cart!";
    }
}

// Handle Book Now (show address form)
$show_address_form = false;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book_order'])) {
    if (!empty($_SESSION['cart'])) {
        $show_address_form = true;
    } else {
        $cart_msg = "Cart is empty!";
    }
}

// Handle address form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_order'])) {
    $_SESSION['cart'] = [];
    $_SESSION['show_cart'] = false; // Hide cart after order
    $order_msg = "Your order is placed!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tools - Agri Pool</title>
    <link rel="stylesheet" href="/src/output.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #addressModal {
            display: none;
        }
        #addressModal.show {
            display: flex;
        }
        #show-less {
            display: none;
        }
        #more-tools {
            display: none;
        }
        #more-tools:not(.hidden) {
            display: grid;
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
        <!-- Tools Grid -->
        <div class="flex-1">
            <h1 class="text-4xl text-green-900 font-bold text-center mb-8">Order Farming Tools</h1>
            <?php if ($cart_msg): ?>
                <p class="text-green-300 text-center mb-4"><?php echo htmlspecialchars($cart_msg); ?></p>
            <?php endif; ?>
            <div class="grid grid-cols-4 gap-6">
                <!-- First 2 rows (8 tools) -->
                <?php for ($index = 0; $index < 8; $index++): ?>
                    <div class="p-4 bg-green-900 text-white rounded-2xl w-64 flex flex-col items-center">
                        <img src="<?php echo htmlspecialchars($tools[$index]['image']); ?>" alt="<?php echo htmlspecialchars($tools[$index]['name']); ?>" class="h-64 w-64 mb-4 object-contain" onerror="this.src='https://img.icons8.com/ios/100/shovel.png'">
                        <div class="w-full ml-1">
                            <h2 class="text-xl font-bold text-left mb-2"><?php echo htmlspecialchars($tools[$index]['name']); ?></h2>
                            <p class="text-sm text-left mb-2"><strong>Usage:</strong> <?php echo htmlspecialchars($tools[$index]['usage']); ?></p>
                            <p class="text-sm text-left mb-2"><strong>Market Price:</strong> ₹<?php echo htmlspecialchars($tools[$index]['market_price']); ?></p>
                            <p class="text-sm text-left mb-4"><strong>Our Price:</strong> ₹<?php echo htmlspecialchars($tools[$index]['our_price']); ?></p>
                            <form method="POST">
                                <input type="hidden" name="tool_index" value="<?php echo $index; ?>">
                                <button type="submit" name="add_to_cart" class="w-full bg-white text-green-900 p-2 rounded-lg text-lg hover:bg-gray-200 hover:shadow-lg hover:shadow-black/50 transition-shadow">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
            <!-- Last 2 rows (8 tools, hidden initially) -->
            <div id="more-tools" class="grid grid-cols-4 mt-10 gap-6 w-full hidden">
                <?php for ($index = 8; $index < 16; $index++): ?>
                    <div class="p-4 bg-green-900 text-white rounded-2xl w-64 flex flex-col items-center">
                        <img src="<?php echo htmlspecialchars($tools[$index]['image']); ?>" alt="<?php echo htmlspecialchars($tools[$index]['name']); ?>" class="h-64 w-64 mb-4 object-contain" onerror="this.src='https://img.icons8.com/ios/100/shovel.png'">
                        <div class="w-full ml-1">
                            <h2 class="text-xl font-bold text-left mb-2"><?php echo htmlspecialchars($tools[$index]['name']); ?></h2>
                            <p class="text-sm text-left mb-2"><strong>Usage:</strong> <?php echo htmlspecialchars($tools[$index]['usage']); ?></p>
                            <p class="text-sm text-left mb-2"><strong>Market Price:</strong> ₹<?php echo htmlspecialchars($tools[$index]['market_price']); ?></p>
                            <p class="text-sm text-left mb-4"><strong>Our Price:</strong> ₹<?php echo htmlspecialchars($tools[$index]['our_price']); ?></p>
                            <form method="POST">
                                <input type="hidden" name="tool_index" value="<?php echo $index; ?>">
                                <button type="submit" name="add_to_cart" class="w-full bg-white text-green-900 p-2 rounded-lg text-lg hover:bg-gray-200 hover:shadow-lg hover:shadow-black/50 transition-shadow">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endfor; ?>
            </div>
            <!-- Show More / Show Less Buttons -->
            <div class="text-center mt-8">
                <button id="show-more" class="bg-green-900 text-white px-6 py-3 rounded-lg text-lg hover:bg-green-500 hover:shadow-lg hover:shadow-black/50 transition-shadow">
                    Show More
                </button>
                <button id="show-less" class="bg-green-900 text-white px-6 py-3 rounded-lg text-lg hover:bg-green-500 hover:shadow-lg hover:shadow-black/50 transition-shadow">
                    Show Less
                </button>
            </div>
        </div>

        <!-- Cart Sidebar -->
        <div class="fixed right-0 top-24 w-80 bg-green-900 text-white p-4 h-[calc(100vh-8rem)] overflow-y-auto <?php echo $_SESSION['show_cart'] ? '' : 'hidden'; ?>">
            <h2 class="text-xl font-bold mb-4">Your Cart</h2>
            <?php if (empty($_SESSION['cart'])): ?>
                <p class="text-sm">Cart is empty</p>
            <?php else: ?>
                <?php $total = 0; ?>
                <?php foreach ($_SESSION['cart'] as $item): ?>
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

        // Show More / Show Less functionality
        $(document).ready(function() {
            $('#show-more').click(function() {
                $('#more-tools').slideDown(2000, function() {
                    $(this).removeClass('hidden').css('display', 'grid');
                });
                $('#show-more').hide();
                $('#show-less').show();
            });

            $('#show-less').click(function() {
                $('#more-tools').slideUp(2000, function() {
                    $(this).addClass('hidden');
                });
                $('#show-less').hide();
                $('#show-more').show();
            });
        });
    </script>
</body>
</html>