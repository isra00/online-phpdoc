<?php include 'init.php' ?>
<?php include 'header.view.php' ?>
<?php /** @todo usar el parámetro state para mayor seguridad */ ?>

<?php include 'header.view.php' ?>

<div class="landing hero-unit">
  <h1>Your phpDocs in the cloud</h1>
  <p>Forget about generating and hosting your PHP code documents. <br>
    Just <strong>one click</strong> and they will be generated automatically from your GitHub repositories.</p>
  <p>
    <a class="btn btn-primary btn-large github-login" href="https://github.com/login/oauth/authorize?client_id=<?php print GITHUB_CLIENT_ID ?>&scope=public_repo" onclick="trackOutboundLink(this, 'Clicks', 'github-login', 'landing', 'hero-button'); return false;">
      <span>Log-in with GitHub</span>
    </a>
  </p>
</div>
