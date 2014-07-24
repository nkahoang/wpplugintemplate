<?php

class WMEShortCodes {
	static function shortcode_1($atts, $content = "") {
		return "<pre>This is the raw content inside shortcode: \n\n" . do_shortcode($content) . "</pre>";
	}
}