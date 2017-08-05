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
 * Robo functions to execute in containers
 *
 * @package     Joomla\Testing\Robo
 * @subpackage  RoboFile
 *
 * @since       1.0.0
 */
trait ClientContainer
{
	/**
	 * Run the whole test script for this extension in a container environment
	 *
	 * @param   array  $opts  Array of configuration options:
	 *                        - 'env': set a specific environment to get configuration from
	 *                        - 'debug': executes codeception tasks with extended debug
	 *
	 * @return void
	 *
	 * @since   3.7.0
	 */
	public function runContainerTests(
		$opts = array(
			'env' => 'desktop',
			'debug' => false
		)
	)
	{
		// Removes install suite and test from the preparation script, to execute it with the full script
		$opts['install-suite'] = '';
		$opts['install-test'] = '';

		$this->runContainerTestPreparation($opts);

		$this->runTestSuites($opts);

	}

	/**
	 * Run a single test script for this extension in a container environment
	 *
	 * @param   array  $opts  Array of configuration options:
	 *  					  - 'env': set a specific environment to get configuration from
	 *                        - 'debug': executes codeception tasks with extended debug
	 * 						  - 'suite': the suite of the test
	 * 						  - 'test': example: 'install/InstallWeblinksCest.php/installWeblinks'
	 * 						  - 'server': the container name on which the tests are run
	 * @return void
	 *
	 * @since   3.7.0
	 */
	public function runContainerTest(
		$opts = array(
			'env' => 'desktop',
			'debug' => false,
			'suite' => 'acceptance',
			'test' => 'install',
			'server' => 'php',
			'config' => ''
		)
	)
	{
		$this->runCodeceptionSuite(
			$opts['suite'],
			$opts['test'],
			$opts['debug'],
			$opts['env'],
			$opts['config']
		);
	}

	/**
	 * Prepare the environment for testing in client containers.  No install/setup task executed
	 *
	 * @param   array  $opts  Array of configuration options:
	 *                        - 'env': set a specific environment to get configuration from
	 *
	 * @return void
	 *
	 * @since   3.7.0
	 */
	public function runContainerTestPreparation(
		$opts = array(
			'env' => 'desktop'
		)
	)
	{
		$this->prepareTestingPackage(array('dev' => true));
		$this->codeceptionBuild();
	}
}
