<?php
/**
 * Contains all theme specific functions
 *
 * @author  ThemeFusion
 * @package Avada
 * @since   Version 3.8
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

if ( ! function_exists( 'avada_render_blog_post_content' ) ) {
	/**
	 * Get the post (excerpt).
	 *
	 * @return void Content is directly echoed.
	 */
	function avada_render_blog_post_content() {
		if ( is_search() && ! Avada()->settings->get( 'search_excerpt' ) ) {
			return;
		}
		echo fusion_get_post_content();
	}
}
add_action( 'avada_blog_post_content', 'avada_render_blog_post_content', 10 );

if ( ! function_exists( 'avada_render_portfolio_post_content' ) ) {
	/**
	 * Get the portfolio post (excerpt).
	 *
	 * @param  int|string $page_id The page ID.
	 * @return void
	 */
	function avada_render_portfolio_post_content( $page_id ) {
		echo fusion_get_post_content( $page_id, 'portfolio' );
	}
}
add_action( 'avada_portfolio_post_content', 'avada_render_portfolio_post_content', 10 );

if ( ! function_exists( 'avada_render_blog_post_date' ) ) {
	/**
	 * Render the HTML for the date box for large/medium alternate blog layouts.
	 *
	 * @return void
	 */
	function avada_render_blog_post_date() {
		get_template_part( 'templates/blog-post-date' );
	}
}
add_action( 'avada_blog_post_date_and_format', 'avada_render_blog_post_date', 10 );

if ( ! function_exists( 'avada_render_blog_post_format' ) ) {
	/**
	 * Render the HTML for the format box for large/medium alternate blog layouts.
	 *
	 * @return void
	 */
	function avada_render_blog_post_format() {
		get_template_part( 'templates/post-format-box' );
	}
}
add_action( 'avada_blog_post_date_and_format', 'avada_render_blog_post_format', 15 );

if ( ! function_exists( 'avada_render_author_info' ) ) {
	/**
	 * Output author information on the author archive page.
	 *
	 * @return void
	 */
	function avada_render_author_info() {
		get_template_part( 'templates/author-info' );
	}
}
add_action( 'avada_author_info', 'avada_render_author_info', 10 );

if ( ! function_exists( 'avada_render_footer_copyright_notice' ) ) {
	/**
	 * Output the footer copyright notice.
	 *
	 * @return void
	 */
	function avada_render_footer_copyright_notice() {
		?>
		<div class="fusion-copyright-notice">
			<div><?php echo html_entity_decode( do_shortcode( Avada()->settings->get( 'footer_text' ) ) ); ?></div>
		</div>
		<?php
	}
}
add_action( 'avada_footer_copyright_content', 'avada_render_footer_copyright_notice', 10 );

if ( ! function_exists( 'avada_render_footer_social_icons' ) ) {
	/**
	 * Output the footer social icons.
	 *
	 * @return void
	 */
	function avada_render_footer_social_icons() {
		global $social_icons;

		// Render the social icons.
		if ( Avada()->settings->get( 'icons_footer' ) ) : ?>
			<div class="fusion-social-links-footer">
				<?php

				$footer_soical_icon_options = array(
					'position'          => 'footer',
					'icon_colors'       => Avada()->settings->get( 'footer_social_links_icon_color' ),
					'box_colors'        => Avada()->settings->get( 'footer_social_links_box_color' ),
					'icon_boxed'        => Avada()->settings->get( 'footer_social_links_boxed' ),
					'icon_boxed_radius' => Avada_Sanitize::size( Avada()->settings->get( 'footer_social_links_boxed_radius' ) ),
					'tooltip_placement' => Avada()->settings->get( 'footer_social_links_tooltip_placement' ),
					'linktarget'        => Avada()->settings->get( 'social_icons_new' ),
				);

				echo $social_icons->render_social_icons( $footer_soical_icon_options ); ?>
			</div>
		<?php endif;
	}
}
add_action( 'avada_footer_copyright_content', 'avada_render_footer_social_icons', 15 );

if ( ! function_exists( 'avada_render_rollover' ) ) {
	/**
	 * Output the image rollover
	 *
	 * @param  string  $post_id                    ID of the current post.
	 * @param  string  $post_permalink             Permalink of current post.
	 * @param  boolean $display_woo_price          Set to yes to show??woocommerce price tag for woo sliders.
	 * @param  boolean $display_woo_buttons        Set to yes to show the woocommerce "add to cart" and "show details" buttons.
	 * @param  string  $display_post_categories    Controls if the post categories will be shown; "deafult": theme option setting; enable/disable otheriwse.
	 * @param  string  $display_post_title         Controls if the post title will be shown; "deafult": theme option setting; enable/disable otheriwse.
	 * @param  string  $gallery_id                 ID of a special gallery the rollover "zoom" link should be connected to for lightbox.
	 * @param  bool    $display_woo_rating         Whether we want to display ratings or not.
	 * @return void
	 */
	function avada_render_rollover( $post_id, $post_permalink = '', $display_woo_price = false, $display_woo_buttons = false, $display_post_categories = 'default', $display_post_title = 'default', $gallery_id = '', $display_woo_rating = false ) {
		include( locate_template( 'templates/rollover.php' ) );
	}
}
add_action( 'avada_rollover', 'avada_render_rollover', 10, 8 );

if ( ! function_exists( 'avada_render_placeholder_image' ) ) {
	/**
	 * Action to output a placeholder image.
	 *
	 * @param  string $featured_image_size     Size of the featured image that should be emulated.
	 *
	 * @return void
	 */
	function avada_render_placeholder_image( $featured_image_size = 'full' ) {
		global $_wp_additional_image_sizes;

		if ( in_array( $featured_image_size, array( 'full', 'fixed' ) ) ) {
			$height = apply_filters( 'avada_set_placeholder_image_height', '150' );
			$width  = '1500px';
		} else {
			@$height = $_wp_additional_image_sizes[ $featured_image_size ]['height'];
			@$width  = $_wp_additional_image_sizes[ $featured_image_size ]['width'] . 'px';
		}
		?>
		 <div class="fusion-placeholder-image" data-origheight="<?php echo $height; ?>" data-origwidth="<?php echo $width; ?>" style="height:<?php echo $height; ?>px;width:<?php echo $width; ?>;"></div>
		<?php
	}
}
add_action( 'avada_placeholder_image', 'avada_render_placeholder_image', 10 );

