<?php
// Flash message partial for AuraEdition
if ($msg = get_flash('success')): ?>
    <div class="mb-4 p-3 bg-green-900/80 border border-yellow-400/30 text-green-300 rounded shadow-lg font-semibold text-center">
        <?= htmlspecialchars($msg) ?>
    </div>
<?php elseif ($msg = get_flash('error')): ?>
    <div class="mb-4 p-3 bg-red-900/80 border border-yellow-400/30 text-yellow-400 rounded shadow-lg font-semibold text-center">
        <?= htmlspecialchars($msg) ?>
    </div>
<?php endif; ?> 