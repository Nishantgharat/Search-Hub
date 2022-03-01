<?php
require 'qprocess.php';
$con = mysqli_connect("localhost","root","","search");
echo $con;
function getTerms($line)
{
    $line=strtolower($line);
    $line=preg_replace('/[^a-z0-9]/',' ',$line);
    $line=preg_replace('/\s+/', ' ', $line);
    $line=explode(' ',$line);
    $line=removeStopWords($line);
    $line=array_values(array_filter($line));
    $line=stem($line);
    return $line;
}

function readIndex($index)
{
    $arr=array();
    $index=explode('|',$index);
    $df=array_pop($index);
    foreach($index as $val)
    {
        array_push($arr,explode(':',$val));
    }
    // print_r($arr);
    for($i=0;$i<count($arr);$i++)
    {
        $arr[$i][2]=$arr[$i][2]*$df;
        $pos[$arr[$i][0]]=$arr[$i][1];
        $tf[$arr[$i][0]]=$arr[$i][2];
    }
    // print_r($tf);
    return $tf;
    // print($df);

}

function array_flat($array)
{
    $result=array();
    foreach ($array as $arr)
    {
        for($i=0;$i<count($arr);$i++);
        {
            $intersect=array_intersect_key($result, $arr);
            if(count($intersect)!=0)
            {
                foreach ($intersect as $key => $value)
                {
                    if($arr[$key]>$result[$key])
                    {
                     $result[$key]=$arr[$key];
                    }
                }
            }
            $result=$result+$arr;
        }
    }
    return $result;
}

function queryCheck($query)
{
    $arr=array();
    $index=[];
    $query=getTerms($query);
    // print_r($query);
    for($i=0;$i<count($query);$i++)
    {
        $sql="select term_id from crawl_index where term = '$query[$i]'";
        $rs=mysqli_query($GLOBALS['con'],$sql);
        // if (!$rs) {
        //     printf("Error: %s\n", mysqli_error($GLOBALS['con']));
        //     exit();
        // }
        $row=mysqli_fetch_array($rs);
        if($row[0]==0)
        {
             array_splice($query,$i, 1);
        }

    }
    for($i=0;$i<count($query);$i++)
    {
        // $arr=array();
        $sql="select term_index from crawl_index where term = '$query[$i]'";
        $rs=mysqli_query($GLOBALS['con'],$sql);
        // print_r($rs);
        // echo '<br>';
        while($row=mysqli_fetch_array($rs))
        {
            $arr[]=readIndex($row[0]);
        }
        // $arr = array_values(array_map('array_values', $arr));
    }
    $arr=array_flat($arr);
    arsort($arr);
    // var_dump($arr);
    printResult($arr);
    // print_r($arr);
}
// $tf=readIndex('1:7:0.0925|10:87:0.0327|41.5000');

function printResult($tf)
{
    $i=0;
    foreach ($tf as $key => $value)
    {
        $sql1="select url,title,url_text from crawl_data where url_id = $key";
        $rs1=mysqli_query($GLOBALS['con'],$sql1);
         // print_r($rs1);
        while($row1=mysqli_fetch_array($rs1))
        {
            // echo $row1[0];
            echo "<a href='$row1[0]'
            style='font-size:20' color='#1A0DAB';'<font color='#1A0DAB''>$row1[1] </font></a><br>"; #sitetitle
            echo "<font size='3' color='#006400'>$row1[0] </font><br>";  #link
            if(mb_strlen($row1[2])<200)
            {
                $pos=strpos($row1[2], ' ',(mb_strlen($row1[2])));
                $url_text=substr($row1[2],0,$pos).' ...';
                if($url_text==' ...')
                {
                    $url_text=$row1[2];
                }
            }
            else
            {
                // echo $key;
                $pos=strpos($row1[2], ' ',200);
                $url_text=substr($row1[2],0,$pos ).' ...';
            }

            echo "<font size='3' color='#666666'>$url_text </font><br><br>";  #discribstion

        }
        $i++;
        // print($i);
        if($i>=10)
        {
            break;
        }

    }
}



?>
