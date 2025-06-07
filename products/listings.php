<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Listings</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>

<body>

    <!-- Navigation Bar -- -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    <!-- Navigation Bar -->

    <!-- Search and Filter bar -->

    <!-- Search and Filter Bar -->
    <nav class="FilterBar navbar navbar-expand-lg bg-light border-bottom mb-4">
        <div class="container-md">
            <form class="FilterBar-search row d-flex flex-wrap w-100 gap-2" role="search">

                <div class="col d-flex align-items-center gap-2">
                    <Button class="btn btn-primary">Filter</Button>

                    <select class="form-select me-2" aria-label="Filter by make">
                        <option selected>All Makes</option>
                        <option value="1">Lamborghini</option>
                        <option value="2">Ferrari</option>
                        <option value="3">Porsche</option>
                    </select>

                    <select class="form-select me-2" aria-label="Filter by make">
                        <option selected>All Models</option>
                        <option value="1">Lamborghini</option>
                        <option value="2">Ferrari</option>
                        <option value="3">Porsche</option>
                    </select>

                    <select class="form-select me-2" aria-label="Filter by price">
                        <option selected>Any Price</option>
                        <option value="1">Under $100,000</option>
                        <option value="2">$100,000 - $250,000</option>
                        <option value="3">Over $250,000</option>
                    </select>
                </div>

                <div class="col d-flex align-items-center gap-2 w-50">
                    <input class="form-control me-2" type="search" placeholder="Search vehicles..." aria-label="Search">
                    <button class="btn btn-primary" type="submit">Search</button>
                    <button class="btn btn-outline-secondary" type="button">Reset</button>
                </div>

            </form>
        </div>
    </nav>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>