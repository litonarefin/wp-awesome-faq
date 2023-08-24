<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * @version       1.0.0
 * @package       JLT_Awesome_FAQ
 * @license       Copyright JLT_Awesome_FAQ
 */

if ( ! function_exists( 'jltwpafaq_option' ) ) {
	/**
	 * Get setting database option
	 *
	 * @param string $section default section name jltwpafaq_general .
	 * @param string $key .
	 * @param string $default .
	 *
	 * @return string
	 */
	function jltwpafaq_option( $section = 'jltwpafaq_general', $key = '', $default = '' ) {
		$settings = get_option( $section );

		return isset( $settings[ $key ] ) ? $settings[ $key ] : $default;
	}
}

if ( ! function_exists( 'jltwpafaq_exclude_pages' ) ) {
	/**
	 * Get exclude pages setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jltwpafaq_exclude_pages() {
		return jltwpafaq_option( 'jltwpafaq_triggers', 'exclude_pages', array() );
	}
}

if ( ! function_exists( 'jltwpafaq_exclude_pages_except' ) ) {
	/**
	 * Get exclude pages except setting option data
	 *
	 * @return string|array
	 *
	 * @version 1.0.0
	 */
	function jltwpafaq_exclude_pages_except() {
		return jltwpafaq_option( 'jltwpafaq_triggers', 'exclude_pages_except', array() );
	}
}