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

if ($id_repo = db_insert_repo('github', $repo, strtolower($repo_info['language']), $branch_info['commit']['sha']))
{
  if (db_insert_job($id_repo, $branch_info['commit']['sha']))
  {
    header('Location: index.php?notify_new=' . urlencode($repo));
  }
  
  die('An error occurred when registrating a job for generating your docs :(');
}

die('An error occurred when registrating your new repo - sorry!');
