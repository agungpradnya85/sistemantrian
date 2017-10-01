<?php

use yii\helpers\Html;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if($result !== null) :?>
<table>
    <tr>
    <th>NIK</th>
    <th>Nama</th>
    <th>Alamat</th>
    <th>Aksi</th>
    </tr>

<?php foreach($result as $daftar_antrian) :?>
    <tr>
    <td><?= $daftar_antrian['nik'];?></td>
    <td><?= $daftar_antrian['nama'];?></td>
    <td><?= $daftar_antrian['alamat'];?></td>
    <td><?= Html::a('batal', ['reservation/cancel-reservation', 'id' => $daftar_antrian['id']]);?></td>
    </tr>

<?php endforeach;?>
</table>
<?php endif; ?>