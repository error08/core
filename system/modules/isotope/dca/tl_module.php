<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 *
 * The TYPOlight webCMS is an accessible web content management system that 
 * specializes in accessibility and generates W3C-compliant HTML code. It 
 * provides a wide range of functionality to develop professional websites 
 * including a built-in search engine, form generator, file and user manager, 
 * CSS engine, multi-language support and many more. For more information and 
 * additional TYPOlight applications like the TYPOlight MVC Framework please 
 * visit the project website http://www.typolight.org.
 *
 * This file modifies the data container array of table tl_module.
 *
 * PHP version 5
 * @copyright  Winans Creative / Fred Bliss 2009
 * @author     Fred Bliss
 * @package    Isotope 
 * @license    GPL 
 * @filesource
 * @filesource
 */
class ListingModule extends Backend
{
	public function getFilters()
	{
		
		
		$objFilters = $this->Database->prepare("SELECT id, name, (SELECT name FROM tl_product_attribute_sets WHERE tl_product_attribute_sets.id=tl_product_attributes.pid) AS attribute_set_name FROM tl_product_attributes WHERE is_filterable=?")
									 ->execute(1);
									 
		if($objFilters->numRows < 1)
		{
			return $GLOBALS['TL_LANG']['MSC']['noResult'];
		}
		
		$arrFilters = $objFilters->fetchAllAssoc();
		
		foreach($arrFilters as $filter)
		{
			
			$strCurrFilter = $filter['attribute_set_name'];
			
			$arrOptionGroups[$strCurrFilter][$filter['id']] = $filter['name'];
		
		}
		
		return $arrOptionGroups;
	
	}
	
	public function getStoreConfigurations()
	{
		
		
		$objStoreConfigurations = $this->Database->prepare("SELECT id, store_configuration_name FROM tl_store")->execute();
									 
		if($objStoreConfigurations->numRows < 1)
		{
			return $GLOBALS['TL_LANG']['MSC']['noResult'];
		}
		
		$arrStoreConfigurations = $objStoreConfigurations->fetchAllAssoc();
		
		foreach($arrStoreConfigurations as $store)
		{
			
			$arrOptions[$store['id']] = $store['store_configuration_name'];
		
		}
		
		return $arrOptions;
	
	}
	
	public function refineFilterData($varValue, DataContainer $dc)
	{
		$arrValues = deserialize($varValue);
		
		//Get attribute basic data
		foreach($arrValues as $value)
		{
			$objAttributeData = $this->Database->prepare("SELECT field_name, (SELECT storeTable FROM tl_product_attribute_sets WHERE tl_product_attribute_sets.id=tl_product_attributes.pid) AS store_table FROM tl_product_attributes WHERE id=?")
										   		->limit(1)
										   		->execute($value);
		
			if($objAttributeData->numRows < 1)
			{
				return '';	
			}
		
			$objAttributeData->first();
		
			$strAttributeFieldName = $objAttributeData->field_name;
			$strStoreTable = $objAttributeData->store_table;
					
			$arrFilterValues = $this->getFilterValues($value);
						
			$objOptionValuesInUse = $this->Database->prepare("SELECT DISTINCT " . $strAttributeFieldName . " FROM " . $strStoreTable)
									 		   ->execute();
								
			if($objOptionValuesInUse->numRows < 1)
			{
				return '';
			} 
		
			$arrOptionValuesInUse = $objOptionValuesInUse->fetchEach($strAttributeFieldName);

			$i = 0;

			$intCurrSorting = 128;
			
						
			foreach($arrFilterValues as $listValue)
			{
				
				if(!in_array($listValue['value'], $arrOptionValuesInUse))
				{
					unset($arrFilterValues[$i]);
				}else{		
					$arrPages = $this->getAssociatedPagesByListValue($listValue, $strStoreTable, $strAttributeFieldName);
						
					$arrSet[] = array
					(
						'id'			=> "''",
						'pid'			=> $value,
						'sorting' 		=> $intCurrSorting,
						'tstamp'		=> time(),
						'value'			=> "'" . mysql_escape_string($listValue['value']) . "'",
						'label'			=> "'" . mysql_escape_string($listValue['label']) . "'",
						'pages'			=> "'" . serialize($arrPages) . "'"		
					);
				}
				
				$i++;
				$intCurrSorting+=128;
			
			}
			
					
			//Reset the current attribute's list cache, if any
			$this->Database->prepare("DELETE FROM tl_list_cache WHERE pid=?")->execute($value);
		
			//Break apart the standard SET array into multiple row insert sql statement	
			foreach($arrSet as $currSet)
			{
				$arrInsertRows[] = implode(",", $currSet);
			}
			
			$strInsertRows = join("),(", $arrInsertRows);
			
			$strInsertRows = "(" . $strInsertRows . ")";
			
			//Add the list values to the list cache.
			//echo $strInsertRows;
			
			$this->Database->prepare("INSERT INTO tl_list_cache (id, pid, sorting, tstamp, value, label, pages) VALUES " . $strInsertRows)->execute();
			
		}

		return $varValue;
	}
	
