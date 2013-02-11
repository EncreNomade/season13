<?php if(!empty($gameInfos)): ?>
    <table>
        <thead>
            <tr><td class="title" colspan="2">Meilleurs scores</td></tr>
            <tr>
                <td>Pseudo</td>
                <td>Score</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($gameInfos as $gi): ?>
                <tr>
                    <td><?php echo $gi->user_id == 0 ? $gi->supp : $gi->user->pseudo; ?></td>
                    <td><?php echo $gi->high_score; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>    
    </table>
<?php endif; ?>