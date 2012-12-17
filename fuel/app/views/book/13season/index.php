<h2>Listing Book_13seasons</h2>
<br>
<?php if ($book_13seasons): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Reference</th>
			<th>Book id</th>
			<th>Season id</th>
			<th>Title</th>
			<th>Cover</th>
			<th>Extra info</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($book_13seasons as $book_13season): ?>		<tr>

			<td><?php echo $book_13season->reference; ?></td>
			<td><?php echo $book_13season->book_id; ?></td>
			<td><?php echo $book_13season->season_id; ?></td>
			<td><?php echo $book_13season->title; ?></td>
			<td><?php echo $book_13season->cover; ?></td>
			<td><?php echo $book_13season->extra_info; ?></td>
			<td>
				<?php echo Html::anchor('book/13season/view/'.$book_13season->id, 'View'); ?> |
				<?php echo Html::anchor('book/13season/edit/'.$book_13season->id, 'Edit'); ?> |
				<?php echo Html::anchor('book/13season/delete/'.$book_13season->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Book_13seasons.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('book/13season/create', 'Add new Book 13season', array('class' => 'btn btn-success')); ?>

</p>
