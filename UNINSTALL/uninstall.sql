##########################################################################
# Wishlist UNINSTALLER - 2024-03-16 - webchills
# NUR AUSFÜHREN WENN SIE DAS MODUL AUS DER DATENBANK ENTFERNEN WOLLEN!!!!!
##########################################################################

DELETE FROM configuration_group WHERE configuration_group_title = 'Wishlist';
DELETE FROM configuration WHERE configuration_key = 'UN_DB_MODULE_WISHLISTS_ENABLED';
DELETE FROM configuration WHERE configuration_key = 'UN_DB_ALLOW_MULTIPLE_WISHLISTS';
DELETE FROM configuration WHERE configuration_key = 'UN_DB_DISPLAY_CATEGORY_FILTER';
DELETE FROM configuration WHERE configuration_key = 'DEFAULT_WISHLIST_NAME';
DELETE FROM configuration WHERE configuration_key = 'DISPLAY_WISHLIST';
DELETE FROM configuration WHERE configuration_key = 'UN_MAX_DISPLAY_EXTENDED';
DELETE FROM configuration WHERE configuration_key = 'UN_MAX_DISPLAY_COMPACT';
DELETE FROM configuration WHERE configuration_key = 'UN_DEFAULT_LIST_VIEW';
DELETE FROM configuration WHERE configuration_key = 'UN_DB_ALLOW_MULTIPLE_PRODUCTS_CART_COMPACT';
DELETE FROM configuration_language WHERE configuration_key = 'UN_DB_MODULE_WISHLISTS_ENABLED';
DELETE FROM configuration_language WHERE configuration_key = 'UN_DB_ALLOW_MULTIPLE_WISHLISTS';
DELETE FROM configuration_language WHERE configuration_key = 'UN_DB_DISPLAY_CATEGORY_FILTER';
DELETE FROM configuration_language WHERE configuration_key = 'DEFAULT_WISHLIST_NAME';
DELETE FROM configuration_language WHERE configuration_key = 'DISPLAY_WISHLIST';
DELETE FROM configuration_language WHERE configuration_key = 'UN_MAX_DISPLAY_EXTENDED';
DELETE FROM configuration_language WHERE configuration_key = 'UN_MAX_DISPLAY_COMPACT';
DELETE FROM configuration_language WHERE configuration_key = 'UN_DEFAULT_LIST_VIEW';
DELETE FROM configuration_language WHERE configuration_key = 'UN_DB_ALLOW_MULTIPLE_PRODUCTS_CART_COMPACT';


# Wenn Sie das gesamte Modul löschen möchten, können Sie die auch die Tabellen löschen, die die Wunschlisten der Kunden enthalten
# Das sollte normalerweise nicht nötig sein, Sie verlieren damit unwiederbringabar bereits angelegte Wunschlisten!
# Aber wenn Sie das möchten, entfernen Sie die # von den beiden folgenden Zeilen:
#DROP TABLE IF EXISTS `un_wishlists`;
#DROP TABLE IF EXISTS `un_products_to_wishlists`;