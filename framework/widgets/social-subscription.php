<?php

add_action( 'after_setup_theme', 'vw_setup_vw_widgets_init_social_subscription' );
function vw_setup_vw_widgets_init_social_subscription() {
	add_action( 'widgets_init', 'vw_widgets_init_social_subscription' );
}

function vw_widgets_init_social_subscription() {
	register_widget( 'Vw_widget_social_subscription' );
}
add_action( 'widgets_init', 'vw_widgets_init_social_subscription' );

class Vw_widget_social_subscription extends WP_Widget {
	private $default = array(
		'supertitle' => '',
		'title' => '',
		'subtitle' => '',
		'twitter' => '',
		'twitter_key' => 'l9e7w4GDJUOvjhNPzGU4Kw',
		'twitter_secret' => 'N1wS0SXR5m41R2fsSm80YO8ymrFGA42X1GuVNVKFgo',
		'facebook' => '',
		'youtube' => '',
		'googleplus' => '',
	);

	public function __construct() {
		// widget actual processes
		parent::__construct(
	 		'vw_widget_social_subscription', // Base ID
			'Envirra Social Subscription', // Name
			array( 'description' => __( 'Display site social with counter', 'envirra' ), ) // Args
		);
	}

	function widget( $args, $instance ) {
		extract($args);

		if ( function_exists( 'icl_t' ) ) {
			$instance['supertitle'] = icl_t( 'PRESSO Widget', $this->id.'_supertitle', $instance['supertitle'] );
			$instance['title'] = icl_t( 'PRESSO Widget', $this->id.'_title', $instance['title'] );
			$instance['subtitle'] = icl_t( 'PRESSO Widget', $this->id.'_subtitle', $instance['subtitle'] );
		}

		$supertitle_html = '';
		if ( ! empty( $instance['supertitle'] ) ) {
			$supertitle_html = sprintf( __( '<span class="super-title">%s</span>', 'envirra' ), $instance['supertitle'] );
		}

		$title_html = '';
		if ( ! empty( $instance['title'] ) ) {
			$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base);
			$title_html = $supertitle_html.$title;
		}
		$subtitle_html = '';
		if ( ! empty( $instance['subtitle'] ) ) {
			$subtitle_html = sprintf( __( '<p class="section-description">%s</p>', 'envirra' ), $instance['subtitle'] );
		}

		$twitter = strip_tags( $instance['twitter'] );
		$twitter_key = strip_tags( $instance['twitter_key'] );
		$twitter_secret = strip_tags( $instance['twitter_secret'] );
		$facebook = strip_tags( $instance['facebook'] );
		$youtube = strip_tags( $instance['youtube'] );
		$googleplus = strip_tags( $instance['googleplus'] );

		echo $before_widget;
		if ( $instance['title'] ) echo $before_title . $title_html . $after_title . $subtitle_html;

		if ( $twitter ) {
			$twitter_count = vw_get_twitter_count( $twitter, $twitter_key, $twitter_secret );
			?>
				<div class="social-subscription">
					<a class="social-subscription-icon" href="<?php echo esc_attr( $twitter_count['page_url'] ); ?>" title="<?php esc_attr_e( 'Follow our twitter', 'envirra' ) ?>" target="_blank"><i class="icon-social-twitter"></i></a>
					<div class="social-subscription-counter">
						<div class="social-subscription-count header-font"><?php echo number_format( $twitter_count['followers_count'] ); ?></div>
						<div class="social-subscription-unit"><?php _e( 'followers', 'envirra' ) ?></div>
					</div>
					<div class="clearfix"></div>
				</div>
			<?php
		}

		if ( $facebook ) {
			$facebook_count = vw_get_facebook_count( $facebook );
			?>
				<div class="social-subscription">
					<a class="social-subscription-icon" href="<?php echo esc_attr( $facebook_count['page_url'] ); ?>" title="<?php esc_attr_e( 'Like our facebook', 'envirra' ) ?>" target="_blank"><i class="icon-social-facebook"></i></a>
					<div class="social-subscription-counter">
						<div class="social-subscription-count header-font"><?php echo number_format( $facebook_count['fans_count'] ); ?></div>
						<div class="social-subscription-unit"><?php _e( 'fans', 'envirra' ) ?></div>
					</div>
					<div class="clearfix"></div>
				</div>
			<?php
		}

