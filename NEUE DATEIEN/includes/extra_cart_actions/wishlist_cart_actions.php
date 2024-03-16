<?php
/**
 * Wishlist for Zen Cart German
 * Zen Cart German Specific
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: wishlist_cart_actions.php 2024-03-16 09:34:16Z webchills $
 */
if (!defined('IS_ADMIN_FLAG')) {
  die('Illegal Access');
}

switch ($_GET['action']) {

		case 'add_product':
		global $messageStack;	
		 
		if (isset($_POST['wishlist']) && ($_POST['wishlist'] == 'yes') || ($_POST['wishlist_x']) ) {
			if ( $_SESSION['cart']->get_quantity($_GET['products_id']) == 1 ){
			$_SESSION['cart']->remove($_GET['products_id']);
			} else {
				$quantnow = $_SESSION['cart']->get_quantity($_GET['products_id']);	
				if (isset($_POST['id'])) {			
				$_SESSION['cart']->update_quantity($_GET['products_id'], $quantnow, $_POST['id']);
			}
			}
				if (!zen_is_logged_in()) {
    				$_SESSION['navigation']->set_snapshot();
    				zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
					}
				if ($_SESSION['customer_id'] && isset($_GET['products_id'])) {
					$attributes = '';
				if (isset($_POST['id']) && is_array($_POST['id'])) {
				(is_array($_POST['id']) ? $attributes = serialize( $_POST['id'] ) : $attributes = '');				
			}
				require_once(DIR_WS_CLASSES . 'un_wishlist.php');
				$oWishlist = new un_wishlist($_SESSION['customer_id']);
				$oWishlist->addProduct((int)$_GET['products_id'], $attributes);
			}
				if ( DISPLAY_WISHLIST == 'true' ) {
				zen_redirect(zen_href_link(FILENAME_WISHLIST));
      		} else {
	      		$messageStack->add_session('header', SUCCESS_ADDED_TO_WISHLIST_PRODUCT, 'success');
      			zen_redirect(zen_href_link(zen_get_info_page($_GET['products_id']), 'products_id=' . $_GET['products_id']));      			
			}	
		}		
		break;
		
		case 'wishlist_add_product':
		global $messageStack;
			if (!zen_is_logged_in()) {
    			$_SESSION['navigation']->set_snapshot();
    			zen_redirect(zen_href_link(FILENAME_LOGIN, '', 'SSL'));
			}
			if ($_SESSION['customer_id'] && isset($_GET['products_id'])) {
				
				require_once(DIR_WS_CLASSES . 'un_wishlist.php');
				$oWishlist = new un_wishlist($_SESSION['customer_id']);
				$oWishlist->addProduct($_GET['products_id']);
				
			}
			if ( DISPLAY_WISHLIST == 'true' ) {
				zen_redirect(zen_href_link(FILENAME_WISHLIST));
      		} else {
	      		$messageStack->add_session('header', SUCCESS_ADDED_TO_WISHLIST_PRODUCT, 'success');
      			zen_redirect(zen_href_link(zen_get_info_page($_GET['products_id']), 'products_id=' . $_GET['products_id']));
			}
			break;

		case 'un_remove_wishlist':
			if ($_SESSION['customer_id'] && isset($_GET['products_id'])) {

				// use wishlist class
				require_once(DIR_WS_CLASSES . 'un_wishlist.php');
				$oWishlist = new un_wishlist($_SESSION['customer_id']);
				$oWishlist->removeProduct($_GET['products_id']);
				
			}
			zen_redirect(zen_href_link(FILENAME_WISHLIST));
			break;
				
		case 'un_update_wishlist':
			$cart_updated = false;
			for ($i=0, $iMax = sizeof($_POST['products_id']); $i< $iMax; $i++) {
				$attributes ='';
				if (isset($_POST['id'])) {	
			(is_array($_POST['id']) ? $attributes = serialize( $_POST['id'] ) : $attributes = '');
			}
				require_once(DIR_WS_CLASSES . 'un_wishlist.php');
				$oWishlist = new un_wishlist($_SESSION['customer_id']);
				$oWishlist->updateProduct((int)$_POST['products_id'][$i], $attributes, (int)$_POST['wishlist_quantity'][$i], (int)$_POST['priority'][$i], $_POST['comment'][$i]);
				if (isset($_POST['add_to_cart'])) {	
				if ( in_array($_POST['products_id'][$i], (is_array($_POST['add_to_cart']) ? $_POST['add_to_cart'] : array())) && $_POST['wishlist_quantity'][$i] != 0 ) {
					$cart_updated = true;
					$_SESSION['cart']->add_cart($_POST['products_id'][$i], $_SESSION['cart']->get_quantity(zen_get_uprid($_POST['products_id'][$i], ''))+$_POST['wishlist_quantity'][$i], '');
				}
			}
			if (isset($_POST['wishlist_delete'])) {	
				if ( in_array($_POST['products_id'][$i], (is_array($_POST['wishlist_delete']) ? $_POST['wishlist_delete'] : array())) or $_POST['wishlist_quantity'][$i] == 0 ) {
					$oWishlist->removeProduct((int)$_POST['products_id'][$i]);
				}
			}
				
			}
			if ( $cart_updated == true ) {
				zen_redirect(zen_href_link($goto, zen_get_all_get_params($parameters)));
			} else {
				zen_redirect(zen_href_link(FILENAME_WISHLIST, zen_get_all_get_params($parameters)));
			}
			break;
}