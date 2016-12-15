<?php
/**
 * @package     Joomla\Testing\Robo
 * @subpackage  Handlers
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Testing\Robo\Handlers;

use Robo\Runner;
use Robo\Application;

/**
 * Robo Handler, for running Robo tasks inside the created Robo tasks
 *
 * @package     Joomla\Testing\Robo
 * @subpackage  Handlers
 *
 * @since       1.0.0
 */
class RoboHandler extends \Robo\Tasks
{
	use FileSystem, Command, File;

	/**
	 * @var $this
	 *
	 * Cached instance of this class, so it can be used to run static calls
	 *
	 * @since   1.0.0
	 */
	protected static $instance = null;

	/**
	 * Initializes the handler to run Robo tasks
	 *
	 * @since   1.0.0
	 */
	public function __construct()
	{
		$runner = new Runner;
		$app = new Application('Joomla\Testing\Engine', '1.0.0');
		$runner->registerCommandClass($app, $this);
	}

	/**
	 * Creates and/or returns a cached instance of the class
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public static function getInstance()
	{
		if (is_null(static::$instance))
		{
			static::$instance = new static;
		}

		return static::$instance;
	}
}
