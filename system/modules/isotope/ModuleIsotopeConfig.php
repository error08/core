<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * TYPOlight webCMS
 * Copyright (C) 2005 Leo Feyer
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 2.1 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at http://www.gnu.org/licenses/.
 *
 * PHP version 5
 * @copyright  Winans Creative 2009
 * @author     Andreas Schempp <andreas@schempp.ch>
 * @license    http://opensource.org/licenses/lgpl-3.0.html
 */


class ModuleIsotopeConfig extends BackendModule
{

	protected $strTemplate = 'be_iso_config';
	
	
	protected function compile()
	{
		$this->import('BackendUser', 'User');
		
		// Modules
		$arrGroups = array();

		foreach ($GLOBALS['ISO_MOD'] as $strGroup=>$arrModules)
		{
			foreach (array_keys($arrModules) as $strModule)
			{
				if ($this->User->hasAccess($strModule, 'iso_modules'))
				{
					$arrGroups[$GLOBALS['TL_LANG']['IMD'][$strGroup]][$GLOBALS['ISO_MOD'][$strGroup][$strModule]['tables'][0]] = array
					(
						'name' => $GLOBALS['TL_LANG']['IMD'][$strModule][0],
						'description' => $GLOBALS['TL_LANG']['IMD'][$strModule][1],
						'icon' => $arrModules[$strModule]['icon']
					);
				}
			}
		}

		$this->Template->arrGroups = $arrGroups;
		$this->Template->script = $this->Environment->script;
		$this->Template->welcome = $GLOBALS['TL_LANG']['ISO']['config_module'];
	}
}

