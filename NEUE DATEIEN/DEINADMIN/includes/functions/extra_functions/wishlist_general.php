<?php
/**
 * Wishlist for Zen Cart German
 * Zen Cart German Specific
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: wishlist_general.php 2024-03-16 08:02:16Z webchills $
 */

// Write a pre-formatted array contents
//-----------------------------------------------------------------

function un_dump($var, $description=NULL) {
    echo "<pre>";
    if (null !== $description) {
		echo $description.":\n";
    }
    if ( is_string($var) || is_int($var) ) {
		var_dump($var);
		echo "\n";
    } else {
		print_r($var);
		echo "\n";
    }
    echo "</pre>";
}

/*
 * Return formatted full name given first and last
 *-----------------------------------------------------------------------*/

function un_get_fullname($firstname='', $lastname='', $default='') {

    if ( zen_not_null($firstname) && zen_not_null($lastname) ) {
		$name = $firstname . " " . $lastname;
    } elseif ( zen_not_null($firstname) ) {
		$name = $firstname;
    } elseif ( zen_not_null($lastname) ) {
		$name = $lastname;
    } else {
    	$name = $default;
    }

    return zen_output_string_protected($name);
}

/*
 * Return sql string of fields
 *-----------------------------------------------------------------------*/
function un_create_sql_field_string($aFields, $sAlias = 'pd.') {

	$sComma = ',';
	$sFields = $sAlias . implode($sComma.$sAlias, $aFields) . $sComma;
	
	return $sFields;
}


/*
 * Return option with sorting capabilities
 *-----------------------------------------------------------------------*/
function un_create_sort_option($sortby, $colnum, $heading) {
	
	if ($sortby) {
		if ( substr($sortby, 0, 1) == $colnum ) {
			$id_sel = $sortby;
			$text_sel = $heading;
			$id = $colnum . (substr($sortby, 1, 1) == 'a' ? 'd' : 'a');
			$text = $heading . (substr($sortby, 1, 1) == 'a' ? '-' : '+');
			$aOption = array(
				'id' => $id,
				'text' => $text,
			);
			$aSelected = array(
				'id' => $id_sel, 
				'text' => $text_sel,
			);
			return $aOption;
		} else {
			$aOption = array(
				'id' => $colnum . 'a',
				'text' => $heading,
			);
			return $aOption;
		}
/* 		$aOption = array( */
/* 			'id' => $colnum . ($sortby == $colnum . 'a' ? 'a' : 'a'), */
/* 			'text' => $heading, */
/* 		); */
	}
}


?>