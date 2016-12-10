<?php
/**
 * @package     Joomla\Testing\Robo
 * @subpackage  Tasks
 *
 * @copyright   Copyright (C) 2005 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Testing\Robo\Tasks;

/**
 * Trait for redWEB specific robo tasks
 *
 * @package     Joomla\Testing\Robo
 * @subpackage  Tasks
 *
 * @since       1.0.0
 */
trait loadTasks
{
	/**
	 * Selenium tasks
	 *
	 * @return SeleniumStandaloneServer
	 *
	 * @since  1.0.0
	 */
	protected function taskSeleniumStandaloneServer()
	{
		return $this->task(SeleniumStandaloneServer::class);
	}

	/**
	 * CMS setup tasks
	 *
	 * @return CMSSetup
	 *
	 * @since  1.0.0
	 */
	protected function taskCMSSetup()
	{
		return $this->task(CMSSetup::class);
	}

	/**
	 * Application setup tasks
	 *
	 * @return ApplicationSetup
	 *
	 * @since  1.0.0
	 */
	protected function taskApplicationSetup()
	{
		return $this->task(ApplicationSetup::class);
	}

	/**
	 * Code check tasks
	 *
	 * @return CodeChecks
	 *
	 * @since  1.0.0
	 */
	protected function taskCodeChecks()
	{
		return $this->task(CodeChecks::class);
	}

	/**
	 * Reporting tasks
	 *
	 * @return Reporting
	 *
	 * @since  1.0.0
	 */
	protected function taskReporting()
	{
		return $this->task(Reporting::class);
	}
}
