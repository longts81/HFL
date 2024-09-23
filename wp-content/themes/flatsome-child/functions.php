<?php
// Add custom Theme Functions here

// Custom Login URL
// function custom_login_url() {
//     // return home_url('/miko-admin');
//     global $wp_query;    
    
//     if ($_SERVER['REQUEST_URI'] == '/wp-admin/' && $_SERVER['REQUEST_METHOD'] == 'GET') {
//         if(!is_user_logged_in()){
//             wp_redirect(home_url('404'));
//             exit;
//         }
//     }
// }
// add_filter('login_url', 'custom_login_url');

// //Redirect wp-login.php to the new login URL
// function redirect_wp_login() {
//     global $pagenow;
//     if ($pagenow == 'wp-login.php' && $_SERVER['REQUEST_METHOD'] == 'GET') {
//         wp_redirect(home_url('/miko-admin'));
//         exit;
//     }
// }
// add_action('init', 'redirect_wp_login');

// // Custom Login Page Template
// function custom_login_page_template() {    
//     if (is_page('miko-admin')) {
//         include(ABSPATH . 'wp-login.php');
//         exit;
//     }
// }
// add_action('template_redirect', 'custom_login_page_template');

//MARK: Phân trang tuyển dụng
function modify_posts_per_page_for_categories($query) {
    if (!is_admin() && $query->is_main_query()) {
        // Check if it's a category archive page
        if (is_category('tuyen-dung')) {
            // Set the number of posts per page for category 1
            $query->set('posts_per_page', 6);
        }
        // Add more conditions for other categories as needed
    }
}
add_action('pre_get_posts', 'modify_posts_per_page_for_categories');

//MARK: Font size for editor
if ( ! function_exists( 'mce_text_sizes' ) ) {
    function mce_text_sizes( $initArray ){
        $initArray['fontsize_formats'] = "9px 10px 12px 13px 14px 16px 17px 18px 19px 20px 21px 24px 28px 32px 35px 36px 40px";
        return $initArray;
    }
    add_filter( 'tiny_mce_before_init', 'mce_text_sizes', 99 );
}

//MARK: Lấy id gốc của post type
function get_root_category($category = null) {
    if (!$category) $category = get_the_category()[0];
    $ancestors = get_ancestors($category->term_id, 'category');    
    if (empty($ancestors)) return $category;
    $root = get_category(array_pop($ancestors));
    return $root;
}

//MARK: Lấy id gốc của product type
function get_root_category_product($category = null) {
    // If no category is provided, get the first category of the current post
    if (!$category) {
        $categories = get_the_terms(get_the_ID(), 'product_cat');
        if (!$categories || is_wp_error($categories)) {
            return null; // Return null if there are no categories or if there's an error
        }
        $category = $categories[0]; // Get the first category
    }

    // Get the ancestors of the category
    $ancestors = get_ancestors($category->term_id, 'product_cat');

    // If there are no ancestors, return the current category
    if (empty($ancestors)) {
        return $category;
    }

    // Get the root ancestor (the last element in the ancestors array)
    $root_ancestor_id = array_pop($ancestors);
    $root_category = get_term($root_ancestor_id, 'product_cat');

    return $root_category;
}

