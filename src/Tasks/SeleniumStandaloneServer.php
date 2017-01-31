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
 * Class for executing and stopping Selenium Standalone Server
 *
 * @package     Joomla\Testing\Robo
 * @subpackage  Tasks
 *
 * @since       1.0.0
 *
 */
final class SeleniumStandaloneServer extends GenericTask
{
	/**
	 * Human readable name of the task
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	protected $taskName = "Selenium Server";

	/**
	 * The domain and port to selenium hub site
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $url = 'http://localhost:4444';

	/**
	 * Binary of the selenium standalone server
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $binary = 'vendor/bin/selenium-server-standalone';

	/**
	 * Webdriver of the selenium standalone server
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $webdriver = null;

	/**
	 * Include debug option in the params or not
	 *
	 * @var boolean
	 *
	 * @since 1.0.0
	 */
	private $debug = true;

	/**
	 * Optionally add a catch-all log file
	 *
	 * @var string
	 *
	 * @since 1.0.0
	 */
	private $logFile = 'selenium.log';

	/**
	 * Number of seconds to wait for the server to start
	 *
	 * @var integer
	 *
	 * @since 1.0.0
	 */
	private $timeOut = 60;

	/**
	 * Set Selenium URL
	 *
	 * @param   string  $url  URL of selenium
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setURL($url)
	{
		$this->url = $url;

		return $this;
	}

	/**
	 * Set Selenium Binary
	 *
	 * @param   string  $binary  Selenium Standalone Server binary
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setBinary($binary)
	{
		$this->binary = $binary;

		return $this;
	}

	/**
	 * Set Selenium Webdriver
	 *
	 * @param   string  $webdriver  Selenium Standalone Server webdriver
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setWebdriver($webdriver)
	{
		$this->webdriver = $webdriver;

		return $this;
	}

	/**
	 * Set debug option for Selenium server
	 *
	 * @param   bool  $debug  Add debug or not
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setDebug($debug = true)
	{
		$this->debug = $debug;

		return $this;
	}

	/**
	 * Set a location for a catch-all log
	 *
	 * @param   string  $logFile  File to store the log in
	 *
	 * @return $this
	 *
	 * @since  1.0.0
	 */
	public function setLogFile($logFile)
	{
		$this->logFile = $logFile;

		return $this;
	}

	/**
	 * Set a timeout for the Selenium Standalone Server
	 *
	 * @param   int  $seconds  Number of seconds to wait for the process to start
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setTimeOut($seconds)
	{
		$this->timeOut = (int) $seconds;

		return $this;
	}

	/**
	 * Sets a task for running the selenium server
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function runSelenium()
	{
		return $this->setupTask('runSelenium');
	}

	/**
	 * Sets a task to wait for the server to be ready
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function waitForSelenium()
	{
		return $this->setupTask('waitForSelenium');
	}

	/**
	 * Sets a task to kill the selenium server
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function killSelenium()
	{
		return $this->setupTask('killSelenium');
	}

	/**
	 * Start the Selenium Server with the given options
	 *
	 * @return  boolean
	 *
	 * @since   1.0.0
	 */
	protected function runSeleniumExecute()
	{
		$roboHandler = RoboHandler::getInstance();

		$this->printTaskInfo('Executing Selenium Standalone server');

		// If no binary given, it doesn't start up the server
		if (empty($this->binary) || !file_exists($this->binary))
		{
			$this->printTaskError('No Selenium binary provided for execution');

			return false;
		}

		if (!$this->isWindows())
		{
			$command = $this->binary;
			$command .= (($this->debug) ? ' -debug' : '');
			$command .= (!empty($this->webdriver)) ? ' ' . $this->webdriver : '';
			$command .= (!empty($this->logFile)) ? ' >> ' . $this->logFile . ' 2>&1' : '';
		}
		else
		{
			$command = 'START java.exe -jar';
			$command .= (!empty($this->webdriver)) ? ' ' . $this->webdriver : '';
			$command .= ' ' . $this->getWindowsPath($this->binary) . '.jar';
			$command .= (($this->debug) ? ' -debug' : '');
		}

		if (!$roboHandler->executeDaemon($command))
		{
			$this->printTaskError('Selenium server execution failed');

			return false;
		}

		return true;
	}

	/**
	 * Wait for server to be available
	 *
	 * @return  boolean
	 *
	 * @since   1.0.0
	 */
	protected function waitForSeleniumExecute()
	{
		$this->printTaskInfo('Waiting for Selenium Standalone server to launch');
		$timeout = 0;

		if (!$this->isWindows())
		{
			while (!$this->isUrlAvailable($this->url . '/wd/hub'))
			{
				// If selenium has not started after the given number of seconds then die
				if ($timeout > $this->timeOut)
				{
					$this->printTaskError('Selenium server execution failed (timeout expired)');

					return false;
				}

				sleep(1);
				$timeout++;
			}
		}
		else
		{
			sleep(10);
		}

		$this->printTaskSuccess('Selenium server is executing correctly');

		return true;
	}

	/**
	 * Kills the server in execution
	 *
	 * @return  boolean
	 *
	 * @since   1.0.0
	 */
	protected function killSeleniumExecute()
	{

		$roboHandler = RoboHandler::getInstance();
		$this->printTaskInfo('Stopping Selenium Server');

		if (!$this->isWindows())
		{
			$command = 'curl ' . $this->url . '/selenium-server/driver/?cmd=shutDownSeleniumServer';

			if ($roboHandler->executeCommand($command))
			{
				$this->printTaskSuccess('Selenium stopped successfully');

				return true;
			}
		}
		else
		{
			$this->printTaskSuccess('Killing Selenium is not available yet on Windows.');

			return true;
		}

		$this->printTaskError('Selenium failed to be stopped');

		return false;
	}

	/**
	 * Checks if the given URL is available
	 *
	 * @param   string  $url  URL to check
	 *
	 * @return boolean
	 *
	 * @since   1.0.0
	 */
	private function isUrlAvailable($url)
	{
		$roboHandler = RoboHandler::getInstance();

		if (!$this->isWindows())
		{
			$command = 'curl  --retry 6 --retry-delay 10 --output /dev/null --silent ' . $url;

			if ($roboHandler->executeCommand($command))
			{
				return true;
			}
		}
		else
		{
			$this->printTaskSuccess('Curl is not installed on windows on default.');

			return true;
		}

		return false;
	}

	/**
	 * Check if local OS is Windows
	 *
	 * @return bool
	 * @since  __DEPLOY_VERSION__
	 */
	private function isWindows()
	{
		return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
	}

	/**
	 * Return the correct path for Windows
	 *
	 * @param   string $path - The linux path
	 *
	 * @return string
	 * @since  __DEPLOY_VERSION__
	 */
	private function getWindowsPath($path)
	{
		return str_replace('/', DIRECTORY_SEPARATOR, $path);
	}
}
