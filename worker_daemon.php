<?php

require 'misc.php';

while (true)
{
  echo ".";

  $cmd = command('php worker.php');
  echo join("\n", $cmd->output);

  if (1 == $cmd->return_code)
  {
    sleep(30);
  }
}
