<h2>Viewing #<?php echo $achat_13product->id; ?></h2>

<p>
	<strong>Reference:</strong>
	<?php echo $achat_13product->reference; ?></p>
<p>
	<strong>Type:</strong>
	<?php echo $achat_13product->type; ?></p>
<p>
	<strong>Pack:</strong>
	<?php echo $achat_13product->pack; ?></p>
<p>
	<strong>Content:</strong>
	<?php echo $achat_13product->content; ?></p>
<p>
	<strong>Presentation:</strong>
	<?php echo $achat_13product->presentation; ?></p>
<p>
	<strong>Tags:</strong>
	<?php echo $achat_13product->tags; ?></p>
<p>
	<strong>Title:</strong>
	<?php echo $achat_13product->title; ?></p>
<p>
	<strong>Category:</strong>
	<?php echo $achat_13product->category; ?></p>
<p>
	<strong>Metas:</strong>
	<?php echo $achat_13product->metas; ?></p>
<p>
	<strong>On sale:</strong>
	<?php echo $achat_13product->on_sale; ?></p>
<p>
	<strong>Price:</strong>
	<?php echo $achat_13product->price; ?></p>
<p>
	<strong>Discount:</strong>
	<?php echo $achat_13product->discount; ?></p>
<p>
	<strong>Sales:</strong>
	<?php echo $achat_13product->sales; ?></p>

<?php echo Html::anchor('achat/13product/edit/'.$achat_13product->id, 'Edit'); ?> |
<?php echo Html::anchor('achat/13product', 'Back'); ?>