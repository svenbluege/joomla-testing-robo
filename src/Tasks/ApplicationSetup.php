<?php
/**
 * @package     Joomla\Testing\Robo
 * @subpackage  Tasks
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Testing\Robo\Tasks;

use Joomla\Testing\Robo\Handlers\RoboHandler;

/**
 * Class with Robo tasks for setting up the application for testing
 *
 * @package     Joomla\Testing\Robo
 * @subpackage  Tasks
 *
 * @since       1.0.0
 */
final class ApplicationSetup extends GenericTask
{
	/**
	 * Human readable name of the task
	 *
	 * @var string
	 *
	 * @since   1.0.0
	 */
	protected $taskName = 'Application setup';

	/**
	 * Command for packaging the application
	 *
	 * @var   string
	 *
	 * @since 1.0.0
	 */
	private $packageCommand = 'gulp release';

	/**
	 * Arguments for packaging the application
	 *
	 * @var   string
	 *
	 * @since 1.0.0
	 */
	private $packageArgs = '--skip-version';

	/**
	 * Function for setting the packager command
	 *
	 * @param   string  $packageCommand  Packager command
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setPackageCommand($packageCommand)
	{
		$this->packageCommand = $packageCommand;

		return $this;
	}

	/**
	 * Function for setting the packager arguments
	 *
	 * @param   string  $packageArgs  Packager arguments
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setPackageArgs($packageArgs)
	{
		$this->packageArgs = $packageArgs;

		return $this;
	}

	/**
	 * Package the application using the specified commands
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function packageApplication()
	{
		return $this->setupTask('packageApplication');
	}

	/**
	 * Package the application using the specified commands
	 *
	 * @return  boolean
	 *
	 * @since   1.0.0
	 */
	protected function packageApplicationExecute()
	{
		if (empty($this->packageCommand))
		{
			$this->printTaskError('No specified command was given for packaging the application');

			return false;
		}

		$roboHandler = RoboHandler::getInstance();
		$command = $this->packageCommand . (empty($this->packageArgs) ? '' : ' ' . $this->packageArgs);

		if (!$roboHandler->executeCommand($command))
		{
			$this->printTaskError('Application packager failed');

			return false;
		}

		return true;
	}
}
