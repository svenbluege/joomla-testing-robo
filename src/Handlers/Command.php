<?php
/**
 * @package     Joomla\Testing\Robo
 * @subpackage  Handlers
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Testing\Robo\Handlers;

/**
 * Tasks related to the command execution
 *
 * @package     Joomla\Testing\Robo
 * @subpackage  Handlers
 *
 * @since       1.0.0
 */
trait Command
{
	/**
	 * Executes a certain command and sends back the exit code
	 *
	 * @param   string  $command  Command to execute
	 * @param   bool    $printed  Output print
	 *
	 * @return  bool
	 *
	 * @since   1.0.0
	 */
	public function executeCommand($command, $printed = false)
	{
		if ($printed)
		{
			$result = $this->taskExec($command)
				->printed(true)
				->run();
		}
		else
		{
			$result = $this->taskExec($command)
				->run();
		}

		if (0 != $result->getExitCode())
		{
			return false;
		}

		return true;
	}

	/**
	 * Executes a certain command and sends back the exit code and stores the message in a referenced variable
	 *
	 * @param   string  $command  Command to execute
	 * @param   string  &$output  Output messages from the execution
	 * @param   bool    $printed  Output print
	 *
	 * @return  bool
	 *
	 * @since   1.0.0
	 */
	public function executeCommandWithMessage($command, &$output, $printed)
	{
		if ($printed)
		{
			$result = $this->taskExec($command)
				->printed(true)
				->run();
		}
		else
		{
			$result = $this->taskExec($command)
				->run();
		}

		$output = $result->getMessage();

		if (0 != $result->getExitCode())
		{
			return false;
		}

		return true;
	}

	/**
	 * Executes a certain command as a daemon
	 *
	 * @param   string  $command  Command to execute
	 *
	 * @return  bool
	 *
	 * @since   1.0.0
	 */
	public function executeDaemon($command)
	{
		$result = $this->taskExec($command)
			->background()
			->run();

		if (0 != $result->getExitCode())
		{
			return false;
		}

		return true;
	}
}
