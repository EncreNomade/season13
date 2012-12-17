<h2>Viewing #<?php echo $book_13book->id; ?></h2>

<p>
	<strong>Reference:</strong>
	<?php echo $book_13book->reference; ?></p>
<p>
	<strong>Title:</strong>
	<?php echo $book_13book->title; ?></p>
<p>
	<strong>Sub title:</strong>
	<?php echo $book_13book->sub_title; ?></p>
<p>
	<strong>Cover:</strong>
	<?php echo $book_13book->cover; ?></p>
<p>
	<strong>Author id:</strong>
	<?php echo $book_13book->author_id; ?></p>
<p>
	<strong>Brief:</strong>
	<?php echo $book_13book->brief; ?></p>
<p>
	<strong>Tags:</strong>
	<?php echo $book_13book->tags; ?></p>
<p>
	<strong>Categories:</strong>
	<?php echo $book_13book->categories; ?></p>
<p>
	<strong>Extra info:</strong>
	<?php echo $book_13book->extra_info; ?></p>

<?php echo Html::anchor('book/13book/edit/'.$book_13book->id, 'Edit'); ?> |
<?php echo Html::anchor('book/13book', 'Back'); ?>