//MARK: Data icon for social
wp_register_script('custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), null, true);
// Localize the script with the `tool` data
$tool = get_tool_data(); // Assuming this function fetches the `$tool` array
wp_localize_script('custom', 'toolData', array('tool' => $tool));
// Enqueue the script
wp_enqueue_script('custom');
function get_tool_data() {
    $args = array(
        'post_type' => 'social',        
        'posts_per_page' => -1, // -1 retrieves all posts in the category
    );
    $tool_arr = new WP_Query($args);
    $tool = array();
    if ($tool_arr->have_posts()) {
        while ($tool_arr->have_posts()) { $tool_arr->the_post();
            $tool[] = array(
                'ten' => get_the_title(),
                'link' => get_the_content(),
                'photo' => get_the_post_thumbnail_url(),
                'excerpt' => get_the_excerpt(),
            );
        }
    }
    return $tool;
}

//MARK: Script trang admin
function enqueue_swiper_assets() {
    wp_enqueue_style('swiper-css', 'https://unpkg.com/swiper/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://unpkg.com/swiper/swiper-bundle.min.js', array('jquery'), null, true);
    wp_enqueue_script('custom-swiper-js', get_stylesheet_directory_uri() . '/js/custom-swiper.js', array('swiper-js'), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_swiper_assets');
add_action('wp_footer', function(){
    ?>
        <script>
            var $choose = '<?= apply_filters( 'wpml_current_language', null ) == 'vi' ? "Chọn dịch vụ" : "Choose Services"; ?>';
            jQuery(document).ready(function($){
                setTimeout(function(){                    
                    $('form .group').find('select option:eq(0)').html($choose);           
                }, 100);
            });
        </script>
    <?php
});

//MARK: Tạo customize hotline
function customizer_a( $wp_customize ) {
	// Tạo section
    $wp_customize->add_section ('section_hotline',array(
            'title' => 'Hotline',
            'description' => 'Tùy chọn',
            'priority' => 25
        )
    );
    // Tạo setting
    $wp_customize->add_setting ('hotline',array(
	        'default' => '09xx.xxx.xxx'
	    )
	);
    $wp_customize->add_setting ('email',array(
	        'default' => '09xx.xxx.xxx'
	    )
	);
	// Tạo coltrol
	$wp_customize->add_control ('control_hotline',array(
	        'label' => 'Miền nam và miền Trung',
	        'section' => 'section_hotline',
	        'type' => 'text',
	        'settings' => 'hotline'
	    )
	);
	$wp_customize->add_control ('control_email',array(
	        'label' => 'Miền Bắc',
	        'section' => 'section_hotline',
	        'type' => 'text',
	        'settings' => 'email'
	    )
	);   
}
// add_action( 'customize_register', 'customizer_a' );

// MARK: Add UX Builder shortcode video
function miko_ux_builder_element(){
    add_ux_builder_shortcode('miko_viewvideo', array(
        'name'      => __('Video Miko'),
        'category'  => __('Content'),
        'thumbnail' =>  get_stylesheet_directory_uri().'/inc/builder/shortcodes/thumbnails/ux_video.svg',
        'priority'  => 1,
        'options' => array(
            'video_url'    =>  array(
                'type' => 'textfield',
                'heading' => 'Url video',
                'default' => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
                // 'step' => '1',
                // 'unit' => '',
                // 'min'   =>  1,
                //'max'   => 2
            ),
        ),
    ));
}
add_action('ux_builder_setup', 'miko_ux_builder_element');
function miko_viewvideo_func($atts){
    extract(shortcode_atts(array(
        'video_url'    => 'https://www.youtube.com/watch?v=9bZkp7q19f0',
    ), $atts));
    ob_start();
    get_template_part('template-parts/ux-builder/video', '', array('video_url' => $video_url));
    return ob_get_clean();
}
add_shortcode('miko_viewvideo', 'miko_viewvideo_func');

// MARK: Add UX Builder shortcode run text
function run_text_ux_builder_element(){
    add_ux_builder_shortcode('miko_runtext', array(
        'name'      => __('Run text'),
        'category'  => __('Content'),
        'thumbnail' =>  get_stylesheet_directory_uri().'/inc/builder/shortcodes/thumbnails/ux_text.svg',
        'priority'  => 1,
        'options' => array(
            'text'    =>  array(
                'full_width' => false,			
                'type' => 'textfield',
                'heading' => 'Text',
                'default' => '',
            ),
            'icon'    =>  array(
                'type' => 'select',
                'heading' => 'Icon',
                'default' => 'none',
                'options' => array(
                    'none' => 'None',
                    'eye' => 'Eye',
                    'star' => 'Star full',
                    'star-border' => 'Star Borde',
                )
            ),
            'effect'    =>  array(
                'type' => 'select',
                'heading' => 'Effect',
                'default' => 'none',
                'options' => array(
                    'none' => 'None',
                    'left-to-right' => 'Left to right',
                    'right-to-left' => 'Right to left',
                ),
            ),
        ),
    ));
}
add_action('ux_builder_setup', 'run_text_ux_builder_element');
function run_text_func($atts){
    extract(shortcode_atts(array(
        'text'    => 'Lorem ipsum dolor sit amet...',
        'effect'    => 'none',
    ), $atts));
    ob_start();    
    get_template_part('template-parts/ux-builder/run-text', '', array('text' => $atts['text'], 'effect' => $atts['effect'], 'icon' => $atts['icon'] ));
    return ob_get_clean();
}
add_shortcode('miko_runtext', 'run_text_func');

//MARK: Add our partner
function our_partner(){
    $label = array(
        'name' => 'Our Partner', //Tên post type dạng số nhiều
        'singular_name' => 'Our Partner' //Tên post type dạng số ít
    );
    $args = array(
        'labels' => $label, //Gọi các label trong biến $label ở trên
        'description' => 'Our Partner', //Mô tả của post type
        'supports' => array(
            'title',
            'thumbnail',            
            'editor'
            // 'comments',
        ), //Các tính năng được hỗ trợ trong post type
        // 'taxonomies' => array( 'post_tag' ), //Các taxonomy được phép sử dụng để phân loại nội dung
        'hierarchical' => false, //Cho phép phân cấp, nếu là false thì post type này giống như Post, true thì giống như Page
        'public' => true, //Kích hoạt post type
        'show_ui' => true, //Hiển thị khung quản trị như Post/Page
        'show_in_menu' => true, //Hiển thị trên Admin Menu (tay trái)
        'show_in_nav_menus' => true, //Hiển thị trong Appearance -> Menus
        'show_in_admin_bar' => true, //Hiển thị trên thanh Admin bar màu đen.
        'menu_position' => 5, //Thứ tự vị trí hiển thị trong menu (tay trái)
        'menu_icon' => 'dashicons-media-document', //Đường dẫn tới icon sẽ hiển thị
        'can_export' => true, //Có thể export nội dung bằng Tools -> Export
        'has_archive' => true, //Cho phép lưu trữ (month, date, year)
        'exclude_from_search' => true, //Loại bỏ khỏi kết quả tìm kiếm
        'publicly_queryable' => true, //Hiển thị các tham số trong query, phải đặt true
        'capability_type' => 'post'
        // 'show_in_menu' => 'product-manager'
    );
    register_post_type('our_partner', $args); //Tạo post type với slug tên là sanpham và các tham số trong biến $args ở trên
}
add_action('init', 'our_partner');

//MARK: Add Eye widget
class Eye_Widget extends WP_Widget {

    // Constructor
    function __construct() {
        parent::__construct(
            'eye', // Base ID
            esc_html__('Eye Effect', 'text_domain'), // Name
            array('description' => esc_html__('A Custom Widget for displaying content.', 'text_domain')) // Args
        );
    }

    // Front-end display of widget
    public function widget($args, $instance) {
        echo $args['before_widget'];

        $image_top = !empty($instance['image_top']) ? $instance['image_top'] : '';
        $image_bot = !empty($instance['image_bot']) ? $instance['image_bot'] : '';

        // Display content
        $str = '<div class="boxEye">';
        $str .= '<div class="eye">
                    <div class="pupil"></div>
                </div>
                <div class="eye">
                    <div class="pupil"></div>
                </div>';
        $str .= '</div>';

        if (!empty($image_top)) {
            $str .= '<div class="image_top svg-top">' . wp_kses($image_top, $this->allowed_svg_tags()) . '</div>';
        }
        if (!empty($image_bot)) {
            $str .= '<div class="image_bot svg-bottom">' . wp_kses($image_bot, $this->allowed_svg_tags()) . '</div>';
        }

        echo $str;
        echo $args['after_widget'];
    }

    // Back-end widget form
    public function form($instance) {
        $image_top = !empty($instance['image_top']) ? $instance['image_top'] : '';
        $image_bot = !empty($instance['image_bot']) ? $instance['image_bot'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('image_top'); ?>"><?php esc_html_e('Hình trên', 'text_domain'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('image_top'); ?>" name="<?php echo $this->get_field_name('image_top'); ?>" rows="5"><?php echo esc_textarea($image_top); ?></textarea>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('image_bot'); ?>"><?php esc_html_e('Hình dưới', 'text_domain'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('image_bot'); ?>" name="<?php echo $this->get_field_name('image_bot'); ?>" rows="5"><?php echo esc_textarea($image_bot); ?></textarea>
        </p>
        <?php
    }

    // Sanitize widget form values as they are saved
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['image_top'] = (!empty($new_instance['image_top'])) ? wp_kses($new_instance['image_top'], $this->allowed_svg_tags()) : '';
        $instance['image_bot'] = (!empty($new_instance['image_bot'])) ? wp_kses($new_instance['image_bot'], $this->allowed_svg_tags()) : '';
        return $instance;
    }

    // Define allowed SVG tags
    private function allowed_svg_tags() {
        return array(
            'svg' => array(
                'xmlns' => true,
                'width' => true,
                'height' => true,
                'viewBox' => true,
                'fill' => true,
            ),
            'path' => array(
                'd' => true,
                'fill' => true,
            ),
        );
    }
}
function eye_load_widget() {
    register_widget('Eye_Widget');
}
add_action('widgets_init', 'eye_load_widget');

if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => 'Eye effect',
        'id'   => 'eye_home',
        'description'   => 'Widget eye effect.',
        'before_widget' => '<div id="%1$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>'
    ));
}

