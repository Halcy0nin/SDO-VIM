<?php

function radio_group(
    $label = 'Radio Group',
    $name = 'radio_group',
    $options = [],
    $selectedValue = null
) {
?>
    <h5 class="ml-2 text-zinc-500 mb-2 text-xs">
        <?php echo htmlspecialchars($label); ?>
    </h5>
    <span class="flex gap-1">
        <?php foreach ($options as $value => $text) : 
            $id = $name . '_' . htmlspecialchars(strtolower($text)); // Create a unique id based on name and text
        ?>
            <input
                type="radio"
                class="peer/<?php echo htmlspecialchars($id); ?> text-zinc-300 accent-[#434F72]"
                id="<?php echo $id; ?>"
                name="<?php echo htmlspecialchars($name); ?>"
                value="<?php echo htmlspecialchars($value); ?>"
                <?php echo ($value == $selectedValue) ? 'checked' : ''; ?>
            >
            <label
                class="mr-2 peer-checked/<?php echo htmlspecialchars($id); ?>:text-[#434F72] text-zinc-400"
                for="<?php echo $id; ?>"
            >
                <?php echo htmlspecialchars($text); ?>
            </label>
        <?php endforeach; ?>
    </span>
<?php
}
?>

<!-- Example usage -->
<!-- <?php
radio_group(
    'Type of School',
    'school_type',
    [
        1 => 'Public',
        2 => 'Private',
    ],
    1
);
?> -->
