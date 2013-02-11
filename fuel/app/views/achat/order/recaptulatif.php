
<table border="1" class="products">
    <thead>
        <tr>
            <th>ISBN</th>
            <th>Description</th>
            <th>Prix</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $p): ?>
        <tr>
            <td><strong><?php echo $p->product->reference ;?></strong></td>
            <td>
                <strong><?php echo $p->product_title ;?></strong>
                <?php 
                if(isset($modifiable) && $modifiable) {
                    echo Asset::img('season13/ui/btn_delete_red.png', array(
                            'class' => "remove_product",
                            'data-productref' => $p->product->reference,
                            'alt' => 'supprimer'
                        )); 
                }
                ?>
            </td>
            <td><?php echo number_format($p->getRealPrice(), 2, ',', '') . $currency->sign ;?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2"><strong>Montant total HT:</strong></td>
            <td><?php echo number_format($ht, 2, ',', '') . $currency->sign; ?></td>
        </tr>
        <tr>
            <td colspan="2"><strong>TVA:</strong></td>
            <td><?php echo number_format($tax, 2, ',', '') . $currency->sign; ?></td>
        </tr>
        <tr>
            <td colspan="2"><strong>Montant total TTC:</strong></td>
            <td><?php echo number_format($total, 2, ',', '') . $currency->sign; ?></td>
        </tr>
    </tfoot>
    
</table>