//MARK: Add Footer widget
class Footer_Widget extends WP_Widget {

    // Constructor
    function __construct() {
        parent::__construct(
            'banner_footer', // Base ID
            esc_html__('Footer Effect', 'text_domain'), // Name
            array('description' => esc_html__('A Custom Widget for displaying content.', 'text_domain')) // Args
        );
    }

    // Front-end display of widget
    public function widget($args, $instance) {
        echo $args['before_widget'];

        $image_effect = !empty($instance['image_effect']) ? $instance['image_effect'] : '';
        $html_text = !empty($instance['html_text']) ? $instance['html_text'] : '';

        $image_center = !empty($instance['image_center']) ? $instance['image_center'] : '';
        $html_center = !empty($instance['html_center']) ? $instance['html_center'] : '';

        $image_bottom = !empty($instance['image_bottom']) ? $instance['image_bottom'] : '';
        $html_bottom = !empty($instance['html_bottom']) ? $instance['html_bottom'] : '';

        // Display content
        $str = '<div class="boxEffect">';

        if (!empty($image_effect) && !empty($html_text)) {
            $str .= '<div class="animate-marquee-rl">';
            $str .= '<div class="line-top">';
                for($index = 0; $index < 6; $index++) {
                    $str .= '<h3>' . $image_effect . '</h3>';
                    $str .= wp_kses($html_text, $this->allowed_svg_tags());
                }       
            $str .= '</div>';
            $str .= '</div>';
        }
        if (!empty($image_center) && !empty($html_center)) {
            $str .= '<div class="animate-marquee">';
            $str .= '<div class="line-center">';
                for($index = 0; $index < 6; $index++) {
                    $str .= '<h3>' . $image_center . '</h3>';
                    $str .= wp_kses($html_center, $this->allowed_svg_tags());
                }       
            $str .= '</div>';
            $str .= '</div>';
        }
        if (!empty($image_bottom) && !empty($html_bottom)) {
            $str .= '<div class="animate-marquee-rl">';
            $str .= '<div class="line-bottom">';
                for($index = 0; $index < 6; $index++) {
                    $str .= '<h3>' . $image_bottom . '</h3>';
                    $str .= wp_kses($html_bottom, $this->allowed_svg_tags());
                }       
            $str .= '</div>';
            $str .= '</div>';
        }

        $str .= '</div>';

        echo $str;
        echo $args['after_widget'];
    }

