<?php
/**
 * Vogue theme.
 *
 * @since 1.0.0
 */

// File Security Check
if (!defined('ABSPATH')) {exit;}

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since 1.0.0
 */
if (!isset($content_width)) {
	$content_width = 1200; /* pixels */
}

/**
 * Initialize theme.
 *
 * @since 1.0.0
 */
require trailingslashit(get_template_directory()) . 'inc/init.php';

function loadCustomTemplate($template) {
	global $wp_query;
	if (!file_exists($template)) {
		return;
	}

	$wp_query->is_page = true;
	$wp_query->is_single = false;
	$wp_query->is_home = false;
	$wp_query->comments = false;
	// if we have a 404 status
	if ($wp_query->is_404) {
		// set status of 404 to false
		unset($wp_query->query["error"]);
		$wp_query->query_vars["error"] = "";
		$wp_query->is_404 = false;
	}
	// change the header to 200 OK
	header("HTTP/1.1 200 OK");
	//load our template
	include $template;
	exit;
}

function templateRedirect() {
	$basename = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
	loadCustomTemplate(TEMPLATEPATH . '/xuanqi/' . "/$basename.php");
}

add_action('template_redirect', 'templateRedirect');
