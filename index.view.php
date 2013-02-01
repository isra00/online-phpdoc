<?php include 'header.view.php' ?>

<img src="<?php print $user_data['avatar_url'] ?>" alt="<?php print $user_data['name'] ?>" />
<h1>Hi, <?php print $user_data['name'] ?></h1>

These are your public repos:

<table>
  <tbody>
  <?php foreach ($repos as $repo) : ?>
    <tr>
      <td><?php print $repo['name'] ?></td>
      <td>
        <?php if ($repo['is_tracking']) : ?>
        Docs up to date. <a href="">View docs</a>
        <?php else : ?>
        Not tracking. <a href="">Start tracking</a>.
        <?php endif ?>
      </td>
  <?php endforeach ?>
  </tbody>
</table>
