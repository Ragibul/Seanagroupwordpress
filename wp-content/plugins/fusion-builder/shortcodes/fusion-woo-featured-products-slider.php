<?php

/**
 * Shortcode class.
 *
 * @package fusion-builder
 * @since 1.0
 */
class FusionSC_WooFeaturedProductsSlider {

	/**
	 * An array of the shortcode arguments.
	 *
	 * @static
	 * @access public
	 * @since 1.0
	 * @var array
	 */
	public static $args;

	/**
	 * Constructor.
	 *
	 * @access public
	 * @since 1.0
	 */
	public function __construct() {

		add_filter( 'fusion_attr_woo-featured-products-slider-shortcode', array( $this, 'attr' ) );
		add_filter( 'fusion_attr_woo-featured-products-slider-shortcode-carousel', array( $this, 'carousel_attr' ) );
		add_shortcode( 'fusion_featured_products_slider', array( $this, 'render' ) );

	}

	/**
	 * Render the shortcode.
	 *
	 * @access public
	 * @since 1.0
	 * @param  array  $args   Shortcode parameters.
	 * @param  string $content Content between shortcode.
	 * @return string         HTML output.
	 */
	public function render( $args, $content = '' ) {
		global $woocommerce;

		$html = '';

		if ( class_exists( 'Woocommerce' ) ) {

			$defaults = FusionBuilder::set_shortcode_defaults(
				array(
					'hide_on_mobile'  => fusion_builder_default_visibility( 'string' ),
					'class'           => '',
					'id'              => '',
					'autoplay'        => 'no',
					'carousel_layout' => 'title_on_rollover',
					'columns'         => '5',
					'column_spacing'  => '10',
					'mouse_scroll'    => 'no',
					'picture_size'    => 'auto',
					'scroll_items'    => '',
					'show_buttons'    => 'yes',
					'show_cats'       => 'yes',
					'show_nav'        => 'yes',
					'show_price'      => 'yes',

					// Internal params.
					'post_type'       => 'product',
					'posts_per_page'  => -1,
					'meta_key'        => '_featured',
					'meta_value'      => 'yes',
				), $args
			);

			$defaults['column_spacing'] = FusionBuilder::validate_shortcode_attr_value( $defaults['column_spacing'], '' );

			$defaults['show_cats'] = ( 'yes' == $defaults['show_cats'] ) ? 'enable' : 'disable';
			$defaults['show_price'] = ( 'yes' == $defaults['show_price'] );
			$defaults['show_buttons'] = ( 'yes' == $defaults['show_buttons'] );

			extract( $defaults );

			self::$args = $defaults;

			$items_in_cart = array();

			if ( $woocommerce->cart && $woocommerce->cart->get_cart() && is_array( $woocommerce->cart->get_cart() ) ) {
				foreach ( $woocommerce->cart->get_cart() as $cart ) {
					$items_in_cart[] = $cart['product_id'];
				}
			}

			$design_class = 'fusion-' . ( ( class_exists( 'Avada' ) ) ? Avada()->settings->get( 'woocommerce_product_box_design' ) : '' ) . '-product-image-wrapper';

			$featured_image_size = ( 'fixed' == $picture_size ) ? 'shop_single' : 'full';

			$products = fusion_builder_cached_query( self::$args );

			if ( ! $products->have_posts() ) {
				return fusion_builder_placeholder( 'product', 'products' );
			}

			$product_list = '';

			if ( $products->have_posts() ) {

				while ( $products->have_posts() ) {
					$products->the_post();

					$id      = get_the_ID();
					$in_cart = in_array( $id, $items_in_cart );
					$image = $price_tag = $terms = '';

					// Title on rollover layout.
					if ( 'title_on_rollover' == $carousel_layout ) {
						$image = avada_render_first_featured_image_markup( get_the_ID(), $featured_image_size, get_permalink( get_the_ID() ), true, $show_price, $show_buttons, $show_cats );
						// Title below image layout.
					} else {
						if ( 'yes' == $show_buttons ) {
							$image = avada_render_first_featured_image_markup( get_the_ID(), $featured_image_size, get_permalink( get_the_ID() ), true, false, $show_buttons, 'disable', 'disable' );
						} else {
							$image = avada_render_first_featured_image_markup( get_the_ID(), $featured_image_size, get_permalink( get_the_ID() ), true, false, $show_buttons, 'disable', 'disable', '', '', 'no' );
						}

						// Get the post title.
						$image .= '<h4 ' . FusionBuilder::attributes( 'fusion-carousel-title' ) . '>';
						$image .= '<a href="' . get_permalink( get_the_ID() ) . '" target="_self">' . get_the_title() . '</a>';
						$image .= '</h4>';
						$image .= '<div class="fusion-carousel-meta">';

						// Get the terms.
						if ( 'enable' == $show_cats ) {
							$image .= get_the_term_list( get_the_ID(), 'product_cat', '', ', ', '' );
						}

						// Check if we should render the woo product price.
						if ( $show_price ) {
							ob_start();
							woocommerce_get_template( 'loop/price.php' );
							$image .= '<div class="fusion-carousel-price">' . ob_get_clean() . '</div>';
						}

						$image .= '</div>';
					}

					if ( $in_cart ) {
						$product_list .= '<li ' . FusionBuilder::attributes( 'fusion-carousel-item' ) . '><div class="' . $design_class . ' fusion-item-in-cart"><div ' . FusionBuilder::attributes( 'fusion-carousel-item-wrapper' ) . '>' . $image . '</div></div></li>';
					} else {
						$product_list .= '<li ' . FusionBuilder::attributes( 'fusion-carousel-item' ) . '><div class="' . $design_class . '"><div ' . FusionBuilder::attributes( 'fusion-carousel-item-wrapper' ) . '>' . $image . '</div></div></li>';
					}
				}
			}
			wp_reset_query();

			$html  = '<div ' . FusionBuilder::attributes( 'woo-featured-products-slider-shortcode' ) . '>';
			$html .= '<div ' . FusionBuilder::attributes( 'woo-featured-products-slider-shortcode-carousel' ) . '>';
			$html .= '<div ' . FusionBuilder::attributes( 'fusion-carousel-positioner' ) . '>';
			$html .= '<ul ' . FusionBuilder::attributes( 'fusion-carousel-holder' ) . '>';
			$html .= $product_list;
			$html .= '</ul>';
			// Check if navigation should be shown.
			if ( 'yes' == $show_nav ) {
				$html .= '<div ' . FusionBuilder::attributes( 'fusion-carousel-nav' ) . '><span ' . FusionBuilder::attributes( 'fusion-nav-prev' ) . '></span><span ' . FusionBuilder::attributes( 'fusion-nav-next' ) . '></span></div>';
			}
			$html .= '</div>';
			$html .= '</div>';
			$html .= '</div>';

		}

		return $html;

	}