		if ( $youtube ) {
			$youtube_count = vw_get_youtube_count( $youtube );
			?>
				<div class="social-subscription">
					<a class="social-subscription-icon" href="<?php echo esc_attr( $youtube_count['page_url'] ); ?>" title="<?php esc_attr_e( 'Subscribe our youtube', 'envirra' ) ?>" target="_blank"><i class="icon-social-youtube"></i></a>
					<div class="social-subscription-counter">
						<div class="social-subscription-count header-font"><?php echo number_format( $youtube_count['subscriber_count'] ); ?></div>
						<div class="social-subscription-unit"><?php _e( 'subscribers', 'envirra' ) ?></div>
					</div>
					<div class="clearfix"></div>
				</div>
			<?php
		}

		if ( $googleplus ) {
			$googleplus_count = vw_get_googleplus_count( $googleplus );
			?>
				<div class="social-subscription">
					<a class="social-subscription-icon" href="<?php echo esc_attr( $googleplus_count['page_url'] ); ?>" title="<?php esc_attr_e( '+1 our page', 'envirra' ) ?>" target="_blank"><i class="icon-social-gplus"></i></a>
					<div class="social-subscription-counter">
						<div class="social-subscription-count header-font"><?php echo number_format( $googleplus_count['people_count'] ); ?></div>
						<div class="social-subscription-unit"><?php _e( 'people', 'envirra' ) ?></div>
					</div>
					<div class="clearfix"></div>
				</div>
			<?php
		}
		?>
		<div class="clearfix"></div>
		<?php

		wp_reset_postdata();
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$new_instance = wp_parse_args( (array) $new_instance, $this->default );
		$instance['supertitle'] = strip_tags( $new_instance['supertitle'] );
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['subtitle'] = strip_tags( $new_instance['subtitle'] );
		$instance['twitter'] = strip_tags( $new_instance['twitter'] );
		$instance['twitter_key'] = strip_tags( $new_instance['twitter_key'] );
		$instance['twitter_secret'] = strip_tags( $new_instance['twitter_secret'] );
		$instance['facebook'] = strip_tags( $new_instance['facebook'] );
		$instance['youtube'] = strip_tags( $new_instance['youtube'] );
		$instance['googleplus'] = strip_tags( $new_instance['googleplus'] );

		delete_transient( 'vw_twitter_count' );
		delete_transient( 'vw_facebook_count' );
		delete_transient( 'vw_youtube_count' );
		delete_transient( 'vw_googleplus_count' );

		if ( function_exists( 'icl_register_string' ) ) {
			icl_register_string( 'PRESSO Widget', $this->id.'_supertitle', $instance['supertitle'] );
			icl_register_string( 'PRESSO Widget', $this->id.'_title', $instance['title'] );
			icl_register_string( 'PRESSO Widget', $this->id.'_subtitle', $instance['subtitle'] );
		}

