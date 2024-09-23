<div class="swiper-slide">
    <div class="post__item">
        <div class="post__img">
            <div class="image">
                <?php the_post_thumbnail(); ?>
            </div>
        </div>
        <div class="post__content">
            <svg width="369" height="16" viewBox="0 0 369 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="8.5" cy="8" r="8" fill="#E0FF78"/>
                <circle cx="30.5" cy="8" r="8" fill="#E0FF78"/>
                <circle cx="52.5" cy="8" r="8" fill="#E0FF78"/>
                <circle cx="74.5" cy="8" r="8" fill="#E0FF78"/>
                <circle cx="96.5" cy="8" r="8" fill="#E0FF78"/>
                <circle cx="118.5" cy="8" r="8" fill="#E0FF78"/>
                <circle cx="140.5" cy="8" r="8" fill="#E0FF78"/>
                <circle cx="162.5" cy="8" r="8" fill="#E0FF78"/>
                <circle cx="184.5" cy="8" r="8" fill="#E0FF78"/>
                <circle cx="206.5" cy="8" r="8" fill="#E0FF78"/>
                <circle cx="228.5" cy="8" r="8" fill="#E0FF78"/>
                <circle cx="250.5" cy="8" r="8" fill="#E0FF78"/>
                <circle cx="272.5" cy="8" r="8" fill="#E0FF78"/>
                <circle cx="294.5" cy="8" r="8" fill="#E0FF78"/>
                <circle cx="316.5" cy="8" r="8" fill="#E0FF78"/>
                <circle cx="338.5" cy="8" r="8" fill="#E0FF78"/>
                <circle cx="360.5" cy="8" r="8" fill="#E0FF78"/>
            </svg>
            <div class="around">
                <label class="post__title">
                    <?php the_title(); ?>
                </label>
                <div class="content">
                    <?php the_excerpt(); ?>
                </div>
            </div>
        </div>
    </div>
</div>