	private function getAssociatedPagesByListValue($intListValue, $strStoreTable, $strAttributeFieldName)
	{
		$objPages = $this->Database->prepare("SELECT pages FROM " . $strStoreTable . " WHERE " . $strAttributeFieldName . "=?")
								   ->execute($intListValue);
								   
		if($objPages->numRows < 1)
		{
			return array();
		}
	
		$arrRawSerializedPages = $objPages->fetchEach('pages');
				
		$arrRawPagesCurr = array();
		$arrRawPages = array();
				
		foreach($arrRawSerializedPages as $pageCollection)
		{
			$arrRawPagesCurr = deserialize($pageCollection);
			
			foreach($arrRawPagesCurr as $pageVal)
			{
				$arrRawPages[] = $pageVal;
			}
			
			$arrRawPagesCurr = array();
			
		}
		
				
		$arrPages = array_unique($arrRawPages);
			
		return $arrPages;
	}
	
	private function getFilterValues($intAttributeID)
	{
		$objAttributeData = $this->Database->prepare("SELECT name, option_list, use_alternate_source, list_source_table, list_source_field, field_name FROM tl_product_attributes WHERE id=? AND is_filterable='1' AND (type='select' OR type='checkbox')")
									  ->limit(1)
									  ->execute($intAttributeID);
		
		if($objAttributeData->numRows < 1)
		{
			return '';
		}
		
		if($objAttributeData->use_alternate_source==1)
		{
			$objLinkData = $this->Database->prepare("SELECT id, " . $objAttributeData->list_source_field . " FROM " . $objAttributeData->list_source_table)
										  ->execute();
						
			if($objLinkData->numRows < 1)
			{
				return array();
			}
			
			$arrLinkValues = $objLinkData->fetchAllAssoc();
			
			$filter_name = $objAttributeData->list_source_field;
						
			foreach($arrLinkValues as $value)
			{
				$arrValues[] = array
				(
					'value'		=> $value[$objAttributeData->id],
					'label'		=> $value[$objAttributeData->list_source_field]
				);
			
			}
			
		}else{
		
			
			$arrLinkValues = deserialize($objAttributeData->option_list);
			
			$filter_name = $objAttributeData->field_name;
			
			foreach($arrLinkValues as $value)
			{
				$arrValues[] = array
				(
					'value'		=> $value['value'],
					'label'		=> $value['label']
				);
			
			}
		}
		
		return $arrValues;

	}
	
	
	/**
	 * Return all editable fields of table tl_member
	 * @return array
	 */
	public function getEditableCheckoutProperties()
	{
		$return = array();

		$this->loadDataContainer('tl_address_book');
		$this->loadLanguageFile('tl_address_book');

		foreach ($GLOBALS['TL_DCA']['tl_address_book']['fields'] as $k=>$v)
		{
			if ($v['eval']['isoEditable'])
			{
				$return[$k] = $GLOBALS['TL_DCA']['tl_address_book']['fields'][$k]['label'][0];
			}
		}
		

		return $return;
	}
	
	/**
	 *
	 *
	 */
	public function getPaymentModules()
	{
		$return = array();
		
		//return '<i>' .  $GLOBALS['TL_LANG']['MSC']['noPaymentModules'] . '</i>';
		
		//$objPaymentModules = $this->Database->prepare("SELECT * FROM tl_payment_modules WHERE enabled=?")
		//									->execute(1);
		
		$objPaymentModules = $this->Database->prepare("SELECT * FROM tl_module WHERE type=?")
											->execute('authorize');
		
		
		if($objPaymentModules->numRows < 1)
		{
			return '<i>' .  $GLOBALS['TL_LANG']['MSC']['noPaymentModules'] . '</i>';
		}	
		
		$arrPaymentModules = $objPaymentModules->fetchAllAssoc();
		
		foreach($arrPaymentModules as $module)
		{
			$return[$module['id']] = $module['name'];
		}
		
		return $return;
	}
	
	/**
	 *
	 *
	 */
	public function getShippingModules()
	{
		$return = array();
		
		
		$objShippingModules = $this->Database->prepare("SELECT * FROM tl_shipping_modules WHERE enabled=?")
											->execute('1');
		
		if($objShippingModules->numRows < 1)
		{
			return '<i>' .  $GLOBALS['TL_LANG']['MSC']['noShippingModules'] . '</i>';
		}	
		
		$arrShippingModules = $objShippingModules->fetchAllAssoc();
				
		foreach($arrShippingModules as $module)
		{
			
			$return[$module['id']] = $module['name'];
		}	
	
		return $return;
	}

}

