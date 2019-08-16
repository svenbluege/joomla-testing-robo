# Joomla Testing Robo tasks
Swiss knife for adding automated tests to your Joomla extensions, using Robo.li for task definition.

## Installation

* composer install

## Commands

All the included commands have setters and actual functions to be executed (using the previous setters).  They are made to be stacked and executed by the robo `run()` command in the end.

### SeleniumStandaloneServer

Allows executing tasks related to a Selenium Server (not included) 

#### Setters:

* **setBinary($binary):** sets the location of the Selenium Server binary file.  Default: *vendor/bin/selenium-server-standalone*
* **setURL($url):** sets the URL of the Selenium Server.  Default: *http://localhost:4444*
* **setDebug($debug = true):** Sets *-debug* option for Selenium server when set to true
* **setLogFile($logFile):** Defines a single log file for the Selenium server execution.  Default: *selenium.log*
* **setTimeOut($seconds):** Sets a timeout to wait for the server to actually run when it's executed.  Default: *60*
* **setWebdriver($name):** Allows setting a named webdriver to run the selenium tests on

#### Functions

* **runSelenium():** Runs the selenium server.
* **waitForSelenium():** Waits for the selenium server to run, using the timeout defined in *setTimeout*
* **killSelenium():** Kills the Selenium Server using the provided URL in *setURL* (or the default one)

#### Examples

Setting up the Selenium Server:
```
$this->taskSeleniumStandaloneServer()
    ->setBinary('<path>/selenium-server-standalone')

    ->runSelenium()
    ->waitForSelenium()

    ->run()
    ->stopOnFail();
```

Killing the Selenium Server:
```
$this->taskSeleniumStandaloneServer()

    ->killSelenium()

    ->run();
```

### CMSSetup

Tasks for setting up the CMS to make it available for testing.

#### Setters

* **setBaseTestsPath($baseTestsPath):** sets the path of the tests folder. **(required)** 
* **setCmsRepository($cmsRepository):** Sets the Github owner/client combination for the CMS repository to use for cloning.  Default: *joomla/joomla-cms*
* **setCmsPath($cmsPath):** Sets the actual path where the CMS will be installed (Apache folder).  Default: *joomla*
* **setCachePath($cachePath):** Sets the path where the CMS will be cached.  Default: *cache* 
* **setCmsBranch($cmsBranch):** Sets the Joomla! branch to clone (based on the repository tags).  Default: *staging*
* **setCmsCache($cmsCacheTime):** Sets the CMS cache time (in seconds).  Default: 86400
* **setExecuteUser($executeUser):** Defines a user to change permissions to, if required.
* **setCertificatesPath($path):** Defines a path with the extra certificates to be added to the Joomla install, if needed. 

#### Functions

* **cloneCMSRepository()**: Clones the repository given the test folder, cache and repository details.
* **setupCMSPath()**: Actually sets up the CMS using the cache. 
* **fixPathPermissions()**: Fixes any permission problem by setting the owner given in *setExecuteUser*.
* **setupHtAccess()**: Sets up the .htaccess file when invoked
* **appendCertificates()**: Appends the certificates using the certificate path.  This is needed for some environments like Travis, so Joomla will not have problems installing extra languages.

#### Examples

Simple set up of Joomla CMS:
```
$this->taskCMSSetup()
    ->setBaseTestsPath(__DIR__ . '/tests')

    ->cloneCMSRepository()
    ->setupCMSPath()

    ->run()
    ->stopOnFail();
```

### ApplicationSetup

Functions to set up the actual application.

#### Setters

* **setPackageCommand($packageCommand):** Sets the command to be executed for creating a package of the application.  Default: *gulp release*
* **setPackageArgs($packageArgs):** Sets the arguments to be sent to the package.  Default: *--skip-version*

#### Functions

* **packageApplication():** Executes the application packager using the given parameters.

#### Examples

Packaging the application:
```
$this->taskApplicationSetup()

    ->packageApplication()

    ->run()
    ->stopOnFail();
```

### Reporting

Methods to report back failures

#### Setters

