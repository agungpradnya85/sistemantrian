<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<table>
    <tr>
        <th>No</th>
        <th>Aksi</th>
    </tr>
    <?php foreach($model as $result) :?>
    <tr>
        <td>
        <?= $result['no_antrian']; ?>
        </td>
        <td>
            <!--<button class="btn">Panggil</button>
            <button class="btn">Set</button>-->
            <?php if($result['status'] < 2) :?>
            <?= \yii\helpers\Html::a('SET', ['update-antrian', 'id' => $result['id'], 'status' => '2', 'id_klinik' => $result['id_klinik']]); ?>
            <?php else : ?>
            SET
            <?php endif; ?>
        </td>
    </tr>
    <?php    endforeach; ?>
</table>