if ( ! function_exists( 'avada_render_first_featured_image_markup' ) ) {
	/**
	 * Render the full markup of the first featured image, incl. image wrapper and rollover.
	 *
	 * @param  string  $post_id                   ID of the current post.
	 * @param  string  $post_featured_image_size  Size of the featured image.
	 * @param  string  $post_permalink            Permalink of current post.
	 * @param  boolean $display_placeholder_image Set to true to show an image placeholder.
	 * @param  boolean $display_woo_price         Set to true to show WooCommerce prices.
	 * @param  boolean $display_woo_buttons       Set to true to show WooCommerce buttons.
	 * @param  boolean $display_post_categories   Set to yes to show post categories on rollover.
	 * @param  string  $display_post_title        Controls if the post title will be shown; "default": theme option setting; enable/disable otheriwse.
	 * @param  string  $type                      Type of element the featured image is for. "Related" for related posts is the only type in use so far.
	 * @param  string  $gallery_id                ID of a special gallery the rollover "zoom" link should be connected to for lightbox.
	 * @param  string  $display_rollover          yes|no|force_yes: no disables rollover; force_yes will force rollover even if the Theme Option is set to no.
	 * @param  bool    $display_woo_rating        Whether we want to display ratings or not.
	 * @return string Full HTML markup of the first featured image.
	 */
	function avada_render_first_featured_image_markup( $post_id, $post_featured_image_size = '', $post_permalink = '', $display_placeholder_image = false, $display_woo_price = false, $display_woo_buttons = false, $display_post_categories = 'default', $display_post_title = 'default', $type = '', $gallery_id = '', $display_rollover = 'yes', $display_woo_rating = false ) {
		// Add a class for fixed image size, to restrict the image rollovers to the image width.
		$image_size_class = ( 'full' != $post_featured_image_size ) ? ' fusion-image-size-fixed' : '';
		$image_size_class = ( ( ! has_post_thumbnail( $post_id ) && get_post_meta( $post_id, 'pyre_video', true ) ) || ( is_home() && 'blog-large' == $post_featured_image_size ) ) ? '' : $image_size_class;

		ob_start();
		include( locate_template( 'templates/featured-image-first.php' ) );
		return ob_get_clean();
	}
}

if ( ! function_exists( 'avada_get_image_orientation_class' ) ) {
	/**
	 * Returns the image class according to aspect ratio.
	 *
	 * @param  array $attachment The attachment.
	 * @return string The image class.
	 */
	function avada_get_image_orientation_class( $attachment ) {

		$sixteen_to_nine_ratio = 1.77;

		if ( ! isset( $attachment[1] ) || ! isset( $attachment[2] ) || empty( $attachment[1] ) || empty( $attachment[2] ) ) {
			return 'fusion-image-grid';
		}

		// Landscape.
		if ( $attachment[1] / $attachment[2] > $sixteen_to_nine_ratio ) {
			return 'fusion-image-landscape';
		}

		// Portrait.
		if ( $attachment[2] / $attachment[1] > $sixteen_to_nine_ratio ) {
			return 'fusion-image-portrait';
		}
	}
}

if ( ! function_exists( 'avada_render_post_title' ) ) {
	/**
	 * Render the post title as linked h1 tag.
	 *
	 * @param  int|string $post_id      The post ID.
	 * @param  bool       $linked       If we want it linked.
	 * @param  string     $custom_title A Custom title.
	 * @param  string|int $custom_size  A custom size.
	 * @param  string|int $custom_link  A custom link.
	 * @return string                   The post title as linked h1 tag.
	 */
	function avada_render_post_title( $post_id = '', $linked = true, $custom_title = '', $custom_size = '2', $custom_link = '' ) {

		$entry_title_class = '';

		// Add the entry title class if rich snippets are enabled.
		if ( Avada()->settings->get( 'disable_date_rich_snippet_pages' ) ) {
			$entry_title_class = ' class="entry-title fusion-post-title"';
		} else {
			$entry_title_class = ' class="fusion-post-title"';
		}

		// If we have a custom title, use it otherwise get post title.
		$title = ( $custom_title ) ? $custom_title : get_the_title( $post_id );
		$permalink = ( $custom_link ) ? $custom_link : get_permalink( $post_id );

		// If the post title should be linked at the markup.
		if ( $linked ) {
			$link_target = '';
			if ( 'yes' == fusion_get_page_option( 'link_icon_target', $post_id ) || 'yes' == fusion_get_page_option( 'post_links_target', $post_id ) ) {
				$link_target = ' target="_blank" rel="noopener noreferrer"';
			}
			$title = '<a href="' . $permalink . '"' . $link_target . '>' . $title . '</a>';
		}

		// Return the HTML markup of the post title.
		return '<h' . $custom_size . $entry_title_class . '>' . $title . '</h' . $custom_size . '>';

	}
}

if ( ! function_exists( 'avada_get_portfolio_classes' ) ) {
	/**
	 * Determine the css classes need for portfolio page content container.
	 *
	 * @param  int|string $post_id The post ID.
	 * @return string The classes separated with space.
	 */
	function avada_get_portfolio_classes( $post_id = '' ) {

		$classes = 'fusion-portfolio';

		// Get the page template slug without .php suffix.
		$page_template = str_replace( '.php', '', get_page_template_slug( $post_id ) );

		// Add the text class, if a text layout is used.
		if ( strpos( $page_template, 'text' ) || strpos( $page_template, 'one' ) ) {
			$classes .= ' fusion-portfolio-text';
		}

		// If one column text layout is used, add special class.
		if ( strpos( $page_template, 'one' ) && ! strpos( $page_template, 'text' ) ) {
			$classes .= ' fusion-portfolio-one-nontext';
		}

		// For text layouts add the class for boxed/unboxed.
		if ( strpos( $page_template, 'text' ) ) {
			$classes .= ' fusion-portfolio-' . fusion_get_option( 'portfolio_text_layout', 'portfolio_text_layout', $post_id ) . ' ';
			$page_template = str_replace( '-text', '', $page_template );
		}

		// Add the column class.
		$page_template = str_replace( '-column', '', $page_template );
		return $classes . ' fusion-' . $page_template;

	}
}

if ( ! function_exists( 'avada_get_image_size_dimensions' ) ) {
	/**
	 * Get Image dimensions.
	 *
	 * @param  string $image_size The Image size (obviously).
	 * @return array
	 */
	function avada_get_image_size_dimensions( $image_size = 'full' ) {
		global $_wp_additional_image_sizes;

		if ( 'full' == $image_size ) {
			$image_dimension = array( 'height' => 'auto', 'width' => '100%' );
		} else {
			if ( 'portfolio-six' == $image_size ) {
				$image_size = 'portfolio-five';
			} elseif ( 'portfolio-four' == $image_size ) {
				$image_size = 'portfolio-three';
			}
			$image_dimension = array( 'height' => $_wp_additional_image_sizes[ $image_size ]['height'] . 'px', 'width' => $_wp_additional_image_sizes[ $image_size ]['width'] . 'px' );
		}

		return $image_dimension;
	}
}

