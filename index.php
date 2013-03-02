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
    if ($repo_languages = github_api('repos/' . $repo['full_name'] . '/languages'))
    {
      if (false !== array_search('PHP', array_keys($repo_languages)))
      {
        $repo['language'] = 'php';
      }
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

  $r['status_display'] = '<abbr title="Only PHP projects can be tracked by now">Not supported</abbr>';

  if ($r['lang'] == 'php')
  {
    $r['status_display'] = '<a class="btn btn-primary" href="' . $r['url_start'] . '">Start tracking</a>';
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
        $r['status_display'] = '<span class="badge badge-info">Generating right now</span>';
        break;
      case 'fail':
        $r['status_display'] = '<span class="error">failed</span>';
        break;
    }
  }

  $repos[] = $r;
}

// Order by repo name, tracked repos first
usort($repos, function($a, $b) {
  if ($a['is_tracking'] == $b['is_tracking'])
  {
    return strcasecmp($a['location'], $b['location']);
  }
  else
  {
    return $a['is_tracking'] ? -1 : 1;
  }
});

include 'index.view.php';
