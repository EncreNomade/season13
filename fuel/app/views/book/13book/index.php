<h2>Listing Book_13books</h2>
<br>
<?php if ($book_13books): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Reference</th>
			<th>Title</th>
			<th>Sub title</th>
			<th>Cover</th>
			<th>Author id</th>
			<th>Brief</th>
			<th>Tags</th>
			<th>Categories</th>
			<th>Extra info</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($book_13books as $book_13book): ?>		<tr>

			<td><?php echo $book_13book->reference; ?></td>
			<td><?php echo $book_13book->title; ?></td>
			<td><?php echo $book_13book->sub_title; ?></td>
			<td><?php echo $book_13book->cover; ?></td>
			<td><?php echo $book_13book->author_id; ?></td>
			<td><?php echo $book_13book->brief; ?></td>
			<td><?php echo $book_13book->tags; ?></td>
			<td><?php echo $book_13book->categories; ?></td>
			<td><?php echo $book_13book->extra_info; ?></td>
			<td>
				<?php echo Html::anchor('book/13book/view/'.$book_13book->id, 'View'); ?> |
				<?php echo Html::anchor('book/13book/edit/'.$book_13book->id, 'Edit'); ?> |
				<?php echo Html::anchor('book/13book/delete/'.$book_13book->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Book_13books.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('book/13book/create', 'Add new Book 13book', array('class' => 'btn btn-success')); ?>

</p>