if ( ! function_exists( 'avada_get_portfolio_image_size' ) ) {
	/**
	 * The portfolio Imge Size.
	 *
	 * @param  int $current_page_id The ID of the current page.
	 * @return string
	 */
	function avada_get_portfolio_image_size( $current_page_id ) {

		$custom_image_size = 'full';
		if (  is_page_template( 'portfolio-one-column-text.php' ) ) {
			$custom_image_size = 'portfolio-full';
		} elseif ( is_page_template( 'portfolio-one-column.php' ) ) {
			$custom_image_size = 'portfolio-one';
		} elseif ( is_page_template( 'portfolio-two-column.php' ) || is_page_template( 'portfolio-two-column-text.php' ) ) {
			$custom_image_size = 'portfolio-two';
		} elseif ( is_page_template( 'portfolio-three-column.php' ) || is_page_template( 'portfolio-three-column-text.php' ) ) {
			$custom_image_size = 'portfolio-three';
		} elseif ( is_page_template( 'portfolio-four-column.php' ) || is_page_template( 'portfolio-four-column-text.php' ) ) {
			$custom_image_size = 'portfolio-three';
		} elseif ( is_page_template( 'portfolio-five-column.php' ) || is_page_template( 'portfolio-five-column-text.php' ) ) {
			$custom_image_size = 'portfolio-five';
		} elseif ( is_page_template( 'portfolio-six-column.php' ) || is_page_template( 'portfolio-six-column-text.php' ) ) {
			$custom_image_size = 'portfolio-five';
		}

		if ( 'default' == get_post_meta( $current_page_id, 'pyre_portfolio_featured_image_size', true ) || ! get_post_meta( $current_page_id, 'pyre_portfolio_featured_image_size', true ) ) {
			$featured_image_size = ( 'full' == Avada()->settings->get( 'portfolio_featured_image_size' ) ) ? 'full' : $custom_image_size;
		} elseif ( 'full' == get_post_meta( $current_page_id, 'pyre_portfolio_featured_image_size', true ) ) {
			$featured_image_size = 'full';
		} else {
			$featured_image_size = $custom_image_size;
		}

		if ( is_page_template( 'portfolio-grid.php' ) ) {
			$featured_image_size = 'full';
		}

		return $featured_image_size;
	}
}

/**
 * Returns the number of columns for a given portfolio layout.
 *
 * @since 4.0.0
 * @param string $layout The proftlio layout.
 * @return string The number of columns.
 */
function avada_get_portfolio_columns( $layout = '' ) {
	$columns = '1';
	if ( false !== strpos( $layout, 'six' ) ) {
		$columns = '6';
	} elseif ( false !== strpos( $layout, 'five' ) ) {
		$columns = '5';
	} elseif ( false !== strpos( $layout, 'four' ) ) {
		$columns = '4';
	} elseif ( false !== strpos( $layout, 'three' ) ) {
		$columns = '3';
	} elseif ( false !== strpos( $layout, 'two' ) ) {
		$columns = '2';
	}

	return $columns;
}

if ( ! function_exists( 'avada_get_blog_layout' ) ) {
	/**
	 * Get the blog layout for the current page template.
	 *
	 * @return string The correct layout name for the blog post class.
	 */
	function avada_get_blog_layout() {
		$theme_options_blog_var = '';

		if ( is_home() ) {
			$theme_options_blog_var = 'blog_layout';
		} elseif ( is_archive() || is_author() ) {
			$theme_options_blog_var = 'blog_archive_layout';
		} elseif ( is_search() ) {
			$theme_options_blog_var = 'search_layout';
		}

		return str_replace( ' ', '-', strtolower( Avada()->settings->get( $theme_options_blog_var ) ) );
	}
}

if ( ! function_exists( 'avada_render_post_metadata' ) ) {
	/**
	 * Render the full meta data for blog archive and single layouts.
	 *
	 * @param string $layout    The blog layout (either single, standard, alternate or grid_timeline).
	 * @param string $settings HTML markup to display the date and post format box.
	 * @return  string
	 */
	function avada_render_post_metadata( $layout, $settings = array() ) {

		$html = $author = $date = $metadata = '';

		$settings = ( is_array( $settings ) ) ? $settings : array();

		$default_settings = array(
			'post_meta'          => Avada()->settings->get( 'post_meta' ),
			'post_meta_author'   => Avada()->settings->get( 'post_meta_author' ),
			'post_meta_date'     => Avada()->settings->get( 'post_meta_date' ),
			'post_meta_cats'     => Avada()->settings->get( 'post_meta_cats' ),
			'post_meta_tags'     => Avada()->settings->get( 'post_meta_tags' ),
			'post_meta_comments' => Avada()->settings->get( 'post_meta_comments' ),
		);

		$settings = wp_parse_args( $settings, $default_settings );

		// Check if meta data is enabled.
		if ( ( $settings['post_meta'] && 'no' != get_post_meta( get_queried_object_id(), 'pyre_post_meta', true ) ) || ( ! $settings['post_meta'] && 'yes' == get_post_meta( get_queried_object_id(), 'pyre_post_meta', true ) ) ) {

			// For alternate, grid and timeline layouts return empty single-line-meta if all meta data for that position is disabled.
			if ( in_array( $layout, array( 'alternate', 'grid_timeline' ) ) && ! $settings['post_meta_author'] && ! $settings['post_meta_date'] && ! $settings['post_meta_cats'] && ! $settings['post_meta_tags'] && ! $settings['post_meta_comments'] ) {
				return '';
			}

			// Render author meta data.
			if ( $settings['post_meta_author'] ) {
				ob_start();
				the_author_posts_link();
				$author_post_link = ob_get_clean();

				// Check if rich snippets are enabled.
				if ( ! Avada()->settings->get( 'disable_date_rich_snippet_pages' ) ) {
					$metadata .= sprintf( esc_html__( 'By %s', 'Avada' ), '<span>' . $author_post_link . '</span>' );
				} else {
					$metadata .= sprintf( esc_html__( 'By %s', 'Avada' ), '<span class="vcard"><span class="fn">' . $author_post_link . '</span></span>' );
				}
				$metadata .= '<span class="fusion-inline-sep">|</span>';
			} else { // If author meta data won't be visible, render just the invisible author rich snippet.
				$author .= avada_render_rich_snippets_for_pages( false, true, false );
			}

			// Render the updated meta data or at least the rich snippet if enabled.
			if ( $settings['post_meta_date'] ) {
				$metadata .= avada_render_rich_snippets_for_pages( false, false, true );

				$formatted_date = get_the_time( Avada()->settings->get( 'date_format' ) );
				$date_markup = '<span>' . $formatted_date . '</span><span class="fusion-inline-sep">|</span>';
				$metadata .= apply_filters( 'avada_post_metadata_date', $date_markup, $formatted_date );
			} else {
				$date .= avada_render_rich_snippets_for_pages( false, false, true );
			}

			// Render rest of meta data.
			// Render categories.
			if ( $settings['post_meta_cats'] ) {
				ob_start();
				the_category( ', ' );
				$categories = ob_get_clean();

				if ( $categories ) {
					$metadata .= ( $settings['post_meta_tags'] ) ? sprintf( esc_html__( 'Categories: %s', 'Avada' ), $categories ) : $categories;
					$metadata .= '<span class="fusion-inline-sep">|</span>';
				}
			}

			// Render tags.
			if ( $settings['post_meta_tags'] ) {
				ob_start();
				the_tags( '' );
				$tags = ob_get_clean();

				if ( $tags ) {
					$metadata .= '<span class="meta-tags">' . sprintf( esc_html__( 'Tags: %s', 'Avada' ), $tags ) . '</span><span class="fusion-inline-sep">|</span>';
				}
			}

			// Render comments.
			if ( $settings['post_meta_comments'] && 'grid_timeline' !== $layout ) {
				ob_start();
				comments_popup_link( esc_html__( '0 Comments', 'Avada' ), esc_html__( '1 Comment', 'Avada' ), esc_html__( '% Comments', 'Avada' ) );
				$comments = ob_get_clean();
				$metadata .= '<span class="fusion-comments">' . $comments . '</span>';
			}

			// Render the HTML wrappers for the different layouts.
			if ( $metadata ) {
				$metadata = $author . $date . $metadata;

				if ( 'single' == $layout ) {
					$html .= '<div class="fusion-meta-info"><div class="fusion-meta-info-wrapper">' . $metadata . '</div></div>';
				} elseif ( in_array( $layout, array( 'alternate', 'grid_timeline' ) ) ) {
					$html .= '<p class="fusion-single-line-meta">' . $metadata . '</p>';
				} else {
					$html .= '<div class="fusion-alignleft">' . $metadata . '</div>';
				}
			} else {
				$html .= $author . $date;
			}
		} else {
			// Render author and updated rich snippets for grid and timeline layouts.
			if ( Avada()->settings->get( 'disable_date_rich_snippet_pages' ) ) {
				$html .= avada_render_rich_snippets_for_pages( false );
			}
		}

		return apply_filters( 'avada_post_metadata_markup', $html );
	}
}

