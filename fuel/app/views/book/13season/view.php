<h2>Viewing #<?php echo $book_13season->id; ?></h2>

<p>
	<strong>Reference:</strong>
	<?php echo $book_13season->reference; ?></p>
<p>
	<strong>Book id:</strong>
	<?php echo $book_13season->book_id; ?></p>
<p>
	<strong>Season id:</strong>
	<?php echo $book_13season->season_id; ?></p>
<p>
	<strong>Title:</strong>
	<?php echo $book_13season->title; ?></p>
<p>
	<strong>Cover:</strong>
	<?php echo $book_13season->cover; ?></p>
<p>
	<strong>Extra info:</strong>
	<?php echo $book_13season->extra_info; ?></p>

<?php echo Html::anchor('book/13season/edit/'.$book_13season->id, 'Edit'); ?> |
<?php echo Html::anchor('book/13season', 'Back'); ?>