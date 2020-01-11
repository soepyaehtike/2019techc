<?php
session_start();
// 接続 ref. https://www.php.net/manual/ja/pdo.connections.php
$dbh = new PDO('mysql:host=database-1.c3ugrn9uhxji.us-east-1.rds.amazonaws.com;dbname=profile_page', 'admin', 'Soe15262');

// 行の中身を取る
$select_sth = $dbh->prepare('SELECT name, body, created_at, filename FROM bbs ORDER BY id ASC');
$select_sth->execute();
$rows = $select_sth->fetchAll();
?>
<?php foreach ($rows as $row) : ?>
<div>
    <span><?php if ($row['name']) { echo $row['name']; } else { echo "名無し"; } ?>さんの投稿 (投稿日: <?php echo $row['created_at']; ?>)</span>
    <p>
	<?php echo $row['body']; ?>
	
    </p>
	<?php if (!empty($row['filename'])) { ?>
	<p>
	<img src="/static/images/<?php echo $row['filename']; ?>" width="200px">
	</p>
	<?php } ?>
</div>  
<?php endforeach; ?>

<?php if(empty($_SESSION['user_login_name'])): ?>
ログインしないと投稿できません。ログインは<a href="./login_form.php">こちら</a>。
<?php else: ?>
<form method="POST" action="./bbs_write.php" enctype="multipart/form-data">
    <div>
        名前: <?php echo($_SESSION['user_login_name']) ?>
        <input type="file" name="upload_image">
    </div>  
    <div>
        <textarea name="body" rows="5" cols="100" required></textarea>
    </div>  
    <input type="submit">
</form>
<?php endif; ?>