	/**
	 * Builds the array of atributes.
	 *
	 * @access public
	 * @since 1.0
	 * @return array
	 */
	public function attr() {

		$attr = fusion_builder_visibility_atts( self::$args['hide_on_mobile'], array(
			'class' => 'fusion-woo-featured-products-slider fusion-woo-slider',
		) );

		if ( self::$args['class'] ) {
			$attr['class'] .= ' ' . self::$args['class'];
		}

		if ( self::$args['id'] ) {
			$attr['id'] = self::$args['id'];
		}

		return $attr;

	}

	/**
	 * Builds the carousel attributes.
	 *
	 * @access public
	 * @since 1.0
	 * @return array
	 */
	public function carousel_attr() {

		$attr = array(
			'class' => 'fusion-carousel',
		);

		if ( 'title_below_image' == self::$args['carousel_layout'] ) {
			$attr['class'] .= ' fusion-carousel-title-below-image';
			$attr['data-metacontent'] = 'yes';
		} else {
			$attr['class'] .= ' fusion-carousel-title-on-rollover';
		}

		$attr['data-autoplay']    = self::$args['autoplay'];
		$attr['data-columns']     = self::$args['columns'];
		$attr['data-itemmargin']  = self::$args['column_spacing'];
		$attr['data-itemwidth']   = 180;
		$attr['data-touchscroll'] = self::$args['mouse_scroll'];
		$attr['data-imagesize']   = self::$args['picture_size'];
		$attr['data-scrollitems'] = self::$args['scroll_items'];

		return $attr;
	}
}
new FusionSC_WooFeaturedProductsSlider();

/**
 * Map shortcode to Fusion Builder.
 *
 * @since 1.0
 */
