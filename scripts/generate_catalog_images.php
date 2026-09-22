<?php
$root=dirname(__DIR__);
$db=new PDO('sqlite:'.$root.'/database/database.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
@mkdir($root.'/public/images/products',0777,true);
@mkdir($root.'/public/images/categories',0777,true);
@mkdir($root.'/public/images/hero',0777,true);

function c($im,$hex){$hex=ltrim($hex,'#'); return imagecolorallocate($im,hexdec(substr($hex,0,2)),hexdec(substr($hex,2,2)),hexdec(substr($hex,4,2)));}
function bg($im,$w,$h,$seed){
    mt_srand($seed);
    $top=[28+mt_rand(0,18),36+mt_rand(0,18),44+mt_rand(0,18)];
    $bot=[118+mt_rand(0,50),126+mt_rand(0,45),132+mt_rand(0,40)];
    for($y=0;$y<$h;$y++){ $t=$y/max(1,$h-1); $col=imagecolorallocate($im,(int)($top[0]*(1-$t)+$bot[0]*$t),(int)($top[1]*(1-$t)+$bot[1]*$t),(int)($top[2]*(1-$t)+$bot[2]*$t)); imageline($im,0,$y,$w,$y,$col);}
    $floor=c($im,'3b4147'); imagefilledpolygon($im,[0,(int)($h*.66),$w,(int)($h*.58),$w,$h,0,$h],4,$floor);
    for($i=0;$i<12;$i++){ $x=mt_rand(0,$w); $a=imagecolorallocatealpha($im,255,255,255,110+mt_rand(0,15)); imageline($im,$x,0,max(0,$x-mt_rand(40,220)),$h,$a);}
}
function steel($im,$kind,$seed,$w,$h){
    mt_srand($seed); $dark=c($im,'30363b'); $mid=c($im,'737d86'); $light=c($im,'c2c9cf'); $accent=c($im,'9aa4ad');
    $cx=(int)($w*.52); $cy=(int)($h*.58); $n=8+($seed%9);
    if($kind==='rebar'){ for($i=0;$i<$n;$i++){ $y=$cy+$i*11-55; $x1=90+($i%3)*18; $x2=$w-120-($i%4)*12; imagesetthickness($im,10+($i%4)); imageline($im,$x1,$y,$x2,$y-90,$i%2?$mid:$light); imagesetthickness($im,2); for($x=$x1+20;$x<$x2;$x+=28) imageline($im,$x,$y-2,$x+8,$y-12,$dark);}}
    elseif($kind==='beam'){ for($i=0;$i<6;$i++){ $x=130+$i*135; $y=$cy+($i%2)*45; imagefilledrectangle($im,$x,$y,$x+95,$y+18,$light); imagefilledrectangle($im,$x+38,$y-95,$x+57,$y+110,$mid); imagefilledrectangle($im,$x,$y+92,$x+95,$y+110,$dark);}}
    elseif($kind==='sheet'){ for($i=0;$i<14;$i++){ $x=120+$i*10; $y=$cy-$i*9; imagefilledpolygon($im,[$x,$y,$x+730,$y-45,$x+760,$y-8,$x+25,$y+38],4,$i%3?$mid:$light);}}
    elseif($kind==='pipe'){ for($i=0;$i<18;$i++){ $r=32+($i%4)*7; $x=130+($i%6)*125; $y=$cy-90+intdiv($i,6)*105; imagefilledellipse($im,$x,$y,$r*2,$r*2,$dark); imageellipse($im,$x,$y,$r*2,$r*2,$light); imageellipse($im,$x,$y,(int)($r*1.2),(int)($r*1.2),$accent);}}
    elseif($kind==='profile'){ for($i=0;$i<12;$i++){ $s=54+($i%4)*8; $x=120+($i%6)*128; $y=$cy-90+intdiv($i,6)*120; imagefilledrectangle($im,$x,$y,$x+$s,$y+$s,$light); imagefilledrectangle($im,$x+10,$y+10,$x+$s-10,$y+$s-10,$dark);}}
    else { for($i=0;$i<14;$i++){ $s=46+($i%3)*10; $x=100+($i%7)*120; $y=$cy-80+intdiv($i,7)*120; imagefilledpolygon($im,[$x,$y,$x+$s,$y,$x+$s,$y+12,$x+14,$y+12,$x+14,$y+$s,$x,$y+$s],6,$i%2?$light:$mid);}}
}
function saveProduct($root,$slug,$kind,$seed){
    $w=1280;$h=800;$im=imagecreatetruecolor($w,$h); imageantialias($im,true); bg($im,$w,$h,$seed); steel($im,$kind,$seed,$w,$h);
    $white=imagecolorallocatealpha($im,255,255,255,35); imagefilledrectangle($im,0,0,$w,54,$white);
    imagestring($im,5,26,18,strtoupper(str_replace('-',' ',$slug)),c($im,'eef2f4'));
    imagejpeg($im,$root.'/public/images/products/'.$slug.'.jpg',93); imagedestroy($im);
}
$rows=$db->query("select p.slug,c.slug as category_slug from products p join categories c on c.id=p.category_id order by c.sort_order,p.id")->fetchAll(PDO::FETCH_ASSOC);
$count=0; foreach($rows as $r){ saveProduct($root,$r['slug'],$r['category_slug'],crc32($r['slug'])); $count++; }

$cats=['rebar','beam','sheet','pipe','profile','angle'];
foreach($cats as $i=>$kind){
    $w=1600;$h=900;$im=imagecreatetruecolor($w,$h); imageantialias($im,true); $seed=9000+$i*733; bg($im,$w,$h,$seed); steel($im,$kind,$seed,$w,$h);
    imagefilledrectangle($im,0,0,$w,76,imagecolorallocatealpha($im,15,20,25,35)); imagestring($im,5,32,28,'FOLADINO / '.strtoupper($kind),c($im,'f3f5f7'));
    imagejpeg($im,$root.'/public/images/categories/'.$kind.'.jpg',94); imagedestroy($im);
}
$heroes=['home-hero','about-plant','admin-login','footer-industry','order-hero','page-hero','price-cta'];
foreach($heroes as $i=>$name){
    $w=1920;$h=1080;$im=imagecreatetruecolor($w,$h); imageantialias($im,true); $seed=22000+$i*991; bg($im,$w,$h,$seed);
    $k=$cats[$i%count($cats)]; steel($im,$k,$seed,$w,$h);
    $navy=c($im,'0b1f33'); imagefilledrectangle($im,0,0,(int)($w*.44),$h,imagecolorallocatealpha($im,11,31,51,28));
    for($j=0;$j<5;$j++){ $x=120+$j*250; imageline($im,$x,120,$x+210,30,c($im,'d5dbe0')); }
    imagestring($im,5,70,70,'FOLADINO INDUSTRIAL SUPPLY',c($im,'ffffff'));
    imagejpeg($im,$root.'/public/images/hero/'.$name.'.jpg',95); imagedestroy($im);
}
echo "generated_products={$count}\n";
