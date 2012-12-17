<h2>Viewing #<?php echo $book_13game->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $book_13game->name; ?></p>
<p>
	<strong>Epid:</strong>
	<?php echo $book_13game->epid; ?></p>
<p>
	<strong>Expo:</strong>
	<?php echo $book_13game->expo; ?></p>
<p>
	<strong>Instruction:</strong>
	<?php echo $book_13game->instruction; ?></p>
<p>
	<strong>Presentation:</strong>
	<?php echo $book_13game->presentation; ?></p>
<p>
	<strong>Categories:</strong>
	<?php echo $book_13game->categories; ?></p>
<p>
	<strong>Metas:</strong>
	<?php echo $book_13game->metas; ?></p>

<?php echo Html::anchor('book/13game/edit/'.$book_13game->id, 'Edit'); ?> |
<?php echo Html::anchor('book/13game', 'Back'); ?>