		return $instance;
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->default );

		$supertitle = strip_tags( $instance['supertitle'] );
		$title = strip_tags( $instance['title'] );
		$subtitle = strip_tags( $instance['subtitle'] );
		$twitter = strip_tags( $instance['twitter'] );
		$twitter_key = strip_tags( $instance['twitter_key'] );
		$twitter_secret = strip_tags( $instance['twitter_secret'] );
		$facebook = strip_tags( $instance['facebook'] );
		$youtube = strip_tags( $instance['youtube'] );
		$googleplus = strip_tags( $instance['googleplus'] );
		?>

		<!-- super title -->
		<p>
			<label for="<?php echo $this->get_field_id('supertitle'); ?>"><?php _e('Super-title:','envirra-backend'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('supertitle'); ?>" name="<?php echo $this->get_field_name('supertitle'); ?>" type="text" value="<?php echo esc_attr($supertitle); ?>" />
		</p>

		<!-- title -->
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:','envirra-backend'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>

		<!-- sub title -->
		<p>
			<label for="<?php echo $this->get_field_id('subtitle'); ?>"><?php _e('Sub-title:','envirra-backend'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('subtitle'); ?>" name="<?php echo $this->get_field_name('subtitle'); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>" />
		</p>

		<!-- twitter username -->
		<p>
			<label for="<?php echo $this->get_field_id('twitter'); ?>"><?php _e('Twitter name:','envirra-backend'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter'); ?>" name="<?php echo $this->get_field_name('twitter'); ?>" type="text" value="<?php echo esc_attr($twitter); ?>" />
		</p>

		<!-- twitter consumer key -->
		<p>
			<label for="<?php echo $this->get_field_id('twitter_key'); ?>"><?php _e('Twitter consumer key:','envirra-backend'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter_key'); ?>" name="<?php echo $this->get_field_name('twitter_key'); ?>" type="text" value="<?php echo esc_attr($twitter_key); ?>" />
		</p>

		<!-- twitter consumer secret -->
		<p>
			<label for="<?php echo $this->get_field_id('twitter_secret'); ?>"><?php _e('Twitter consumer secret:','envirra-backend'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('twitter_secret'); ?>" name="<?php echo $this->get_field_name('twitter_secret'); ?>" type="text" value="<?php echo esc_attr($twitter_secret); ?>" />
		</p>

		<!-- facebook id -->
		<p>
			<label for="<?php echo $this->get_field_id('facebook'); ?>"><?php _e('Facebook ID:','envirra-backend'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('facebook'); ?>" name="<?php echo $this->get_field_name('facebook'); ?>" type="text" value="<?php echo esc_attr($facebook); ?>" />
			<p class="description">The value should be a page id like "<strong>80655071208</strong>".You can find the page id <a href="http://findmyfacebookid.com/" target="_blank">here</a>.</p>
		</p>

		<!-- youtube username -->
		<p>
			<label for="<?php echo $this->get_field_id('youtube'); ?>"><?php _e('Youtube name:','envirra-backend'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('youtube'); ?>" name="<?php echo $this->get_field_name('youtube'); ?>" type="text" value="<?php echo esc_attr($youtube); ?>" />
		</p>

		<!-- googleplus username -->
		<p>
			<label for="<?php echo $this->get_field_id('googleplus'); ?>"><?php _e('Google+ Username/ID:','envirra-backend'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('googleplus'); ?>" name="<?php echo $this->get_field_name('googleplus'); ?>" type="text" value="<?php echo esc_attr($googleplus); ?>" />
			<p class="description">The value should be a name or id like "<strong>+envato</strong>"" or "<strong>107285294994146126204</strong>"</p>
		</p>

		<?php
	}
}

if ( ! function_exists( 'vw_get_twitter_count' ) ) {
	function vw_get_twitter_count( $twitter_id, $consumer_key, $consumer_secret ) {
		$twitter = get_transient('vw_twitter_count');
		if ($twitter !== false) return $twitter;

		// some variables
		$token = get_option('vw_twitter_token');
		$twitter['page_url'] = "http://www.twitter.com/$twitter_id";

		if($twitter_id && $consumer_key && $consumer_secret) {
			if(!$token) {
				// preparing credentials
				$credentials = $consumer_key . ':' . $consumer_secret;
				$toSend = base64_encode($credentials);

				// http post arguments
				$args = array(
					'method' => 'POST',
					'httpversion' => '1.1',
					'blocking' => true,
					'headers' => array(
						'Authorization' => 'Basic ' . $toSend,
						'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
					),
					'body' => array( 'grant_type' => 'client_credentials' )
				);

				add_filter('https_ssl_verify', '__return_false');
				$response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);

				$keys = json_decode(wp_remote_retrieve_body($response));

				if($keys) {
					// saving token to wp_options table
					update_option('vw_twitter_token', $keys->access_token);
					$token = $keys->access_token;
				}
			}
			// we have bearer token wether we obtained it from API or from options
			$args = array(
				'httpversion' => '1.1',
				'blocking' => true,
				'headers' => array(
					'Authorization' => "Bearer $token"
				)
			);

			add_filter('https_ssl_verify', '__return_false');
			$api_url = "https://api.twitter.com/1.1/users/show.json?screen_name=$twitter_id";
			$response = wp_remote_get($api_url, $args);

			if (!is_wp_error($response)) {
				$twitter_reply = json_decode(wp_remote_retrieve_body($response));
				if ( isset( $twitter_reply->followers_count ) ) {
					$twitter['followers_count'] = $twitter_reply->followers_count;
				} else {
					$twitter['followers_count'] = null;
				}
			} else {
				$twitter['followers_count'] = null;
			}
		} else {
			$twitter['followers_count'] = null;
		}

		if ( is_null( $twitter['followers_count'] ) ){
			$saved_twitter = get_option( 'vw_social_counter_twitter', array() );

			if ( ! empty( $saved_twitter['followers_count'] ) && $saved_twitter['page_url'] == $twitter['page_url'] ) {
				// Restore previous counter
				$twitter['followers_count'] = $saved_twitter['followers_count'];
			} else {
				$twitter['followers_count'] = 0;
			}
		}

		update_option( 'vw_social_counter_twitter', $twitter );
		set_transient( 'vw_twitter_count', $twitter, 60*60*4 ); // 4 hour cache
		return $twitter;
	}
}

if ( ! function_exists( 'vw_get_facebook_count' ) ) {
	function vw_get_facebook_count( $page_id ) {
		$facebook = get_transient('vw_facebook_count');
		if ($facebook !== false) return $facebook;

		$facebook['page_id'] = $page_id;

		try {
			$url = "http://graph.facebook.com/".$page_id;
			@$reply = json_decode(@vw_get_subscriber_counter($url));
			@$facebook['fans_count'] = $reply->likes;
			@$facebook['page_url'] = $reply->link;
		} catch (Exception $e) {
			$saved_facebook = get_option( 'vw_social_counter_facebook', array() );
			if ( ! empty( $saved_facebook['fans_count'] ) && $saved_facebook['page_id'] == $facebook['page_id'] ) {
				// Restore previous counter
				$facebook['fans_count'] = $saved_facebook['fans_count'];
				$facebook['page_url'] = $saved_facebook['page_url'];
			} else {
				$facebook['fans_count'] = '0';
				$facebook['page_url'] = 'http://www.facebook.com';
			}
		}

		update_option( 'vw_social_counter_facebook', $facebook );
		set_transient( 'vw_facebook_count', $facebook, 60*60*4 ); // 4 hour cache
		return $facebook;
	}
}

if ( ! function_exists( 'vw_get_youtube_count' ) ) {
	function vw_get_youtube_count( $username ) {
		$youtube = get_transient('vw_youtube_count');
		if ($youtube !== false) return $youtube;

		$youtube['page_url'] = "http://www.youtube.com/user/".$username;

		try {
			@$xmlData = @vw_get_subscriber_counter('http://gdata.youtube.com/feeds/api/users/' . $username); 
			@$xmlData = str_replace('yt:', 'yt', $xmlData); 
			@$xml = new SimpleXMLElement($xmlData); 
			@$youtube['subscriber_count'] = ( string ) $xml->ytstatistics['subscriberCount'];
		} catch (Exception $e) {
			$youtube['subscriber_count'] = 0;
			$youtube['page_url'] = "http://www.youtube.com";

			$saved_youtube = get_option( 'vw_social_counter_youtube', array() );
			if ( ! empty( $saved_youtube['subscriber_count'] ) && $saved_youtube['page_url'] == $youtube['page_url'] ) {
				// Restore previous counter
				$youtube['subscriber_count'] = $saved_youtube['subscriber_count'];
			} else {
				$youtube['subscriber_count'] = '0';
			}
		}

		update_option( 'vw_social_counter_youtube', $youtube );
		set_transient( 'vw_youtube_count', $youtube, 60*60*4 ); // 4 hour cache
		return($youtube); 
	}
}

if ( ! function_exists( 'vw_get_googleplus_count' ) ) {
	function vw_get_googleplus_count( $username ) {
		$googleplus = get_transient('vw_googleplus_count');
		if ($googleplus !== false) return $googleplus;

		if ( preg_match( '/[^0-9]/', $username ) && strpos( $username, '+' ) !== 0 ) {
			$username = '+'.$username;
		}
		
		$api_url = 'https://www.googleapis.com/plus/v1/people/'.$username.'?key=AIzaSyCfbKKE_GQqyuxXT38eVCRtlKgmMrwZz4o';
		$googleplus['page_url'] = 'https://plus.google.com/'.$username;
		$googleplus['people_count'] = null;
		
		$data = vw_get_subscriber_counter($api_url); 

		if ( ! is_wp_error( $data ) ) {
			$json = json_decode( $data );

			if ( isset( $json->url ) ) {
				$googleplus['page_url'] = $json->url;
			}

			if ( isset( $json->plusOneCount ) ) {
				$googleplus['people_count'] = $json->plusOneCount;
			} elseif ( isset( $json->circledByCount ) ) {
				$googleplus['people_count'] = $json->circledByCount;
			}
		}

		if ( is_null( $googleplus['people_count'] ) ){
			$saved_googleplus = get_option( 'vw_social_counter_googleplus', array() );

			if ( ! empty( $saved_googleplus['people_count'] ) && $saved_googleplus['page_url'] == $googleplus['page_url'] ) {
				// Restore previous counter
				$googleplus['people_count'] = $saved_googleplus['people_count'];
			} else {
				$googleplus['people_count'] = 0;
			}
		}

		update_option( 'vw_social_counter_googleplus', $googleplus );
		set_transient( 'vw_googleplus_count', $googleplus, 60*60*4 ); // 4 hour cache
		return $googleplus;
	}
}


if ( ! function_exists( 'vw_get_subscriber_counter' ) ) {
	function vw_get_subscriber_counter( $api_url ) {
		$args = array(
			'httpversion' => '1.1',
			'blocking' => true,
		);

		$response = wp_remote_get( $api_url, $args );
		if ( ! is_wp_error( $response ) ) {
			return wp_remote_retrieve_body( $response );
		}
	}
}