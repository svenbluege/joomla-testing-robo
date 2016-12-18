<?php
/**
 * @package     Joomla\Testing\Robo
 * @subpackage  RoboFile
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Testing\Robo\RoboFile;

/**
 * Robo File interface
 *
 * @since  1.0.0
 */
interface RoboFileInterface
{
	/**
	 * Function for actual execution of the test suites of this extension
	 *
	 * @param   array  $opts  Array of configuration options:
	 *                        - 'env': set a specific environment to get configuration from
	 *                        - 'debug': executes codeception tasks with extended debug
	 *
	 * @return void
	 *
	 * @since   3.7.0
	 */
	public function runTestSuites(
		$opts = [
		'env' => 'desktop',
		'debug' => false
		]);

	/**
	 * Executes the extension packager for this extension
	 *
	 * @param   array  $params  Additional parameters
	 *
	 * @return  void
	 *
	 * @since   3.7.0
	 */
	public function prepareTestingPackage($params = ['dev' => false]);
}