if ( ! function_exists( 'avada_render_social_sharing' ) ) {
	/**
	 * Renders social sharing links.
	 *
	 * @param string $post_type The post-type.
	 * @return void
	 */
	function avada_render_social_sharing( $post_type = 'post' ) {
		global $social_icons;

		$setting_name = ( 'post' == $post_type ) ? 'social_sharing_box' : $post_type . '_social_sharing_box';

		if ( ( Avada()->settings->get( $setting_name ) && 'no' != get_post_meta( get_the_ID(), 'pyre_share_box', true ) ) || ( ! Avada()->settings->get( $setting_name ) && 'yes' == get_post_meta( get_the_ID(), 'pyre_share_box', true ) ) ) {

			$full_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );

			$sharingbox_soical_icon_options = array(
				'sharingbox'        => 'yes',
				'icon_colors'       => Avada()->settings->get( 'sharing_social_links_icon_color' ),
				'box_colors'        => Avada()->settings->get( 'sharing_social_links_box_color' ),
				'icon_boxed'        => Avada()->settings->get( 'sharing_social_links_boxed' ),
				'icon_boxed_radius' => Avada_Sanitize::size( Avada()->settings->get( 'sharing_social_links_boxed_radius' ) ),
				'tooltip_placement' => Avada()->settings->get( 'sharing_social_links_tooltip_placement' ),
				'linktarget'        => Avada()->settings->get( 'social_icons_new' ),
				'title'             => wp_strip_all_tags( get_the_title( get_the_ID() ), true ),
				'description'       => Avada()->blog->get_content_stripped_and_excerpted( 55, get_the_content() ),
				'link'              => get_permalink( get_the_ID() ),
				'pinterest_image'   => ( $full_image ) ? $full_image[0] : '',
			);
			?>
			<div class="fusion-sharing-box fusion-single-sharing-box share-box">
				<h4><?php echo apply_filters( 'fusion_sharing_box_tagline', Avada()->settings->get( 'sharing_social_tagline' ) ); ?></h4>
				<?php echo Avada()->social_sharing->render_social_icons( $sharingbox_soical_icon_options ); ?>
			</div>
			<?php
		}
	}
}

if ( ! function_exists( 'avada_render_related_posts' ) ) {
	/**
	 * Render related posts carousel.
	 *
	 * @param  string $post_type The post type to determine correct related posts and headings.
	 * @return string            HTML markup to display related posts.
	 */
	function avada_render_related_posts( $post_type = 'post' ) {

		$html = '';

		// Set the needed variables according to post type.
		if ( 'post' == $post_type ) {
			$theme_option_name = 'related_posts';
			$main_heading      = esc_html__( 'Related Posts', 'Avada' );
		} elseif ( 'avada_portfolio' == $post_type ) {
			$theme_option_name = 'portfolio_related_posts';
			$main_heading      = esc_html__( 'Related Projects', 'Avada' );
		} elseif ( 'avada_faq' == $post_type ) {
			$theme_option_name = 'faq_related_posts';
			$main_heading      = esc_html__( 'Related Faqs', 'Avada' );
		}

		// Check if related posts should be shown.
		if ( isset( $theme_option_name ) && ( 'yes' == fusion_get_option( $theme_option_name, 'related_posts', get_the_ID() ) || '1' == fusion_get_option( $theme_option_name, 'related_posts', get_the_ID() ) ) ) {
			$number_related_posts = Avada()->settings->get( 'number_related_posts' );
			$number_related_posts = ( '0' == $number_related_posts ) ? '-1' : $number_related_posts;
			if ( 'post' == $post_type ) {
				$related_posts = fusion_get_related_posts( get_the_ID(), $number_related_posts );
			} else {
				$related_posts = fusion_get_custom_posttype_related_posts( get_the_ID(), $number_related_posts, $post_type );
			}

			// If there are related posts, display them.
			if ( isset( $related_posts ) && $related_posts->have_posts() ) {
				ob_start();
				include( locate_template( 'templates/related-posts.php' ) );
				$html .= ob_get_clean();
			}
		}

		return $html;
	}
}


if ( ! function_exists( 'avada_render_rich_snippets_for_pages' ) ) {
	/**
	 * Render the full meta data for blog archive and single layouts.
	 *
	 * @param  boolean $title_tag   Set to true to render title rich snippet.
	 * @param  bool    $author_tag  Set to true to render author rich snippet.
	 * @param  bool    $updated_tag Set to true to render updated rich snippet.
	 * @return string               HTML markup to display rich snippets.
	 */
	function avada_render_rich_snippets_for_pages( $title_tag = true, $author_tag = true, $updated_tag = true ) {
		ob_start();
		include( locate_template( 'templates/pages-rich-snippets.php' ) );
		return ob_get_clean();
	}
}

