<?php
/**
 * @package     Joomla\Testing\Robo
 * @subpackage  Configuration
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Testing\Robo\Configuration;

/**
 * Configuration handler for Robo Files
 *
 * @package     Joomla\Testing\Robo
 * @subpackage  Configuration
 *
 * @since       1.0.0
 */
class RoboFileConfiguration extends GenericConfiguration
{
	/**
	 * If set to true, the repo will not be cloned from GitHub and the local copy will be reused.
	 *
	 * @var    bool
	 *
	 * @since  1.0.0
	 */
	protected $cmsSkipClone = false;

	/**
	 * CMS repository
	 *
	 * @var    string
	 *
	 * @since  1.0.0
	 */
	protected $cmsRepository = 'joomla/joomla-cms';

	/**
	 * Base CMS branch
	 *
	 * @var    string
	 *
	 * @since  1.0.0
	 */
	protected $cmsBranch = 'staging';

	/**
	 * Base path of the CMS
	 *
	 * @var    string
	 *
	 * @since  1.0.0
	 */
	protected $cmsPath = 'joomla';

	/**
	 * (Linux/Mac) Owner user of the CMS path in case an override is needed
	 *
	 * @var    string
	 *
	 * @since  1.0.0
	 */
	protected $cmsPathOwner = '';

	/**
	 * CMS root folder in the webserver
	 *
	 * @var    string
	 *
	 * @since  1.0.0
	 */
	protected $cmsRootFolder = '';

	/**
	 * Use an insecure connections for Curl
	 *
	 * @var    bool
	 *
	 * @since  1.0.0
	 */
	protected $insecureConnections = false;

}