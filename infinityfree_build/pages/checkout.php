<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/bootstrap.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Checkout</title>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>
<body class="bg-black text-white min-h-screen">
    <!-- Navigation Bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    <!-- Navigation Bar -->

    <!-- Main Content -->
    <div class="max-w-6xl mx-auto p-8 bg-black rounded-2xl shadow-2xl my-12">
      <div class="flex flex-col md:flex-row gap-6">
        <!-- Checkout Card -->
        <div class="flex-1 bg-gray-900 rounded-2xl shadow-xl p-10">
          <h2 class="text-3xl font-extrabold text-yellow-400 mb-10">Checkout</h2>
          <!-- Item Card -->
          <?php if (isset($_SESSION['vehicles']) && count($_SESSION['vehicles']) > 0): ?>
            <?php foreach ($_SESSION['vehicles'] as &$vehicle): ?>
              <div class="flex items-center gap-4 bg-gray-800 rounded-xl p-6 mb-4 shadow-lg">
                <img src="<?php echo get_vehicle_image($vehicle['id'], $connection); ?>" class="w-32 h-32 object-cover rounded-lg border-2 border-yellow-400/30" alt="">
                <div class="flex-1">
                  <h3 class="text-2xl font-bold text-white mb-2"><?= htmlspecialchars($vehicle['title']) ?></h3>
                  <p class="text-yellow-400 font-bold text-xl mb-4">$<?= htmlspecialchars($vehicle['price']) ?></p>
                  <div class="flex items-center gap-4 mt-2">
                    <button class="px-5 py-2 text-lg bg-yellow-400 text-black rounded-lg hover:bg-yellow-500 btn-minus" data-vehicle-id="<?= htmlspecialchars($vehicle['id']); ?>">-</button>
                    <span class="text-white text-xl font-semibold" id="quantity-<?= htmlspecialchars($vehicle['id']); ?>"><?= htmlspecialchars($vehicle['quantity']); ?></span>
                    <button class="px-5 py-2 text-lg bg-yellow-400 text-black rounded-lg hover:bg-yellow-500 btn-plus" data-vehicle-id="<?= htmlspecialchars($vehicle['id']); ?>">+</button>
                  </div>
                </div>
              </div>
            <?php endforeach; unset($vehicle); ?>
          <?php else: ?>
            <p class="text-gray-400 text-lg">No items to checkout.</p>
          <?php endif; ?>
        </div>
        <!-- Payment Card -->
        <div class="w-full md:w-2/5 bg-gray-900 rounded-2xl shadow-xl p-10 flex flex-col items-center">
          <h2 class="text-2xl font-bold text-yellow-400 mb-6">Order Summary</h2>
          <div class="w-full mb-6">
            <?php if (isset($_SESSION['vehicles']) && count($_SESSION['vehicles']) > 0): ?>
              <?php foreach ($_SESSION['vehicles'] as $vehicle): ?>
                <div class="flex justify-between text-white text-lg mb-3">
                  <span><?= htmlspecialchars($vehicle['title']) ?></span>
                  <span>$<?= htmlspecialchars($vehicle['price']) ?></span>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
          <div class="w-full flex justify-between border-t border-yellow-400/20 pt-6 mb-8">
            <span class="text-xl text-white font-bold">Total</span>
            <span class="text-3xl text-yellow-400 font-extrabold">$<?php echo isset($_SESSION['total_price']) ? $_SESSION['total_price'] : '0'; ?></span>
          </div>
          <button id="payBtn" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold text-xl py-4 rounded-xl transition mb-3" type="submit" name="submit" value="Pay" onclick="pay();">
            Pay
          </button>
          <button class="w-full bg-red-600 hover:bg-red-700 text-white font-bold text-xl py-4 rounded-xl transition" type="button" id="cancelBtn">
            Cancel
          </button>
        </div>
      </div>
    </div>
    <!-- Main Content -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/Projects/AuraEdition/assets/js/script.js"></script>
</body>
</html>