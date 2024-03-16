<?php 
/**
 * Wishlist for Zen Cart German
 * Zen Cart German Specific
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: header_php.php 2024-03-16 08:02:16Z webchills $
 */
if (!zen_is_logged_in()) {
	$_SESSION['navigation']->set_snapshot();
	zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}

if ( UN_ALLOW_MULTIPLE_WISHLISTS!==true ) {
	zen_redirect(zen_href_link(FILENAME_WISHLIST, '', 'SSL'));
}

// Get wishlist class and instantiate
require_once(DIR_WS_CLASSES . 'un_wishlist.php');
$oWishlist = new un_wishlist($_SESSION['customer_id']);

// Use specified wishlist if wid set, else use default wishlist
$id = isset($_REQUEST['wid']) ? (int) $_REQUEST['wid'] : '';
if ( ! un_is_empty($id) ) {
	$oWishlist->setWishlistId($id);
	if ( ! $oWishlist->hasPermission() ) {
		zen_redirect(zen_href_link(FILENAME_WISHLISTS, '', 'SSL'));
	}
} else {
	$id = $oWishlist->getDefaultWishlistId();
}

// Process
if ( un_check_html_form('wishlist_move') ) {
	for ($i=0, $iMax = sizeof($_POST['products_id']); $i< $iMax; $i++) {
		
		if ( in_array($_POST['products_id'][$i], (is_array($_POST['select']) ? $_POST['select'] : array())) ) {
			$oWishlist->moveProduct((int)$_POST['products_id'][$i], (int)$_POST['wishlists_id']);
		}
		
	}
}
require(DIR_WS_MODULES . 'require_languages.php');
$breadcrumb->add(NAVBAR_TITLE);