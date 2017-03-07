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
 * Tasks related to the filesystem
 *
 * @package     Joomla\Testing\Robo
 * @subpackage  Handlers
 *
 * @since       1.0.0
 */
trait FileSystem
{
	/**
	 * Deletes a whole directory
	 *
	 * @param   string  $dir  Directory to delete
	 *
	 * @return  boolean
	 *
	 * @since   1.0.0
	 */
	public function deleteDirectory($dir)
	{
		if (!file_exists($dir) && is_dir($dir))
		{
			return false;
		}

		$result = $this->taskDeleteDir($dir)
			->run();

		if (0 != $result->getExitCode())
		{
			return false;
		}

		if (file_exists($dir))
		{
			return false;
		}

		return true;
	}

	/**
	 * Copies a directory into another, recursively
	 *
	 * @param   string  $src   Source directory
	 * @param   string  $dest  Target directory
	 *
	 * @return  boolean
	 *
	 * @since   1.0.0
	 */
	public function copyDir($src, $dest)
	{
		if (!file_exists($src) && is_dir($src))
		{
			return false;
		}

		$result = $this->taskCopyDir(
			array(
				'src' => $dest
			)
		)
			->run();

		if (0 != $result->getExitCode())
		{
			return false;
		}

		return true;
	}

	/**
	 * Copies a file to a different location
	 *
	 * @param   string  $src   Source file
	 * @param   string  $dest  Destination file
	 *
	 * @return  boolean
	 *
	 * @since   1.0.0
	 */
	public function copyFile($src, $dest)
	{
		$result = $this->taskFilesystemStack()
			->copy($src, $dest)
			->run();

		if (0 != $result->getExitCode())
		{
			return false;
		}

		return true;
	}

	/**
	 * Concatenates the content of several files
	 *
	 * @param   array   $sourceFiles  Array of files to concatenate (in order)
	 * @param   string  $destFile     Destination file with the combined (concatenated) content of the source files
	 *
	 * @return  boolean
	 *
	 * @since   1.0.0
	 */
	public function concatFiles($sourceFiles, $destFile)
	{
		$result = $this->taskConcat($sourceFiles)
			->to($destFile)
			->run();

		if (0 != $result->getExitCode())
		{
			return false;
		}

		return true;
	}
}
