<?php
/**
 * Simple PHP Git deploy script
 *
 * Automatically deploy the code using PHP and Git.
 *
 * @version 1.3.1
 * @link    https://github.com/markomarkovic/simple-php-git-deploy/
 */

// =========================================[ Configuration start ]===

/**
 * It's preferable to configure the script using `deploy-config.php` file.
 *
 * Rename `deploy-config.example.php` to `deploy-config.php` and edit the
 * configuration options there instead of here. That way, you won't have to edit
 * the configuration again if you download the new version of `deploy.php`.
 */
if (file_exists(basename(__FILE__, '.php').'-config.php')) {
	define('CONFIG_FILE', basename(__FILE__, '.php').'-config.php');
	require_once CONFIG_FILE;
} else {
	define('CONFIG_FILE', __FILE__);
}

/**
 * Protect the script from unauthorized access by using a secret access token.
 * If it's not present in the access URL as a GET variable named `sat`
 * e.g. deploy.php?sat=Bett...s the script is not going to deploy.
 *
 * @var string
 */
if (!defined('SECRET_ACCESS_TOKEN')) define('SECRET_ACCESS_TOKEN', 'BetterChangeMeNowOrSufferTheConsequences');

/**
 * The address of the remote Git repository that contains the code that's being
 * deployed.
 * If the repository is private, you'll need to use the SSH address.
 *
 * @var string
 */
if (!defined('REMOTE_REPOSITORY')) define('REMOTE_REPOSITORY', 'http://arba:123qweasdzxc@git.nevera.space/Nevera.Space/ARBA.AE.git');

/**
 * The branch that's being deployed.
 * Must be present in the remote repository.
 *
 * @var string
 */
if (!defined('BRANCH')) define('BRANCH', 'production');

/**
 * The location that the code is going to be deployed to.
 * Don't forget the trailing slash!
 *
 * @var string Full path including the trailing slash
 */
if (!defined('ARBA_TARGET_DIR')) define('ARBA_TARGET_DIR', '/home/arba/public_html/ARBA.AE/');

/**
 * Whether to delete the files that are not in the repository but are on the
 * local (server) machine.
 *
 * !!! WARNING !!! This can lead to a serious loss of data if you're not
 * careful. All files that are not in the repository are going to be deleted,
 * except the ones defined in EXCLUDE section.
 * BE CAREFUL!
 *
 * @var boolean
 */
if (!defined('DELETE_FILES')) define('DELETE_FILES', false);

/**
 * The directories and files that are to be excluded when updating the code.
 * Normally, these are the directories containing files that are not part of
 * code base, for example user uploads or server-specific configuration files.
 * Use rsync exclude pattern syntax for each element.
 *
 * @var serialized array of strings
 */
if (!defined('EXCLUDE')) define('EXCLUDE', serialize(array(
	'.git',
)));

/**
 * Temporary directory we'll use to stage the code before the update. If it
 * already exists, script assumes that it contains an already cloned copy of the
 * repository with the correct remote origin and only fetches changes instead of
 * cloning the entire thing.
 *
 * @var string Full path including the trailing slash
 */
if (!defined('ARBA_TMP_DIR')) define('ARBA_TMP_DIR', '/home/arba/public_html/ARBA.AE.tmp/');

/**
 * Whether to remove the ARBA_TMP_DIR after the deployment.
 * It's useful NOT to clean up in order to only fetch changes on the next
 * deployment.
 */
if (!defined('CLEAN_UP')) define('CLEAN_UP', true);

/**
 * Output the version of the deployed code.
 *
 * @var string Full path to the file name
 */
if (!defined('VERSION_FILE')) define('VERSION_FILE', ARBA_TMP_DIR.'VERSION');

/**
 * Time limit for each command.
 *
 * @var int Time in seconds
 */
if (!defined('TIME_LIMIT')) define('TIME_LIMIT', 9999);

/**
 * OPTIONAL
 * Backup the TARGET_DIR into BACKUP_DIR before deployment.
 *
 * @var string Full backup directory path e.g. `/tmp/`
 */
if (!defined('BACKUP_DIR')) define('BACKUP_DIR', false);

/**
 * OPTIONAL
 * Whether to invoke composer after the repository is cloned or changes are
 * fetched. Composer needs to be available on the server machine, installed
 * globaly (as `composer`). See http://getcomposer.org/doc/00-intro.md#globally
 *
 * @var boolean Whether to use composer or not
 * @link http://getcomposer.org/
 */
if (!defined('USE_COMPOSER')) define('USE_COMPOSER', false);