* **setCloudinaryCloudName($cloudinaryCloudName):**  Sets up a Cloudinary cloud to have error images uploaded.
* **setCloudinaryApiKey($cloudinaryApiKey):**  Sets up the Cloudinary API key.  
* **setCloudinaryApiSecret($cloudinaryApiSecret):**  Sets up the Cloudinary API secret.
* **setImagesToUpload($images):** Sets an array of images to be uploaded by Cloudinary
* **setFolderImagesToUpload($path):** Sets a full folder with images to be uploaded by Cloudinary
* **setGithubToken($githubToken):**  Sets up the Github token to make reporting errors done to the Github Pull Request.  
* **setGithubRepo($githubRepo):**  Sets the owner/repo combination of the Github repository.  
* **setGithubPR($githubPR):**  Sets the number of the Github Pull Request.
* **setUploadedImagesURLs($uploadedImagesURLs):** When not using Cloudinary, allows setting up the array of image URLs to be appended to the comment in the PR.  
* **setGithubCommentBody($githubCommentBody):** Sets the error message to be sent to Github.  If there are any uploaded image URLs (or generated by Cloudinary) they will be appended at the end.

#### Functions

* **publishCloudinaryImages():** Executes the actual push of the images to Cloudinary, and sets them up to be appended it to the PR comment when invoking the task.
* **publishGithubCommentToPR():** Comments in Github, using the comment body and optionally the uploaded image URLs.

#### Examples

Actual reporting done to a Github PR, including an image:

```
$this->taskReporting()
    ->setCloudinaryCloudName('<cloud>')
    ->setCloudinaryApiKey('<api key>')
    ->setCloudinaryApiSecret('<api secret>')
    ->setGithubToken('<github token>')
    ->setGithubRepo('<owner/repo>')
    ->setGithubPR('<PR #>')
    ->setImagesToUpload([
        '/path/to/image',
        '/path/to/image'
    [)
    ->setGithubCommentBody('<Error comment>')

    ->publishCloudinaryImages()
    ->publishGithubCommentToPR()

    ->run()
    ->stopOnFail();

```

### CodeChecks

Performs included code tests

#### Setters

* **setBaseRepositoryPath($baseRepositoryPath):** Sets up the base repository path where tests will be executed.  **Required**
* **setParseErrorsCheckFolders($parseErrorsCheckFolders):**  Array of folders to check for parse errors in. 
* **setPhpExecutable($phpExecutable):** Sets the php executable command.  Default: *php*
* **setDebugLeftoversFolders($debugLeftoversFolders):** Sets the folders to check for debug leftovers 
* **setCodeStyleStandardsFolder($codeStyleStandardsFolder):** Sets the folder where code style definitions are going to be downloaded/stored (using the repository). 
* **setCodeStyleStandardsRepo($codeStyleStandardsRepo):** Sets the Github repository (owner/repo) with code style definitions, to download it.  Default: *joomla/coding-standards* 
* **setCodeStyleStandardsBranch($codeStyleStandardsBranch):**  Branch of the coding standards repository to use.  Default: *master* 
* **setCodeStyleCheckFolders($codeStyleCheckFolders):**  Folders to perform the code style check in. 
* **setCodeStyleExcludedPaths($codeStyleExcludedPaths):** Array of paths (files/folders/path patterns) to exclude from the code style checking. 

#### Functions

* **checkForParseErrors():** Performs the parse error checking.
* **checkForDebugLeftovers():** Performs the debug leftovers check, to look for *var_dump* or *console_log* leftovers.
* **checkCodeStyle():**  Performs the code style checking (phpcs), by downloading the standards from Github.

#### Examples

Executing parse errors check
```
$this->taskCodeChecks()
    ->setBaseRepositoryPath(<base repository path>)
    ->setParseErrorsCheckFolders(<array of folders to check>)
    ->checkForParseErrors()
    ->run();
```

Debug leftovers check
```
$this->taskCodeChecks()
    ->setBaseRepositoryPath(<base repository path>)
    ->setDebugLeftoversFolders(<array of folders to check>)
    ->checkForDebugLeftovers()
    ->run();
```

Code style check
```
$this->taskCodeChecks()
    ->setBaseRepositoryPath(<base repository path>)
    ->setCodeStyleCheckFolders(<array of folders to check>)
    ->checkCodeStyle()
    ->run();
```
