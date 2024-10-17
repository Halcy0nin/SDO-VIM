<?php

function dashboard_card(
    $label = 'Total Equipment',
    $data = '5',
    $icon = 'bi-boxes',
) {
?>
    <div class="h-32 w-full min-w-[16rem] bg-zinc-50 border-[1px] rounded-lg p-3 flex flex-col justify-between">
        <span class="flex items-center gap-2 opacity-90">
            <i class="bi <?php echo htmlspecialchars($icon) ?> text-[#434f72] text-2xl"></i>
            <h3 class="text-xl text-[#434f72] font-bold"><?php echo $label ?></h3>
        </span>
        <h3 class="text-5xl text-end font-black text-[#434f72]"><?php echo $data ?></h3>
    </div>
<?php
}
?>