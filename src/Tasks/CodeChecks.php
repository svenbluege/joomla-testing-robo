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
 * Class with Robo tasks for performing code checks
 *
 * @package     Joomla\Testing\Robo
 * @subpackage  Tasks
 *
 * @since       1.0.0
 */
final class CodeChecks extends GenericTask
{
	use Traits\OS;

	/**
	 * Human readable name of the task
	 *
	 * @var string
	 *
	 * @since   1.0.0
	 */
	protected $taskName = 'Code checking';

	/**
	 * Base path of the repository
	 *
	 * @var     string
	 *
	 * @since   1.0.0
	 */
	private $baseRepositoryPath = '';

	/**
	 * Folders included in the parse code check
	 *
	 * @var    array
	 *
	 * @since  1.0.0
	 */
	private $parseErrorsCheckFolders = array();

	/**
	 * PHP executable command
	 *
	 * @var     string
	 *
	 * @since   1.0.0
	 */
	private $phpExecutable = 'php';

	/**
	 * Folders to check for debug leftovers
	 *
	 * @var     array
	 *
	 * @since   1.0.0
	 */
	private $debugLeftoversFolders = array();

	/**
	 * Folder used to store the coding standard definitions
	 *
	 * @var     string
	 *
	 * @since   1.0.0
	 */
	private $codeStyleStandardsFolder = '';

	/**
	 * Repository (Github) where the coding standards are set
	 *
	 * @var     string
	 *
	 * @since   1.0.0
	 */
	private $codeStyleStandardsRepo = 'joomla/coding-standards';

	/**
	 * Branch of the coding standards repository to use
	 *
	 * @var     string
	 *
	 * @since   1.0.0
	 */
	private $codeStyleStandardsBranch = 'master';

	/**
	 * Folders to perform the code style check in
	 *
	 * @var     array
	 *
	 * @since   1.0.0
	 */
	private $codeStyleCheckFolders = array();

	/**
	 * Paths (files/folders/path patterns) to exclude from the code style checking
	 *
	 * @var     array
	 *
	 * @since   1.0.0
	 */
	private $codeStyleExcludedPaths = array();

	/**
	 * Include an extra folder to name the standard in case the sniff is in the root of the repository.
	 * Tip: Joomla phpcs v.1 set to true, v.2 set to false (default)
	 *
	 * @var     boolean
	 *
	 * @since   1.0.0
	 */
	private $codeStyleExtraFolder = false;

	/**
	 * Include the codestyle name.
	 *
	 * @var     string
	 *
	 * @since   1.0.0
	 */
	private $codeStyleName = 'Joomla';

	/**
	 * Set the path of the repository
	 *
	 * @param   string  $baseRepositoryPath  Base path of the repository
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setBaseRepositoryPath($baseRepositoryPath)
	{
		$this->baseRepositoryPath = $baseRepositoryPath;

		return $this;
	}

	/**
	 * Set the folders to include in the code check (parse)
	 *
	 * @param   array  $parseErrorsCheckFolders  Folders to include in the parse check
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setParseErrorsCheckFolders($parseErrorsCheckFolders)
	{
		$this->parseErrorsCheckFolders = $parseErrorsCheckFolders;

		return $this;
	}

	/**
	 * Sets the PHP executable command
	 *
	 * @param   string  $phpExecutable  PHP executable
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setPhpExecutable($phpExecutable)
	{
		$this->phpExecutable = $phpExecutable;

		return $this;
	}

	/**
	 * Sets the folders to check for debug leftovers
	 *
	 * @param   string  $debugLeftoversFolders  Folders to check for debug leftovers
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setDebugLeftoversFolders($debugLeftoversFolders)
	{
		$this->debugLeftoversFolders = $debugLeftoversFolders;

		return $this;
	}

	/**
	 * Sets the folder where code style definitions are going to be downloaded/stored
	 *
	 * @param   string  $codeStyleStandardsFolder  Folder with code style definitions
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setCodeStyleStandardsFolder($codeStyleStandardsFolder)
	{
		$this->codeStyleStandardsFolder = $codeStyleStandardsFolder;

		return $this;
	}

	/**
	 * Sets the repository with code style definitions
	 *
	 * @param   string  $codeStyleStandardsRepo  Code style definitions repository (owner/user)
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setCodeStyleStandardsRepo($codeStyleStandardsRepo)
	{
		$this->codeStyleStandardsRepo = $codeStyleStandardsRepo;

		return $this;
	}

	/**
	 * Sets the branch with the code style definitions
	 *
	 * @param   string  $codeStyleStandardsBranch  Branch used for code style definitions
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setCodeStyleStandardsBranch($codeStyleStandardsBranch)
	{
		$this->codeStyleStandardsBranch = $codeStyleStandardsBranch;

		return $this;
	}

	/**
	 * Set the folders to perform the code style check in
	 *
	 * @param   string|array  $codeStyleCheckFolders  Folders to perform the code style check in
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setCodeStyleCheckFolders($codeStyleCheckFolders)
	{
		$this->codeStyleCheckFolders = $codeStyleCheckFolders;

		return $this;
	}

	/**
	 * Set the paths (files/folders/path patterns) to exclude from the code style checking
	 *
	 * @param   string  $codeStyleExcludedPaths  Paths to exclude from the code style checking
	 *
	 * @return $this
	 *
	 * @since   1.0.0
	 */
	public function setCodeStyleExcludedPaths($codeStyleExcludedPaths)
	{
		$this->codeStyleExcludedPaths = $codeStyleExcludedPaths;

		return $this;
	}

