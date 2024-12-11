<?php

function dashboard_card(
    $label = 'Total Equipment',
    $data = '5',
    $icon = 'bi-boxes',
    $dataTextColor = '#434f72', // Default data text color
    $labelTextColor = '#434f72', // Default label text color
    $iconColor = '#434f72' // Default icon color
) {
?>
    <div class="h-32 w-full min-w-[16rem] bg-zinc-50 border-[1px] rounded-lg p-3 flex flex-col justify-between">
        <span class="flex items-center gap-2 opacity-90">
            <i class="bi <?php echo htmlspecialchars($icon) ?>" style="color: <?php echo htmlspecialchars($iconColor) ?>"></i>
            <h3 class="text-xl font-bold" style="color: <?php echo htmlspecialchars($labelTextColor) ?>;">
                <?php echo $label ?>
            </h3>
        </span>
        <h3 class="text-5xl text-end font-black" style="color: <?php echo htmlspecialchars($dataTextColor) ?>;">
            <?php echo $data ?>
        </h3>
    </div>
<?php
}
?>
