<?php
// control multiple wishlist functionality
if(UN_DB_MODULE_WISHLISTS_ENABLED == 'true'){
	define('UN_MODULE_WISHLISTS_ENABLED', true);
} else {
	define('UN_MODULE_WISHLISTS_ENABLED', false);}
if(UN_DB_ALLOW_MULTIPLE_WISHLISTS == 'true'){
	define('UN_ALLOW_MULTIPLE_WISHLISTS', true);
} else {
	define('UN_ALLOW_MULTIPLE_WISHLISTS', false);}
if(UN_DB_DISPLAY_CATEGORY_FILTER == 'true'){
	define('UN_DISPLAY_CATEGORY_FILTER', true);
} else {
	define('UN_DISPLAY_CATEGORY_FILTER', false);}
if(UN_DB_ALLOW_MULTIPLE_PRODUCTS_CART_COMPACT == 'true'){
	define('UN_ALLOW_MULTIPLE_PRODUCTS_CART_COMPACT', true);
} else {
	define('UN_ALLOW_MULTIPLE_PRODUCTS_CART_COMPACT', false);}
		
// template header
define('UN_HEADER_TITLE_WISHLIST', 'Wunschliste');

// wishlist sidebox
define('UN_BOX_HEADING_WISHLIST', 'Wunschliste');
define('UN_BUTTON_IMAGE_WISHLIST_ADD', 'wishlist_add.gif');
define('UN_BUTTON_WISHLIST_ADD_ALT', 'auf meine Wunschliste');
define('UN_BOX_WISHLIST_ADD_TEXT', 'Hier clicken um den Artikel auf Ihre Wunschliste zu setzen');
define('UN_BOX_WISHLIST_LOGIN_TEXT', '<p><a href="' . zen_href_link(FILENAME_LOGIN, '', 'NONSSL') . '">Einloggen</a> um den Artikel auf Ihre Wunschliste setzen zu können.</p>');

// control form
define('UN_TEXT_SORT', 'Sortieren');
define('UN_TEXT_SHOW', 'Zeige');
define('UN_TEXT_VIEW', 'Zeige');
define('UN_TEXT_ALL_CATEGORIES', 'Alle Kategorien');

// more
define('UN_TEXT_ADD_WISHLIST', 'auf meine Wunschliste');
define('UN_TEXT_REMOVE_WISHLIST', 'von der Wunschliste entfernen');
define('UN_BUTTON_IMAGE_SAVE', 'Aktualisieren');
define('UN_BUTTON_SAVE_ALT', 'Aktualisieren');
define('UN_TEXT_NEW_WISHLIST', 'eine neue Wunschliste erstellen');
define('UN_TEXT_MANAGE_WISHLISTS', 'Meine Wunschlisten verwalten');
define('UN_TEXT_WISHLIST_MOVE', 'Artikel auf eine andere Wunschliste verschieben');
define('SUCCESS_ADDED_TO_WISHLIST_PRODUCT', 'Artikel erfolgreich auf die Wunschliste gesetzt ...');

define('UN_TEXT_PRIORITY', 'Prioriät');
define('UN_TEXT_DATE_ADDED', 'hinzugefügt am');
define('UN_TEXT_QUANTITY', 'Menge');
define('UN_TEXT_COMMENT', 'Kommentare');

define('UN_TEXT_PRIORITY_0', '0 - Uninteressant für mich');
define('UN_TEXT_PRIORITY_1', '1 - Denke darüber nach');
define('UN_TEXT_PRIORITY_2', '2 - hätte ich gerne');
define('UN_TEXT_PRIORITY_3', '3 - hätte ich sehr gerne');
define('UN_TEXT_PRIORITY_4', '4 - muss ich haben');

// product lists
define('UN_TEXT_NO_PRODUCTS', 'Derzeit keine Artikel auf dieser Liste');
define('UN_TEXT_COMPACT', 'Kompakt');
define('UN_TEXT_EXTENDED', 'Erweitert');

// general
define('UN_LABEL_DELIMITER', ': ');
define('UN_TEXT_REMOVE', 'Entfernen');
define('UN_EMAIL_SEPARATOR', "-------------------------------------------------------------------------------\n");
define('UN_TEXT_DATE_AVAILABLE', 'verfügbar am: %s');
define('UN_TEXT_FORM_FIELD_REQUIRED', '*');
define('TEXT_OPTION_DIVIDER', '&nbsp;-&nbsp;');

// tables
define('UN_TABLE_HEADING_PRODUCTS', 'Name');
define('UN_TABLE_HEADING_PRICE', 'Preis');
define('UN_TABLE_HEADING_BUY_NOW', 'Warenkorb');
define('UN_TABLE_HEADING_QUANTITY', 'Menge');
define('UN_TABLE_HEADING_WISHLIST', 'Wunschliste');
define('UN_TABLE_HEADING_SELECT', 'Auswählen');

//errors
define('UN_ERROR_GET_ID', 'Error getting default wishlist id.');
define('UN_ERROR_GET_CUSTDATA', 'Error getting customer data.');
define('UN_ERROR_GET_PERMISSION', 'You do not have permission.');
define('UN_ERROR_GET_WISHLIST', 'Error getting wishlist.');
define('UN_ERROR_GET_WISHLIST_ID', 'Error getting wishlist: id not set.');
define('UN_ERROR_FIND_WISHLIST', 'Error finding wishlists.');
define('UN_ERROR_IS_PRIVATE', 'Error determining if wishlist is private.');
define('UN_ERROR_MAKE_DEFAULT', 'Error setting default.');
define('UN_ERROR_MAKE_DEFAULT_ZERO', 'Error zeroing default.');
define('UN_ERROR_MAKE_PUBLIC', 'Error making wishlist public.');
define('UN_ERROR_MAKE_PRIVATE', 'Error making wishlist private.');
define('UN_ERROR_CREATE_DEFAULT', 'Error creating default wishlist.');
define('UN_ERROR_IN_WISHLIST', 'Error determining if product in wishlist.');
define('UN_ERROR_CREATE_WISHLIST', 'Error creating wishlist.');
define('UN_ERROR_ADD_WISHLIST', 'Error adding wishlist item.');
define('UN_ERROR_EDIT_WISHLIST', 'Error editing wishlist item.');
define('UN_ERROR_ADD_PRODUCT_WISHLIST', 'Error adding product to wishlist.');
define('UN_ERROR_DELETE_DEFAULT_WISHLIST', 'Error deleting default wishlist.');
define('UN_ERROR_DELETE_WISHLIST', 'Error deleting wishlist.');
define('UN_ERROR_DELETE_PRODUCT_WISHLIST', 'Error deleting product from wishlist.');