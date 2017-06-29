<?php foreach ($authors as $author): ?>
	<input type="checkbox" name="author_ids[]" 
		value="<?php echo $author->ID; ?>"
		<?php if(in_array($author->ID, (array) $authorIds)) echo "checked" ?>>
		&nbsp;<?php echo $author->post_title; ?><br>
<?php endforeach; ?>