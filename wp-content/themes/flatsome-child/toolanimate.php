<?php 
    $args = array(
        'post_type' => 'social',        
        'posts_per_page' => -1, // -1 retrieves all posts in the category
    );
    $tool_social = new WP_Query($args);
?>
<div id='arcontactus'>
    
</div>
<div class="pd-compact-mobile" style="background-color: unset;">
    <div class="pd-body">
        <?php while ($tool_social->have_posts()) { $tool_social->the_post();?>
            <a href="<?= get_the_content(); ?>" target="_blank" class="pushdy-widget-button pd-tel" style="height: 40px; width: 40px;display: block; background-image: url({{UPLOAD_PHOTO.$v['photo']}});">
                <span class="pd-label pd-tel pd-tooltip-text" style="color: black; background: rgb(20, 53, 195);"><?= get_the_title(); ?></span>
            </a>
        <?php }?>
        <div class="pd-close"><svg class="mt-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#C6A669" d="M23 20.168l-8.185-8.187 8.185-8.174-2.832-2.807-8.182 8.179-8.176-8.179-2.81 2.81 8.186 8.196-8.186 8.184 2.81 2.81 8.203-8.192 8.18 8.192z"/></svg></div>
    </div>
</div>