<?php
/**
 * WCFM Markeplace plugin core
 *
 * WCfM Markeplace Store SEO
 *
 * @author 		WC Lovers
 * @package 	wcfmmp/core
 * @version   1.0.0
 */
class WCFMmp_Store_SEO {

	public $feedback    = false;
	private $store_info = false;
	private $store_id   = 0;

	public function __construct() {
		add_action( 'init', array( $this, 'register_sitemap' ) );
		add_action( 'template_redirect', array( $this, 'wcfmmp_output_meta_tags' ) );
		add_filter( 'wpseo_sitemap_index', array( $this, 'wcfmmp_add_sellers_sitemap' ), 100 );
	}

	function wcfmmp_output_meta_tags() {
		global $WCFM, $WCFMmp;
		
		if ( !wcfmmp_is_store_page() ) {
			return;
		}
		
		$this->store_id = get_query_var( 'author' );

		if ( !$WCFM->wcfm_vendor_support->wcfm_vendor_has_capability( $this->store_id, 'vendor_seo' ) ) {
			return;
		}

		$this->store_info = wcfmmp_get_store_info( $this->store_id );

		if ( class_exists( 'All_in_One_SEO_Pack' ) ) {
			add_filter( 'aioseop_title', array( $this, 'wcfmmp_replace_seo_title' ), 250 );
			add_filter( 'aioseop_keywords', array( $this, 'wcfmmp_replace_seo_keywords' ), 250 );
			add_filter( 'aioseop_description', array( $this, 'wcfmmp_replace_seo_desc' ), 250 );
			add_action( 'wp_head', array( $this, 'wcfmmp_print_social_tags' ), 1 );
		} elseif ( class_exists( 'WPSEO_Frontend' ) ) {
		 
			add_filter( 'wpseo_title', array( $this, 'wcfmmp_replace_seo_title' ), 250 );
			add_filter( 'wp_title', array( $this, 'wcfmmp_replace_seo_title' ), 250 );
			add_filter( 'wpseo_metakeywords', array( $this, 'wcfmmp_replace_seo_keywords' ) );
			add_filter( 'wpseo_metadesc', array( $this, 'wcfmmp_replace_seo_desc' ) );

			add_filter( 'wpseo_opengraph_url', array( $this, 'wcfmmp_replace_og_url' ) );
			add_filter( 'wpseo_opengraph_title', array( $this, 'wcfmmp_replace_og_title' ) );
			add_filter( 'wpseo_opengraph_desc', array( $this, 'wcfmmp_replace_og_desc' ) );
			add_filter( 'wpseo_opengraph_image', array( $this, 'wcfmmp_replace_og_img' ) );
			add_action( 'wpseo_opengraph', array( $this, 'wcfmmp_print_og_img' ), 250 );

			add_filter( 'wpseo_twitter_title', array( $this, 'wcfmmp_replace_twitter_title' ) );
			add_filter( 'wpseo_twitter_description', array( $this, 'wcfmmp_replace_twitter_desc' ) );
			add_filter( 'wpseo_twitter_image', array( $this, 'wcfmmp_replace_twitter_img' ) );
			add_action( 'wpseo_twitter', array( $this, 'wcfmmp_print_twitter_img' ), 250 );
		} else {
			add_filter( 'wp_title', array( $this, 'wcfmmp_replace_seo_title' ), 250 );
			add_action( 'wp_head', array( $this, 'wcfmmp_print_seo_tags' ), 1 );
			add_action( 'wp_head', array( $this, 'wcfmmp_print_social_tags' ), 1 );
		}
		add_filter( 'document_title_parts', array( $this, 'wcfmmp_replace_store_title' ), 250 );
	}

 /**
	* Register wcfmmp-stores sitemap on yoast SEO
	*/
	function register_sitemap() {
		global $WCFM, $WCFMmp, $wpseo_sitemaps;

		if ( is_a( $wpseo_sitemaps, 'WPSEO_Sitemaps' ) ) {
			$wpseo_sitemaps->register_sitemap( 'wcfmmp-stores', array( $this, 'sitemap_output' ) );
		}

	}
	/**
	 * Add wcfmmp-stores sitemap url to sitemap_index list
	 */
	function wcfmmp_add_sellers_sitemap() {

		if ( WPSEO_VERSION < 3.2 ) {
			$base_url = wpseo_xml_sitemaps_base_url( 'wcfmmp-stores-sitemap.xml' );
		} else {
			$base_url = WPSEO_Sitemaps_Router::get_base_url( 'wcfmmp-stores-sitemap.xml' );
		}

		ob_start();
		?>
		<sitemap>
		<loc><?php echo $base_url ?></loc>

		</sitemap>
		<?php

		return ob_get_clean();
	}

