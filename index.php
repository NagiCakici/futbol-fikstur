<?php

$teams = [];
$fixed = 'team1';
$weaks = [];
$score = [];
$points = [];
$n = 18;

for($i=2; $i < ($n+1); $i++){
    $teams[] = 'team' . $i;
}

 
for ($i = 1; $i <= ($n - 1); $i++)//hafta
{
    $weaks[$i][$fixed] = $teams[0];

    $x = rnd();
    $y = rnd();

    $score[$fixed][$i] = $x;
    $score[$teams[0]][$i] = $y;
    
    puanla($fixed, $x, $y);
    puanla($teams[0], $x, $y);

    for($j = 1; $j <= (($n - 2) / 2); $j++){

        $x = rnd();
        $y = rnd();

        $weaks[$i][$teams[$j]] = $teams[($n - ($j + 1))];

        $score[$teams[$j]][$i] = $x ;
        $score[$teams[($n - ($j + 1))]][$i] = $y ;

        puanla($teams[$j], $x, $y);
        puanla($teams[($n - ($j + 1))], $x, $y);

    }

    $x = 1;
    $tmx[0] = end($teams);
    foreach($teams as $tm){
        if($x < ($n - 1)){
            $tmx[$x] = $tm;
        }
        $x++;
    }
    $teams = $tmx;
}

function rnd(){
    return rand(0,5);

}

function puanla($team, $x, $y){
    

     if($x > $y){
         $GLOBALS['points'][$team]['G'] = isset($GLOBALS['points'][$team]['G']) ? ($GLOBALS['points'][$team]['G'] + 1) : 1;
         $GLOBALS['points'][$team]['P'] = isset($GLOBALS['points'][$team]['P']) ? ($GLOBALS['points'][$team]['P'] + 3) : 3;
     }else if($x < $y){
         $GLOBALS['points'][$team]['M'] = isset($GLOBALS['points'][$team]['M']) ? ($GLOBALS['points'][$team]['M'] + 1) : 1;
     }else{
         $GLOBALS['points'][$team]['B'] = isset($GLOBALS['points'][$team]['B']) ? ($GLOBALS['points'][$team]['B'] + 1) : 1;
         $GLOBALS['points'][$team]['P'] = isset($GLOBALS['points'][$team]['P']) ? ($GLOBALS['points'][$team]['P'] + 1) : 1;
     }
    $GLOBALS['points'][$team]['A'] = isset($GLOBALS['points'][$team]['A']) ? ($GLOBALS['points'][$team]['A'] + $x) : $x;
    $GLOBALS['points'][$team]['Y'] = isset($GLOBALS['points'][$team]['Y']) ? ($GLOBALS['points'][$team]['Y'] + $y) : $y;
    $GLOBALS['points'][$team]['Av'] = isset($GLOBALS['points'][$team]['Av']) ? ($GLOBALS['points'][$team]['Av'] + ($x - $y)) : ($x - $y);
}

$list = [];
foreach( $points as $key => $data){
    $list [$key] = $data['P'];
}
arsort($list);

$pl = [];
foreach($points as $key => $data){
    $pl[] = [
        'team' =>$key,
        'G' => $data['G'],
        'B' => $data['B'],
        'M' => $data['M'],
        'A' => $data['A'],
        'Y' => $data['Y'],
        'Av' => $data['Av'],
        'P' => $data['P']
    ];
}



function order($dtx){
    $order = $dtx;
    $cnt=count($dtx);

    
    for($t=0; $t < ($cnt); $t++){

        for($i=0; $i < ($cnt - 1); $i++){

            if($dtx[$i]['P'] < $dtx[($i + 1)]['P']){

                $order[$i] = $dtx[($i + 1)];
                $order[($i + 1)] = $dtx[$i];

            }else if($dtx[$i]['P'] > $dtx[($i + 1)]['P']){

                $order[$i] = $dtx[$i];
                $order[($i + 1)] = $dtx[($i + 1)];

            }else if($dtx[$i]['Av'] > $dtx[($i + 1)]['Av']){

                $order[$i] = $dtx[$i];
                $order[($i + 1)] = $dtx[($i + 1)];

            }else if($dtx[$i]['Av'] < $dtx[($i + 1)]['Av']){

                $order[$i] = $dtx[($i + 1)];
                $order[($i + 1)] = $dtx[$i];

            }else{

                $order[$i] = $dtx[$i];
                $order[($i + 1)] = $dtx[($i + 1)];

            }
            $dtx = $order;
        }
    }

$GLOBALS['pl'] = $order;

}

order($pl);

?>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fikstür</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<style>
    .dnone{
        display: none;
    }
</style>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col-5"></div>
        <div class="col-1">G</div>
        <div class="col-1">B</div>
        <div class="col-1">M</div>
        <div class="col-1">A</div>
        <div class="col-1">Y</div>
        <div class="col-1">AV</div>
        <div class="col-1">P</div>
    <?php
        foreach($pl as $pcl){
    ?>
        <div class="col-5 border" onclick="openTeam('<?php echo $pcl['team']?>');"><?php echo $pcl['team']?></div>
        <div class="col-1 border"><?php echo $pcl['G']?></div>
        <div class="col-1 border"><?php echo $pcl['B']?></div>
        <div class="col-1 border"><?php echo $pcl['M']?></div>
        <div class="col-1 border"><?php echo $pcl['A']?></div>
        <div class="col-1 border"><?php echo $pcl['Y']?></div>
        <div class="col-1 border"><?php echo $pcl['Av']?></div>
        <div class="col-1 border"><?php echo $pcl['P']?></div>
        <div class="col-12 dnone" id="<?php echo $pcl['team']?>">
            <div class="row">
        
                <?php
                    foreach($weaks as $k => $data){
                ?>
                        <?php
                            if(isset($data[$pcl['team']])){
                                $t1 = $pcl['team'];
                                $t2 = $data[$pcl['team']];
                            }else{
                                $t2 = $pcl['team'];
                                $t1 = array_search($pcl['team'], $data);
                            }
                        ?>
                        <div class="col-3 border-bottom">Hafta <?php echo $k ?></div>
                        <div class="col-3 border-bottom"><?php echo $t1;?></div>
                        <div class="col-3 text-center border-bottom">
                        <?php echo $score[$t1][$k];?> - <?php echo $score[$t2][$k];?>
                        </div>
                        <div class="col-3 text-end border-bottom"><?php echo $t2;?></div>
                <?php
                }
                ?>
            </div>
        </div>
    <?php
        }
    ?>
    </div>

    <div class="row gx-5 gy-3">
        
    <?php
        foreach($weaks as $k => $data){
    ?>
        <div class="col-6">
            <div class="row border">
                <div class="col-12 text-center">Hafta <?php echo $k ?></div>
            <?php
                foreach($data as $t1 => $t2){
            ?>
                <div class="col-5"><?php echo $t1;?></div>
                <div class="col-2 text-center">
                <?php echo $score[$t1][$k];?> - <?php echo $score[$t2][$k];?>
                </div>
                <div class="col-5 text-end"><?php echo $t2;?></div>

            <?php
                }
            ?>
            </div>
        </div>
        <?php
        }
        ?>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.slim.js" integrity="sha256-HwWONEZrpuoh951cQD1ov2HUK5zA5DwJ1DNUXaM6FsY=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-kjU+l4N0Yf4ZOJErLsIcvOU2qSb74wXpOhqTvwVx3OElZRweTnQ6d31fXEoRD1Jy" crossorigin="anonymous"></script>

<script type="text/javascript">
    function openTeam(team){
        console.log(team);
        $('#'+team).show();
    }
</script>

</body>
</html>

