<?php
/**
 * The template for displaying the footer.
 *
 * @package          Flatsome\Templates
 * @flatsome-version 3.16.0
 */

global $flatsome_opt;
?>

</main>

<footer id="footer" class="footer-wrapper">

	<?php do_action('flatsome_footer'); ?>

</footer>
<div class="scroll-top">
	<span>Page up</span>
	<div class="svg">
		<svg width="86" height="70" viewBox="0 0 86 70" fill="none" xmlns="http://www.w3.org/2000/svg">
			<g filter="url(#filter0_d_193_293)">
			<path fill-rule="evenodd" clip-rule="evenodd" d="M6.0245 61.0878C6.02344 61.0877 6.0224 61.0877 6.10479 59.6506L6.0224 61.0877L4.58124 61.0069L4.74605 58.1326L6.18636 58.2134L6.18677 58.2134L6.18721 58.2135L6.19057 58.2136L6.21202 58.2147C6.2322 58.2156 6.26414 58.2171 6.3076 58.2188C6.39454 58.2223 6.52735 58.2269 6.70367 58.2308C7.05612 58.2388 7.58183 58.2444 8.25995 58.2341C9.61639 58.2137 11.5802 58.13 13.9849 57.8759C18.7984 57.3672 25.3552 56.178 32.3341 53.4609C45.9268 48.169 61.1549 37.0795 68.2695 13.7467C67.9543 14.2048 67.6237 14.6755 67.2755 15.1635L67.2753 15.1637C63.7023 20.1672 57.5121 24.5777 50.1025 26.5018L48.705 26.8648L47.9799 24.0788L49.3772 23.716C56.1659 21.9531 61.7654 17.9182 64.9236 13.4958C68.2165 8.88196 69.8093 5.97592 71.7913 0.477419L74.545 1.33161C72.4236 9.29541 72.9559 15.4292 74.495 23.4456C75.5683 29.0364 77.5686 34.2707 80.3167 38.7974L81.064 40.0283L78.5937 41.5207L77.8464 40.2898C74.9119 35.4561 72.7936 29.8982 71.6593 23.9894C71.142 21.2952 70.7291 18.7724 70.4881 16.2968C62.8553 39.462 47.3 50.7239 33.3821 56.1425C26.1059 58.9752 19.2859 60.2104 14.2866 60.7387C11.785 61.0031 9.73337 61.091 8.30093 61.1126C7.58451 61.1234 7.02244 61.1176 6.63587 61.1089C6.44257 61.1045 6.29299 61.0994 6.1899 61.0953C6.13825 61.0933 6.09832 61.0915 6.07036 61.0902C6.05647 61.0895 6.04533 61.0889 6.03733 61.0885L6.02766 61.088L6.0245 61.0878ZM70.26 10.9836C70.2618 10.8775 70.264 10.7714 70.2665 10.6651C70.2117 10.7564 70.1563 10.8478 70.1004 10.9392L70.26 10.9836Z" fill="#1D68FF"/>
			</g>
			<defs>
			<filter id="filter0_d_193_293" x="0.581238" y="0.477539" width="84.4827" height="68.6409" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
			<feFlood flood-opacity="0" result="BackgroundImageFix"/>
			<feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
			<feOffset dy="4"/>
			<feGaussianBlur stdDeviation="2"/>
			<feComposite in2="hardAlpha" operator="out"/>
			<feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
			<feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_193_293"/>
			<feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_193_293" result="shape"/>
			</filter>
			</defs>
		</svg>		
	</div>
</div>

<?php wp_footer(); ?>
<?php
//<script type='text/javascript' src="<?php bloginfo('stylesheet_directory'); /photobox/photobox.js"></script>
//<script src="https://unpkg.com/popper.js@1"></script>
//<script src="https://unpkg.com/tippy.js@5/dist/tippy-bundle.iife.js"></script>
//<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
//<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
// <script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
// <script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/11.0.5/swiper-bundle.min.js"></script>
?>
<script type='text/javascript' src="<?php bloginfo('stylesheet_directory'); ?>/js/custom.js"></script>
<script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script type='text/javascript' src="<?php bloginfo('stylesheet_directory'); ?>/js/arcontactus.js"></script>
<script type='text/javascript' src="<?php bloginfo('stylesheet_directory'); ?>/js/gsap.min.js"></script>

</body>
</html>
