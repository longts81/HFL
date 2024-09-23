<?php
/**
 * Posts content single.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

?>
<div class="entry-content single-page">

	<?php the_content(); ?>

	<?php
	wp_link_pages();
	?>

	<?php if ( get_theme_mod( 'blog_share', 1 ) ) {
		// SHARE ICONS
		echo '<div class="blog-share text-center">';
		echo '<div class="is-divider medium"></div>';
		echo do_shortcode( '[share]' );
		echo '</div>';
	} ?>
</div>

<?php if ( get_theme_mod( 'blog_single_footer_meta', 1 ) ) : ?>
	<footer class="entry-meta text-<?php echo get_theme_mod( 'blog_posts_title_align', 'center' ); ?>">
		<?php
		/* translators: used between list items, there is a space after the comma */
		$category_list = get_the_category_list( __( ', ', 'flatsome' ) );

		/* translators: used between list items, there is a space after the comma */
		$tag_list = get_the_tag_list( '', __( ', ', 'flatsome' ) );


		// But this blog has loads of categories so we should probably display them here.
		if ( '' != $tag_list ) {
			$meta_text = __( 'This entry was posted in %1$s and tagged %2$s.', 'flatsome' );
		} else {
			$meta_text = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'flatsome' );
		}

		printf( $meta_text, $category_list, $tag_list, get_permalink(), the_title_attribute( 'echo=0' ) );
		?>
	</footer>
<?php endif; ?>

<?php if ( get_theme_mod( 'blog_author_box', 1 ) ) : ?>
	<div class="entry-author author-box">
		<div class="flex-row align-top">
			<div class="flex-col mr circle">
				<div class="blog-author-image">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), apply_filters( 'flatsome_author_bio_avatar_size', 90 ) ); ?>
				</div>
			</div>
			<div class="flex-col flex-grow">
				<h5 class="author-name uppercase pt-half">
					<?php the_author_meta( 'display_name' ); ?>
				</h5>
				<p class="author-desc small"><?php the_author_meta( 'description' ); ?></p>
			</div>
		</div>
	</div>
<?php endif; ?>

<div class="related-posts-after-content">    
	<?php		
		// Get the current post categories
		$categories = get_the_category();
		$sorted_categories = wp_list_sort($categories, 'parent', 'DESC');
		$category_parent_id = $sorted_categories[0]->cat_ID;
		// if(count($categories) > 1) {			
		// 	$category_parent_id = $categories[count($categories) - 1]->cat_ID;
		// }else{
		// 	$category_parent_id = $categories[0]->cat_ID;
		// }

		// Check if the post has categories
		if ($categories) {
			$category_ids = array(); // Initialize an array to store category IDs

			// Get the IDs of the current post categories
			foreach ($categories as $category) {
				$category_ids[] = $category->term_id;
			}

			// Query related posts from the same categories
			$related_posts_query = new WP_Query(array(
				'category__in' => $category_parent_id, //$category_ids
				'post__not_in' => array(get_the_ID()), // Exclude the current post
				'posts_per_page' => 7, // Adjust the number of related posts to display
				'orderby' => 'rand', // Display random posts from the same category
			));
			// $readmore = __('Read more', 'flatsome');
			$readmore_color = 'is-link black';

			// Check if there are related posts
			if ($related_posts_query->have_posts()) {
				$post_icon = true;
				$show_date = false;
				$excerpt = true;
				$excerpt_length = 15;
				echo '<div class="w-full top-header">';
				echo '<h2>' . __('Related Posts', 'flatsome') . '</h2>';
				echo '<div class="swiper-buttons">
						<a href="#" title="Prev" class="swiper-prev swiper-button-disabled">
							<i class="fal fa-chevron-double-left"></i>
						</a>
						<a href="#" title="Next" class="swiper-next swiper-button-disabled">
							<i class="fal fa-chevron-double-right"></i>
						</a>
					</div>';
				echo '</div>';
				echo '<div class="related-posts">';
				echo '<div class="swiper-related swiper">';
				echo '<div class="swiper-wrapper">';
				while ($related_posts_query->have_posts()) {
					$related_posts_query->the_post();
						echo '<div class="swiper-slide post-item">
							<a href="'.get_the_permalink().'" class="plain">
								<div class="box box-text-bottom box-blog-post has-hover">';
									if(has_post_thumbnail()) {
										echo '<div class="box-image">
											<div class="image-cover" style="padding-top:56%;">'.get_the_post_thumbnail($image_size).'</div>';
											if($post_icon && get_post_format()) { 
												echo '<div class="absolute no-click x50 y50 md-x50 md-y50 lg-x50 lg-y50">
													<div class="overlay-icon">
														<i class="icon-play"></i>
													</div>
												</div>';
											}
										echo '</div><!-- .box-image -->';
									}
									echo '<div class="box-text text-left" >
									<div class="box-text-inner blog-post-inner">';

									do_action('flatsome_blog_post_before');
									if((!has_post_thumbnail() && $show_date !== 'false') || $show_date == 'text') {
										echo '<div class="post-meta is-small op-8"><i class="fal fa-calendar"></i> '.get_the_date().'</div>';
									}
									echo '<h5 class="post-title is-large">'.get_the_title().'</h5>';
									
									if($excerpt !== 'false') {
										echo '<p class="from_the_blog_excerpt">';										
										$the_excerpt  = get_the_excerpt();
										$excerpt_more = apply_filters( 'excerpt_more', ' [...]' );
										echo flatsome_string_limit_words($the_excerpt, $excerpt_length) . $excerpt_more;
										echo '</p>';									
									}

									if($readmore) {
										echo '<button href="'.get_the_permalink().'" class="button is-link black is-outline is-small mb-0">
											'.$readmore.'
											<svg width="22" height="6" viewBox="0 0 22 6" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M16.7413 2.09324H1.39395C0.627277 2.09324 0 2.50289 0 3.00358C0 3.50427 0.627277 3.91392 1.39395 3.91392H16.7413V5.54343C16.7413 5.95309 17.4941 6.15336 17.9262 5.86205L21.8014 3.3222C22.0662 3.14013 22.0662 2.85792 21.8014 2.67585L17.9262 0.136C17.4941 -0.155309 16.7413 0.054069 16.7413 0.45462V2.09324Z" fill="#FDBB5A"/>
											</svg>
										</button>';
									}

									do_action('flatsome_blog_post_after');

									echo '</div><!-- .box-text-inner -->
									</div><!-- .box-text -->
								</div><!-- .box -->
							</a>
						</div>';
				}
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}

			// Restore original post data
			wp_reset_postdata();
		}
		?>
</div>

<?php if ( get_theme_mod( 'blog_single_next_prev_nav', 1 ) ) :
	flatsome_content_nav( 'nav-below' );
endif; ?>
