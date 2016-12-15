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
 * Tasks related to file manipulation
 *
 * @package     Joomla\Testing\Robo
 * @subpackage  Handlers
 *
 * @since       1.0.0
 */
trait File
{
	/**
	 * Replaces a string in a certain given file
	 *
	 * @param   string  $path  Path of the file
	 * @param   string  $from  Original string
	 * @param   string  $to    Final string
	 *
	 * @return  bool
	 *
	 * @since   1.0.0
	 */
	public function replaceInFile($path, $from, $to)
	{
		return $this->taskReplaceInFile($path)
			->from($from)
			->to($to)
			->run();
	}
}
