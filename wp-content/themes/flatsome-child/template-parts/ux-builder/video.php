<?php
// Retrieve the passed variable
$urlvideo = isset($args['video_url']) ? $args['video_url'] : null;
?>
<div class="video-url">
    <video playsinline class="w-full video" muted="muted" preload="auto" crossorigin="anonymous" data-track="video" loop="" autoplay="" width="100%">
        <source src="<?= $urlvideo ?>" type="video/mp4">        
    </video>    
</div>