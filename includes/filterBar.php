<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/db.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/functions.php';

// filterBar.php
$selected_make = $_GET['make'] ?? '';
$selected_model = $_GET['model'] ?? '';
$price = $_GET['price'] ?? '';
$q = $_GET['q'] ?? '';

// Fetch all makes
$makes = getAllMakes($connection);
// Fetch models using the new function
$models = getModels($connection, $selected_make ?: null);
?>
<nav class="FilterBar navbar navbar-expand-lg bg-light border-bottom mb-4">
    <div class="container-md">
        <form action="/Projects/AuraEdition/products/listings.php" method="GET" class="FilterBar-search row d-flex flex-wrap w-100 gap-2 align-content-around" role="search">
            <!-- Filter Options -->
            <div class="col d-flex align-items-center gap-2">
                <button class="btn btn-primary" type="submit">Filter</button>

                <select class="form-select me-2" name="make" aria-label="Filter by make">
                    <option value="" <?= $selected_make == '' ? 'selected' : '' ?>>All Makes</option>
                    <?php foreach ($makes as $m): ?>
                        <option value="<?= htmlspecialchars($m['make_name']) ?>" <?= $selected_make == $m['make_name'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m['make_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select class="form-select me-2" name="model" aria-label="Filter by model">
                    <option value="" <?= $selected_model == '' ? 'selected' : '' ?>>All Models</option>
                    <?php foreach ($models as $mod): ?>
                        <option value="<?= htmlspecialchars($mod['model_name']) ?>" <?= $selected_model == $mod['model_name'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($mod['model_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select class="form-select me-2" name="price" aria-label="Filter by price">
                    <option value="" <?= $price == '' ? 'selected' : '' ?>>Any Price</option>
                    <option value="under100" <?= $price == 'under100' ? 'selected' : '' ?>>Under $100,000</option>
                    <option value="100to250" <?= $price == '100to250' ? 'selected' : '' ?>>$100,000 - $250,000</option>
                    <option value="over250" <?= $price == 'over250' ? 'selected' : '' ?>>Over $250,000</option>
                </select>
            </div>

            <!-- Search Bar -->
            <div class="col d-flex align-items-center gap-2 w-50">
                <input class="form-control me-2" type="search" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Search vehicles..." aria-label="Search">
                <button class="btn btn-primary" type="submit">Search</button>
                <a href="?" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</nav>
