<?php
/**
 * Wishlist for Zen Cart German
 * Zen Cart German Specific
 * @copyright Copyright 2003-2024 Zen Cart Development Team
 * Zen Cart German Version - www.zen-cart-pro.at
 * @copyright Portions Copyright 2003 osCommerce
 * @license https://www.zen-cart-pro.at/license/3_0.txt GNU General Public License V3.0
 * @version $Id: un_productlist.php 2024-03-16 08:02:16Z webchills $
 */

class un_productlist {
    
    /** 
     * fields for product list
     *
     * @var array
     * @access private
     * @see setStructure()
     */
    public $_aFields = array();
    
    /** 
     * structure for product list
     *
     * @var array
     * @access private
     * @see setStructure()
     */
    public $_aStructure = array();
    
    /** 
     * sql
     *
     * @var string
     * @access public
     * @see $this->setSqlFrom
     */
    public $_sSqlFrom='';
    
    /** 
     * sql
     *
     * @var string
     * @access public
     * @see $this->setSqlWhere
     */
    public $_sSqlWhere='';
    
    /** 
     * zencart db object
     *
     * @var object
     * @access private
     */
    public $_oDB;
    
    /** 
     * zencart message object
     *
     * @var object
     * @access private
     */
    public $_oMessages;
    
    /** 
     * default page for errors
     *
     * @var string
     * @access public
     * @see $this->_oMessages->add()
     */
    public $_sName='header';
    
    
    // CONSTRUCTOR ::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    
    /** 
     * class constructor
     *
     * @access public
	/*----------------------------------------------------------*/
	public function __construct() {
    	global $db, $messageStack;
        
        // implement db object
        $this->_oDB =& $db;
        $this->_oMessages =& $messageStack;
        
	}
    
    
    // PUBLIC METHODS :::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    
    /** 
     * get structure
     *
     * @return array
     * @access public
	/*----------------------------------------------------------*/
	public function getStructure() {
	
		$structure = $this->_aStructure;	
		foreach ($structure as $val) {
			$sortarray[] = $val['column_order'];
		}
		array_multisort($sortarray,$structure);
		
		return $structure;
    }

    /**
     * set stuff
     *
     * @param $structure
     * @return boolean
     * @access public
     * /*----------------------------------------------------------
     */
	
	public function setStructure($structure) {
		
		foreach ($structure as $val) {
			$sortarray[] = $val['column_order'];
		}
		array_multisort($sortarray,$structure);
		$this->_aStructure = $structure;
		
		return true;
    }
	
	public function setFields($fields) {
		
		$this->_aFields = $fields;
		
		return true;
    }
    
	public function setSqlFrom($string) {
		
		$this->_sSqlFrom = $string;
		
		return true;
    }
    
	public function setSqlWhere($string) {
		
		$this->_sSqlWhere = $string;
		
		return true;
    }
	
	
	/*
	 * Sort options
	 *-----------------------------------------------------------------------*/
	 
	public function getSortOptions($current_option) {
	
		$define_list = $this->getStructure();
		
		$options = array();
		foreach ( $define_list as $value ) {
			if ( $value['sortable'] == true ) {
		/* 		$lc_text = zen_create_sort_heading($current_option, $col+1, $lc_text); */
				$lc_option = un_create_sort_option($current_option, $value['column_order'], $value['label']);
				array_push($options, $lc_option);
				
				if ( substr($current_option, 0, 1) == $value['column_order'] ) {
					$lc_option = array(
						'id' => $current_option,
						'text' => $value['label'],
					);
					array_push($options, $lc_option);
				}
			}
		}
		return $options;
	}
	
	
	/*
	 * Generic Main function
	 *-----------------------------------------------------------------------*/
	 
	public function getProductsQuery() {
	
		$define_list = $this->getStructure();
		$extra_fields = $this->_aFields;
		$sql_from = $this->_sSqlFrom;
		$sql_where = $this->_sSqlWhere;
		
		// Manipulate define_list array to get column order, fields, default
		foreach ($define_list as $val) {
			$sortarray[] = $val['column_order'];
			if ( isset($val['field']) && zen_not_null($val['field']) && !in_array($val['field'], $extra_fields) ) {
				array_push($extra_fields, $val['field']);
			}
			if ( $val['default'] == true ) {
				$default = $val;
			}
		}
		array_multisort($sortarray,$define_list);
		
		$field_string = un_create_sql_field_string($extra_fields, '');
		$sql_select = 'select ' . substr($field_string, 0, strlen($field_string)-1) . ' ';
		$sql_filter = '';
		$sql_order = '';
		if ( isset($_GET['cPath']) && $_GET['cPath'] ) {
			$sql_filter .= "and p2c.categories_id = '" . $_GET['cPath'] . "' ";
			$sql_from .= ', ' . TABLE_PRODUCTS_TO_CATEGORIES . ' p2c ';
			$sql_where .= ' and p.products_id = p2c.products_id ';
		}
	
		// Define order based on posted html form
		if ( !isset($_GET['sort']) || (substr($_GET['sort'], 0, 1) > sizeof($define_list)) ) {
			$_GET['sort'] = $default['column_order'] . 'a';
			$sql_order .= ' order by ' . $default['field'];
		} else {
			$sort_col = substr($_GET['sort'], 0 , 1);
			$sort_order = substr($_GET['sort'], 1);
			foreach ($define_list as $key => $val) {
				if ( $val['column_order'] == $sort_col ) {
					break;
				}
			}
			$sql_order .= ' order by ' . $define_list[$key]['field'] . ' ' . ($sort_order === 'd' ? 'desc' : '') . ', ' . $default['field'];
		}

		$listing_sql = $sql_select . $sql_from . $sql_where . $sql_filter . $sql_order;
		
		return $listing_sql;
	}
	
