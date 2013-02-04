<?php

include 'init.php';

$user_data = $_SESSION['github']['user_data'];
$github_repos = github_api('user/repos');

$repos = array();

foreach ($github_repos as &$repo) {
  /*
   * 'language' JSON attribute does not work sometimes, so we look for languages 
   * lines stats
   */
  if ($repo['language'] != 'PHP')
  {
    $repo_languages = github_api('repos/' . $repo['full_name'] . '/languages');
    if (false !== array_search('PHP', array_keys($repo_languages)))
    {
      $repo['language'] = 'php';
    }
  }
  
  $r = array(
    'service'        => 'github',
    'location'       => $repo['full_name'],
    'name'           => $repo['name'],
    'lang'           => strtolower($repo['language']),
    'url_start'      => 'start.php?' . http_build_query(array('service' => 'github', 'location' => $repo['full_name'])),
  );
  
  $db_repo = db_search_repo('github', $repo['full_name']);
  
  $r['is_tracking'] = false;
  
  if (!empty($db_repo)) {
    $r['is_tracking'] = true;
    $r = array_merge($r, $db_repo);
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
