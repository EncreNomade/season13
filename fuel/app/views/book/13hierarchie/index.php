<h2>Listing Book_13hierarchies</h2>
<br>
<?php if ($book_13hierarchies): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Epid</th>
			<th>Belongto</th>
			<th>Relation type</th>
			<th>Extra</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($book_13hierarchies as $book_13hierarchie): ?>		<tr>

			<td><?php echo $book_13hierarchie->epid; ?></td>
			<td><?php echo $book_13hierarchie->belongto; ?></td>
			<td><?php echo $book_13hierarchie->relation_type; ?></td>
			<td><?php echo $book_13hierarchie->extra; ?></td>
			<td>
				<?php echo Html::anchor('book/13hierarchie/view/'.$book_13hierarchie->id, 'View'); ?> |
				<?php echo Html::anchor('book/13hierarchie/edit/'.$book_13hierarchie->id, 'Edit'); ?> |
				<?php echo Html::anchor('book/13hierarchie/delete/'.$book_13hierarchie->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Book_13hierarchies.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('book/13hierarchie/create', 'Add new Book 13hierarchie', array('class' => 'btn btn-success')); ?>

</p>
