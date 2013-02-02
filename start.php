<?php

include 'init.php';

if (!isset($_GET['service']) || !isset($_GET['location']))
{
  header('Status: 400 Bad Request');
  die;
}

$repo = $_GET['location'];

if (!$repo_info = github_api("repos/$repo"))
{
  die('The requested repo does not exist');
}

if ($repo_info['owner']['login'] != $_SESSION['github']['user_data']['login'])
{
  die('Seems like you are not the owner of the requested repo.');
}

$branch_info = github_api("repos/$repo/branches/master");

if ($inserted_repo = db_insert_repo('github', $repo, strtolower($repo_info['language']), $branch_info['commit']['sha']))
{
  //Create a job for the first docs
  if (!db_insert_job($inserted_repo['id_repo'], $branch_info['commit']['sha']))
  {
    die('An error occurred when registrating a job for generating your docs :(');
  }
  
  //Declare the web hook so GitHub will notify every push in the repo
  $resp = github_api("repos/$repo/hooks", array(
      'name'   => 'web',
      'active' => true,
      'events' => array('push'),
      'config' => array(
          'url'          => GITHUB_HOOK_URL,
          'content_type' => 'json',
          'secret'       => $inserted_repo['secret']
      )
  ));
  
  header('Location: index.php?notify_new=' . urlencode($repo));
}

die('An error occurred when registrating your new repo - sorry!');