if ( ! function_exists( 'avada_extract_shortcode_contents' ) ) {
	/**
	 * Extract text contents from all shortcodes for usage in excerpts.
	 *
	 * @param array $m The text.
	 * @return string The shortcode contents
	 */
	function avada_extract_shortcode_contents( $m ) {

		global $shortcode_tags;

		// Setup the array of all registered shortcodes.
		$shortcodes = array_keys( $shortcode_tags );
		$no_space_shortcodes = array( 'fusion_dropcap' );
		$omitted_shortcodes  = array( 'fusion_code', 'fusion_imageframe', 'fusion_slide' );

		// Extract contents from all shortcodes recursively.
		if ( in_array( $m[2], $shortcodes ) && ! in_array( $m[2], $omitted_shortcodes ) ) {
			$pattern = get_shortcode_regex();
			// Add space to the excerpt by shortcode, except for those who should stick together, like dropcap.
			$space = ' ';
			if ( in_array( $m[2], $no_space_shortcodes ) ) {
				$space = '';
			}
			$content = preg_replace_callback( "/$pattern/s", 'avada_extract_shortcode_contents', rtrim( $m[5] ) . $space );

			return $content;
		}

		// Allow [[foo]] syntax for escaping a tag.
		if ( '[' == $m[1] && ']' == $m[6] ) {
			return substr( $m[0], 1, -1 );
		}

		return $m[1] . $m[6];
	}
}

if ( ! function_exists( 'avada_page_title_bar' ) ) {
	/**
	 * Render the HTML markup of the page title bar.
	 *
	 * @param  string $title             Main title; page/post title or custom title set by user.
	 * @param  string $subtitle          Subtitle as custom user setting.
	 * @param  string $secondary_content HTML markup of the secondary content; breadcrumbs or search field.
	 * @return void
	 */
	function avada_page_title_bar( $title, $subtitle, $secondary_content ) {
		$post_id = get_queried_object_id();

		// Check for the secondary content.
		$content_type = 'none';
		if ( false !== strpos( $secondary_content, 'searchform' ) ) {
			$content_type = 'search';
		} elseif ( '' != $secondary_content ) {
			$content_type = 'breadcrumbs';
		}

		// Check the position of page title.
		if ( metadata_exists( 'post', $post_id, 'pyre_page_title_text_alignment' ) && 'default' != get_post_meta( get_queried_object_id(), 'pyre_page_title_text_alignment', true ) ) {
			$alignment = get_post_meta( $post_id, 'pyre_page_title_text_alignment', true );
		} elseif ( Avada()->settings->get( 'page_title_alignment' ) ) {
			$alignment = Avada()->settings->get( 'page_title_alignment' );
		}

		// Render the page title bar.
		include( locate_template( 'templates/title-bar.php' ) );
	}
}

if ( ! function_exists( 'avada_add_login_box_to_nav' ) ) {
	/**
	 * Add woocommerce cart to main navigation or top navigation.
	 *
	 * @param  string $items HTML for the main menu items.
	 * @param  array  $args  Arguments for the WP menu.
	 * @return string
	 */
	function avada_add_login_box_to_nav( $items, $args ) {

		$ubermenu = ( function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) && ubermenu_get_menu_instance_by_theme_location( $args->theme_location ) ) ? true : false; // Disable woo cart on ubermenu navigations.

		if ( $ubermenu ) {
			return $items;
		}
		if ( in_array( $args->theme_location, array( 'main_navigation', 'top_navigation', 'sticky_navigation' ) ) ) {
			$is_enabled = ( 'top_navigation' == $args->theme_location ) ? Avada()->settings->get( 'woocommerce_acc_link_top_nav' ) : Avada()->settings->get( 'woocommerce_acc_link_main_nav' );

			if ( class_exists( 'WooCommerce' ) && $is_enabled ) {
				$woo_account_page_link = get_permalink( get_option( 'woocommerce_myaccount_page_id' ) );
				$logout_link = wp_logout_url( get_permalink( woocommerce_get_page_id( 'myaccount' ) ) );

				if ( $woo_account_page_link ) {
					$active_classes = '';
					if ( is_account_page() ) {
						$active_classes = ' current-menu-item current_page_item';
					}

					$items .= '<li class="fusion-custom-menu-item fusion-menu-login-box' . $active_classes . '">';

						// If chosen in Theme Options, display the caret icon, as the my account item alyways has a dropdown.
						$caret_icon = '';
					if ( Avada()->settings->get( 'menu_display_dropdown_indicator' ) && 'v6' != Avada()->settings->get( 'header_layout' ) ) {
						$caret_icon = '<span class="fusion-caret"><i class="fusion-dropdown-indicator"></i></span>';
					}

						$my_account_link_contents = ( 'Right' == Avada()->settings->get( 'header_position' ) ) ? $caret_icon . esc_html__( 'My Account', 'Avada' ) : esc_html__( 'My Account', 'Avada' );

						$items .= '<a href="' . $woo_account_page_link . '"><span class="menu-text">' . $my_account_link_contents . '</span>' . $caret_icon . '</a>';

					if ( ! is_user_logged_in() ) {
						$items .= '<div class="fusion-custom-menu-item-contents">';
						if ( isset( $_GET['login'] ) && 'failed' == $_GET['login'] ) {
							$items .= '<p class="fusion-menu-login-box-error">' . esc_html__( 'Login failed, please try again.', 'Avada' ) . '</p>';
						}
						$items .= '<form action="' . wp_login_url() . '" name="loginform" method="post">';
						$items .= '<p><input type="text" class="input-text" name="log" id="username" value="" placeholder="' . esc_html__( 'Username', 'Avada' ) . '" /></p>';
						$items .= '<p><input type="password" class="input-text" name="pwd" id="password" value="" placeholder="' . esc_html__( 'Password', 'Avada' ) . '" /></p>';
						$items .= '<p class="fusion-remember-checkbox"><label for="fusion-menu-login-box-rememberme"><input name="rememberme" type="checkbox" id="fusion-menu-login-box-rememberme" value="forever"> ' . esc_html__( 'Remember Me', 'Avada' ) . '</label></p>';
						$items .= '<input type="hidden" name="fusion_woo_login_box" value="true" />';
						$items .= '<p class="fusion-login-box-submit">';
						$items .= '<input type="submit" name="wp-submit" id="wp-submit" class="button small default comment-submit" value="' . esc_html__( 'Log In', 'Avada' ) . '">';
						$items .= '<input type="hidden" name="redirect" value="' . esc_url( ( isset( $_SERVER['HTTP_REFERER'] ) ) ? $_SERVER['HTTP_REFERER'] : $_SERVER['REQUEST_URI'] ) . '">';
						$items .= '</p>';
						$items .= '</form>';
						$items .= '<a class="fusion-menu-login-box-register" href="' . get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) . '" title="' . esc_attr__( 'Register', 'Avada' ) . '">' . esc_attr__( 'Register', 'Avada' ) . '</a>';
						$items .= '</div>';
					} else {
						$items .= '<ul class="sub-menu">';
						$items .= '<li><a href="' . $logout_link . '">' . esc_html__( 'Logout', 'Avada' ) . '</a></li>';
						$items .= '</ul>';
					}
					$items .= '</li>';
				}
			}
		}
		return $items;
	}
}
add_filter( 'wp_nav_menu_items', 'avada_add_login_box_to_nav', 10, 3 );