$GLOBALS['TL_DCA']['tl_module']['palettes']['isoProductLister'] = 'name,type,headline;columns;store_id;new_products_time_window;listing_filters;iso_list_layout;guests,protected;align,space,cssID';

$GLOBALS['TL_DCA']['tl_module']['palettes']['isoProductReader']  = 'name,type,headline;store_id;iso_reader_layout;guests,protected;align,space,cssID';

$GLOBALS['TL_DCA']['tl_module']['palettes']['isoShoppingCart'] = 'name,type,headline;store_id,iso_cart_layout;guests,protected;align,space,cssID';

$GLOBALS['TL_DCA']['tl_module']['palettes']['isoAddressBook'] = 'name,type,headline;store_id,addressBookTemplate;isoEditable;align,space,cssID';

$GLOBALS['TL_DCA']['tl_module']['palettes']['isoGiftRegistryManager'] = 'name,type,headline;store_id,iso_registry_layout;guests,protected;align,space,cssID';

$GLOBALS['TL_DCA']['tl_module']['palettes']['isoGiftRegistrySearch'] = 'name,type,headline;jumpTo;guests,protected;align,space,cssID';

$GLOBALS['TL_DCA']['tl_module']['palettes']['isoGiftRegistryResults'] = 'name,type,headline;jumpTo;iso_registry_results;perPage;guests,protected;align,space,cssID';

$GLOBALS['TL_DCA']['tl_module']['palettes']['isoGiftRegistryReader'] = 'name,type,headline;store_id,iso_registry_reader;guests,protected;align,space,cssID';

$GLOBALS['TL_DCA']['tl_module']['palettes']['isoCheckout'] = 'name,type,headline;store_id,orderCompleteJumpTo;iso_payment_modules;iso_shipping_modules;iso_checkout_layout;guests,protected;align,space,cssID';

$GLOBALS['TL_DCA']['tl_module']['fields']['iso_list_layout'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['iso_list_layout'],
	'default'                 => 'iso_list_productlist',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => $this->getTemplateGroup('iso_list_')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['iso_reader_layout'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['iso_reader_layout'],
	'default'                 => 'iso_reader_product_single',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => $this->getTemplateGroup('iso_reader_')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['iso_cart_layout'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['iso_cart_layout'],
	'default'                 => 'iso_reader_product_single',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => $this->getTemplateGroup('iso_cart_')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['iso_registry_layout'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['iso_registry_layout'],
	'default'                 => 'iso_registry_manage',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => $this->getTemplateGroup('iso_registry_manage')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['iso_registry_reader'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['iso_registry_reader'],
	'default'                 => 'iso_registry_full',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => $this->getTemplateGroup('iso_registry_full')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['iso_registry_results'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['iso_registry_results_lister'],
	'default'                 => 'iso_registry_searchlister',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => $this->getTemplateGroup('iso_registry_search')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['iso_checkout_layout'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['iso_checkout_layout'],
	'default'                 => 'iso_reader_product_single',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => $this->getTemplateGroup('iso_mod_checkout_')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['addressBookTemplate'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['addressBookTemplate'],
	'default'                 => 'iso_address_book_list',
	'exclude'                 => true,
	'inputType'               => 'select',
	'options'                 => $this->getTemplateGroup('iso_address_book_')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['new_products_time_window'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['new_products_time_window'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'mandatory'=>false, 'maxlength'=>255)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['columns'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['columns'],
	'default'				  => 3,
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('rgxp'=>'digit', 'mandatory'=>false, 'maxlength'=>255)
);

$GLOBALS['TL_DCA']['tl_module']['fields']['listing_filters'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['listing_filters'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'					  => array('multiple'=>true),
	'options_callback'		  => array('ListingModule','getFilters')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['store_id'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['store_id'],
	'exclude'                 => true,
	'inputType'               => 'select',
	'eval'					  => array('includeBlankOption'=>true,'mandatory'=>true),
	'options_callback'		  => array('ListingModule','getStoreConfigurations')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['iso_payment_modules'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['iso_payment_modules'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'					  => array('multiple'=>true),
	'options_callback'		  => array('ListingModule','getPaymentModules')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['iso_shipping_modules'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['iso_shipping_modules'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'					  => array('multiple'=>true),
	'options_callback'		  => array('ListingModule','getShippingModules')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['orderCompleteJumpTo'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_module']['orderCompleteJumpTo'],
	'exclude'                 => true,
	'inputType'               => 'pageTree',
	'explanation'             => 'jumpTo',
	'eval'                    => array('fieldType'=>'radio', 'helpwizard'=>true)
);
?>