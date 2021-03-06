<?php
include('_header.php');

$update = getUpdate($_GET['file']);	

if($_POST) {

	$file = buildFile();
	$newFileName = getFileName($_POST['date'], $_POST['title']);

	// delete current Markdown file
	unlink($updates_dir . $_GET['file']);

	// write new Markdown file
	file_put_contents($updates_dir . $newFileName, $file);
	chmod($updates_dir . $newFileName, 0755);

	//echo "<textarea style='width: 100%; height: 500px;'>";
	//echo $file;
	//echo "</textarea>";

	echo "<script>location.href = location.pathname + '?file=". $newFileName ."';</script>";

}

?>

<form action="" method="post">
	<fieldset>
		<legend>Metadata</legend>
		<div>
			<label for="published">Published</label>
			<div>
				<input type="radio" name="published" value="true" <?php if($update['page']->fetch('published')) { echo "checked"; } ?>> True
				<input type="radio" name="published" value="false" <?php if(!$update['page']->fetch('published')) { echo "checked"; } ?>> False
			</div>
		</div>
		<div>
			<label for="type">Type</label>
			<div>
				<input type="radio" name="type" id="type-news" value="news" <?php if($update['page']->fetch('type') == 'news') { echo "checked"; } ?>> News
				<input type="radio" name="type" id="type-tip" value="tip" <?php if($update['page']->fetch('type') == 'tip') { echo "checked"; } ?>> Tip
			</div>
		</div>
		<div>
			<label for="product">Product</label>
			<div>
				<input type="radio" name="product" value="none" <?php if(!$update['page']->fetch('product')) { echo "checked"; } ?>> None
				<input type="radio" name="product" value="chrome" <?php if($update['page']->fetch('product') == 'chrome') { echo "checked"; } ?>> Chrome
				<input type="radio" name="product" value="chrome-devtools" <?php if($update['page']->fetch('product') == 'chrome-devtools') { echo "checked"; } ?>> DevTools
				<input type="radio" name="product" value="web-starter-kit" <?php if($update['page']->fetch('product') == 'web-starter-kit') { echo "checked"; } ?>> WSK
				<input type="radio" name="product" value="polymer-starter-kit" <?php if($update['page']->fetch('product') == 'polymer-starter-kit') { echo "checked"; } ?>> PSK
				<input type="radio" name="product" value="material-design-lite" <?php if($update['page']->fetch('product') == 'material-design-lite') { echo "checked"; } ?>> MDL
			</div>
		</div>
		<div>
			<label for="title">Title *</label>
			<input type="text" id="title" name="title" value="<?= $update['page']->fetch('title') ?>">
		</div>
		<div id="description-block">
			<label for="description">Description *</label>
			<input type="text" id="description" name="description" value="<?= $update['page']->keyExists('description') ? $update['page']->fetch('description') : '' ?>">
		</div>
		<div id="featured-image-block">
			<label for="featured-image">Featured Image</label>
			<input type="text" id="featured-image" name="featured-image" value="<?= $update['page']->keyExists('featured-image') ? $update['page']->fetch('featured-image') : '' ?>">
		</div>
		<div>
			<label for="author">Author *</label>
			<input type="text" id="author" name="author" value="<?= $update['page']->fetch('authors')[0] ?>">
		</div>
		<div>
			<label for="date">Date *</label>
			<input type="date" id="date" name="date" value="<?= $update['page']->fetch('date') ?>">
		</div>
		<div>
			<label for="tags">Tags (Comma separated)</label>
			<input type="text" id="tags" name="tags" value="<?= $update['page']->keyExists('tags') ? implode(', ', $update['page']->fetch('tags')) : '' ?>">
		</div>
		<div>
			<label for="tags">Source Name (i.e. A List Apart)</label>
			<input type="text" id="source_name" name="source_name" value="<?= $update['page']->keyExists('source_name') ? $update['page']->fetch('source_name') : '' ?>">
		</div>
		<div>
			<label for="tags">Source URL</label>
			<input type="text" id="source_url" name="source_url" value="<?= $update['page']->keyExists('source_url') ? $update['page']->fetch('source_url') : '' ?>">
		</div>

	</fieldset>

	<fieldset>
		<legend>Content</legend>
		<div>
			<div>Current (does not live update, reference only)</div>
			<div>Content</div>
		</div>
		<div>
			<iframe src="http://localhost:8081/web<?= $update['page']->fetch('permalink') ?>" frameborder="0"></iframe>
			<textarea name="content" id="content"><?= htmlentities($update['page']->fetch('content'), ENT_QUOTES, "UTF-8") ?></textarea>
		</div>
	</fieldset>

	<input id="submit" type="submit" value="Save Changes">
</form>

			<script>
			function typeChange() {
				if(document.getElementById('type-tip').checked) {
					document.getElementById('description-block').style.display = 'none';
					document.getElementById('featured-image-block').style.display = 'none';
				} else {
					document.getElementById('description-block').style.display = '';
					document.getElementById('featured-image-block').style.display = '';
				}
			}

			document.getElementById('type-tip').onchange = function() {
				typeChange();
			};

			document.getElementById('type-news').onchange = function() {
				typeChange();
			};

			typeChange();
			</script>

<?php
include('_footer.php');
?>
