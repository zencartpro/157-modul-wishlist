<?php
/**
 * Wishlist for Zen Cart German
 * Zen Cart German Specific
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: wishlists.php 2024-03-16 08:02:16Z webchills $
 */

	// Includes
  require('includes/application_top.php');
	require_once(DIR_WS_CLASSES . 'wishlist_class.php');
  
  // Instantiate
	$oWishlist = new un_wishlist();
  
  // Process action
  $action = (isset($_GET['action']) ? $_GET['action'] : '');
  if (zen_not_null($action)) {
    switch ($action) {
      case 'delete':
      	$oWishlist->deleteWishlist($_GET['wid']);
        break;
    }
  }
  
  // Get records
	$records = $oWishlist->getWishlists();
	
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

<h1><?php echo HEADING_TITLE; ?></h1>

<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr class="dataTableHeadingRow">
		<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CUSTOMER; ?></td>
		<td class="dataTableHeadingContent"><?php echo TABLE_HEADING_WISHLIST; ?></td>
		<td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_COUNT; ?></td>
		<td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
	</tr>
              
<?php if ( $records->RecordCount() > 0 ) { ?>

<?php while (!$records->EOF) { ?>
	<tr>
		<td class="dataTableContent"><?php echo un_get_fullname($records->fields['customers_firstname'], $records->fields['customers_lastname'], $records->fields['customers_email_address']); ?></td>
		<td class="dataTableContent"><a href="<?php echo zen_href_link(FILENAME_WISHLIST, 'wid=' . $records->fields['id']);?>"><?php echo $records->fields['name']; ?></a></td>
		<td class="dataTableContent" align="right"><?php echo $records->fields['items_count']; ?></td>
		<td class="dataTableContent" align="right">
			<a href="<?php echo zen_href_link(FILENAME_WISHLISTS, 'wid=' . $records->fields['id'] . '&action=delete'); ?>" onclick="javascript:return confirm('Wollen Sie diesen Eintrag wirklich löschen?')"><?php echo zen_image(DIR_WS_IMAGES . 'icon_delete.gif', ICON_DELETE); ?></a>
		</td>
	</tr>
	<?php $records->MoveNext(); ?>
<?php } ?>

<?php } else { ?>
	<tr>
		<td class="dataTableContent" colspan="99"><?php echo TEXT_NO_RECORDS; ?></td>
	</tr>
<?php } ?>


</table>
        
        
<!-- body_text_eof //-->
      </div>
      <!-- body_eof //-->
      <!-- footer //-->
  <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
      <!-- footer_eof //-->
    </body>
  </html>