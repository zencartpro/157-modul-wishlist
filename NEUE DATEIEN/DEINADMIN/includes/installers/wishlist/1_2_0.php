<?php
$db->Execute("UPDATE " . TABLE_CONFIGURATION . " SET configuration_value = '1.2.0' WHERE configuration_key = 'WISHLIST_MODUL_VERSION' LIMIT 1;");