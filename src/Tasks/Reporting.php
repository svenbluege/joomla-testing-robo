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
 * Class for reporting tests results
 *
 * @package     Joomla\Testing\Robo
 * @subpackage  Tasks
 *
 * @since       1.0.0
 */
final class Reporting extends GenericTask
{
	/**
	 * Human readable name of the task
	 *
	 * @var string
	 *
	 * @since   1.0.0
	 */
	protected $taskName = "Reporting";

	/**
	 * Cloudinary service cloud name
	 *
	 * @var     string
	 *
	 * @since   1.0.0
	 */
	private $cloudinaryCloudName = '';

	/**
	 * Cloudinary API key
	 *
	 * @var     string
	 *
	 * @since   1.0.0
	 */
	private $cloudinaryApiKey = '';

	/**
	 * Cloudinary API secret
	 *
	 * @var     string
	 *
	 * @since   1.0.0
	 */
	private $cloudinaryApiSecret = '';

	/**
	 * Github token
	 *
	 * @var     string
	 *
	 * @since   1.0.0
	 */
	private $githubToken = '';

	/**
	 * Github repository (owner/repo)
	 *
	 * @var     string
	 *
	 * @since   1.0.0
	 */
	private $githubRepo = '';

	/**
	 * Github Pull Request number
	 *
	 * @var     int
	 *
	 * @since   1.0.0
	 */
	private $githubPR = 0;

	/**
	 * Array of images to upload (local paths)
	 *
	 * @var     array
	 *
	 * @since   1.0.0
	 */
	private $imagesToUpload = array();

	/**
	 * Local folder of images to upload
	 *
	 * @var     string
	 *
	 * @since   1.0.0
	 */
	private $folderImagesToUpload = '';

	/**
	 * Comment body to include into Github
	 *
	 * @var     string
	 *
	 * @since   1.0.0
	 */
	private $githubCommentBody = '';

	/**
	 * Uploaded images (URL)
	 *
	 * @var     array
	 *
	 * @since   1.0.0
	 */
	private $uploadedImagesURLs = array();

	/**
	 * Sets the Cloudinary service cloud name
	 *
	 * @param   string  $cloudinaryCloudName  Cloudinary service cloud name
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setCloudinaryCloudName($cloudinaryCloudName)
	{
		$this->cloudinaryCloudName = $cloudinaryCloudName;

		return $this;
	}

	/**
	 * Sets the Cloudinary API key
	 *
	 * @param   string  $cloudinaryApiKey  Cloudinary API key
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setCloudinaryApiKey($cloudinaryApiKey)
	{
		$this->cloudinaryApiKey = $cloudinaryApiKey;

		return $this;
	}

	/**
	 * Sets the Cloudinary API secret
	 *
	 * @param   string  $cloudinaryApiSecret  Cloudinary API secret
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setCloudinaryApiSecret($cloudinaryApiSecret)
	{
		$this->cloudinaryApiSecret = $cloudinaryApiSecret;

		return $this;
	}

	/**
	 * Sets the Github token
	 *
	 * @param   string  $githubToken  Github token
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setGithubToken($githubToken)
	{
		$this->githubToken = $githubToken;

		return $this;
	}

	/**
	 * Sets the Github repository (owner/repo)
	 *
	 * @param   string  $githubRepo  Github repository
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setGithubRepo($githubRepo)
	{
		$this->githubRepo = $githubRepo;

		return $this;
	}

	/**
	 * Sets the Github Pull Request number
	 *
	 * @param   int  $githubPR  Github pull request number
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setGithubPR($githubPR)
	{
		$this->githubPR = $githubPR;

		return $this;
	}

	/**
	 * Sets the local images to upload
	 *
	 * @param   mixed  $imagesToUpload  Local paths of images to upload - Array or String
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setImagesToUpload($imagesToUpload)
	{
		if (is_array($imagesToUpload))
		{
			$this->imagesToUpload = $imagesToUpload;

			return $this;
		}

		$this->imagesToUpload = array($imagesToUpload);

		return $this;
	}

	/**
	 * Sets a folder to search for images to upload
	 *
	 * @param   string  $folderImagesToUpload  Local path with images to upload
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setFolderImagesToUpload($folderImagesToUpload)
	{
		$this->folderImagesToUpload = $folderImagesToUpload;

		return $this;
	}

	/**
	 * Sets the comment body to include into Github
	 *
	 * @param   string  $githubCommentBody  Comment body to include into Github
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setGithubCommentBody($githubCommentBody)
	{
		$this->githubCommentBody = $githubCommentBody;

		return $this;
	}

	/**
	 * Sets the uploaded images (URLs)
	 *
	 * @param   mixed  $uploadedImagesURLs  Uploaded images (URLs) - Array or String
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function setUploadedImagesURLs($uploadedImagesURLs)
	{
		if (is_array($uploadedImagesURLs))
		{
			$this->uploadedImagesURLs = $uploadedImagesURLs;

			return $this;
		}

		$this->uploadedImagesURLs = array($uploadedImagesURLs);

		return $this;
	}

	/**
	 * Task to publish the reported images to Cloudinary and store the URLs
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function publishCloudinaryImages()
	{
		return $this->setupTask('publishCloudinaryImages');
	}

	/**
	 * Task to publish a comment into a Github PR
	 *
	 * @return  $this
	 *
	 * @since   1.0.0
	 */
	public function publishGithubCommentToPR()
	{
		return $this->setupTask('publishGithubCommentToPR');
	}

