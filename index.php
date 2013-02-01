<?php

include 'init.php';

if (empty($_SESSION['github']['access_token'])) {
  header("Location: gh-login.php");
  die;
}

//User GitHub data is stored in Session for better performance
if (!isset($_SESSION['github']['user_data']))
{
  $_SESSION['github']['user_data'] = github_api('user');
}

$user_data = $_SESSION['github']['user_data'];
$user_repos = github_api('user/repos');

$repos = array();

foreach ($user_repos as &$repo) {
  /*
   * Possible status:
   *  - Not tracking
   *  - Tracking and up-to-date (succesfully generated docs for the last changeset)
   *  - Tracking but not up-to-date (no docs or last docs belong to an old changeset)
   */
  $repos[] = array(
    'service'  => 'github',
    'location' => $repo['full_name'],
    'name'     => $repo['name'],
    'is_tracking' => (boolean) db_search_repo('github', $repo['full_name']),
  );
}

include 'index.view.php';
