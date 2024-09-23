<?php
/**
 * Posts archive 2 column.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.18.0
 */
$cat = isset( $args['cat'] ) ? $args['cat'] : '';
$key = isset( $args['key'] ) ? $args['key'] : '';
$cat_name = isset( $args['cat_name'] ) ? $args['cat_name'] : '';
$args = array(
    'post_type' => 'post',        
    'posts_per_page' => -1, // -1 retrieves all posts in the category
    'tax_query' => isset( $cat ) ? array(
        array(
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $cat
        )
    ) : null
);
$query = new WP_Query($args);
if ( have_posts() ) : ?>
	<div id="post-list-custom<?= $key ?>">
        <h2 class="title-category"><?php echo $cat_name; ?></h2>
		<?php
		$ids = array();
        if( $query->have_posts() ) :
            while ( $query->have_posts() ) : $query->the_post();
                array_push( $ids, get_the_ID() );
            endwhile;
        else :
            while ( have_posts() ) : the_post();
                array_push( $ids, get_the_ID() );
            endwhile; // end of the loop.
        endif;
		$ids = implode( ',', $ids );
		?>
		<?php
		echo flatsome_apply_shortcode( 'blog_posts', array(
			'type'        => get_theme_mod( 'blog_style_type', 'masonry' ),
			'depth'       => get_theme_mod( 'blog_posts_depth', 0 ),
			'depth_hover' => get_theme_mod( 'blog_posts_depth_hover', 0 ),
			'text_align'  => get_theme_mod( 'blog_posts_title_align', 'center' ),
			'columns'     => '1',
            'image_size' => 'full',
			'show_date'   => get_theme_mod( 'blog_badge', 1 ) ? 'true' : 'false',
			'ids'         => $ids,
            'show_date'   => 'hidden',
            'excerpt_length' => 30,
            'image_height' => '60%'
		) );
		?>
		<?php flatsome_posts_pagination(); ?>
	</div>
<?php else : ?>
	<?php get_template_part( 'template-parts/posts/content', 'none' ); ?>
<?php endif; ?>
