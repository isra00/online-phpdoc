<?php include 'header.view.php' ?>

<div class="header">
  <img src="<?php print $user_data['avatar_url'] ?>" alt="<?php print $user_data['name'] ?>" style="float: left; margin: 0 1em 1em 0" />
  <h1>Hi, <?php print $user_data['name'] ?></h1>
</div>

<?php if (isset($_GET['notify_new'])) : ?>
<div class="notify success">
  <p>Congrats! Your repo <?php print $_GET['notify_new'] ?> has been registered. Your docs will be available soon. Be patient!</p>
</div>
<?php endif ?>

<p style="clear: both">These are your public repositories. If you click on Start tracking for a project, we will generate the phpDoc each time you push code to the repository.</p>

<table class="repo-list">
  <tbody>
  <?php foreach ($repos as $repo) : ?>
    <tr>
      <td>
        <?php if ($repo['is_tracking'] && 'updated' == $repo['doc_status']) : ?>
          <a href="<?php print $repo['url_docs'] ?>"><?php print $repo['name'] ?></a>
        <?php else : ?>
          <?php print $repo['name'] ?>
        <?php endif ?>
        (<?php print $repo['lang'] ?>)
      </td>
      <td>
        <?php print $repo['status_display'] ?>
      </td>
  <?php endforeach ?>
  </tbody>
</table>