if ( ! function_exists( 'avada_nav_woo_cart' ) ) {
	/**
	 * Woo Cart Dropdown for Main Nav or Top Nav.
	 *
	 * @param string $position The cart position.
	 * @return string HTML of Dropdown
	 */
	function avada_nav_woo_cart( $position = 'main' ) {

		if ( ! class_exists( 'WooCommerce' ) ) {
			return '';
		}

		global $woocommerce;
		$woo_cart_page_link = $woocommerce->cart->get_cart_url();

		$cart_link_active_class   = '';
		$cart_link_active_text    = '';
		$is_enabled               = false;
		$main_cart_class          = '';
		$cart_link_inactive_class = '';
		$cart_link_inactive_text  = '';
		$items                    = '';

		if ( 'main' == $position ) {
			$is_enabled               = Avada()->settings->get( 'woocommerce_cart_link_main_nav' );
			$main_cart_class          = ' fusion-main-menu-cart';
			$cart_link_active_class   = 'fusion-main-menu-icon fusion-main-menu-icon-active';
			$cart_link_inactive_class = 'fusion-main-menu-icon';

			if ( Avada()->settings->get( 'woocommerce_cart_counter' ) ) {
				if ( $woocommerce->cart->get_cart_contents_count() ) {
					$cart_link_active_text = '<span class="fusion-widget-cart-number">' . $woocommerce->cart->get_cart_contents_count() . '</span>';
				}
				$main_cart_class      .= ' fusion-widget-cart-counter';
			} elseif ( $woocommerce->cart->get_cart_contents_count() ) {
				// If we're here, then ( Avada()->settings->get( 'woocommerce_cart_counter' ) ) is not true.
				$main_cart_class .= ' fusion-active-cart-icons';
			}
		} elseif ( 'secondary' == $position ) {
			$is_enabled               = Avada()->settings->get( 'woocommerce_cart_link_top_nav' );
			$main_cart_class          = ' fusion-secondary-menu-cart';
			$cart_link_active_class   = 'fusion-secondary-menu-icon';
			$cart_link_active_text    = sprintf( esc_html__( '%s Item(s)', 'Avada' ), $woocommerce->cart->get_cart_contents_count() ) . ' <span class="fusion-woo-cart-separator">-</span> ' . wc_price( $woocommerce->cart->subtotal );
			$cart_link_inactive_class = $cart_link_active_class;
			$cart_link_inactive_text  = esc_html__( 'Cart', 'Avada' );
		}

		$cart_link_markup = '<a class="' . $cart_link_active_class . '" href="' . $woo_cart_page_link . '" ><span class="menu-text">' . $cart_link_active_text . '</span></a>';

		if (  $is_enabled ) {
			if ( is_cart() ) {
				$main_cart_class .= ' current-menu-item current_page_item';
			}

			$items = '<li class="fusion-custom-menu-item fusion-menu-cart' . $main_cart_class . '">';
			if ( $woocommerce->cart->get_cart_contents_count() ) {
				$checkout_link = get_permalink( get_option( 'woocommerce_checkout_page_id' ) );

				$items .= $cart_link_markup;

				$items .= '<div class="fusion-custom-menu-item-contents fusion-menu-cart-items">';
				foreach ( $woocommerce->cart->cart_contents as $cart_item ) {
					$product_link = get_permalink( $cart_item['product_id'] );
					$thumbnail_id = ( $cart_item['variation_id'] && has_post_thumbnail( $cart_item['variation_id'] ) ) ? $cart_item['variation_id'] : $cart_item['product_id'];
					$items .= '<div class="fusion-menu-cart-item">';
					$items .= '<a href="' . $product_link . '">';
						$items .= get_the_post_thumbnail( $thumbnail_id, 'recent-works-thumbnail' );
						$items .= '<div class="fusion-menu-cart-item-details">';
							$items .= '<span class="fusion-menu-cart-item-title">' . $cart_item['data']->post->post_title . '</span>';
							$items .= '<span class="fusion-menu-cart-item-quantity">' . $cart_item['quantity'] . ' x ' . $woocommerce->cart->get_product_subtotal( $cart_item['data'], 1 ) . '</span>';
						$items .= '</div>';
					$items .= '</a>';
					$items .= '</div>';
				}
				$items .= '<div class="fusion-menu-cart-checkout">';
				$items .= '<div class="fusion-menu-cart-link"><a href="' . $woo_cart_page_link . '">' . esc_html__( 'View Cart', 'Avada' ) . '</a></div>';
				$items .= '<div class="fusion-menu-cart-checkout-link"><a href="' . $checkout_link . '">' . esc_html__( 'Checkout', 'Avada' ) . '</a></div>';
				$items .= '</div>';
				$items .= '</div>';
			} else {
				$items .= '<a class="' . $cart_link_inactive_class . '" href="' . $woo_cart_page_link . '" ><span class="menu-text">' . $cart_link_inactive_text . '</span></a>';
			}
			$items .= '</li>';
		}
		return $items;
	}
}

if ( ! function_exists( 'fusion_add_woo_cart_to_widget_html' ) ) {
	/**
	 * Adds cart HTML to widget.
	 *
	 * @return string The final HTML.
	 */
	function fusion_add_woo_cart_to_widget_html() {
		global $woocommerce;
		$items = '';

		if ( class_exists( 'WooCommerce' ) ) {
			$counter = '';
			$class   = '';
			$items   = '';

			if ( Avada()->settings->get( 'woocommerce_cart_counter' ) ) {
				$counter = '<span class="fusion-widget-cart-number">' . $woocommerce->cart->get_cart_contents_count() . '</span>';
				$class   = 'fusion-widget-cart-counter';
			}

			if ( ! Avada()->settings->get( 'woocommerce_cart_counter' ) && $woocommerce->cart->get_cart_contents_count() ) {
				$class .= ' fusion-active-cart-icon';
			}

			$items .= '<li class="fusion-widget-cart ' . $class . '"><a href="' . get_permalink( get_option( 'woocommerce_cart_page_id' ) ) . '" class=""><span class="fusion-widget-cart-icon"></span>' . $counter . '</a></li>';
		}

		return $items;
	}
}

if ( ! function_exists( 'avada_add_woo_cart_to_nav' ) ) {
	/**
	 * Add woocommerce cart to main navigation or top navigation.
	 *
	 * @param  string $items HTML for the main menu items.
	 * @param  array  $args  Arguments for the WP menu.
	 * @return string
	 */
	function avada_add_woo_cart_to_nav( $items, $args ) {
		if ( ! class_exists( 'WooCommerce' ) ) {
			return $items;
		}
		global $woocommerce;

		$ubermenu = false;

		if ( function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) && ubermenu_get_menu_instance_by_theme_location( $args->theme_location ) ) {

			// Disable woo cart on ubermenu navigations.
			$ubermenu = true;
		}

		if ( 'v6' !== Avada()->settings->get( 'header_layout' ) ) {
			if ( false == $ubermenu && 'main_navigation' == $args->theme_location || 'sticky_navigation' == $args->theme_location ) {
				$items .= avada_nav_woo_cart( 'main' );
			} elseif ( false == $ubermenu && 'top_navigation' === $args->theme_location ) {
				$items .= avada_nav_woo_cart( 'secondary' );
			}
		}

		return $items;
	}
}
add_filter( 'wp_nav_menu_items', 'avada_add_woo_cart_to_nav', 10, 3 );

