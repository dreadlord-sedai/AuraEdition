<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AuraEdition | Contact</title>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/header.php'; ?>

<body class="bg-black text-white min-h-screen">

    <!-- Navigation Bar -->
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/Projects/AuraEdition/includes/navbar.php'; ?>
    <!-- Navigation Bar -->

    <!-- Hero Section -->
    <div class="relative w-full h-[40vh] md:h-[60vh] flex items-center justify-start overflow-hidden">
        <img src="../assets/images/contact-hero.png" alt="Hero" class="absolute inset-0 w-full h-full object-cover z-0">
    </div>
    <!-- Hero Section -->

    <div class="max-w-2xl mx-auto px-4 my-16">
        <!-- Contact Section -->
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] === 'success'): ?>
                <div class="w-full mb-6 p-4 rounded text-white bg-green-600 text-center font-semibold shadow-lg border-l-4 border-yellow-400/50">
                    Your message has been sent successfully!
                </div>
            <?php elseif ($_GET['status'] === 'error'): ?>
                <div class="w-full mb-6 p-4 rounded text-white bg-red-600 text-center font-semibold shadow-lg border-l-4 border-yellow-400/50">
                    There was an error sending your message. Please try again.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <form action="/Projects/AuraEdition/process/contactProcess.php" method="POST" class="p-8 bg-gray-900 rounded-xl shadow-lg border border-yellow-400/20 flex flex-col gap-6">
            <div class="flex flex-col md:flex-row gap-6">
                <div class="flex-1">
                    <label for="first_name" class="block mb-2 text-yellow-400 font-serif" style="font-family: 'Trajan Pro', serif;">First Name</label>
                    <input type="text" class="w-full bg-black border border-gray-700 text-white rounded-md p-3 focus:ring-yellow-400 focus:border-yellow-400" id="first_name" name="first_name" required>
                </div>
                <div class="flex-1">
                    <label for="last_name" class="block mb-2 text-yellow-400 font-serif" style="font-family: 'Trajan Pro', serif;">Last Name</label>
                    <input type="text" class="w-full bg-black border border-gray-700 text-white rounded-md p-3 focus:ring-yellow-400 focus:border-yellow-400" id="last_name" name="last_name" required>
                </div>
            </div>
            <div>
                <label for="email" class="block mb-2 text-yellow-400 font-serif" style="font-family: 'Trajan Pro', serif;">Email</label>
                <input type="email" class="w-full bg-black border border-gray-700 text-white rounded-md p-3 focus:ring-yellow-400 focus:border-yellow-400" id="email" name="_replyto" required>
            </div>
            <div>
                <label for="message" class="block mb-2 text-yellow-400 font-serif" style="font-family: 'Trajan Pro', serif;">Message</label>
                <textarea class="w-full bg-black border border-gray-700 text-white rounded-md p-3 focus:ring-yellow-400 focus:border-yellow-400" id="message" name="message" rows="5" required></textarea>
            </div>
            <button type="submit" name="submit" value="Send Message" class="w-full bg-yellow-400 text-black font-semibold py-3 rounded-md hover:bg-yellow-500 transition-all text-lg tracking-wide">Send Message</button>
        </form>
        <!-- Contact Section -->
    </div>

    <?php include_once $_SERVER['DOCUMENT_ROOT'] . "/Projects/AuraEdition/includes/footer.php"; ?>
</body>
</html>