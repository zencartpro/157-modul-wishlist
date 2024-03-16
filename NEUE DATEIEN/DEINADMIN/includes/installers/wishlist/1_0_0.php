<?php
/**
 * Wishlist for Zen Cart German
 * Zen Cart German Specific
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: 1.0.0.php 2024-03-16 08:02:16Z webchills $
 */
 
$db->Execute(" SELECT @gid:=configuration_group_id
FROM ".TABLE_CONFIGURATION_GROUP."
WHERE configuration_group_title= 'Wishlist'
LIMIT 1;");

$db->Execute("INSERT IGNORE INTO ".TABLE_CONFIGURATION." (configuration_title, configuration_key, configuration_value, configuration_description, configuration_group_id, sort_order, date_added, last_modified, use_function, set_function) VALUES
('Wishlist Module Switch', 'UN_DB_MODULE_WISHLISTS_ENABLED', 'true', 'Set this option true or false to enable or disable the wishlist', @gid, 1, now(), now(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),'),
('Wishlist allow multiple lists', 'UN_DB_ALLOW_MULTIPLE_WISHLISTS', 'true', 'Set this option true or false to allow for more than 1 wishlist', @gid, 3, now(), now(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),'),
('Wishlist display category filter', 'UN_DB_DISPLAY_CATEGORY_FILTER', 'false', 'Set this option true or false to enable a category filter', @gid, 4, now(), now(), NULL,'zen_cfg_select_option(array(''true'', ''false''),'),
('Wishlist default name', 'DEFAULT_WISHLIST_NAME', 'Allgemein', 'Enter the name you want to be assigned to the initial wishlist.', @gid, 5, now(), now(), NULL, NULL),
('Wishlist show list after product addition', 'DISPLAY_WISHLIST', 'true', 'Set this option true or false to show the wishlist after a product was added to the wishlist', @gid, 6, now(), now(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),'),
('Wishlist display max items in extended view', 'UN_MAX_DISPLAY_EXTENDED', '10', 'Enter the maximum amount of products you want to show in extended view.<br />default = 10', @gid, 7, now(), now(), NULL, NULL),
('Wishlist display max items in compact view', 'UN_MAX_DISPLAY_COMPACT', '20', 'Enter the maximum amount of products you want to show in extended view.<br />default = 20', @gid, 8, now(), now(), NULL, NULL),
('Wishlist default view Switch', 'UN_DEFAULT_LIST_VIEW', 'compact', 'Set the default view of the list to compact or extended view', @gid, 9, now(), now(), NULL, 'zen_cfg_select_option(array(''compact'', ''extended''),'),
('Wishlist allow multiple products to cart', 'UN_DB_ALLOW_MULTIPLE_PRODUCTS_CART_COMPACT', 'false', 'Set this option true or false to allow multiple products to be moved in the cart via checkboxes in compact view', @gid, 10, now(), now(), NULL, 'zen_cfg_select_option(array(''true'', ''false''),')");

$db->Execute("REPLACE INTO ".TABLE_CONFIGURATION_LANGUAGE." (configuration_title, configuration_key, configuration_description, configuration_language_id) VALUES
('Wunschliste - Aktivieren?', 'UN_DB_MODULE_WISHLISTS_ENABLED', '<br />Wollen Sie die Wunschliste aktivieren?<br />', 43),
('Wunschliste - Mehrere Wunschlisten zulassen?', 'UN_DB_ALLOW_MULTIPLE_WISHLISTS', '<br />Soll der Kunde mehrere Wunschlisten zur Verfügung haben?<br />', 43),
('Wunschliste - Kategoriefilter anzeigen?', 'UN_DB_DISPLAY_CATEGORY_FILTER', '<br />Soll die Wunschliste einen Kategoriefilter anbieten?<br />', 43),
('Wunschliste - Default Name?', 'DEFAULT_WISHLIST_NAME', '<br />Geben Sie hier den Namen ein, den eine Wunschliste standardmäßig bekommen soll.<br />', 43),
('Wunschliste - Nach Hinzufügen eines Artikels Wunschliste anzeigen?', 'DISPLAY_WISHLIST', '<br />Wenn ein Artikel auf die Wunschliste gesetzt wurde, soll dann die Wunschliste angezeigt werden?<br />', 43),
('Wunschliste - maximale Artikel in erweiterter Ansicht', 'UN_MAX_DISPLAY_EXTENDED', '<br />Wieviele Artikel sollen maximal in der erweiterten Ansicht der Wunschliste angezeigt werden?<br />', 43),
('Wunschliste - maximale Artikel in kompakter Ansicht', 'UN_MAX_DISPLAY_COMPACT', '<br />Wieviele Artikel sollen maximal in der kompakten Ansicht der Wunschliste angezeigt werden?<br />', 43),
('Wunschliste - Default Ansicht', 'UN_DEFAULT_LIST_VIEW', '<br />Welche Ansicht soll standardmäßig aktiv sein? Erweitert (extended) oder Kompakt (compact)?<br />', 43),
('Wunschliste - Mehrere Artikel in den Warenkorb legen erlaubt?', 'UN_DB_ALLOW_MULTIPLE_PRODUCTS_CART_COMPACT','<br />Sollen in der kompakten Ansicht mehrere Artikel auf einmal von der Wunschliste in den Warenkorb verschoben werden können?<br />', 43)");

// create new tables

$db->Execute("CREATE TABLE IF NOT EXISTS " . UN_TABLE_WISHLISTS . " (
`id` int(11) NOT NULL AUTO_INCREMENT,
`customers_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `comment` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `default_status` int(1) NOT NULL,  
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;");

$db->Execute("CREATE TABLE IF NOT EXISTS " . UN_TABLE_PRODUCTS_TO_WISHLISTS . " (
 `products_id` int(11) NOT NULL,
  `un_wishlists_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `quantity` int(2) NOT NULL,
  `priority` int(1) NOT NULL,
  `comment` varchar(255) CHARACTER SET utf8 NOT NULL,
  `attributes` varchar(255) CHARACTER SET utf8 NOT NULL,
	 PRIMARY KEY  (`products_id`,`un_wishlists_id`)
) ENGINE=MyISAM;");


// delete old configuration/ menu
$admin_page = 'configZCAWishListModule';
$db->Execute("DELETE FROM " . TABLE_ADMIN_PAGES . " WHERE page_key = '" . $admin_page . "' LIMIT 1;");
// add configuration menu
if (!zen_page_key_exists($admin_page)) {
$db->Execute(" SELECT @gid:=configuration_group_id
FROM ".TABLE_CONFIGURATION_GROUP."
WHERE configuration_group_title= 'Wishlist'
LIMIT 1;");
$db->Execute("INSERT IGNORE INTO " . TABLE_ADMIN_PAGES . " (page_key,language_key,main_page,page_params,menu_key,display_on_menu,sort_order) VALUES 
('configZCAWishListModule','BOX_CONFIGURATION_ZCA_WISHLIST','FILENAME_CONFIGURATION',CONCAT('gID=',@gid),'configuration','Y',@gid)");
$db->Execute("INSERT IGNORE INTO " . TABLE_ADMIN_PAGES . " (page_key,language_key,main_page,page_params,menu_key,display_on_menu,sort_order) VALUES 
('extrasWishlists','BOX_EXTRAS_WISHLISTS','FILENAME_WISHLISTS','','extras','Y',901)");
$messageStack->add('Wunschliste Modul erfolgreich installiert.', 'success');  
}