    // Back-end widget form
    public function form($instance) {
        $image_effect = !empty($instance['image_effect']) ? $instance['image_effect'] : '';
        $html_text = !empty($instance['html_text']) ? $instance['html_text'] : '';
        $image_center = !empty($instance['image_center']) ? $instance['image_center'] : '';
        $html_center = !empty($instance['html_center']) ? $instance['html_center'] : '';
        $image_bottom = !empty($instance['image_bottom']) ? $instance['image_bottom'] : '';
        $html_bottom = !empty($instance['html_bottom']) ? $instance['html_bottom'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('image_effect'); ?>"><?php esc_html_e('Dòng chữ trên', 'text_domain'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('image_effect'); ?>" name="<?php echo $this->get_field_name('image_effect'); ?>" value="<?php echo esc_attr($image_effect); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('html_text'); ?>"><?php esc_html_e('Hình trên', 'text_domain'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('html_text'); ?>" name="<?php echo $this->get_field_name('html_text'); ?>" rows="5"><?php echo esc_textarea($html_text); ?></textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('image_center'); ?>"><?php esc_html_e('Dòng chữ giữa', 'text_domain'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('image_center'); ?>" name="<?php echo $this->get_field_name('image_center'); ?>" value="<?php echo esc_attr($image_center); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('html_center'); ?>"><?php esc_html_e('Hình giữa', 'text_domain'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('html_center'); ?>" name="<?php echo $this->get_field_name('html_center'); ?>" rows="5"><?php echo esc_textarea($html_center); ?></textarea>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('image_bottom'); ?>"><?php esc_html_e('Dòng chữ dưới', 'text_domain'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('image_bottom'); ?>" name="<?php echo $this->get_field_name('image_bottom'); ?>" value="<?php echo esc_attr($image_bottom); ?>"/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('html_bottom'); ?>"><?php esc_html_e('Hình dưới', 'text_domain'); ?></label>
            <textarea class="widefat" id="<?php echo $this->get_field_id('html_bottom'); ?>" name="<?php echo $this->get_field_name('html_bottom'); ?>" rows="5"><?php echo esc_textarea($html_bottom); ?></textarea>
        </p>

        <?php
    }

    // Sanitize widget form values as they are saved
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['image_effect'] = (!empty($new_instance['image_effect'])) ? strip_tags($new_instance['image_effect']) : '';
        $instance['html_text'] = (!empty($new_instance['html_text'])) ? wp_kses($new_instance['html_text'], $this->allowed_svg_tags()) : '';
        $instance['image_center'] = (!empty($new_instance['image_center'])) ? strip_tags($new_instance['image_center']) : '';
        $instance['html_center'] = (!empty($new_instance['html_center'])) ? wp_kses($new_instance['html_center'], $this->allowed_svg_tags()) : '';
        $instance['image_bottom'] = (!empty($new_instance['image_bottom'])) ? strip_tags($new_instance['image_bottom']) : '';
        $instance['html_bottom'] = (!empty($new_instance['html_bottom'])) ? wp_kses($new_instance['html_bottom'], $this->allowed_svg_tags()) : '';        
        return $instance;
    }

    // Define allowed SVG tags
    private function allowed_svg_tags() {
        return array(
            'svg' => array(
                'xmlns' => true,
                'width' => true,
                'height' => true,
                'viewBox' => true,
                'fill' => true,
            ),
            'path' => array(
                'd' => true,
                'fill' => true,
                'stroke' => true,
                'stroke-width' => true,
            ),
        );
    }
}
function footer_load_widget() {
    register_widget('Footer_Widget');
}
add_action('widgets_init', 'footer_load_widget');

if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => 'Footer effect',
        'id'   => 'footer_home',
        'description'   => 'Widget footer effect.',
        'before_widget' => '<div id="%1$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>'
    ));
}

//MARK: Add Post Category widget
class Post_Category_Widget extends WP_Widget {
    
    // Constructor
    function __construct() {
        parent::__construct(
            'category_post', // Base ID
            esc_html__('Category Post', 'text_domain'), // Name
            array('description' => esc_html__('A Custom Widget for displaying content.', 'text_domain')) // Args
        );
    }
    // Front-end display of widget
    public function widget($args, $instance) {
        echo $args['before_widget'];
        
        $category_post = !empty($instance['category_post']) ? $instance['category_post'] : array();        
        
        if (!empty($category_post)) {

            $arg = array(
                'hide_empty' => false,
                'parent' => $category_post[0]
            );
            $category = get_categories($arg);
            
            if (!empty($category)) {
                foreach ($category as $key => $value) {
                    $query = new WP_Query(array(
                        'post_type' => 'post',
                        'posts_per_page' => -1,
                        'cat' => $value->term_id,
                        'post_status' => 'publish',
                    ));
        
                    if ($query->have_posts()) {
                        echo '<div class="list__category__post">';
                        echo '<div class="title__category__post"><svg width="98" height="93" viewBox="0 0 98 93" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M50.1838 34.5976C40.6272 34.5976 32.8801 26.8526 32.8801 17.2988C32.8801 7.74493 40.6272 0 50.1838 0C59.7404 0 67.4875 7.74493 67.4875 17.2988C67.4875 26.8526 59.7404 34.5976 50.1838 34.5976Z" fill="#E0FF78"/>
                            <path d="M17.3037 63.5689C7.74706 63.5689 -9.53674e-05 55.824 -9.53674e-05 46.2701C-9.53674e-05 36.7163 7.74706 28.9713 17.3037 28.9713C26.8603 28.9713 34.6074 36.7163 34.6074 46.2701C34.6074 55.824 26.8603 63.5689 17.3037 63.5689Z" fill="#E0FF78"/>
                            <path d="M97.3495 9.34243C97.3495 55.1303 60.2279 92.2722 14.4355 92.2722V72.1672C49.1292 72.1672 77.2267 44.0365 77.2267 9.34243H97.3495Z" fill="#E0FF78"/>
                            </svg>';
                        echo '<h3><a href="' . get_category_link($value->term_id) . '#post-list-custom'.$key.'"><span>' . $value->name . '</span></a></h3>';
                        echo '</div>';
                        while ($query->have_posts()) {
                            $query->the_post();
                            get_template_part('template-parts/posts/category-post');
                        }
                        echo '</div>';
                    }
                }
            }
            
            wp_reset_postdata();
        }

        // Display content
        echo $args['after_widget'];
    }

    // Back-end widget form
    public function form($instance) {
        $category_post = !empty($instance['category_post']) ? $instance['category_post'] : array();
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('category_post'); ?>"><?php _e('Select Left Product:', 'text_domain'); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id('category_post'); ?>" name="<?php echo $this->get_field_name('category_post'); ?>[]">
                <?php
                $args = array(
                    'orderby' => 'name',
                    'order' => 'ASC',
                    'hide_empty' => false,
                    'parent' => 0
                );
                $categories = get_categories($args);
                foreach ($categories as $category) {
                    echo '<option value="' . $category->term_id . '"' . (in_array($category->term_id, $category_post) ? ' selected' : '') . '>' . $category->name . '</option>';
                }                            
                ?>
            </select>
        </p>
        <?php
    }

