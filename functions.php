<?php 
/**
 * functions.php
 *
 * The theme's functions and definitions.
 */

/**
 * ----------------------------------------------------------------------------------------
 * 1.0 - Define constants.
 * ----------------------------------------------------------------------------------------
 */
define( 'THEMEROOT', get_stylesheet_directory_uri() );
define( 'IMAGES', THEMEROOT . '/images' );
define( 'SCRIPTS', THEMEROOT . '/js' );
define( 'FRAMEWORK', get_template_directory() . '/framework' );


/**
 * ----------------------------------------------------------------------------------------
 * 2.0 - Load the framework.
 * ----------------------------------------------------------------------------------------
 */
require_once( FRAMEWORK . '/init.php' );


/**
 * ----------------------------------------------------------------------------------------
 * 3.0 - Set up the content width value based on the theme's design.
 * ----------------------------------------------------------------------------------------
 */
// if ( ! isset( $content_width ) ) {
// 	$content_width = 800;
// }


/**
 * ----------------------------------------------------------------------------------------
 * 4.0 - Set up theme default and register various supported features.
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'alpha_setup' ) ) {
	function alpha_setup() {
		/**
		 * Make the theme available for translation.
		 */
		$lang_dir = THEMEROOT . '/languages';
		load_theme_textdomain( 'alpha', $lang_dir );

		/**
		 * Add support for post formats.
		 */
		add_theme_support( 'post-formats',
			array(
				'gallery',
				'link',
				'image',
				'quote',
				'video',
				'audio'
			)
		);

		/**
		 * Add support for automatic feed links.
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Add support for post thumbnails.
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Register nav menus.
		 */
		register_nav_menus(
			array(
				'main-menu' => __( 'Main Menu', 'alpha' )
			)
		);
	}

	add_action( 'after_setup_theme', 'alpha_setup' );
}


/**
 * ----------------------------------------------------------------------------------------
 * 5.0 - Display meta information for a specific post.
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'min_post_meta' ) ) {
    function min_post_meta() {
        if ( get_post_type() === 'post' ) {
            /* Post author. */
            echo '<p class="post-meta">';
            _e( 'by', 'tuts' );
            printf( '<a href="%1$s" rel="author"> %2$s </a>', esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ), get_the_author() );
            _e( 'on', 'tuts' );
            echo ' <span>' . get_the_date() . '</span></p>';
        }
    }
}



/**
 * ----------------------------------------------------------------------------------------
 * 6.0 - Display navigation to the next/previous set of posts.
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'alpha_paging_nav' ) ) {
	function alpha_paging_nav() { ?>
		<ul>
			<?php 
				if ( get_previous_posts_link() ) : ?>
				<li class="next">
					<?php previous_posts_link( __( 'Newer Posts &rarr;', 'alpha' ) ); ?>
				</li>
				<?php endif;
			 ?>
			<?php 
				if ( get_next_posts_link() ) : ?>
				<li class="previous">
					<?php next_posts_link( __( '&larr; Older Posts', 'alpha' ) ); ?>
				</li>
				<?php endif;
			 ?>
		</ul> <?php
	}
}


/**
 * ----------------------------------------------------------------------------------------
 * 7.0 - Register the widget areas.
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'tuts_widget_init' ) ) {
    function tuts_widget_init() {
        if ( function_exists( 'register_sidebar' ) ) {
            register_sidebar( array(
                'name' => __( 'Main Widget Area', 'tuts' ),
                'id' => 'main-sidebar',
                'description' => __( 'Appears in the blog pages.', 'tuts' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div> <!-- end widget -->',
                'before_title' => '<h2>',
                'after_title' => '</h2>'
            ) );
        }
    }

    add_action( 'widgets_init', 'tuts_widget_init' );
}


/**
 * ----------------------------------------------------------------------------------------
 * 8.0 - Function that validates a field's length.
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'alpha_validate_length' ) ) {
	function alpha_validate_length( $fieldValue, $minLength ) {
		// First, remove trailing and leading whitespace
		return ( strlen( trim( $fieldValue ) ) > $minLength );
	}
}


/**
 * ----------------------------------------------------------------------------------------
 * 9.0 - Include the generated CSS in the page header.
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'alpha_load_wp_head' ) ) {
	function alpha_load_wp_head() {
		// Get the logos
		$logo = IMAGES . '/logo.png';
		$logo_retina = IMAGES . '/logo@2x.png';

		$logo_size = getimagesize( $logo );
		?>
		
		<!-- Logo CSS -->
		<style type="text/css">
			.site-logo a {
				background: transparent url( <?php echo $logo; ?> ) 0 0 no-repeat;
				width: <?php echo $logo_size[0] ?>px;
				height: <?php echo $logo_size[1] ?>px;
				display: inline-block;
			}

			@media only screen and (-webkit-min-device-pixel-ratio: 1.5),
			only screen and (-moz-min-device-pixel-ratio: 1.5),
			only screen and (-o-min-device-pixel-ratio: 3/2),
			only screen and (min-device-pixel-ratio: 1.5) {
				.site-logo a {
					background: transparent url( <?php echo $logo_retina; ?> ) 0 0 no-repeat;
					background-size: <?php echo $logo_size[0]; ?>px <?php echo $logo_size[1]; ?>px;
				}
			}
		</style>

		<?php
	}

	add_action( 'wp_head', 'alpha_load_wp_head' );
}

/**
 * ----------------------------------------------------------------------------------------
 * 10.0 - Load the custom scripts for the theme.
 * ----------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'alpha_scripts' ) ) {
	function alpha_scripts() {
		// Adds support for pages with threaded comments
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Register scripts
		wp_register_script( 'bootstrap-js', 'http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js', array( 'jquery' ), false, true );
		wp_register_script( 'alpha-custom', SCRIPTS . '/scripts.js', array( 'jquery' ), false, true );

		// Load the custom scripts
		wp_enqueue_script( 'bootstrap-js' );
		wp_enqueue_script( 'alpha-custom' );

		// Load the stylesheets
		wp_enqueue_style('bootstrap-css','https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css');
		wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
		wp_enqueue_style( 'font-awesome', THEMEROOT . '/css/font-awesome.min.css' );
		wp_enqueue_style( 'alpha-master', THEMEROOT . '/css/style.css' );
	}

	add_action( 'wp_enqueue_scripts', 'alpha_scripts' );
}
?>