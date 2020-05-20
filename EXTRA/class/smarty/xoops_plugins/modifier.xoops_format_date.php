<?php

/*
 * Smarty plugin #*#UNCACHE_DATES#
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     xoops_format_date
 * Purpose:  format date via PHP function date or equivalent Javascript (if enabled)
 * -------------------------------------------------------------
 * Inputs:
 *    $timestamp    - (operand) number of seconds since 1970-01-01 00:00:00 UTC
 *    $format       - format string (same as $format parameter to PHP function date()
 *    $nojavascript - (optional) suppresses generation of Javascript
 *       'nojavascript' - do not generate Javascript
 *       (not provided) - generate Javascript
 *
 * Examples:
 * 
 *    (These examples assume ldelim is "{" and rdelim is "}".)
 * 
 *    Formatted date using specified timestamp, with Javascript generated:
 *       {'1076029235'|xoops_format_date:'Y/n/j G:i'}
 *
 *    Formatted date using current time, with Javascript generated:
 *       {$smarty.now|xoops_format_date:'Y/n/j G:i'}
 * 
 *    Formatted date using specified timestamp, with no Javascript generated:
 *       {'1076029235'|xoops_format_date:'Y/n/j G:i:'nojavascript'}
 *
 * For testing purposes only, the formatted date is prefixed with "J" (Javascript) or "P" (PHP). #*#DEBUG#
 * -------------------------------------------------------------
 */

/**
 * @param      $timestamp
 * @param      $format
 * @param null $nojavascript
 * @return string|void
 */
function smarty_modifier_xoops_format_date($timestamp, $format, $nojavascript=null)
{
	static $javascript_include_generated = false;

	if (!isset($timestamp)) {
		trigger_error("modifier xoops_format_date: missing 'timestamp' operand");
		return;
	}

	if (!isset($format)) {
		trigger_error("modifier xoops_format_date: missing 'format' parameter");
		return;
	}

	$use_javascript = true;
	if (isset($nojavascript)) {
		if (strtolower($nojavascript) == 'nojavascript') {
			$use_javascript = false;
		} else {
			trigger_error("modifier xoops_format_date: 'nojavascript' parameter is '$nojavascript', expecting 'nojavascript'");
			return;
		}
	}

	// PHP-formatted date
	#$pdate = 'P' . date($format, $timestamp); #*#DEBUG# - 'P' only for debugging purposes
	$pdate = date($format, $timestamp);

	$rtn = '';

	if ($use_javascript) {
		if (!$javascript_include_generated) {
			$file = XOOPS_URL . '/include/phpdate.js';
			$rtn .= "<script type='text/javascript' src='$file'></script>";
			$javascript_include_generated = true;
		}
	}

	if ($use_javascript) {

		// backslashes have to be encoded (replaced with ASCII code) for Javascript
		$format_encoded = str_replace('\\', '\\x' . dechex(ord('\\')), $format);

		// ampersands have to be encoded for XHTML compliancy
		$format_encoded = str_replace('&', '\x' . dechex(ord('&')), $format_encoded);

		// Javascript-formatted date
		#$jdate = "'J' + phpDate('$format_encoded', $timestamp)"; #*#DEBUG# - 'J' only for debugging purposes
		$jdate = "phpDate('$format_encoded', $timestamp)";

		$rtn .= "<script type='text/javascript'>document.write($jdate);</script><noscript>$pdate</noscript>";

	} else {

		$rtn .= $pdate;
	}

	return $rtn;
}

/* vim: set expandtab: */

?>