	/**
	 * Include an extra folder to name the standard in case the sniff is not in the root of the repository.
	 *
	 * @param   boolean  $codeStyleExtraFolder  Set the folder flag on/off
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setCodeStyleExtraFolder($codeStyleExtraFolder)
	{
		$this->codeStyleExtraFolder = $codeStyleExtraFolder;

		return $this;
	}

	/**
	 * Set the codestyle name. Default = Joomla
	 *
	 * @param   string  $codeStyleName  name of the codestyle
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setcodeStyleName($codeStyleName)
	{
		$this->codeStyleName = $codeStyleName;

		return $this;
	}

	/**
	 * Task to check for parse errors through the code
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function checkForParseErrors()
	{
		return $this->setupTask('checkForParseErrors');
	}

	/**
	 * Task to check for debug leftovers (var_dump, console.log, etc)
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function checkForDebugLeftovers()
	{
		return $this->setupTask('checkForDebugLeftovers');
	}

	/**
	 * Task to check code style
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function checkCodeStyle()
	{
		return $this->setupTask('checkCodeStyle');
	}

	/**
	 * Task to check for parse errors through the code
	 *
	 * @return  boolean
	 *
	 * @since   1.0.0
	 */
	protected function checkForParseErrorsExecute()
	{
		$this->printTaskInfo('Checking for parse errors over the code');

		if (empty($this->phpExecutable))
		{
			$this->printTaskError('No valid PHP executable was given');

			return false;
		}

		if (empty($this->baseRepositoryPath))
		{
			$this->printTaskError('Please set the base path of the repository');

			return false;
		}

		if (!is_array($this->parseErrorsCheckFolders) || empty($this->parseErrorsCheckFolders))
		{
			$this->printTaskError('No folders for checking parse errors were given');

			return false;
		}

		$return = true;
		$roboHandler = RoboHandler::getInstance();

		// Performs the check on each folders
		foreach ($this->parseErrorsCheckFolders as $parseErrorsCheckFolder)
		{
			$this->printTaskInfo('Performing parse errors check in folder ' . $parseErrorsCheckFolder);
			$fullPath = $this->baseRepositoryPath . '/' . $parseErrorsCheckFolder;

			if (!file_exists($fullPath) || !is_dir($fullPath))
			{
				$this->printTaskError('Folder ' . $parseErrorsCheckFolder . ' is not valid');
				$return = false;

				continue;
			}

			$parseErrors = '';
			$command = 'find ' . $fullPath . ' -name "*.php" -exec ' . $this->phpExecutable . ' -l {} \; | grep "Errors parsing";';

			// Find ends up with code error 1 if no matches are found so there is no point in validating the execution
			$roboHandler->executeCommandWithMessage($command, $parseErrors, false);

			if ($parseErrors != '')
			{
				$this->printTaskError('Parse errors were found in folder ' . $parseErrorsCheckFolder . ': ' . chr(10) . $parseErrors);
				$return = false;
			}
		}

		return $return;
	}