	public function getTableHeader() {
	
		$result = '';
		for ($col=0;$col<sizeof($this->_aStructure);$col++) {

			
				$params = ' class="wishlist"';
		
			$result .= '<th' . $params . '>';
			$result .= $this->_aStructure[$col]['label'];
			$result .= '</th>';

		} // end for each column
	
		return $result;
	}
	
	public function getTableRow($tdclass, $products) {
		
		$dispatch = $this->getDispatch();
		
		$result = '';
		for ($col=0;$col<sizeof($this->_aStructure);$col++) {

			$params = ' class="wishlist"';
			$result .= '<td' . $params . '>';
			$cmd = $this->_aStructure[$col]['command'];
			if ( array_key_exists($cmd,$dispatch) ) {
				$function = $dispatch[$cmd];
				$return = $this->$function($this->_aStructure[$col], $products);
				if ( $return ) {
					$result .= $return;
				}
			} else {
				$result .= 'command not found';
			}
			$result .= '</td>';

		} // end for each column
	
		return $result;
	}
    
    
    // PRIVATE METHODS :::::::::::::::::::::::::::::::::::::::::::::::::::::::::
    
    /** 
     * associative array of descriptions used in product list structure
     * and respective functions to which they're mapped
     *
     * @var array
     * @access private
     * @see getDispatch()
     */
    public $_aDispatchFunctions = array(
    	'field_value'				=>	'_dispatchFieldValue',
		'price'						=>	'_dispatchPrice',
		'comment_hidden'			=>	'_dispatchCommentHidden',
		'comment_field'				=>	'_dispatchCommentField',
		'quantity_hidden'			=>	'_dispatchQuantityHidden',
		'priority_menu_s'			=>	'_dispatchPriorityMenuSmall',
		'select_checkbox'			=>	'_dispatchSelectCheckbox',
		'deletewish_checkbox'		=>	'_dispatchDeleteWishCheckbox',
		'addcart_checkbox'			=>	'_dispatchAddCartCheckbox',
		'product'					=>	'_dispatchProduct',
		'addcart_field'				=>	'_dispatchAddCartField',
		'addcart_link'				=>	'_dispatchAddCartLink',
		'addcart_multi'				=>	'_dispatchAddCartMulti',
	);
    
    /** 
     * get dispatch function array
     *
     * @return array
     * @access public
	/*----------------------------------------------------------*/
	 
	public function getDispatch() {
		return $this->_aDispatchFunctions;
    }

    /**
     * dispatch functions
     * functions referenced in product list structure
     * returning html strings computed from given product data
     *
     * @param $map
     * @param $data
     * @return string
     * @access private
    /*----------------------------------------------------------
     */
	
	public function _dispatchFieldValue($map, $data) {
        return $data->fields[substr($map['field'], strpos($map['field'], '.')+1)];
	}
	
	public function _dispatchCommentHidden($map, $data) {
        return zen_draw_hidden_field('comment[]', $data->fields['comment']);
	}
	
	public function _dispatchCommentField($map, $data) {
		$value = zen_draw_input_field('comment[]', $data->fields['comment'], 'maxlength="255" class="l"');
		return $value;
	}
	
	public function _dispatchQuantityHidden($map, $data) {
        return zen_draw_hidden_field('wishlist_quantity[]', $data->fields['quantity']);
	}
	
	public function _dispatchSelectCheckbox($map, $data) {
        return zen_draw_checkbox_field('select[]', $data->fields['products_id']);
	}
	
	public function _dispatchAddCartCheckbox($map, $data) {
        return zen_draw_checkbox_field('add_to_cart[]', $data->fields['products_id']);
	}
	
	public function _dispatchDeleteWishCheckbox($map, $data) {
		$value = zen_draw_checkbox_field('wishlist_delete[]', $data->fields['products_id']);
		return $value;
	}
	
	public function _dispatchAddCartField($map, $data) {
		$value = zen_draw_input_field('cart_quantity[]', '', 'size="2" maxlength="3" class="monospace"');
	/* 	$value .= zen_draw_hidden_field('products_id[]', $data->fields['products_id']); */
		return $value;
	}
	
	public function _dispatchPriorityMenuSmall($map, $data) {
		$value = un_draw_priority_pull_down_menu_s('priority[]', '', $data->fields['priority'], 'class="s"');
		return $value;
	}
	
	public function _dispatchPrice($map, $data) {
        return zen_get_products_display_price($data->fields['products_id']);
	}
	
	public function _dispatchProduct($map, $data) {
		$product_id = $data->fields['products_id'];
		$value = '<a href="' . zen_href_link(zen_get_info_page($data->fields['products_id']), 'products_id=' . $data->fields['products_id']) . '">' . $data->fields['products_name'] . '</a>';
		return $value;
	}
	
	public function _dispatchAddCartLink($map, $data) {
		$value = '<a href="' . zen_href_link($_GET['main_page'], zen_get_all_get_params(array('action')) . 'action=buy_now&products_id=' . $data->fields['products_id']) . '" title="'.BUTTON_IN_CART_ALT.'">' . zen_image_button(BUTTON_IMAGE_IN_CART, BUTTON_IN_CART_ALT, '') . '</a>';
		return $value;
	}
	
	public function _dispatchAddCartMulti($map, $data) {
		$value = zen_draw_input_field('products_id['.$data->fields['products_id'].']', '0', 'size="2" maxlength="3" class="monospace"');
		return $value;
	}


} // end class

