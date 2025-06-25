<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Contact</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>

<body>

    <!-- Navigation Bar -- -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    <!-- Navigation Bar -->

    <!-- Hero Section -->
    <div class="Hero">
        <img src="../assets/images/contact-hero.png" alt="Hero" class="img-fluid w-100">
        <div class="position-absolute top-50 align-items-start text-white ms-5 ">
        </div>
    </div>
    <!-- Hero Section -->


    <div class="container-md my-5 main-content">

        <!-- Contact Section -->
        <div class="container-md justify-content-center align-items-center">

        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] === 'success'): ?>
                <div class="w-100 mb-4 p-4 rounded text-white bg-green-500 text-center font-semibold">
                    Your message has been sent successfully!
                </div>
            <?php elseif ($_GET['status'] === 'error'): ?>
                <div class="w-100 mb-4 p-4 rounded text-white bg-red-500 text-center font-semibold">
                    There was an error sending your message. Please try again.
                </div>
            <?php endif; ?>
        <?php endif; ?>

            <form action="/Projects/AuraEdition/process/contactProcess.php" method="POST" class="contact-form col-md-8 mx-auto p-4 bg-light shadow rounded">

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="col-md-6">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="_replyto" required>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>

                <button type="submit" name="submit" value="Send Message" class="btn btn-primary w-100">Send Message</button>
        </div>
        <!-- Contact Section -->

    </div>



    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>