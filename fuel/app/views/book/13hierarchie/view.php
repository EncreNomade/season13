<h2>Viewing #<?php echo $book_13hierarchie->id; ?></h2>

<p>
	<strong>Epid:</strong>
	<?php echo $book_13hierarchie->epid; ?></p>
<p>
	<strong>Belongto:</strong>
	<?php echo $book_13hierarchie->belongto; ?></p>
<p>
	<strong>Relation type:</strong>
	<?php echo $book_13hierarchie->relation_type; ?></p>
<p>
	<strong>Extra:</strong>
	<?php echo $book_13hierarchie->extra; ?></p>

<?php echo Html::anchor('book/13hierarchie/edit/'.$book_13hierarchie->id, 'Edit'); ?> |
<?php echo Html::anchor('book/13hierarchie', 'Back'); ?>