	/**
	 * Generate output for wcfmmp_sellers sitemap
	 */
	function sitemap_output() {
		global $WCFM, $WCFMmp, $wpseo_sitemaps;

		$seller_q = new WP_User_Query( array(
				'role'       => 'wcfm_vendor',
		) );
		$sellers = $seller_q->get_results();
		ob_start();
		?>
		<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
		  <?php foreach ( $sellers as $seller ) {
				$products = $WCFM->wcfm_vendor_support->wcfm_get_products_by_vendor( $seller->ID, 'publish', array( 'posts_per_page' => 1 ) );
				if( !empty( $products ) ) {
					foreach( $products as $product ) {
						$last_modified = $product->post_modified;
				?>
						<url>
							<loc><?php echo wcfmmp_get_store_url( $seller->ID ) ?></loc>
							<priority><?php echo apply_filters( 'wcfmmp_yoast_store_sitemap_priority', 0.8 )  ?></priority>
							<changefreq><?php echo apply_filters( 'wcfmmp_yoast_store_sitemap_changefreq', 'weekly' )  ?></changefreq>
							<lastmod><?php echo $last_modified ?></lastmod>
						</url>
				<?php break; }
				}
			}
			?>
		</urlset>
		<?php
		$sitemap = ob_get_clean();
		$wpseo_sitemaps->set_sitemap( $sitemap );
	}

	function wcfmmp_print_seo_tags() {
		global $WCFM, $WCFMmp;
		
		$store_info = $this->store_info;

		if ( !isset( $store_info['store_seo'] ) || empty( $store_info['store_seo'] ) || $store_info == false ) {
			return;
		}

		if ( isset( $store_info['store_seo']['wcfmmp-seo-meta-desc'] ) && !empty( $store_info['store_seo']['wcfmmp-seo-meta-desc'] ) ) {
			echo PHP_EOL . '<meta name="description" content="' . $this->wcfmmp_print_seo_saved_meta( $store_info['store_seo']['wcfmmp-seo-meta-desc'] ) . '"/>';
		}
		if ( isset( $store_info['store_seo']['wcfmmp-seo-meta-keywords'] ) && !empty( $store_info['store_seo']['wcfmmp-seo-meta-keywords'] ) ) {
			echo PHP_EOL . '<meta name="keywords" content="' . $this->wcfmmp_print_seo_saved_meta( $store_info['store_seo']['wcfmmp-seo-meta-keywords'] ) . '"/>';
		}
	}

	function wcfmmp_print_social_tags() {
		global $WCFM, $WCFMmp;
		
		$store_info = $this->store_info;

		if ( !isset( $store_info['store_seo'] ) || empty( $store_info['store_seo'] ) || $store_info == false ) {
				return;
		}

		$og_url        = wcfmmp_get_store_url( $this->store_id );
		$og_title      = isset( $store_info['store_seo']['wcfmmp-seo-og-title'] ) ? $store_info['store_seo']['wcfmmp-seo-og-title'] : '';
		$og_desc       = isset( $store_info['store_seo']['wcfmmp-seo-og-desc'] ) ? $store_info['store_seo']['wcfmmp-seo-og-desc'] : '';
		$og_img        = isset( $store_info['store_seo']['wcfmmp-seo-og-image'] ) ? $store_info['store_seo']['wcfmmp-seo-og-image'] : '';
		$twitter_title = isset( $store_info['store_seo']['wcfmmp-seo-twitter-title'] ) ?  $store_info['store_seo']['wcfmmp-seo-twitter-title'] : '';
		$twitter_desc  = isset( $store_info['store_seo']['wcfmmp-seo-twitter-desc'] ) ? $store_info['store_seo']['wcfmmp-seo-twitter-desc'] : '';
		$twitter_img   = isset( $store_info['store_seo']['wcfmmp-seo-twitter-image'] ) ? $store_info['store_seo']['wcfmmp-seo-twitter-image'] : '';

		if ( $og_url ) {
			echo PHP_EOL . '<meta property="og:url" content="' . $og_url . '">';
		}

		if ( $og_title ) {
			echo PHP_EOL . '<meta property="og:title" content="' . $this->wcfmmp_print_seo_saved_meta( $og_title ) . '"/>';
		}

		if ( $og_desc ) {
			echo PHP_EOL . '<meta property="og:description" content="' . $this->wcfmmp_print_seo_saved_meta( $og_desc ) . '"/>';
		}

		if ( $og_img ) {
			echo PHP_EOL . '<meta property="og:image" content="' . wp_get_attachment_url( $og_img ) . '"/>';
		}

		if ( $twitter_title ) {
			echo PHP_EOL . '<meta name="twitter:title" content="' . $this->wcfmmp_print_seo_saved_meta( $twitter_title ) . '"/>';
		}

		if ( $twitter_desc ) {
			echo PHP_EOL . '<meta name="twitter:description" content="' . $this->wcfmmp_print_seo_saved_meta( $twitter_desc ) . '"/>';
		}

		if ( $twitter_img ) {
			echo PHP_EOL . '<meta name="twitter:image" content="' . wp_get_attachment_url( $twitter_img ) . '"/>';
		}
	}