if ( ! function_exists( 'avada_add_search_to_main_nav' ) ) {
	/**
	 * Add search to the main navigation.
	 *
	 * @param  string $items HTML for the main menu items.
	 * @param  array  $args  Arguments for the WP menu.
	 * @return string
	 */
	function avada_add_search_to_main_nav( $items, $args ) {
		$ubermenu = false;

		if ( function_exists( 'ubermenu_get_menu_instance_by_theme_location' ) && ubermenu_get_menu_instance_by_theme_location( $args->theme_location ) ) {

			// Disable woo cart on ubermenu navigations.
			$ubermenu = true;
		}

		if ( 'v6' != Avada()->settings->get( 'header_layout' ) && false == $ubermenu ) {
			if ( 'main_navigation' == $args->theme_location || 'sticky_navigation' == $args->theme_location ) {
				if ( Avada()->settings->get( 'main_nav_search_icon' ) ) {

					$items .= '<li class="fusion-custom-menu-item fusion-main-menu-search">';
						$items .= '<a class="fusion-main-menu-icon"></a>';
						$items .= '<div class="fusion-custom-menu-item-contents">';
							$items .= get_search_form( false );
						$items .= '</div>';
					$items .= '</li>';
				}
			}
		}

		return $items;
	}
}
add_filter( 'wp_nav_menu_items', 'avada_add_search_to_main_nav', 20, 4 );

if ( ! function_exists( 'avada_update_featured_content_for_split_terms' ) ) {
	/**
	 * Updates post meta.
	 *
	 * @param  int    $old_term_id      The ID of the old taxonomy term.
	 * @param  int    $new_term_id      The ID of the new taxonomy term.
	 * @param  int    $term_taxonomy_id Deprecated.
	 * @param  string $taxonomy         The taxonomy.
	 */
	function avada_update_featured_content_for_split_terms( $old_term_id, $new_term_id, $term_taxonomy_id, $taxonomy ) {
		if ( 'portfolio_category' == $taxonomy ) {
			$pages = get_pages();

			if ( $pages ) {
				foreach ( $pages as $page ) {
					$page_id        = $page->ID;
					$categories     = get_post_meta( $page_id, 'pyre_portfolio_category', true );
					$new_categories = array();
					if ( $categories ) {
						foreach ( $categories as $category ) {
							if ( '0' != $category ) {
								$new_categories[] = ( isset( $category ) && $old_term_id == $category ) ? $new_term_id : $category;
							} else {
								$new_categories[] = '0';
							}
						}

						update_post_meta( $page_id, 'pyre_portfolio_category', $new_categories );
					}
				}
			}
		}
	}
}
add_action( 'split_shared_term', 'avada_update_featured_content_for_split_terms', 10, 4 );

/**
 * Perform a HTTP HEAD or GET request.
 *
 * If $file_path is a writable filename, this will do a GET request and write
 * the file to that path.
 *
 * This is a re-implementation of the deprecated wp_get_http() function from WP Core,
 * but this time using the recommended WP_Http() class and the WordPress filesystem.
 *
 * @param string      $url       URL to fetch.
 * @param string|bool $file_path Optional. File path to write request to. Default false.
 * @param array       $args      Optional. Arguments to be passed-on to the request.
 * @return bool|string False on failure and string of headers if HEAD request.
 */
function avada_wp_get_http( $url = false, $file_path = false, $args = array() ) {

	// No need to proceed if we don't have a $url or a $file_path.
	if ( ! $url || ! $file_path ) {
		return false;
	}

	$try_file_get_contents = false;

	// Make sure we normalize $file_path.
	$file_path = wp_normalize_path( $file_path );

	// Include the WP_Http class if it doesn't already exist.
	if ( ! class_exists( 'WP_Http' ) ) {
		include_once( wp_normalize_path( ABSPATH . WPINC . '/class-http.php' ) );
	}
	// Inlude the wp_remote_get function if it doesn't already exist.
	if ( ! function_exists( 'wp_remote_get' ) ) {
		include_once( wp_normalize_path( ABSPATH . WPINC . '/http.php' ) );
	}

	$args = wp_parse_args( $args, array(
		'timeout'    => 30,
		'user-agent' => 'avada-user-agent',
	) );
	$response = wp_remote_get( esc_url_raw( $url ), $args );
	$body     = wp_remote_retrieve_body( $response );

	// Try file_get_contents if body is empty.
	if ( empty( $body ) ) {
		if ( function_exists( 'ini_get' ) && ini_get( 'allow_url_fopen' ) ) {
			$body = @file_get_contents( $url );
		}
	}

	// Initialize the Wordpress filesystem.
	$wp_filesystem = Avada_Helper::init_filesystem();

	if ( ! defined( 'FS_CHMOD_DIR' ) ) {
		define( 'FS_CHMOD_DIR', ( 0755 & ~ umask() ) );
	}
	if ( ! defined( 'FS_CHMOD_FILE' ) ) {
		define( 'FS_CHMOD_FILE', ( 0644 & ~ umask() ) );
	}

	// Attempt to write the file.
	if ( ! $wp_filesystem->put_contents( $file_path, $body, FS_CHMOD_FILE ) ) {
		// If the attempt to write to the file failed, then fallback to fwrite.
		@unlink( $file_path );
		$fp = fopen( $file_path, 'w' );
		$written = fwrite( $fp, $body );
		fclose( $fp );
		if ( false === $written ) {
			return false;
		}
	}

	// If all went well, then return the headers of the request.
	if ( isset( $response['headers'] ) ) {
		$response['headers']['response'] = $response['response']['code'];
		return $response['headers'];
	}

	// If all else fails, then return false.
	return false;
}

/**
 * Returns a cached query.
 * If the query is not cached then it caches it and returns the result.
 *
 * @param string|array $args Same as in WP_Query.
 * @return object
 */
function avada_cached_query( $args ) {
	$query_id   = md5( maybe_serialize( $args ) );
	$query = wp_cache_get( $query_id, 'avada' );
	if ( false === $query ) {
		$query = new WP_Query( $args );
		wp_cache_set( $query_id, $query, 'avada' );
	}
	return $query;
}

/**
 * Returns a cached query.
 * If the query is not cached then it caches it and returns the result.
 *
 * @param string|array $args Same as in WP_Query.
 * @return array
 */
function avada_cached_get_posts( $args ) {
	$query = avada_cached_query( $args );
	return $query->posts;
}

