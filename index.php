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
  
  $r['status_display'] = '<abbr title="Only PHP projects can be tracked by now">Not PHP</abbr>';
  
  if ($r['lang'] == 'php')
  {
    $r['status_display'] = '<a href="' . $r['url_start'] . '">Start tracking</a>';
  }
  
  if (isset($r['doc_status']))
  {
    switch ($r['doc_status'])
    {
      case 'waiting':
        $r['status_display'] = 'Waiting in the queue';
        break;
      case 'updated':
        $r['status_display'] = 'Generated ' . $r['last_update'];
        break;
      case 'generating':
        $r['status_display'] = 'Generating right now';
        break;
      case 'fail':
        $r['status_display'] = '<span class="error">failed</span>';
        break;
    }
  }
  
  $repos[] = $r;
}

include 'index.view.php';
