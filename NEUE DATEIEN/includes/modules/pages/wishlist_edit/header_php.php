<?php
/**
 * Wishlist for Zen Cart German
 * Zen Cart German Specific
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: header_php.php 2024-03-16 09:41:16Z webchills $
 */
if (!zen_is_logged_in()) {
	$_SESSION['navigation']->set_snapshot();
zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
}

if ( UN_ALLOW_MULTIPLE_WISHLISTS!==true ) {
	zen_redirect(zen_href_link(FILENAME_WISHLIST, '', 'SSL'));
}

require(DIR_WS_MODULES . 'require_languages.php');
$breadcrumb->add(NAVBAR_TITLE);

// get form data
$id = isset($_REQUEST['wid']) ? (int) $_REQUEST['wid'] : 0;
$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : '';

// Get wishlist class and instantiate
require_once(DIR_WS_CLASSES . 'un_wishlist.php');
$oWishlist = new un_wishlist($_SESSION['customer_id']);

// get wishlist data
if ( $op=='edit' && !un_is_empty($id) ) {
	$oWishlist->setWishlistId($id);
	$records = $oWishlist->getWishlist();
} else {
	$records = NULL;
}	
// process form if posted
if ( un_check_html_form('wishlist_edit') ) {
    
    // do more data input check here, if needed
    
    $FORMOK = true;
    $success = false;
    
    // assign post vars
    if (isset($_POST['required-name'])) {	
    $aArgs['name'] = $_POST['required-name'];
  }
    $aArgs['comment'] = $_POST['comment'];
    
	
	if ( $FORMOK===true ) {
		// check operation type
		if (!strcmp("edit", $op)) {
			// try edit users
			$success = $oWishlist->editWishlist($aArgs);
		} elseif (!strcmp("add", $op)) {
			// try add users
			$success = $oWishlist->addWishlist($aArgs);
		}
	}	
	// redirect if successful
	if ($success) {
		zen_redirect(zen_href_link(FILENAME_WISHLISTS, '', 'SSL'));
		$success = true;
	}    
} else {
	$success = false;
}