function fusion_element_featured_products_slider() {
	if ( class_exists( 'WooCommerce' ) ) {
		fusion_builder_map( array(
			'name'      => esc_attr__( 'Woo Featured', 'fusion-builder' ),
			'shortcode' => 'fusion_featured_products_slider',
			'icon'      => 'fusiona-star-empty',
			'params'    => array(
				array(
					'type'        => 'radio_button_set',
					'heading'     => esc_attr__( 'Picture Size', 'fusion-builder' ),
					'description' => __( 'fixed = width and height will be fixed <br />auto = width and height will adjust to the image.', 'fusion-builder' ),
					'param_name'  => 'picture_size',
					'value'       => array(
						esc_attr__( 'Fixed', 'fusion-builder' ) => 'fixed',
						esc_attr__( 'Auto', 'fusion-builder' )  => 'auto',
					),
					'default'     => 'fixed',
				),
				array(
					'type'        => 'radio_button_set',
					'heading'     => esc_attr__( 'Carousel Layout', 'fusion-builder' ),
					'description' => esc_attr__( 'Choose to show titles on rollover image, or below image.', 'fusion-builder' ),
					'param_name'  => 'carousel_layout',
					'value'       => array(
						esc_attr__( 'Title on rollover', 'fusion-builder' ) => 'title_on_rollover',
						esc_attr__( 'Title below image', 'fusion-builder' ) => 'title_below_image',
					),
					'default'     => 'title_on_rollover',
				),
				array(
					'type'        => 'radio_button_set',
					'heading'     => esc_attr__( 'Carousel Autoplay', 'fusion-builder' ),
					'description' => esc_attr__( 'Choose to autoplay the carousel.', 'fusion-builder' ),
					'param_name'  => 'autoplay',
					'value'       => array(
						esc_attr__( 'Yes', 'fusion-builder' ) => 'yes',
						esc_attr__( 'No', 'fusion-builder' )  => 'no',
					),
					'default'     => 'no',
				),
				array(
					'type'        => 'range',
					'heading'     => esc_attr__( 'Maximum Columns', 'fusion-builder' ),
					'description' => esc_attr__( 'Select the number of max columns to display.', 'fusion-builder' ),
					'param_name'  => 'columns',
					'value'       => '5',
					'min'         => '1',
					'max'         => '6',
					'step'        => '1',
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_attr__( 'Column Spacing', 'fusion-builder' ),
					'description' => esc_attr__( "Insert the amount of spacing between items without 'px'. ex: 13.", 'fusion-builder' ),
					'param_name'  => 'column_spacing',
					'value'       => '',
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_attr__( 'Scroll Items', 'fusion-builder' ),
					'description' => esc_attr__( 'Insert the amount of items to scroll. Leave empty to scroll number of visible items.', 'fusion-builder' ),
					'param_name'  => 'scroll_items',
					'value'       => '',
				),
				array(
					'type'        => 'radio_button_set',
					'heading'     => esc_attr__( 'Show Navigation', 'fusion-builder' ),
					'description' => esc_attr__( 'Choose to show navigation buttons on the carousel.', 'fusion-builder' ),
					'param_name'  => 'show_nav',
					'value'       => array(
						esc_attr__( 'Yes', 'fusion-builder' ) => 'yes',
						esc_attr__( 'No', 'fusion-builder' )  => 'no',
					),
					'default' => 'yes',
				),
				array(
					'type'        => 'radio_button_set',
					'heading'     => esc_attr__( 'Mouse Scroll', 'fusion-builder' ),
					'description' => esc_attr__( 'Choose to enable mouse drag control on the carousel. IMPORTANT: For easy draggability, when mouse scroll is activated, links will be disabled.', 'fusion-builder' ),
					'param_name'  => 'mouse_scroll',
					'value'       => array(
						esc_attr__( 'Yes', 'fusion-builder' ) => 'yes',
						esc_attr__( 'No', 'fusion-builder' )  => 'no',
					),
					'default'     => 'no',
				),
				array(
					'type'        => 'radio_button_set',
					'heading'     => esc_attr__( 'Show Categories', 'fusion-builder' ),
					'description' => esc_attr__( 'Choose to show or hide the categories.', 'fusion-builder' ),
					'param_name'  => 'show_cats',
					'value'       => array(
						esc_attr__( 'Yes', 'fusion-builder' ) => 'yes',
						esc_attr__( 'No', 'fusion-builder' )  => 'no',
					),
					'default' => 'yes',
				),
				array(
					'type'        => 'radio_button_set',
					'heading'     => esc_attr__( 'Show Price', 'fusion-builder' ),
					'description' => esc_attr__( 'Choose to show or hide the price.', 'fusion-builder' ),
					'param_name'  => 'show_price',
					'value'       => array(
						esc_attr__( 'Yes', 'fusion-builder' ) => 'yes',
						esc_attr__( 'No', 'fusion-builder' )  => 'no',
					),
					'default'     => 'yes',
				),
				array(
					'type'        => 'radio_button_set',
					'heading'     => esc_attr__( 'Show Buttons', 'fusion-builder' ),
					'description' => esc_attr__( 'Choose to show or hide the icon buttons.', 'fusion-builder' ),
					'param_name'  => 'show_buttons',
					'value'       => array(
						esc_attr__( 'Yes', 'fusion-builder' ) => 'yes',
						esc_attr__( 'No', 'fusion-builder' )  => 'no',
					),
					'default'     => 'yes',
				),
				array(
					'type'        => 'checkbox_button_set',
					'heading'     => esc_attr__( 'Element Visibility', 'fusion-builder' ),
					'param_name'  => 'hide_on_mobile',
					'value'       => fusion_builder_visibility_options( 'full' ),
					'default'     => fusion_builder_default_visibility( 'array' ),
					'description' => esc_attr__( 'Choose to show or hide the element on small, medium or large screens. You can choose more than one at a time.', 'fusion-builder' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_attr__( 'CSS Class', 'fusion-builder' ),
					'description' => esc_attr__( 'Add a class to the wrapping HTML element.', 'fusion-builder' ),
					'param_name'  => 'class',
					'value'       => '',
					'group'       => esc_attr__( 'General', 'fusion-builder' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_attr__( 'CSS ID', 'fusion-builder' ),
					'description' => esc_attr__( 'Add an ID to the wrapping HTML element.', 'fusion-builder' ),
					'param_name'  => 'id',
					'value'       => '',
					'group'       => esc_attr__( 'General', 'fusion-builder' ),
				),
			),
		) );
	}
}
add_action( 'fusion_builder_before_init', 'fusion_element_featured_products_slider' );