<?php

function select_input(
    $label = 'Select Input',
    $id = 'select_input',
    $name = 'select_input',
    $options = [],
    $selectedValue = null
) {
?>
    <span class="flex flex-col">
        <label for="<?php echo htmlspecialchars($id); ?>" class="ml-2 text-xs text-zinc-500 mb-1">
            <?php echo htmlspecialchars($label); ?>
        </label>
        <select
            id="<?php echo htmlspecialchars($id); ?>"
            name="<?php echo htmlspecialchars($name); ?>"
            class="flex w-full bg-white gap-1 p-2 outline-none rounded border-1 border-zinc-300 hover:border-zinc-400 active:border-[#434F72] focus:border-[#434F72] valid:border-[#434F72] shadow-inner"
        >
            <?php foreach ($options as $value => $text) : ?>
                <option value="<?php echo htmlspecialchars($value); ?>" <?php echo ($value == $selectedValue) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($text); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </span>
<?php
}
?>

<!-- Example usage -->
 
<!-- <?php
select_input(
    'School Division',
    'school_division',
    'school_division',
    [
        1 => 'Option 1',
        2 => 'Option 2123132',
    ],
    1
);
?> -->