    // Sanitize widget form values as they are saved
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['category_post'] = (!empty($new_instance['category_post'])) ? array_map('intval', $new_instance['category_post']) : array();
        return $instance;
    }
}
function post_category_load_widget() {
    register_widget('Post_Category_Widget');
}
add_action('widgets_init', 'post_category_load_widget');

if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => 'Category Post',
        'id'   => 'category_post',
        'description'   => 'Widget Category Post',
        'before_widget' => '<div id="%1$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>'
    ));
}

//MARK: Add Partner widget
class Partner_Widget extends WP_Widget {

    // Constructor
    function __construct() {
        parent::__construct(
            'partner', // Base ID
            esc_html__('Partner Post', 'text_domain'), // Name
            array('description' => esc_html__('A Custom Widget for displaying content.', 'text_domain')) // Args
        );
    }

    // Front-end display of widget
    public function widget($args, $instance) {
        echo $args['before_widget'];

        $number = !empty($instance['number']) ? $instance['number'] : 3;
        $autoplay = !empty($instance['autoplay']) ? $instance['autoplay'] : false;
        if($autoplay == 'true') {
            $autoplay = '{
                            delay: 2000,
                            disableOnInteraction: false,
                            pauseOnMouseEnter: true
                        }';
        }        
        // Display content
        $str = '<div class="boxPartner">';
        $str .= '<div class="swiper swiper-partner">
                    <div class="swiper-wrapper">';
                    $query = new WP_Query(array(
                        'post_type' => 'our_partner',
                        'posts_per_page' => -1,
                        'post_status' => 'publish',
                        'orderby' => 'menu_order',
                        'order' => 'ASC'
                    ));
                    if ($query->have_posts()) {
                        while ($query->have_posts()) {
                            $query->the_post();
                            ob_start();
                            get_template_part('template-parts/posts/partner-post');
                            $str .= ob_get_clean();
                        }
                    }
                    wp_reset_postdata();
        $str .= '</div>
                <div class="group-div">
                    <div class="swiper-partner-button-next">
                        <svg class="icon-stroke" width="61" height="29" viewBox="0 0 61 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_189_476)">
                            <mask id="path-1-inside-1_189_476" fill="white">
                            <path d="M0.5 14.4981C10.9862 17.1749 17.4713 29 17.4713 29V19.4255C46.393 19.4255 60.0822 26.1119 60.5 26.3193C52.6485 22.2368 53.1077 14.4981 53.1077 14.4981C53.1077 14.4981 52.6485 6.76321 60.5 2.67686C60.0822 2.88425 46.393 9.57449 17.4676 9.57449V0C17.4676 0 10.9824 11.8251 0.496239 14.4981"/>
                            </mask>
                            <path d="M17.4713 29H18.4713L16.5945 29.4809L17.4713 29ZM17.4713 19.4255H16.4713V18.4255H17.4713V19.4255ZM60.5 26.3193L60.9613 25.4321L60.0554 27.215L60.5 26.3193ZM53.1077 14.4981L54.106 14.4388L54.1095 14.4981L54.106 14.5573L53.1077 14.4981ZM60.5 2.67686L60.0554 1.78115L60.9617 3.56391L60.5 2.67686ZM17.4676 9.57449V10.5745H16.4676V9.57449H17.4676ZM17.4676 0L16.5908 -0.480859L18.4676 0H17.4676ZM0.747345 13.5292C6.27011 14.939 10.6758 18.733 13.6646 22.0876C15.1676 23.7745 16.3335 25.3742 17.1246 26.5534C17.5205 27.1435 17.8236 27.6298 18.0289 27.9709C18.1316 28.1415 18.21 28.2759 18.2634 28.3689C18.29 28.4155 18.3105 28.4517 18.3247 28.4769C18.3317 28.4896 18.3372 28.4994 18.3412 28.5065C18.3431 28.51 18.3447 28.5129 18.3458 28.515C18.3464 28.516 18.3469 28.5169 18.3473 28.5176C18.3475 28.5179 18.3477 28.5183 18.3478 28.5185C18.348 28.5188 18.3481 28.5191 17.4713 29C16.5945 29.4809 16.5946 29.4811 16.5947 29.4812C16.5947 29.4812 16.5948 29.4813 16.5948 29.4813C16.5948 29.4813 16.5947 29.4811 16.5945 29.4807C16.594 29.48 16.5932 29.4785 16.592 29.4763C16.5896 29.472 16.5857 29.4649 16.5802 29.4551C16.5691 29.4354 16.5519 29.4049 16.5285 29.3641C16.4818 29.2827 16.4106 29.1604 16.3155 29.0024C16.1252 28.6864 15.8397 28.2279 15.4638 27.6676C14.7112 26.546 13.6005 25.0221 12.1713 23.4181C9.29605 20.1909 5.21606 16.734 0.252655 15.467L0.747345 13.5292ZM16.4713 29V19.4255H18.4713V29H16.4713ZM17.4713 18.4255C46.5535 18.4255 60.3944 25.1504 60.9446 25.4236L60.0554 27.215C59.77 27.0734 46.2324 20.4255 17.4713 20.4255V18.4255ZM60.0387 27.2065C55.8501 25.0286 53.8527 21.8516 52.917 19.2118C52.4518 17.8993 52.2497 16.7234 52.1637 15.8714C52.1207 15.4447 52.1065 15.097 52.1034 14.8512C52.1019 14.7282 52.1031 14.6305 52.1048 14.5609C52.1057 14.5261 52.1067 14.4983 52.1076 14.4778C52.108 14.4676 52.1084 14.4592 52.1087 14.4527C52.1089 14.4494 52.1091 14.4467 52.1092 14.4443C52.1092 14.4432 52.1093 14.4422 52.1094 14.4412C52.1094 14.4408 52.1094 14.4402 52.1094 14.44C52.1095 14.4394 52.1095 14.4388 53.1077 14.4981C54.106 14.5573 54.106 14.5568 54.106 14.5564C54.106 14.5563 54.1061 14.5559 54.1061 14.5556C54.1061 14.5552 54.1061 14.5549 54.1061 14.5546C54.1062 14.5542 54.1062 14.5542 54.1061 14.5547C54.1061 14.5557 54.106 14.5584 54.1058 14.563C54.1054 14.5721 54.1048 14.5882 54.1042 14.6111C54.103 14.6568 54.102 14.7293 54.1033 14.8259C54.1057 15.0193 54.117 15.3081 54.1536 15.6707C54.2269 16.3972 54.4007 17.4112 54.8021 18.5437C55.5997 20.7939 57.2984 23.5275 60.9613 25.4321L60.0387 27.2065ZM53.1077 14.4981C52.1095 14.5573 52.1095 14.5568 52.1094 14.5562C52.1094 14.556 52.1094 14.5554 52.1094 14.5549C52.1093 14.554 52.1092 14.553 52.1092 14.5518C52.1091 14.5495 52.1089 14.5467 52.1087 14.5435C52.1084 14.537 52.108 14.5286 52.1076 14.5184C52.1067 14.4979 52.1057 14.4701 52.1048 14.4353C52.1031 14.3657 52.1019 14.268 52.1034 14.1451C52.1065 13.8994 52.1207 13.5518 52.1637 13.1252C52.2497 12.2735 52.4518 11.098 52.9171 9.78571C53.8527 7.14647 55.8501 3.96962 60.0383 1.78981L60.9617 3.56391C57.2985 5.47045 55.5997 8.20421 54.8021 10.454C54.4007 11.5862 54.2269 12.5998 54.1536 13.3261C54.117 13.6885 54.1057 13.9772 54.1033 14.1704C54.102 14.2669 54.103 14.3394 54.1042 14.3851C54.1048 14.408 54.1054 14.4241 54.1058 14.4332C54.1059 14.4377 54.1061 14.4405 54.1061 14.4414C54.1062 14.4419 54.1062 14.4419 54.1061 14.4415C54.1061 14.4413 54.1061 14.4409 54.1061 14.4405C54.1061 14.4403 54.106 14.4399 54.106 14.4397C54.106 14.4393 54.106 14.4388 53.1077 14.4981ZM60.9446 3.57258C60.3945 3.84564 46.5537 10.5745 17.4676 10.5745V8.57449C46.2323 8.57449 59.7699 1.92286 60.0554 1.78115L60.9446 3.57258ZM16.4676 9.57449V0H18.4676V9.57449H16.4676ZM17.4676 0C18.3444 0.480859 18.3442 0.481155 18.344 0.481496C18.3439 0.48167 18.3437 0.482057 18.3435 0.482405C18.3431 0.483101 18.3427 0.483978 18.3421 0.485032C18.3409 0.487142 18.3393 0.489967 18.3374 0.493497C18.3335 0.500557 18.328 0.510439 18.3209 0.523061C18.3067 0.548305 18.2863 0.584516 18.2596 0.631052C18.2062 0.724117 18.1278 0.858521 18.0251 1.02911C17.8198 1.37021 17.5168 1.85648 17.1208 2.44659C16.3297 3.6257 15.1638 5.2253 13.6608 6.91194C10.6719 10.2661 6.26618 14.0592 0.743248 15.4671L0.249226 13.5291C5.21247 12.2639 9.29237 8.80802 12.1676 5.58137C13.5967 3.97762 14.7075 2.45389 15.46 1.33227C15.8359 0.772014 16.1214 0.313567 16.3117 -0.00245531C16.4068 -0.160426 16.478 -0.282686 16.5248 -0.364145C16.5481 -0.404871 16.5654 -0.435386 16.5764 -0.455054C16.5819 -0.464887 16.5859 -0.472008 16.5883 -0.476335C16.5895 -0.478499 16.5903 -0.479965 16.5907 -0.480722C16.5909 -0.481101 16.591 -0.481302 16.591 -0.481325C16.591 -0.481337 16.591 -0.48122 16.591 -0.481226C16.5909 -0.481065 16.5908 -0.480859 17.4676 0Z" fill="#E0FF78" mask="url(#path-1-inside-1_189_476)"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_189_476">
                                <rect width="60" height="29" fill="white" transform="matrix(-1 0 0 1 60.5 0)"/>
                            </clipPath>
                            </defs>
                        </svg>
                        <svg class="icon-fill" width="60" height="29" viewBox="0 0 60 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.00378418 14.5019C10.49 11.8251 16.9751 0 16.9751 0V9.57449C45.8968 9.57449 59.586 2.8881 60.0038 2.68071C52.1523 6.76321 52.6115 14.5019 52.6115 14.5019C52.6115 14.5019 52.1523 22.2368 60.0038 26.3231C59.586 26.1157 45.8968 19.4255 16.9714 19.4255V29C16.9714 29 10.4862 17.1749 2.28882e-05 14.5019" fill="#E0FF78"/>
                        </svg>
                    </div>
                    <div class="swiper-partner-pagination"></div>
                    <div class="swiper-partner-button-prev">
                        <svg class="icon-fill" width="61" height="29" viewBox="0 0 61 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M60.5 14.4981C50.0138 17.1749 43.5287 29 43.5287 29V19.4255C14.607 19.4255 0.917791 26.1119 0.5 26.3193C8.35145 22.2368 7.89226 14.4981 7.89226 14.4981C7.89226 14.4981 8.35145 6.76321 0.5 2.67686C0.917791 2.88425 14.607 9.57449 43.5324 9.57449V0C43.5324 0 50.0176 11.8251 60.5038 14.4981" fill="#E0FF78"/>
                        </svg>
                        <svg class="icon-stroke" width="61" height="29" viewBox="0 0 61 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_2083_317)">
                            <mask id="path-1-inside-1_2083_317" fill="white">
                            <path d="M60.5 14.5019C50.0138 11.8251 43.5287 2.37552e-07 43.5287 2.37552e-07V9.57449C14.607 9.57449 0.917791 2.8881 0.5 2.68071C8.35145 6.76321 7.89226 14.5019 7.89226 14.5019C7.89226 14.5019 8.35145 22.2368 0.5 26.3231C0.917791 26.1157 14.607 19.4255 43.5324 19.4255V29C43.5324 29 50.0176 17.1749 60.5038 14.5019"/>
                            </mask>
                            <path d="M43.5287 2.37552e-07H42.5287L44.4055 -0.480858L43.5287 2.37552e-07ZM43.5287 9.57449L44.5287 9.57449V10.5745L43.5287 10.5745V9.57449ZM0.5 2.68071L0.0386695 3.56793L0.944629 1.78499L0.5 2.68071ZM7.89226 14.5019L6.89402 14.5612L6.8905 14.5019L6.89401 14.4427L7.89226 14.5019ZM0.5 26.3231L0.944629 27.2189L0.0383279 25.4361L0.5 26.3231ZM43.5324 19.4255V18.4255H44.5324V19.4255H43.5324ZM43.5324 29L44.4092 29.4809L42.5324 29H43.5324ZM60.2527 15.4708C54.7299 14.061 50.3242 10.267 47.3354 6.91237C45.8324 5.2255 44.6665 3.62579 43.8754 2.44663C43.4795 1.8565 43.1764 1.37022 42.9711 1.02911C42.8684 0.858519 42.79 0.724113 42.7366 0.63105C42.71 0.584514 42.6895 0.548303 42.6753 0.52306C42.6683 0.510438 42.6628 0.500557 42.6588 0.493497C42.6569 0.489967 42.6553 0.487142 42.6542 0.485032C42.6536 0.483978 42.6531 0.483101 42.6527 0.482405C42.6525 0.482058 42.6523 0.481671 42.6522 0.481497C42.652 0.481155 42.6519 0.480859 43.5287 2.37552e-07C44.4055 -0.480858 44.4054 -0.481065 44.4053 -0.481226C44.4053 -0.48122 44.4052 -0.481337 44.4052 -0.481325C44.4052 -0.481302 44.4053 -0.4811 44.4055 -0.480721C44.406 -0.479964 44.4068 -0.478498 44.408 -0.476334C44.4104 -0.472006 44.4143 -0.464886 44.4198 -0.455052C44.4309 -0.435383 44.4481 -0.404867 44.4715 -0.36414C44.5182 -0.282678 44.5894 -0.160415 44.6845 -0.00243901C44.8748 0.313594 45.1603 0.77206 45.5362 1.33235C46.2888 2.45404 47.3995 3.9779 48.8287 5.58191C51.7039 8.80905 55.7839 12.266 60.7473 13.533L60.2527 15.4708ZM44.5287 2.37552e-07V9.57449L42.5287 9.57449V2.37552e-07L44.5287 2.37552e-07ZM43.5287 10.5745C14.4465 10.5745 0.605608 3.84956 0.0553705 3.57642L0.944629 1.78499C1.22997 1.92663 14.7676 8.57449 43.5287 8.57449V10.5745ZM0.961331 1.79348C5.14989 3.9714 7.14731 7.14844 8.08297 9.78817C8.54821 11.1007 8.75032 12.2766 8.83628 13.1286C8.87933 13.5553 8.89346 13.903 8.89657 14.1488C8.89813 14.2718 8.89693 14.3695 8.89518 14.4391C8.89431 14.4739 8.8933 14.5017 8.89243 14.5222C8.89199 14.5324 8.89159 14.5408 8.89126 14.5473C8.89109 14.5506 8.89094 14.5533 8.89082 14.5557C8.89075 14.5568 8.89069 14.5578 8.89064 14.5588C8.89062 14.5592 8.89058 14.5598 8.89057 14.56C8.89053 14.5606 8.8905 14.5612 7.89226 14.5019C6.89401 14.4427 6.89399 14.4432 6.89396 14.4436C6.89395 14.4437 6.89393 14.4441 6.89392 14.4444C6.89389 14.4448 6.89387 14.4451 6.89386 14.4454C6.89384 14.4458 6.89384 14.4458 6.89386 14.4453C6.89391 14.4443 6.89405 14.4416 6.89424 14.437C6.89463 14.4279 6.89524 14.4118 6.89581 14.3889C6.89696 14.3432 6.89796 14.2707 6.89673 14.1741C6.89429 13.9807 6.88296 13.6919 6.84638 13.3293C6.77308 12.6028 6.59927 11.5888 6.19788 10.4563C5.40027 8.20608 3.70156 5.47252 0.0386695 3.56793L0.961331 1.79348ZM7.89226 14.5019C8.8905 14.4427 8.89053 14.4432 8.89057 14.4438C8.89058 14.444 8.89061 14.4446 8.89064 14.4451C8.89069 14.446 8.89075 14.447 8.89082 14.4482C8.89094 14.4505 8.89109 14.4533 8.89126 14.4565C8.89159 14.463 8.89199 14.4714 8.89243 14.4816C8.8933 14.5021 8.89431 14.5299 8.89518 14.5647C8.89693 14.6343 8.89813 14.732 8.89657 14.8549C8.89346 15.1006 8.87932 15.4482 8.83627 15.8748C8.75031 16.7265 8.5482 17.902 8.08295 19.2143C7.14728 21.8535 5.14993 25.0304 0.961672 27.2102L0.0383279 25.4361C3.70152 23.5295 5.4003 20.7958 6.1979 18.546C6.59928 17.4138 6.77309 16.4002 6.84638 15.6739C6.88296 15.3115 6.89429 15.0228 6.89673 14.8296C6.89796 14.7331 6.89696 14.6606 6.89581 14.6149C6.89524 14.592 6.89463 14.5759 6.89424 14.5668C6.89405 14.5623 6.89391 14.5595 6.89386 14.5586C6.89384 14.5581 6.89384 14.5581 6.89386 14.5585C6.89387 14.5587 6.89389 14.5591 6.89392 14.5595C6.89393 14.5597 6.89395 14.5601 6.89396 14.5603C6.89399 14.5607 6.89402 14.5612 7.89226 14.5019ZM0.0553705 25.4274C0.605467 25.1544 14.4463 18.4255 43.5324 18.4255V20.4255C14.7677 20.4255 1.23011 27.0771 0.944629 27.2189L0.0553705 25.4274ZM44.5324 19.4255V29L42.5324 29V19.4255H44.5324ZM43.5324 29C42.6556 28.5191 42.6558 28.5188 42.656 28.5185C42.6561 28.5183 42.6563 28.5179 42.6565 28.5176C42.6569 28.5169 42.6573 28.516 42.6579 28.515C42.6591 28.5129 42.6607 28.51 42.6626 28.5065C42.6665 28.4994 42.672 28.4896 42.6791 28.4769C42.6933 28.4517 42.7137 28.4155 42.7404 28.3689C42.7938 28.2759 42.8721 28.1415 42.9749 27.9709C43.1802 27.6298 43.4833 27.1435 43.8792 26.5534C44.6703 25.3743 45.8362 23.7747 47.3392 22.0881C50.3281 18.7339 54.7338 14.9408 60.2568 13.5329L60.7508 15.4709C55.7875 16.7361 51.7076 20.192 48.8324 23.4186C47.4033 25.0224 46.2925 26.5461 45.54 27.6677C45.1641 28.228 44.8786 28.6864 44.6883 29.0025C44.5932 29.1604 44.522 29.2827 44.4752 29.3641C44.4519 29.4049 44.4346 29.4354 44.4236 29.4551C44.4181 29.4649 44.4141 29.472 44.4117 29.4763C44.4105 29.4785 44.4097 29.48 44.4093 29.4807C44.4091 29.4811 44.409 29.4813 44.409 29.4813C44.409 29.4813 44.409 29.4812 44.409 29.4812C44.4091 29.4811 44.4092 29.4809 43.5324 29Z" fill="#E0FF78" mask="url(#path-1-inside-1_2083_317)"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_2083_317">
                            <rect width="60" height="29" fill="white" transform="matrix(1 0 0 -1 0.5 29)"/>
                            </clipPath>
                            </defs>
                        </svg>
                    </div>
                </div>
                </div>';
        $str .= '</div>';

