<h2>Listing Book_13authors</h2>
<br>
<?php if ($book_13authors): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Firstname</th>
			<th>Lastname</th>
			<th>Nickname</th>
			<th>Biographie</th>
			<th>Photo</th>
			<th>Author slogan</th>
			<th>Metas</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($book_13authors as $book_13author): ?>		<tr>

			<td><?php echo $book_13author->firstname; ?></td>
			<td><?php echo $book_13author->lastname; ?></td>
			<td><?php echo $book_13author->nickname; ?></td>
			<td><?php echo $book_13author->biographie; ?></td>
			<td><?php echo $book_13author->photo; ?></td>
			<td><?php echo $book_13author->author_slogan; ?></td>
			<td><?php echo $book_13author->metas; ?></td>
			<td>
				<?php echo Html::anchor('book/13author/view/'.$book_13author->id, 'View'); ?> |
				<?php echo Html::anchor('book/13author/edit/'.$book_13author->id, 'Edit'); ?> |
				<?php echo Html::anchor('book/13author/delete/'.$book_13author->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Book_13authors.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('book/13author/create', 'Add new Book 13author', array('class' => 'btn btn-success')); ?>

</p>
