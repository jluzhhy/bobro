<?php
require_once("config/common.php");
//header ("Content-type: image/png"); 

$jobid=$_GET[jobid];
$gene=$_GET[gene];

$piclength=950;
$picheight=500;
 $x=25;
$y=15;
$gridlength=5;
$Unit=10;
 $down=400;
$left=100;
 $result=array();
  $ymax=0;
   $fp=fopen("$BASE/data/annotation/$jobid/$jobid"."tg".".cur",'r');
   {
     
            $line=fgets($fp);
             
                $arr=explode("	",chop($line));
               
             $line=fgets($fp);
                $arr1=explode("	",chop($line));
               foreach ($arr as $ss)
                {$result[$ss]=$arr1[$ss];
                if($ymax<$result[$ss]) $ymax=$result[$ss];
                }
   }
   fclose($fp);
   $result2=array();
   $region=array();
    $genelength=count($result);
   $i=0;
     $fp=fopen("$BASE/data/annotation/$jobid/$jobid"."tg".".hot",'r');
   {         $line=fgets($fp);
            while(!feof($fp))
            {$line=fgets($fp);
               $arr=explode("	",chop($line));
               
                 $result2[$arr[2]]=$genelength-$arr[3]+1;
                    echo $genelength-$arr[3]+1."<br/>";
                 $region[$arr[2]]=$arr[1];
                
             }
                
            
   }
   fclose($fp);
  

    $gridy=($down-$y)/($ymax+5);
    $gridscore=($genelength+10)/(($piclength-$left)/$gridlength);
$im = @ImageCreate ($piclength,$picheight+50) or die ("Cannot Initialize new GD image stream");

$background_color = ImageColorAllocate ($im, 255, 255, 255);
$text_color = ImageColorAllocate ($im, 33, 14, 91);
$line_color = ImageColorAllocate ($im, 0, 0, 0);
$numColor = ImageColorAllocate ($im, 200, 10, 10);
$gene_color=ImageColorAllocate ($im,128,128,128);


ImageFilledRectangle($im,$x,$y+$down,$x+$piclength,$y+$thick+$down,$line_color);
ImageFilledRectangle($im,$piclength-$left,$y-20+$down,$piclength,$y+$down,$gene_color);
 ImageString($im,2,$piclength-$left-5,$y-35+$down,$gene,$numColor);
 ImageFilledRectangle($im,$piclength-$left-100,$y+20,$piclength-$left-50,$y+40,$gene_color);
 ImageString($im,2,$piclength-$left-45,$y+20,"Gene",$numColor);
  ImageFilledRectangle($im,$piclength-$left-100,$y+45,$piclength-$left-50,$y+65,$numColor);
 ImageString($im,2,$piclength-$left-45,$y+45,"Hot region",$numColor);
  $lastx=$piclength-$left;
     $lasty=$y+$down;
   for($i=0;$i<($piclength-$left-$x)/$gridlength;$i++)
    {
    
       
              if($i%$Unit==0)
                {ImageString($im,2,$piclength-$left-$i*$gridlength-$gridlength*0.5,$y+$down-20,-floor($i*$gridscore),$numColor);
                  Imageline($im,$piclength-$left-$i*$gridlength,$y-15+$down,$piclength-$left-$i*$gridlength,$y+$down,$line_color);
                 }
                else
                {
                  
                 Imageline($im,$piclength-$left-$i*$gridlength,$y-7+$down,$piclength-$left-$i*$gridlength,$y+$down,$line_color);
                }
                    //echo   floor($i*$gridscore)."<br/>Q".$result[floor($i*$gridscore)]."<br/>";
          Imageline($im,$lastx,$lasty,$piclength-$left-$i*$gridlength,$y+$down-$result[floor($i*$gridscore)]*$gridy,$line_color);
        $lastx=$piclength-$left-$i*$gridlength;
        $lasty=$y+$down-$result[floor($i*$gridscore)]*$gridy;
    
    }
           foreach ($result2 as $key => $value)
              {
                 if($key!=0) 
              {  
                 ImageFilledRectangle($im,$piclength-$left-$key/$gridscore*$gridlength,$y+1+$down,$piclength-$left-$key/$gridscore*$gridlength-$value*$gridlength/$gridscore,$y+25+$down,$numColor);
               ImageString($im,2,$piclength-$left-$key/$gridscore*$gridlength-$value*$gridlength/$gridscore*0.5,$y+30+$down,-floor($key),$line_color);
               ImageString($im,2,$piclength-$left-$key/$gridscore*$gridlength-$value*$gridlength/$gridscore,$y+40+$down,"region".$region[$key],$line_color);
               ImageString($im,2,$piclength-$left-$key/$gridscore*$gridlength-$value*$gridlength/$gridscore,$y+30+$down,-floor($key)-$value,$line_color);
               }
              }
/*for($i=$ScaleLen-$leff; $i>0; $i-=$GridUnit) {
	if($i%($GridUnit*$LabelUnit)==0) {
		Imageline($im,$x+$i,$y-7,$x+$i,$y,$line_color);
		ImageString($im,2,$x+$i,$y-18,(int)(($i*$MinLabel*$Unit)/($GridUnit*$LabelUnit)),$numColor); 
	}  else {
		Imageline($im,$x+$i,$y-5,$x+$i,$y,$line_color);
	}
}   */
 

 
    Imageline($im,$x,$y-$picheight+$down,$x,$y+$down,$line_color);
   
    for($i=0;$i<($ymax+5);$i++)
       {  if($i%5==0)
           {   ImageString($im,2,$x-20,$y+$down-$i*$gridy-$gridy,$i,$numColor);
               Imageline($im,$x-5,$y+$down-$i*$gridy,$x,$y+$down-$i*$gridy,$line_color);
          }
       }
//header ("Content-type: image/png");
ImagePng ($im);
ImageDestroy($im);
?>
