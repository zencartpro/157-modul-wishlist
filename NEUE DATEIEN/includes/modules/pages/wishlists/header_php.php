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

if ( !UN_ALLOW_MULTIPLE_WISHLISTS ) {
	//zen_redirect(zen_href_link(FILENAME_WISHLIST, '', 'SSL'));
}

require(DIR_WS_MODULES . 'require_languages.php');
$breadcrumb->add(NAVBAR_TITLE);

// Get wishlist class and instantiate
require_once(DIR_WS_CLASSES . 'un_wishlist.php');
$oWishlist = new un_wishlist($_SESSION['customer_id']);

// check for id
if ( isset($_GET['wid']) && !un_is_empty($_GET['wid']) ) {
    
    $id = (int)$_GET['wid'];
    $op = $_GET['op'];
    
    // assign wishlist id
    $oWishlist->setWishlistId($id);
    
    // check operation type
    if (!strcmp($op, 'del')) {
        
        // try delete wishlist and redirect
        $success = $oWishlist->deleteWishlist();
        if ( $success===true ) {
			zen_redirect(zen_href_link(FILENAME_WISHLISTS, zen_get_all_get_params(array('op', 'wid')), 'SSL'));
		}
        
    } elseif (!strcmp($op, 'act')) {
        
        // try to make publice
        $success = $oWishlist->makePublic();
        if ( $success===true ) {
			zen_redirect(zen_href_link(FILENAME_WISHLISTS, zen_get_all_get_params(array('op', 'wid')), 'SSL'));
		}
        
    } elseif (!strcmp($op, 'deact')) {
        
        // try to make private
        $success = $oWishlist->makePrivate();
        if ( $success===true ) {
			zen_redirect(zen_href_link(FILENAME_WISHLISTS, zen_get_all_get_params(array('op', 'wid')), 'SSL'));
		}
		
    } elseif (!strcmp($op, 'default')) {
        
        // try to make private
        $success = $oWishlist->makeDefault();
        if ( $success===true ) {
			zen_redirect(zen_href_link(FILENAME_WISHLISTS, zen_get_all_get_params(array('op', 'wid')), 'SSL'));
		}		
    }
}
// Get records
$records = $oWishlist->getWishlists();