	/**
	 * Publishes the reported images to Cloudinary and stores the URLs
	 *
	 * @return  bool
	 *
	 * @since   1.0.0
	 */
	protected function _publishCloudinaryImages()
	{
		$this->printTaskInfo('Uploading images to Cloudinary');

		if (empty($this->cloudinaryCloudName) || empty($this->cloudinaryApiKey) || empty($this->cloudinaryApiSecret))
		{
			$this->printTaskError('Cloudinary API data was not provided');

			return false;
		}

		$imagesToUpload = $this->imagesToUpload;

		if (!empty($this->folderImagesToUpload))
		{
			$images = $this->searchImagesToUpload($this->folderImagesToUpload);

			if (!$images)
			{
				$this->printTaskError('Provided folder with images to upload is not valid: ' . $this->folderImagesToUpload);

				return false;
			}

			$imagesToUpload = array_merge($imagesToUpload, $images);
		}

		foreach ($imagesToUpload as $image)
		{
			if (!in_array(pathinfo($image, PATHINFO_EXTENSION), ['jpg', 'png']))
			{
				$this->printTaskError('Provided file is not a valid local image path (PNG or JPG are allowed): ' . $image);

				return false;
			}
		}

		if (empty($imagesToUpload))
		{
			$this->printTaskError('No valid local images were provided');

			return false;
		}


		\Cloudinary::config(
			[
				'cloud_name'   => $this->cloudinaryCloudName,
				'api_key'      => $this->cloudinaryApiKey,
				'api_secret'   => $this->cloudinaryApiSecret
			]
		);

		// Empties the uploaded images array
		$this->uploadedImagesURLs = [];

		foreach ($imagesToUpload as $image)
		{
			$result = \Cloudinary\Uploader::upload(realpath($image));

			if (isset($result['error']))
			{
				$this->printTaskError('Error when uploading image to Cloudinary: ' . $result['error'] . '. Image path: ' . $image);

				return false;
			}

			$this->uploadedImagesURLs[] = $result['secure_url'];
		}

		return true;
	}

	/**
	 * Publishes a comment into a Github PR.  It includes the uploaded image, if set and present
	 *
	 * @return  bool
	 *
	 * @since   1.0.0
	 */
	protected function _publishGithubCommentToPR()
	{
		$this->printTaskInfo('Sending comment to Github PR');

		$repoMatches = array();

		if (empty($this->githubToken) || empty($this->githubRepo)
			|| !preg_match('/([0-9a-z_-]+)\/([0-9a-z_-]+)/i', $this->githubRepo, $repoMatches) || !$this->githubPR)
		{
			$this->printTaskError('Valid Github token repository and pull request number were not provided');

			return false;
		}

		if (empty($this->githubCommentBody))
		{
			$this->printTaskError('Github comment body was not provided');

			return false;
		}

		$commentBody = $this->githubCommentBody;

		// If an image URL exists, it's attached to the comment body
		if (!empty($this->uploadedImagesURLs))
		{
			foreach ($this->uploadedImagesURLs as $image)
			{
				$commentBody .= '<br />![Screenshot](' . $image . ')';
			}
		}

		$repositoryOwner = $repoMatches[1];
		$repositoryName = $repoMatches[2];

		try
		{
			$github = new \Github\Client;
			$github->authenticate($this->githubToken, \Github\Client::AUTH_HTTP_TOKEN);
			$github
				->api('issue')
				->comments()->create(
					$repositoryOwner, $repositoryName, $this->githubPR,
					array(
						'body'  => $commentBody
					)
				);
		}
		catch (\Exception $e)
		{
			$this->printTaskError('Github comment could not be added due to an error: ' . $e->getMessage());

			return false;
		}

		return true;
	}

	/**
	 * Given a certain folder, it returns an array of images to upload from it
	 *
	 * @param   string  $folder  Folder with images to upload
	 *
	 * @return  array | false
	 *
	 * @since   1.0.0
	 */
	private function searchImagesToUpload($folder)
	{
		if (!file_exists($folder) || !is_dir($folder))
		{
			return false;
		}

		$images = array();
		$handler = opendir($folder);

		while (false !== ($file = readdir($handler)))
		{
			// Avoid sending system files or html files
			if (!(in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'png'])))
			{
				continue;
			}

			$images[] = $folder . '/' . $file;
		}

		return $images;
	}
}
