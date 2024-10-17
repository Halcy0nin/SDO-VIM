<?php

function text_input(
    $label = 'Text Input',
    $name = 'text_input',
    $placeholder = 'Text Input',
    $value = '',
    $type = 'text',
    $required = true
) {
?>
    <div class="flex flex-col">
        <label class="ml-2 text-xs text-zinc-500 mb-1">
            <?php echo htmlspecialchars($label); ?>
        </label>
        <input
            class="w-full p-2 outline-none rounded border-1 border-zinc-300 hover:border-zinc-400 active:border-[#434F72] focus:border-[#434F72] valid:border-[#434F72] shadow-inner"
            name="<?php echo htmlspecialchars($name); ?>"
            id="<?php echo htmlspecialchars($name); ?>"
            placeholder="<?php echo htmlspecialchars($placeholder); ?>"
            value="<?php echo htmlspecialchars($value); ?>"
            type="<?php echo htmlspecialchars($type); ?>"
            <?php echo $required ? 'required' : '' ?> />
    </div>
<?php
}
?>