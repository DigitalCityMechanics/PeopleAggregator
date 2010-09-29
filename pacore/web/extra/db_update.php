<?php
/** !
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* [filename] is a part of PeopleAggregator.
* [description including history]
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
* @author [creator, or "Original Author"]
* @license http://bit.ly/aVWqRV PayAsYouGo License
* @copyright Copyright (c) 2010 Broadband Mechanics
* @package PeopleAggregator
*/
?>
<?php
// if a paproject db_update.php file exists, include it instead
if (file_exists(PA::$project_dir.'/web/extra/project_db_update_page.class.php')) {
	require_once(PA::$project_dir.'/web/extra/project_db_update_page.class.php');
} else {
	require_once PA::$core_dir . "/web/extra/db_update_page.class.php";
}

  $running_from_script = false;
  $is_quiet = db_update_page::check_quiet();
  if(false !== strpos($_SERVER['SCRIPT_NAME'], 'run_scripts.php')) {
    $running_from_script = true;
//    echo "SCRIPT:" . $_SERVER['SCRIPT_NAME'] . "<br>";
  }

  if(!$is_quiet && $running_from_script) { ?>
   <html>
     <head>
       <link rel="stylesheet" type="text/css" href="/extra/update.css" media="screen" />
     </head>
     <body>
       <table>
  <?php }

  if (!$is_quiet) {
    echo "<tr><td>Update PeopleAggregator CORE database schema</td><td style='color: blue'>INFO</td></tr>";
  }

  $p = (class_exists('project_db_update_page')) ? new project_db_update_page() : new db_update_page();
  $p->main();

  if(!$is_quiet && $running_from_script) { ?>
        </table>
      </body>
    </html>
  <?php }

?>