        $str .='<script type="text/javascript">
                jQuery(document).ready(function($) {
                    const swiperPartner = new Swiper(".swiper-partner", {
                        autoplay: '.$autoplay.',
                        speed: 2000,                        
                        slidesPerView: 1,
                        spaceBetween: 10,
                        mousewheel: false,
                        loop: true,
                        pagination: {
                            el: ".swiper-partner-pagination",
                            clickable: true,
                        },
                        navigation: {
                            nextEl: ".swiper-partner-button-next",
                            prevEl: ".swiper-partner-button-prev",
                        },
                        breakpoints: {
                            280: {
                                slidesPerView: 1.2,
                                spaceBetween: 16,
                            },
                            768: {                
                                slidesPerView: 2,
                                spaceBetween: 10,
                            },
                            1024: {                
                                slidesPerView: 3,
                                spaceBetween: 16,
                            },
                            1180: {
                                slidesPerView: '.$number.',
                                spaceBetween: 40,
                            }
                        },
                    });
                });
                </script>';
        echo $str;
        echo $args['after_widget'];
    }

    // Back-end widget form
    public function form($instance) {
        $number = !empty($instance['number']) ? $instance['number'] : '';
        $autoplay = !empty($instance['autoplay']) ? $instance['autoplay'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php esc_html_e('Số card', 'text_domain'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo esc_attr($number); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('autoplay'); ?>"><?php esc_html_e('Tự động chạy', 'text_domain'); ?></label>
            <select class="widefat" name="<?php echo $this->get_field_name('autoplay'); ?>" id="<?php echo $this->get_field_id('autoplay'); ?>">
                <option value="">Chọn kiểu</option>
                <option value="true" <?php selected($autoplay, 'true'); ?>>Tự động</option>
                <option value="false" <?php selected($autoplay, 'false'); ?>>Không tự động</option>
            </select>
        </p>
        <?php
    }

    // Sanitize widget form values as they are saved
    public function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['number'] = (!empty($new_instance['number'])) ? strip_tags($new_instance['number']) : '';
        $instance['autoplay'] = (!empty($new_instance['autoplay'])) ? strip_tags($new_instance['autoplay']) : '';
        return $instance;
    }
}
function partner_load_widget() {
    register_widget('Partner_Widget');
}
add_action('widgets_init', 'partner_load_widget');

if (function_exists('register_sidebar')) {
    register_sidebar(array(
        'name' => 'Partner Post',
        'id'   => 'partner_home',
        'description'   => 'Widget Partner.',
        'before_widget' => '<div id="%1$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2>',
        'after_title'   => '</h2>'
    ));
}