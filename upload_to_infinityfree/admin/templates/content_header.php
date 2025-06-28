<?php
/**
 * Admin Content Header
 *
 * This template partial includes the main content wrapper's opening tags
 * and the dynamic breadcrumb navigation for admin pages.
 *
 * @var array $breadcrumbs An associative array for breadcrumbs, e.g., ['Label' => 'url', 'Current Page' => '#']
 */
?>
<main class="flex-1 p-8 relative">
    <!-- Page Title & Breadcrumbs -->
    <div class="flex justify-between items-center mb-8">
        <?php if (!empty($page_title)): ?>
            <h1 class="text-3xl font-bold text-yellow-400" style="font-family: 'Trajan Pro', serif;">
                <?= htmlspecialchars($page_title) ?>
            </h1>
        <?php endif; ?>
    </div>
</main> 
