<?php
/**
 * Header template.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php flatsome_html_classes(); ?>">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php wp_head(); ?>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/custom.css">
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/arcontactus.css">
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_directory'); ?>/css/FontAwesome/css/all.min.css">	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>	
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css"/>
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Anton&family=Unbounded:wght@200..900&display=swap" rel="stylesheet">
	<?php 
		// <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.css"/>
		// <link rel="stylesheet" href="<?php bloginfo('stylesheet_directory');/photobox/photobox.css">
		// <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css"/>
		// <link rel="stylesheet" href="https://unpkg.com/tippy.js@5/dist/backdrop.css" />
		// <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
		// <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
	?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'flatsome_after_body_open' ); ?>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'flatsome' ); ?></a>

<div id="wrapper">
	<div class="scroll-bottom">
		<span>Scroll</span>
		<div class="svg">
		<svg width="86" height="69" viewBox="0 0 86 69" fill="none" xmlns="http://www.w3.org/2000/svg">
			<g filter="url(#filter0_d_189_426)">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M6.0245 0.131177C6.02344 0.131245 6.0224 0.131273 6.10479 1.56842L6.0224 0.131273L4.58124 0.212118L4.74605 3.0864L6.18636 3.0056L6.18677 3.0056L6.18721 3.00554L6.19057 3.00538L6.21202 3.00434C6.2322 3.00338 6.26414 3.0019 6.3076 3.00018C6.39454 2.99671 6.52735 2.99214 6.70367 2.98818C7.05612 2.98024 7.58183 2.97464 8.25995 2.98487C9.61639 3.0053 11.5802 3.08895 13.9849 3.34305C18.7984 3.85175 25.3552 5.041 32.3341 7.75805C45.9268 13.05 61.1549 24.1395 68.2695 47.4723C67.9543 47.0142 67.6237 46.5435 67.2755 46.0555L67.2753 46.0553C63.7023 41.0518 57.5121 36.6413 50.1025 34.7172L48.705 34.3542L47.9799 37.1402L49.3772 37.503C56.1659 39.2659 61.7654 43.3008 64.9236 47.7232C68.2165 52.337 69.8093 55.2431 71.7913 60.7416L74.545 59.8874C72.4236 51.9236 72.9559 45.7898 74.495 37.7734C75.5683 32.1826 77.5686 26.9483 80.3167 22.4216L81.064 21.1907L78.5937 19.6983L77.8464 20.9292C74.9119 25.7629 72.7936 31.3208 71.6593 37.2295C71.142 39.9238 70.7291 42.4466 70.4881 44.9222C62.8553 21.757 47.3 10.495 33.3821 5.07652C26.1059 2.24378 19.2859 1.0086 14.2866 0.480286C11.785 0.215927 9.73337 0.127953 8.30093 0.106379C7.58451 0.0955845 7.02244 0.101395 6.63587 0.110114C6.44257 0.114477 6.29299 0.119552 6.1899 0.123648C6.13825 0.125682 6.09832 0.127488 6.07036 0.128841C6.05647 0.129531 6.04533 0.130069 6.03733 0.130485L6.02766 0.131008L6.0245 0.131177ZM70.26 50.2354C70.2618 50.3415 70.264 50.4476 70.2665 50.5539C70.2117 50.4626 70.1563 50.3712 70.1004 50.2798L70.26 50.2354Z" fill="#1D68FF"/>
			</g>
			<defs>
			<filter id="filter0_d_189_426" x="0.581238" y="0.100464" width="84.4827" height="68.6411" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
			<feFlood flood-opacity="0" result="BackgroundImageFix"/>
			<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
			<feOffset dy="4"/>
			<feGaussianBlur stdDeviation="2"/>
			<feComposite in2="hardAlpha" operator="out"/>
			<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
			<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_189_426"/>
			<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_189_426" result="shape"/>
			</filter>
			</defs>
		</svg>
		</div>
	</div>
	<?php do_action( 'flatsome_before_header' ); ?>

	<header id="header" class="header <?php flatsome_header_classes(); ?>">
		<div class="header-wrapper">
			<?php get_template_part( 'template-parts/header/header', 'wrapper' ); ?>
		</div>
	</header>

	<?php do_action( 'flatsome_after_header' ); ?>

	<main id="main" class="<?php flatsome_main_classes(); ?>">
