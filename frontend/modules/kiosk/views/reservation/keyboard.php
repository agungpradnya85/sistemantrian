<!-- http://d2o0t5hpnwv4c1.cloudfront.net/378_jqueryKeyboard/demo/index.html -->
<div class="container">
<ul id="keyboard">
        <li class="symbol"><span class="off">`</span><span class="on">~</span></li>
        <li class="symbol"><span class="off">1</span><span class="on">!</span></li>
        <li class="symbol"><span class="off">2</span><span class="on">@</span></li>
        <li class="symbol"><span class="off">3</span><span class="on">#</span></li>
        <li class="symbol"><span class="off">4</span><span class="on">$</span></li>
        <li class="symbol"><span class="off">5</span><span class="on">%</span></li>
        <li class="symbol"><span class="off">6</span><span class="on">^</span></li>
        <li class="symbol"><span class="off">7</span><span class="on">&amp;</span></li>
        <li class="symbol"><span class="off">8</span><span class="on">*</span></li>
        <li class="symbol"><span class="off">9</span><span class="on">(</span></li>
        <li class="symbol"><span class="off">0</span><span class="on">)</span></li>
        <li class="symbol"><span class="off">-</span><span class="on">_</span></li>
        <li class="symbol"><span class="off">=</span><span class="on">+</span></li>
        <li class="delete lastitem">delete</li>
        <li class="tab">tab</li>
        <li class="letter">q</li>
        <li class="letter">w</li>
        <li class="letter">e</li>
        <li class="letter">r</li>
        <li class="letter">t</li>
        <li class="letter">y</li>
        <li class="letter">u</li>
        <li class="letter">i</li>
        <li class="letter">o</li>
        <li class="letter">p</li>
        <li class="symbol"><span class="off">[</span><span class="on">{</span></li>
        <li class="symbol"><span class="off">]</span><span class="on">}</span></li>
        <li class="symbol lastitem"><span class="off">\</span><span class="on">|</span></li>
        <li class="capslock">caps lock</li>
        <li class="letter">a</li>
        <li class="letter">s</li>
        <li class="letter">d</li>
        <li class="letter">f</li>
        <li class="letter">g</li>
        <li class="letter">h</li>
        <li class="letter">j</li>
        <li class="letter">k</li>
        <li class="letter">l</li>
        <li class="symbol"><span class="off">;</span><span class="on">:</span></li>
        <li class="symbol"><span class="off">'</span><span class="on">&quot;</span></li>
        <li class="return lastitem">return</li>
        <li class="left-shift">shift</li>
        <li class="letter">z</li>
        <li class="letter">x</li>
        <li class="letter">c</li>
        <li class="letter">v</li>
        <li class="letter">b</li>
        <li class="letter">n</li>
        <li class="letter">m</li>
        <li class="symbol"><span class="off">,</span><span class="on">&lt;</span></li>
        <li class="symbol"><span class="off">.</span><span class="on">&gt;</span></li>
        <li class="symbol"><span class="off">/</span><span class="on">?</span></li>
        <li class="right-shift lastitem">shift</li>
        <li class="space lastitem">&nbsp;</li>
</ul>
</div>
<?php

$css =<<<CSS
#keyboard {
     margin: 0;
     padding: 0;
     list-style: none;
}
 #keyboard li {
     float: left;
     margin: 0 5px 5px 0;
     width: 40px;
     height: 40px;
     line-height: 40px;
     text-align: center;
     background: #fff;
     border: 1px solid #f9f9f9;
     -moz-border-radius: 5px;
     -webkit-border-radius: 5px;
}
 .capslock, .tab, .left-shift {
     clear: left;
}
 #keyboard .tab, #keyboard .delete {
     width: 70px;
}
 #keyboard .capslock {
     width: 80px;
}
 #keyboard .return {
     width: 77px;
}
 #keyboard .left-shift {
     width: 95px;
}
 #keyboard .right-shift {
     width: 109px;
}
 .lastitem {
     margin-right: 0;
}
 .uppercase {
     text-transform: uppercase;
}
 #keyboard .space {
     clear: left;
     width: 681px;
}
 .on {
     display: none;
}
 #keyboard li:hover {
     position: relative;
     top: 1px;
     left: 1px;
     border-color: #e5e5e5;
     cursor: pointer;
}

CSS;
$this->registerCss($css);
$this->registerJsFile(Yii::getAlias('@web/script/keyboard.js'), ['depends' => [\yii\web\JqueryAsset::className()]]);
?>