/**
 * OPTIONAL
 * The options that the composer is going to use.
 *
 * @var string Composer options
 * @link http://getcomposer.org/doc/03-cli.md#install
 */
if (!defined('COMPOSER_OPTIONS')) define('COMPOSER_OPTIONS', '--no-dev');

/**
 * OPTIONAL
 * The COMPOSER_HOME environment variable is needed only if the script is
 * executed by a system user that has no HOME defined, e.g. `www-data`.
 *
 * @var string Path to the COMPOSER_HOME e.g. `/tmp/composer`
 * @link https://getcomposer.org/doc/03-cli.md#composer-home
 */
if (!defined('COMPOSER_HOME')) define('COMPOSER_HOME', false);

/**
 * OPTIONAL
 * Email address to be notified on deployment failure.
 *
 * @var string A single email address, or comma separated list of email addresses
 *      e.g. 'someone@example.com' or 'someone@example.com, someone-else@example.com, ...'
 */
if (!defined('EMAIL_ON_ERROR')) define('EMAIL_ON_ERROR', false);

// ===========================================[ Configuration end ]===

ob_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="robots" content="noindex">
	<title>Simple PHP Git deploy script</title>
	<style>
body { padding: 0 1em; background: #222; color: #fff; }
h2, .error { color: #c33; }
.prompt { color: #6be234; }
.command { color: #729fcf; }
.output { color: #999; }
	</style>
</head>
<body>
<pre>

Checking the environment ...

Running as <b><?php echo trim(shell_exec('whoami')); ?></b>.

Environment OK.

Using configuration defined in <?php echo CONFIG_FILE."\n"; ?>

Deploying <?php echo REMOTE_REPOSITORY; ?> <?php echo BRANCH."\n"; ?>
to        <?php echo ARBA_TARGET_DIR; ?> ...

<?php
// The commands
$commands = array();

// ========================================[ Pre-Deployment steps ]===

// ARBA_TMP_DIR exists and hopefully already contains the correct remote origin
// so we'll fetch the changes and reset the contents.
$commands[] = sprintf(
	'git --git-dir="%s.git" --work-tree="%s" fetch --tags origin %s'
	, ARBA_TARGET_DIR
	, ARBA_TARGET_DIR
	, BRANCH
);
$commands[] = sprintf(
	'git --git-dir="%s.git" --work-tree="%s" reset --hard FETCH_HEAD'
	, ARBA_TARGET_DIR
	, ARBA_TARGET_DIR
);

// Update the submodules
$commands[] = sprintf(
	'git submodule update --init --recursive'
);

// Invoke composer
if (defined('USE_COMPOSER') && USE_COMPOSER === true) {
	$commands[] = sprintf(
		'composer --no-ansi --no-interaction --no-progress --working-dir=%s install %s'
		, ARBA_TARGET_DIR
		, (defined('COMPOSER_OPTIONS')) ? COMPOSER_OPTIONS : ''
	);
	if (defined('COMPOSER_HOME') && is_dir(COMPOSER_HOME)) {
		putenv('COMPOSER_HOME='.COMPOSER_HOME);
	}
}

// ==================================================[ Deployment ]===

// Compile exclude parameters
$exclude = '';
foreach (unserialize(EXCLUDE) as $exc) {
	$exclude .= ' --exclude='.$exc;
}

// =======================================[ Run the command steps ]===
$output = '';
foreach ($commands as $command) {
	set_time_limit(TIME_LIMIT); // Reset the time limit for each command
	if (file_exists(ARBA_TARGET_DIR) && is_dir(ARBA_TARGET_DIR)) {
		chdir(ARBA_TARGET_DIR); // Ensure that we're in the right directory
	}
	$tmp = array();
	exec($command.' 2>&1', $tmp, $return_code); // Execute the command
	// Output the result
	printf('
<span class="prompt">$</span> <span class="command">%s</span>
<div class="output">%s</div>
'
		, htmlentities(trim($command))
		, htmlentities(trim(implode("\n", $tmp)))
	);
	$output .= ob_get_contents();
	ob_flush(); // Try to output everything as it happens

	// Error handling and cleanup
	if ($return_code !== 0) {
		header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
		printf('
<div class="error">
Error encountered!
Stopping the script to prevent possible data loss.
CHECK THE DATA IN YOUR TARGET DIR!
</div>
'
		);
		
		$error = sprintf(
			'Deployment error on %s using %s!'
			, $_SERVER['HTTP_HOST']
			, __FILE__
		);
		break;
	}
}
?>

Done.
</pre>
</body>
</html>