	/**
	 * Task to check for debug leftovers (var_dump, console.log, etc)
	 *
	 * @return  boolean
	 *
	 * @since   1.0.0
	 */
	protected function checkForDebugLeftoversExecute()
	{
		$this->printTaskInfo('Checking for debug leftovers');

		if (empty($this->phpExecutable))
		{
			$this->printTaskError('No valid PHP executable was given');

			return false;
		}

		if (empty($this->baseRepositoryPath))
		{
			$this->printTaskError('Please set the base path of the repository');

			return false;
		}

		if (!is_array($this->debugLeftoversFolders) || empty($this->debugLeftoversFolders))
		{
			$this->printTaskError('No folders for checking for debug leftovers were given');

			return false;
		}

		$return = true;
		$roboHandler = RoboHandler::getInstance();

		// Performs the check on each folders
		foreach ($this->debugLeftoversFolders as $debugLeftoversFolder)
		{
			$this->printTaskInfo('Performing debug leftovers check in folder ' . $debugLeftoversFolder);
			$fullPath = $this->baseRepositoryPath . '/' . $debugLeftoversFolder;

			if (!file_exists($fullPath) || !is_dir($fullPath))
			{
				$this->printTaskError('Folder ' . $debugLeftoversFolder . ' is not valid');
				$return = false;

				continue;
			}

			$phpDebugLeftovers = '';
			$jsDebugLeftovers = '';
			$phpCommand = 'grep -r --include "*.php" var_dump ' . $fullPath;
			$jsCommand = 'grep -r --include "*.js" --include "*.php" console.log ' . $fullPath;

			// Preg ends up with code error 1 if no matches are found so there is no point in validating the execution
			$roboHandler->executeCommandWithMessage($phpCommand, $phpDebugLeftovers, false);
			$roboHandler->executeCommandWithMessage($jsCommand, $jsDebugLeftovers, false);

			if ($phpDebugLeftovers != '' || $jsDebugLeftovers)
			{
				$this->printTaskError(
					'Debug leftovers were found in folder ' . $debugLeftoversFolder . ': '
					. chr(10) . (empty($phpDebugLeftovers) ? '' : $phpDebugLeftovers)
					. chr(10) . (empty($jsDebugLeftovers) ? '' : $jsDebugLeftovers)
				);
				$return = false;
			}
		}

		return $return;
	}

	/**
	 * Task to check code style
	 *
	 * @return  boolean
	 *
	 * @since   1.0.0
	 */
	protected function checkCodeStyleExecute()
	{
		$this->printTaskInfo('Checking for code style standards');

		if (empty($this->phpExecutable))
		{
			$this->printTaskError('No valid PHP executable was given');

			return false;
		}

		if (empty($this->baseRepositoryPath))
		{
			$this->printTaskError('Please set the base path of the repository');

			return false;
		}

		if (empty($this->codeStyleStandardsFolder))
		{
			$this->printTaskError('No folder for coding standards was given');

			return false;
		}

		if (!is_array($this->codeStyleCheckFolders) || empty($this->codeStyleCheckFolders))
		{
			$this->printTaskError('No folders for checking for code styling were given');

			return false;
		}

		// Clones the coding standards repository if needed
		if (!is_dir($this->codeStyleStandardsFolder))
		{
			$roboHandler = RoboHandler::getInstance();

			if (empty($this->codeStyleStandardsRepo) || empty($this->codeStyleStandardsBranch))
			{
				$this->printTaskError('No repo/branch for coding standards were given');

				return false;
			}

			$command = 'git' . $this->getGitExecutableExtension() .
				' clone -b ' . $this->codeStyleStandardsBranch . ' --single-branch --depth 1 ' .
				'https://github.com/' . $this->codeStyleStandardsRepo . '.git ' . $this->codeStyleStandardsFolder .
				($this->codeStyleExtraFolder ? '/' . $this->codeStyleName : '');

			if (!$roboHandler->executeCommand($command))
			{
				$this->printTaskError('Cloning the code style standards definition failed');

				return false;
			}
		}

		// Appends base repo folder to the folders to be checked
		$codeStyleCheckFolders = preg_filter('/^/', $this->baseRepositoryPath . '/', $this->codeStyleCheckFolders);

		// Creates the options for the sniffer
		$codeStyleCheckOptions = array(
			'files'        => $codeStyleCheckFolders,
			'standard'     => array($this->codeStyleName),
			'showProgress' => true,
			'verbosity'    => false,
			'extensions'   => array('php')
		);

		// Excludes paths if given
		if (is_array($this->codeStyleExcludedPaths) && !empty($this->codeStyleExcludedPaths))
		{
			$codeStyleExcludedPaths = preg_filter('/^/', $this->baseRepositoryPath . '/', $this->codeStyleExcludedPaths);
			$codeStyleCheckOptions['ignore'] = $codeStyleExcludedPaths;
		}

		// Sets the folder where Joomla standards are stored as a source for phpcs
		\PHP_CodeSniffer::setConfigData('installed_paths', $this->codeStyleStandardsFolder);

		$phpcs = new \PHP_CodeSniffer_CLI;
		$phpcs->checkRequirements();
		$phpcsErrors = $phpcs->process($codeStyleCheckOptions);

		// If there were errors, output the number and exit with a fail status
		if ($phpcsErrors)
		{
			$this->printTaskError('There were ' . $phpcsErrors . ' code styling errors detected');

			return false;
		}

		return true;
	}
}
