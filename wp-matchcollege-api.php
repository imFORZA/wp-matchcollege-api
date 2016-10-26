<?php
/**
 * WP Match College API (http://www.matchcollege.com/college-data-api)
 *
 * @package WP-Enerscore-API
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) { exit; }

/* Check if class exists. */
if ( ! class_exists( 'MatchCollegeAPI' ) ) {

	/**
	 * MatchCollegeAPI class.
	 */
	class MatchCollegeAPI {

		/**
		 * API Key.
		 *
		 * @var string
		 */
		static private $api_key;

		/**
		 * Return format. XML or JSON or PHP.
		 *
		 * @var [string
		 */
		static private $output;

		 /**
		 * URL to the API.
		 *
		 * @var string
		 */
		private $base_uri = 'http://api.matchcollege.com/colleges';

		/**
		 * __construct function.
		 *
		 * @access public
		 * @return void
		 */
		public function __construct( $api_key, $output ) {

			static::$api_key = $api_key;
			static::$output = $output;

		}

		 /**
		 * Fetch the request from the API.
		 *
		 * @access private
		 * @param mixed $request Request URL.
		 * @return $body Body.
		 */
		private function fetch( $request ) {

			$response = wp_remote_get( $request );
			$code = wp_remote_retrieve_response_code( $response );

			if ( 200 !== $code ) {
				return new WP_Error( 'response-error', sprintf( __( 'Server response code: %d', 'text-domain' ), $code ) );
			}

			$body = wp_remote_retrieve_body( $response );

			return json_decode( $body );

		}


		/**
		 * Get Colleges.
		 *
		 * @access public
		 * @param string $fn (default: 'college_search')
		 * @param string $v (default: '1')
		 * @param mixed $zip
		 * @param mixed $city
		 * @param mixed $state
		 * @param string $college_type (default: '')
		 * @param string $college_funding (default: '')
		 * @param string $distance (default: '')
		 * @return void
		 */
		public function get_colleges( $fn = 'college_search', $v = '1', $zip, $city, $state, $college_type = '', $college_funding = '', $distance = '' ) {

			$request = $this->base_uri . '?key=' . static::$api_key . '&v=' . $v . '&fn=' . $fn . '&output=' . static::$output;

			return $this->fetch( $request );

		}

	}

}
