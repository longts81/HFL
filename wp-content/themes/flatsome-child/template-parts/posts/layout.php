<?php
/**
 * Posts layout.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

do_action('flatsome_before_blog');

$category = get_queried_object();
$root_id = get_root_category( $category );
?>
<?php if(!is_single() && get_theme_mod('blog_featured', '') == 'top'){ get_template_part('template-parts/posts/featured-posts'); } ?>

<?php if($root_id->term_id == apply_filters( 'wpml_object_id', 19, 'category' ) || $root_id->term_id == apply_filters( 'wpml_object_id', 18, 'category' )): 
	if (function_exists('z_taxonomy_image_url')){
		$id_cate = $category->term_id ?? $category_id;	
		$image_url = z_taxonomy_image_url($id_cate);
	}
	$category_id = $root_id->cat_ID;	
	$child_terms = get_terms(array(
        'taxonomy' => 'category',
        'child_of' => $category_id,
        'hide_empty' => false,		
    ));	
?>
<?php if($image_url): ?>
	<div class="banner <?= $root_id->term_id == apply_filters( 'wpml_object_id', 18, 'category' ) ? 'mb-100' : '' ?>">
		<img src="<?php echo $image_url; ?>" alt="banner">
	</div>
<?php endif; ?>
<div class="align-center boxCat">
	<div class="large">
		<?php if($child_terms): ?>
			<?php foreach($child_terms as $key => $child_term): ?>				
				<?php get_template_part( 'template-parts/posts/archive', 'full', array( 'cat' => $child_term->term_id, 'key' => $key, 'cat_name' => $child_term->name ) ); ?>
			<?php endforeach; ?>
		<?php else: ?>
			<?php get_template_part( 'template-parts/posts/archive', 'full' ); ?>
		<?php endif; ?>
	</div>
</div>
<?php return false; endif;?>

<div class="row align-center">
	<div class="large-12 col">
	<?php if(!is_single() && get_theme_mod('blog_featured', '') == 'content'){ get_template_part('template-parts/posts/featured-posts'); } ?>

	<?php
		if(is_single()){
			get_template_part( 'template-parts/posts/single');
			comments_template();
		} elseif(get_theme_mod('blog_style_archive', '') && (is_archive() || is_search())){
			get_template_part( 'template-parts/posts/archive', get_theme_mod('blog_style_archive', '') );
		} else{
			get_template_part( 'template-parts/posts/archive', get_theme_mod('blog_style', 'normal') );
		}
	?>
	</div>

</div>

<?php do_action('flatsome_after_blog');
