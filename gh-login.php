<?php include 'init.php' ?>
<?php $last_repos = db_get_last_jobs() ?>
<?php include 'header.view.php' ?>
<?php /** @todo usar el parámetro state para mayor seguridad */ ?>

<a href="https://github.com/isra00/online-phpdoc"><img style="position: absolute; top: 0; right: 0; border: 0;" src="/assets/img/github-forkme.png" alt="Fork me on GitHub"></a>
<div class="landing hero-unit">
  <h1>Your phpDocs in the cloud</h1>
  <p>Forget about generating and hosting your PHP code documents. <br>
    Just <strong>one click</strong> and they will be generated automatically from your GitHub repositories.</p>
  <p>
    <a class="btn btn-primary btn-large github-login" href="https://github.com/login/oauth/authorize?client_id=<?php print GITHUB_CLIENT_ID ?>&scope=public_repo" onclick="trackOutboundLink(this, 'Clicks', 'github-login'); return false;">
      <span>Choose your repositories</span>
    </a>
  </p>

  <?php if (!empty($last_repos)) : ?>
  <h4>Latest documented projects</h4>
  <ul class="recent">
  <?php foreach ($last_repos as $r) : ?>
    <li><a href="/docs/<?php echo $r ?>"><?php echo $r ?></a></li>
  <?php endforeach ?>
  </ul>
  <?php endif ?>

</div>

<?php include 'footer.view.php' ?>
