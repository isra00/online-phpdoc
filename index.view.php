<?php include 'header.view.php' ?>

<div class="main">
  <div class="header">
    <img src="<?php print $user_data['avatar_url'] ?>" alt="<?php print $user_data['name'] ?>" style="float: left; margin: 0 1em 1em 0" />
    <h1>Hi, <?php print $user_data['name'] ?></h1>
  </div>

  <?php if (isset($_GET['notify_new'])) : ?>
  <div class="alert alert-success">
    Congrats! Your repo <?php print $_GET['notify_new'] ?> has been registered. Your docs will be available soon. Be patient!
  </div>
  <?php endif ?>

  <table class="repo-list table">
    <caption>These are your public repositories. If you click on Start tracking for a project, we will generate the phpDoc each time you push code to the repository.</caption>
    <tbody>
    <?php foreach ($repos as $repo) : ?>
      <tr>
        <td class="repo">
          <?php if ($repo['is_tracking'] && 'updated' == $repo['doc_status']) : ?>
          <h5><a href="<?php print $repo['url_docs'] ?>"><?php print $repo['name'] ?></a></h5>
          <?php else : ?>
            <h5><?php print $repo['name'] ?></h5>
          <?php endif ?>
          <span class="badge"><?php print $repo['lang'] ?></span>
        </td>
        <td>
          <?php print $repo['status_display'] ?>
        </td>
    <?php endforeach ?>
    </tbody>
  </table>

</div>