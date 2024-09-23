<?php
// Retrieve the passed variable
$text = isset($args['text']) ? $args['text'] : null;
$effect = isset($args['effect']) ? $args['effect'] : null;
$icon = isset($args['icon']) ? $args['icon'] : null;
?>
<div class="group-text-run">
    <div class="text-<?= esc_attr($effect) ?>">
        <div class="text">
            <?php for ($i=0; $i < 25; $i++) { ?>
                <p><?= esc_html($text) ?></p>
                <?php if (!empty($icon) && $icon == 'eye'): ?>
                    <svg width="53" height="36" viewBox="0 0 53 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 17.5436C0 7.85932 5.647 0 12.6197 0C19.5923 0 25.2394 7.85071 25.2394 17.5436C25.2394 27.2365 19.5923 35.0872 12.6197 35.0872C5.647 35.0872 0 27.2365 0 17.5436Z" fill="#E0FF78"/>
                        <path d="M27.7607 17.5436C27.7607 7.85932 33.4077 0 40.3803 0C47.353 0 53 7.85071 53 17.5436C53 27.2365 47.353 35.0872 40.3803 35.0872C33.4077 35.0872 27.7607 27.2365 27.7607 17.5436Z" fill="#E0FF78"/>
                        <path d="M11.6214 17.5436C11.6214 14.0572 14.1953 11.2337 17.3803 11.2337C20.5654 11.2337 23.1392 14.0572 23.1392 17.5436C23.1392 21.0299 20.5567 23.8534 17.3803 23.8534C14.2039 23.8534 11.6214 21.0299 11.6214 17.5436Z" fill="black"/>
                        <path d="M39.5038 17.5436C39.5038 14.0572 42.0776 11.2337 45.2627 11.2337C48.4477 11.2337 51.0216 14.0572 51.0216 17.5436C51.0216 21.0299 48.4477 23.8534 45.2627 23.8534C42.0776 23.8534 39.5038 21.0299 39.5038 17.5436Z" fill="black"/>
                    </svg>
                <?php elseif (!empty($icon) && $icon == 'star'): ?>
                    <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M26 0L29.9799 16.3917L44.3848 7.61522L35.6083 22.0201L52 26L35.6083 29.9799L44.3848 44.3848L29.9799 35.6083L26 52L22.0201 35.6083L7.61522 44.3848L16.3917 29.9799L0 26L16.3917 22.0201L7.61522 7.61522L22.0201 16.3917L26 0Z" fill="#FF5CC4"/>
                    </svg>
                <?php elseif (!empty($icon) && $icon == 'star-border'): ?>
                    <svg width="54" height="54" viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M27 1L30.9799 17.3917L45.3848 8.61522L36.6083 23.0201L53 27L36.6083 30.9799L45.3848 45.3848L30.9799 36.6083L27 53L23.0201 36.6083L8.61522 45.3848L17.3917 30.9799L1 27L17.3917 23.0201L8.61522 8.61522L23.0201 17.3917L27 1Z" fill="white" stroke="#FF5CC4" stroke-width="2"/>
                    </svg>
                <?php else: ?><?php endif; ?>
            <?php } ?>
        </div>
    </div>
</div>