<h2>Listing Book_13games</h2>
<br>
<?php if ($book_13games): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Epid</th>
			<th>Expo</th>
			<th>Instruction</th>
			<th>Presentation</th>
			<th>Categories</th>
			<th>Metas</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($book_13games as $book_13game): ?>		<tr>

			<td><?php echo $book_13game->name; ?></td>
			<td><?php echo $book_13game->epid; ?></td>
			<td><?php echo $book_13game->expo; ?></td>
			<td><?php echo $book_13game->instruction; ?></td>
			<td><?php echo $book_13game->presentation; ?></td>
			<td><?php echo $book_13game->categories; ?></td>
			<td><?php echo $book_13game->metas; ?></td>
			<td>
				<?php echo Html::anchor('book/13game/view/'.$book_13game->id, 'View'); ?> |
				<?php echo Html::anchor('book/13game/edit/'.$book_13game->id, 'Edit'); ?> |
				<?php echo Html::anchor('book/13game/delete/'.$book_13game->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Book_13games.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('book/13game/create', 'Add new Book 13game', array('class' => 'btn btn-success')); ?>

</p>
