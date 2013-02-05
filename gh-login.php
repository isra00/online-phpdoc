<?php include 'init.php' ?>
<?php include 'header.view.php' ?>
<?php /** @todo usar el parámetro state para mayor seguridad */ ?>
<a href="https://github.com/login/oauth/authorize?client_id=<?php print GITHUB_CLIENT_ID ?>&scope=public_repo">Log-in with GitHub</a>
