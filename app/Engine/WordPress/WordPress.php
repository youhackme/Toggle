<?php

namespace App\Engine\WordPress;

/**
 * Created by PhpStorm.
 * User: Hyder
 * Date: 03/04/2017
 * Time: 22:16
 */
class WordPress {


	/**
	 * 1. Check for presence of readme.html
	 * 2. Check for generator meta tags
	 * 3. Check presence of this file: https://darktips.com/wp-includes/css/buttons.css
	 * 4. Check for WP core api: wp-json in url
	 * 5. check for wp-content/wp-includes in souces code
	 * 6. find /wp-content/ in robots.txt
	 * 7. Find logo /wp-admin/images/wordpress-logo.svg
	 * 8. Find /license.txt
	 * 9.
	 * 10.
	 * 11.
	 * 12.
	 * 13.
	 * 14.
	 * 15.
	 */

}

class MetaTags {

	// Check for powered by wordpress
	// Check also for presence of plugins in meta tags to confirm WP

}

class Headers {
	// Check for headers such as Powered by W3 total cache
	// Powered by X
	// This will confirm WP
}

class Uri {
	// Check presence of wp-content
	// Check presence of wp-include
}

class robots {
	// Check presence of wp-content in robots.txt
}

class link(){
	// check presence of absolute path such as readme, buttons.css , license.txt
}

class plugins {
	// * ways to check for presence of plugins:
	//   - based on urls e.g wp-content/plugins/w3totalcache
	//   - based on class names and ids
	//   - Based on headers
	//   - html comments such as "html": "<!--[^>]+WP-Super-Cache",
	//   -
}

class Theme{
	// * detect theme based on
	// -- screenshot hash
	// -- theme alias => wp-content/themes/theme-name
	// -- meta data in style sheets
}