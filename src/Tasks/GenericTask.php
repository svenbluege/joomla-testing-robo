<?php
/**
 * @package     Joomla\Testing\Robo
 * @subpackage  Tasks
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Testing\Robo\Tasks;

use Robo\Result;
use Robo\Task\BaseTask;
use Robo\Contract\TaskInterface;


/**
 * Generic class for adding Robo tasks
 *
 * @package     Joomla\Testing\Robo
 * @subpackage  Tasks
 *
 * @since       1.0.0
 */
abstract class GenericTask extends BaseTask implements TaskInterface
{
	/**
	 * Tasks to execute when this task runs
	 *
	 * @var array
	 *
	 * @since   1.0.0
	 */
	protected $tasks = array();

	/**
	 * Human readable name of the task
	 *
	 * @var string
	 *
	 * @since   1.0.0
	 */
	protected $taskName;

	/**
	 * Sets up a task to be executed during the run command
	 *
	 * @param   string  $task  Task to be executed during runtime
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	protected function setupTask($task)
	{
		$this->tasks[] = $task;

		return $this;
	}

	/**
	 * Execute the Selenium Standalone Server binaries
	 *
	 * @return  Result
	 *
	 * @since   1.0.0
	 */
	public function run()
	{
		if (empty($this->taskName))
		{
			$this->taskName = get_called_class();
		}

		// No tasks given
		if (empty($this->tasks))
		{
			return Result::error($this, 'No tasks given for execution regarding ' . $this->taskName);
		}

		foreach ($this->tasks as $task)
		{
			$taskExec = '_' . $task;

			if (!$this->$taskExec())
			{
				return Result::error($this, 'Error executing ' . $this->taskName . ' tasks.  Execution stopped');
			}
		}

		return Result::success($this, $this->taskName . ' tasks executed correctly', ['time' => $this->getExecutionTime()]);
	}
}
