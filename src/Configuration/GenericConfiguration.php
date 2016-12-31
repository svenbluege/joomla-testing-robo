<?php
/**
 * @package     Joomla\Testing\Robo
 * @subpackage  Configuration
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Testing\Robo\Configuration;

use Joomla\Testing\Object\GenericObject;

/**
 * Generic configuration handler
 *
 * @package     Joomla\Testing\Robo
 * @subpackage  Configuration
 *
 * @since       1.0.0
 */
abstract class GenericConfiguration extends GenericObject
{
	/**
	 * Loads a configuration file in simple ini format (key = value)
	 *
	 * @param   string  $filePath  Path to the configuration file
	 *
	 * @return  boolean
	 *
	 * @since   1.0.0
	 */
	public function loadConfigurationFile($filePath)
	{
		if (!file_exists($filePath))
		{
			return false;
		}

		$configuration = parse_ini_file($filePath);

		if ($configuration === false || !is_array($configuration))
		{
			return false;
		}

		// Sets all the possible configurations in the current class (they need to exist)
		foreach ($configuration as $configVar => $configValue)
		{
			if (property_exists($this, $configVar) && !empty($configValue))
			{
				switch (gettype($this->$configVar))
				{
					case 'boolean':
						$this->$configVar = (bool) $configValue;
						break;

					case 'integer':
						$this->$configVar = (int) $configValue;
						break;

					case 'float':
						$this->$configVar = (float) $configValue;
						break;

					default:
						$this->$configVar = $configValue;
				}
			}
		}

		return true;
	}
}
