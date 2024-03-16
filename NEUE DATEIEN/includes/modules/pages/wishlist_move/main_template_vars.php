<?php 
/**
 * Wishlist for Zen Cart German
 * Zen Cart German Specific
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: main_template_vars.php 2024-03-16 08:02:16Z webchills $
 */

$structure = array(
	array(
		'label'			=>	UN_TABLE_HEADING_SELECT,
		'field'			=>	'',
		'column_order'	=>	1,
		'default'		=>	false,
		'sortable'		=>	false,
		'align'			=>	'center',
		'command'		=>	'select_checkbox',
	),
	array(
		'label'			=>	UN_TABLE_HEADING_PRODUCTS,
		'field'			=>	'pd.products_name',
		'column_order'	=>	2,
		'default'		=>	true,
		'sortable'		=>	true,
		'command'		=>	'product',
	),
	array(
		'label'			=>	UN_TEXT_PRIORITY,
		'field'			=>	'p2w.priority',
		'column_order'	=>	3,
		'default'		=>	false,
		'sortable'		=>	true,
		'align'			=>	'center',
		'command'		=>	'field_value',
	),
	array(
		'label'			=>	UN_TEXT_COMMENT,
		'field'			=>	'p2w.comment',
		'column_order'	=>	4,
		'default'		=>	false,
		'sortable'		=>	false,
		'command'		=>	'field_value',
	),
);

// Sort columns as defined
$oWishlist->setStructure($structure);
$products_query = $oWishlist->getProductsQuery();
$aSortOptions = $oWishlist->getSortOptions(isset($_GET['sort'])? $_GET['sort']: '');

$listing_split = new splitPageResults($products_query, UN_MAX_DISPLAY_EXTENDED);
$tpl_page_body = 'tpl_wishlist_move_default.php';

require($template->get_template_dir($tpl_page_body, DIR_WS_TEMPLATE, $current_page_base, 'templates') . '/' . $tpl_page_body);

?>