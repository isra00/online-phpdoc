<?php

include 'init.php';

$user_data = $_SESSION['github']['user_data'];
$github_repos = github_api('user/repos');

$repos = array();

foreach ($github_repos as &$repo) {
  /*
   * Possible status:
   *  - Not tracking
   *  - Tracking and up-to-date (succesfully generated docs for the last changeset)
   *  - Tracking but not up-to-date (no docs or last docs belong to an old changeset)
   */
  
  $r = array(
    'service'        => 'github',
    'location'       => $repo['full_name'],
    'name'           => $repo['name'],
    'lang'           => strtolower($repo['language']),
    'url_start'      => 'start.php?' . http_build_query(array('service' => 'github', 'location' => $repo['full_name'])),
  );
  
  $db_repo = db_search_repo('github', $repo['full_name']);
  
  $r['is_tracking'] = false;
  
  if ($db_repo->num_rows) {
    $r['is_tracking'] = true;
    $r = array_merge($r, $db_repo->fetch_assoc());
    $r['url_docs'] = 'docs/' . $repo['full_name'];
  }
  
  $repos[] = $r;
}

include 'index.view.php';
