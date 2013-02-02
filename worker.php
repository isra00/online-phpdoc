<?php

/**
 *
 * WARNING! The environment variables requested in config.php must be set in
 * the environment of the user executing the worker (export command).
 */

/*
 * @todo Cambiar repo.status(fail) por 'outdated', ya que el repo en sí no 
 * falla. Si un job falla, se usa la doc anterior, por tanto el repo siempre
 * está correcto, aunque puede estar desactualizado si el último job falló. Hay
 * una excepción a esto: si el primer trabajo al registrar el repo falla, 
 * debería quedar en estado new o algo así 
 */

include 'config.php';
require 'db.php';
require 'misc.php';

//Init DB
$db_conn = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);

$job = db_select_pending_job();

if (!$job)
{
  exit(1);
}

echo "Starting job #" . $job['id_job'] . "...\n";

db_update_job_status($job['id_job'], 'generating');
db_update_repo_status($job['id_repo'], 'generating');

list($user, $repo) = explode('/', $job['location']);

/*
 * Grab the latest code
 * @todo Repensar si es necesario el hash del changeset...
 */
$repos_dir = __DIR__ . '/repos';
$repo_dir = "$repos_dir/$user/$repo";

if (file_exists($repo_dir . '/.git'))
{
  //If the repo is already cloned, update it
  $cmd = command("cd $repo_dir && git pull 2>&1");
}
else
{
  $cmd = command("cd $repos_dir && git clone git://github.com/$user/$repo.git $user/$repo 2>&1");
}

/*
 * Generate the phpDoc
 */
 
$docs_dir = __DIR__ . '/docs';
$doc_dir = "$docs_dir/$user/$repo";

/** @todo Do not remove the old docs until the new ones are succcesfully generated */
if (file_exists($doc_dir))
{
  command("rm -rf $doc_dir");
}

/** @todo Store in a temporary dir, then remove the old docs if phpdoc returned success, and then move the new ones */
$cmd = command("phpdoc --extensions php --ignore-symlinks --defaultpackagename $user/$repo -d $repo_dir -t $doc_dir");

if (0 == $cmd->return_code)
{
  db_update_job_status($job['id_job'], 'done');
  db_update_repo_status($job['id_repo'], 'updated');
  
  echo 'Succeed job #' . $job['id_job'];
}
else
{
  db_update_job_status($job['id_job'], 'fail');
  db_update_repo_status($job['id_repo'], 'fail');
  
  echo 'Failed job #' . $job['id_job'];
}

exit(0);