	function replace_seo_meta( $val_default, $meta, $type = '' ) {

		$meta_values = $this->store_info;

		if ( $meta_values == false || !isset( $meta_values['store_seo'] ) ) {
			return $val_default;
		}

		$key = 'wcfmmp-seo-' . $type . '-' . $meta;
		$val = '';
		if( isset( $meta_values['store_seo'] ) && isset( $meta_values['store_seo'][$key] ) && !empty( $meta_values['store_seo'][$key] ) ) {
			$val = $meta_values['store_seo'][$key];
		} else {
			$val = $meta_values['store_name'];
		}

		if ( $val ) {
			return $val;
		}

		return $val_default;
	}

	function wcfmmp_replace_seo_title( $title ) {
		return $this->replace_seo_meta( $title, 'title', 'meta' );
	}
	
	function wcfmmp_replace_store_title( $title ) {
		$meta_values = $this->store_info;
		$title['title'] = $meta_values['store_name'] . " " . apply_filters( 'wcfmmp_store_page_title_separator', '&#8211;' ) . " " . $title['title'];
		return $title;
	}

	function wcfmmp_replace_seo_keywords( $keywords ) {
		return $this->replace_seo_meta( $keywords, 'keywords', 'meta' );
	}

	function wcfmmp_replace_seo_desc( $desc ) {
		return $this->replace_seo_meta( $desc, 'desc', 'meta' );
	}

	function wcfmmp_replace_og_title( $title ) {
		return $this->replace_seo_meta( $title, 'title', 'og' );
	}

	function wcfmmp_replace_og_desc( $desc ) {
		return $this->replace_seo_meta( $desc, 'desc', 'og' );
	}

	function wcfmmp_replace_og_img( $img ) {
		$img_default = $img;

		$meta_values = $this->store_info;

		if ( !isset( $meta_values['store_seo'] ) || $meta_values == false ) {
			return $img_default;
		}

		$img = $meta_values['store_seo']['wcfmmp-seo-og-image'];

		if ( $img ) {
			return wp_get_attachment_url( $img );
		} else {
			return $img_default;
		}
	}

	function wcfmmp_print_og_img() {
		global $WCFM, $WCFMmp;
		
		$meta_values = $this->store_info;

		if ( $meta_values == false || !isset( $meta_values['store_seo'] ) || !isset( $meta_values['store_seo']['wcfmmp-seo-og-image'] )  ) {
			return;
		}

		$og_img = $meta_values['store_seo']['wcfmmp-seo-og-image'];

		if ( $og_img ) {
			echo '<meta property="og:image" content="' . wp_get_attachment_url( $og_img ) . '"/>';
		}
	}

	function wcfmmp_replace_twitter_title( $val_default ) {
		return $this->replace_seo_meta( $val_default, 'title', 'twitter' );
	}

	function wcfmmp_replace_twitter_desc( $val_default ) {
		return $this->replace_seo_meta( $val_default, 'desc', 'twitter' );
	}

	function wcfmmp_replace_twitter_img( $img ) {
		$img_default = $img;

		$meta_values = $this->store_info;

		if ( !isset( $meta_values['store_seo'] ) || $meta_values == false ) {
			return $img_default;
		}

		$img = $meta_values['store_seo']['wcfmmp-seo-twitter-image'];

		if ( $img ) {
			return wp_get_attachment_url( $img );
		}

		return $img_default;
	}

	function wcfmmp_print_twitter_img() {
		$meta_values = $this->store_info;

		if ( $meta_values == false || !isset( $meta_values['store_seo'] ) || !isset( $meta_values['store_seo']['wcfmmp-seo-twitter-image'] ) ) {
			return;
		}

		$tw_img = $meta_values['store_seo']['wcfmmp-seo-twitter-image'];

		if ( $tw_img ) {
			echo '<meta name="twitter:image" content="' . wp_get_attachment_url( $tw_img ) . '"/>';
		}
	}

	function wcfmmp_print_seo_saved_meta( $val ) {
		if ( $val == false ) {
			return '';
		} else {
			return esc_attr( $val );
		}
	}

	function wcfmmp_replace_og_url(){
		$og_url = wcfmmp_get_store_url( $this->store_id );
		return $og_url;
	}

}