add_action( 'wp_ajax_avada_slider_preview', 'avada_ajax_avada_slider_preview' );
add_action( 'wp_ajax_nopriv_avada_slider_preview', 'avada_ajax_avada_slider_preview' );
add_action( 'fusion_builder_before_content', 'avada_ajax_avada_slider_preview' );

/**
 * Add slider UI to FusionBuilder
 *
 * @since 5.0
 * @return void
 */
function avada_ajax_avada_slider_preview() {
	global $post;

	$slider_type = ( isset( $_POST['data'] ) ) ? $_POST['data']['slidertype'] : get_post_meta( $post->ID, 'pyre_slider_type', true );
	$slider_demo = ( isset( $_POST['data'] ) ) ? $_POST['data']['demoslider'] : get_post_meta( $post->ID, 'pyre_demo_slider', true );

	$slider_object = false;

	if ( 'layer' == $slider_type ) {
		$slider = ( isset( $_POST['data'] ) ) ? $_POST['data']['layerslider'] : get_post_meta( $post->ID, 'pyre_slider', true );
		$slider_type = __( 'LayerSlider', 'textdomain' );
		if ( class_exists( 'LS_Sliders' ) ) {
			$slider_object = LS_Sliders::find( $slider );
			$edit_link = admin_url( 'admin.php?page=layerslider&action=edit&id=' . $slider );
		}
	} elseif ( 'rev' == $slider_type ) {
		$slider = ( isset( $_POST['data'] ) ) ? $_POST['data']['revslider'] : get_post_meta( $post->ID, 'pyre_revslider', true );
		$slider_type = 'Revolution Slider';
		if ( class_exists( 'RevSlider' ) ) {
			$slider_object = new RevSlider();
			if ( $slider_object->isAliasExistsInDB( $slider ) ) {
				$slider_object->initByAlias( $slider );
				$edit_link = admin_url( 'admin.php?page=revslider&view=slider&id=' . $slider_object->getID() );
			}
		}
	} elseif ( 'flex' == $slider_type ) {
		$slider = ( isset( $_POST['data'] ) ) ? $_POST['data']['wooslider'] : get_post_meta( $post->ID, 'pyre_wooslider', true );
		$slider_type = 'Fusion Slider';
		$slider_object = get_term_by( 'slug', $slider, 'slide-page' );
		if ( is_object( $slider_object ) ) {
			$edit_link = admin_url( 'term.php?taxonomy=slide-page&tag_ID=' . $slider_object->term_id . '&post_type=slide' );
			$edit_slides_link = admin_url( 'edit.php?slide-page=' . $slider . '&post_type=slide' );
		}
	} elseif ( 'elastic' == $slider_type ) {
		$slider = ( isset( $_POST['data'] ) ) ? $_POST['data']['elasticslider'] : get_post_meta( $post->ID, 'pyre_elasticslider', true );
		$slider_type = 'Elastic Slider';
		$slider_object = get_term_by( 'slug', $slider, 'themefusion_es_groups' );
		if ( is_object( $slider_object ) ) {
			$edit_link = admin_url( 'term.php?taxonomy=themefusion_es_groups&tag_ID=' . $slider_object->term_id . '&post_type=themefusion_elastic' );
			$edit_slides_link = admin_url( 'edit.php?themefusion_es_groups=' . $slider . '&post_type=themefusion_elastic' );
		}
	}

	// If there was a demo import, but now they have changed slider, delete the demo post meta.
	if ( isset( $slider_demo ) && ! empty( $slider_demo ) && isset( $slider ) && '0' !== $slider ) {
		delete_post_meta( $post->ID, 'pyre_demo_slider', true );
	}

	$html = '';

	if ( isset( $slider ) && '0' !== $slider && ( is_object( $slider_object ) || is_array( $slider_object ) ) ) {

		// If there is a slider set and it can be found.
		$html .= '<div class="fusion-builder-slider-helper">';
		$html .= '<h2 class="fusion-builder-slider-type"><span class="fusion-module-icon fusiona-uniF61C"></span> ' . $slider_type . '</h2>';
		$html .= '<p>' . __( 'This Slider Is Assigned Via Fusion Page Options', 'Avada' ) . '</p>';
		$html .= '<h4 class="fusion-builder-slider-id">' . __( 'Slider ID: ', 'Avada' ) . $slider . '</h4>';
		$html .= '<a href="' . $edit_link . '" title="' . __( 'Edit slider', 'Avada' ) . '" target="_blank" rel="noopener noreferrer" class="button button-primary">' . __( 'Edit Slider', 'Avada' ) . '</a>';
		if ( isset( $edit_slides_link ) ) {
			$html .= '<a href="' . $edit_slides_link . '" title="' . __( 'Edit slides', 'Avada' ) . '" style="margin-left:10px" target="_blank" rel="noopener noreferrer" class="button button-primary">' . __( 'Edit Slides', 'Avada' ) . '</a>';
		}
		$html .= '<a href="#" id="avada-slider-remove" title="' . esc_attr( 'Remove Slider', 'Avada' ) . '" style="margin-left:10px" class="button button-primary">' . esc_attr( 'Remove Slider', 'Avada' ) . '</a>';
		$html .= '</div>';
	} elseif ( isset( $slider_demo ) && ! empty( $slider_demo ) ) {

		// If there is not a found slider, but there is demo post meta.
		$html = '<div class="fusion-builder-slider-helper">';
		$html .= '<h2 class="fusion-builder-slider-type"><span class="fusion-module-icon fusiona-uniF61C"></span> ' . $slider_type . '</h2>';
		$html .= '<p>' . __( 'This Slider Is Assigned Via Fusion Page Options', 'Avada' ) . '</p>';
		$html .= '<h4 class="fusion-builder-slider-id">' . sprintf( __( 'Slider "%s" cannot be found', 'Avada' ), $slider_demo ) . '</h4>';
		$html .= '<a href="https://theme-fusion.com/avada-doc/sliders/how-to-get-our-demo-sliders/" title="' . __( 'Learn How To Import Sliders', 'Avada' ) . '" target="_blank" rel="noopener noreferrer" class="button button-primary">' . __( 'Learn How To Import Sliders', 'Avada' ) . '</a>';
		$html .= ' <a href="#" id="avada-slider-remove" title="' . esc_attr( 'Remove Slider', 'Avada' ) . '" style="margin-left:10px" class="button button-primary">' . esc_attr( 'Remove Slider', 'Avada' ) . '</a>';
		$html .= '</div>';
	}

	echo $html;
}

/**
 * Returns an avada user agent for use with premium plugin downloads.
 *
 * @since 5.0.2
 * @return string
 */
function avada_user_agent() {
	return 'avada-user-agent';
}

if ( function_exists( 'wp_cache_clean_cache' ) && ! function_exists( 'wp_cache_debug' ) ) {
	/**
	 * This is an additional function to avoid PHP Fatal issues with WP Super Cache
	 */
	function wp_cache_debug() {
	}
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
