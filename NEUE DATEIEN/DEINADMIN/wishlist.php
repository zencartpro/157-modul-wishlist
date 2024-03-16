<?php
/**
 * Wishlist for Zen Cart German
 * Zen Cart German Specific
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: wishlist.php 2024-03-16 08:02:16Z webchills $
 */

	// Includes
  require('includes/application_top.php');
  require(DIR_WS_CLASSES . 'currencies.php');
	require_once(DIR_WS_CLASSES . 'wishlist_class.php');
  
  // Instantiate
  $currencies = new currencies();
	$oWishlist = new un_wishlist();
  
  // Get wishlist
  $id = (isset($_GET['wid']) ? $_GET['wid'] : '');
  if ( zen_not_null($id) ) {
		$wishlist = $oWishlist->getWishlist($id);
  } else {
  	zen_redirect(FILENAME_WISHLISTS);
  	exit;
  }
  
  // Process action
  $products_id = (isset($_GET['products_id']) ? $_GET['products_id'] : '');
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  if ( zen_not_null($action) && zen_not_null($products_id) ) {
    switch ($action) {
      case 'delete':
      	$oWishlist->removeProduct($products_id);
    }
  }

	// Get products in wishlist
	$products_query = $oWishlist->getProductsQuery();
	$products = $db->Execute($products_query);
	if ( !$products ) {
		$messageStack->add('header', 'Error getting wishlist products.');
	}
	
?>
<!doctype html>
<html <?php echo HTML_PARAMS; ?>>
<head>
    <?php require DIR_WS_INCLUDES . 'admin_html_head.php'; ?>
</head>
<body>
      <!-- header //-->
      <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
      <!-- header_eof //-->
      <div class="container-fluid">
        <!-- body //-->

<h1><?php echo HEADING_TITLE . TEXT_DELIMITER . $wishlist->fields['name']; ?></h1>

<ul>
<li><?php echo ENTRY_CUSTOMER; ?><a href="<?php echo zen_href_link(FILENAME_CUSTOMERS, 'cID=' . $wishlist->fields['customers_id']); ?>"><?php echo un_get_fullname($wishlist->fields['customers_firstname'], $wishlist->fields['customers_lastname'], $wishlist->fields['customers_email_address']); ?></a></li>
<li><?php echo ENTRY_COMMENT . $wishlist->fields['comment']; ?></li>
<li><?php echo ENTRY_DEFAULT . $wishlist->fields['default_status']; ?></li>

</ul>

<!-- product listing -->
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr class="dataTableHeadingRow">

	<?php echo $oWishlist->getTableHeader(); ?>

	</tr>
              
<?php 
if ( $products->RecordCount() > 0 ) { 
	$rows = 0;
	while (!$products->EOF) {
		if ( $rows & 1 ) {
			$tdclass = 'even';
		} else {
			$tdclass = 'odd';
		}
?>

	<tr>
  
	<?php echo $oWishlist->getTableRow($tdclass, $products); ?>

	</tr>
		<?php $rows++; ?>
		<?php $products->MoveNext(); ?>
	<?php } // end while products ?>
	
<?php } else { ?>
	<tr><td colspan="99"><?php echo TEXT_NO_RECORDS; ?></td></tr>
	
<?php } ?>

</table>
<!-- end product listing -->
        
        
<!-- body_text_eof //-->
      </div>
      <!-- body_eof //-->
      <!-- footer //-->
  <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
      <!-- footer_eof //-->
    </body>
  </html>