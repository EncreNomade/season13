<h2>Viewing #<?php echo $book_13author->id; ?></h2>

<p>
	<strong>Firstname:</strong>
	<?php echo $book_13author->firstname; ?></p>
<p>
	<strong>Lastname:</strong>
	<?php echo $book_13author->lastname; ?></p>
<p>
	<strong>Nickname:</strong>
	<?php echo $book_13author->nickname; ?></p>
<p>
	<strong>Biographie:</strong>
	<?php echo $book_13author->biographie; ?></p>
<p>
	<strong>Photo:</strong>
	<?php echo $book_13author->photo; ?></p>
<p>
	<strong>Author slogan:</strong>
	<?php echo $book_13author->author_slogan; ?></p>
<p>
	<strong>Metas:</strong>
	<?php echo $book_13author->metas; ?></p>

<?php echo Html::anchor('book/13author/edit/'.$book_13author->id, 'Edit'); ?> |
<?php echo Html::anchor('book/13author', 'Back'); ?>