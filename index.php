<?php

function printWorkDay(int $year, int $month, int $quantityMonths = 1): void {
    
    if ($month > 12 || $month <= 0 || $year <= 0 || $quantityMonths <= 0) {
        fwrite(STDERR, "Ошибка входных данных!\n");
        return;
    }

    echo $year;          
    $startDate = "01-".$month."-".$year;
    $startTime =  strtotime($startDate);
    $endTime = strtotime("+$quantityMonths month", $startTime);
    
    $curMonth = "";        
    $counter = 1; //счетчик рабочих и выходных дней

    for($d = $startTime; $d < $endTime; $d += 24*60*60) {
        
        $monthCurDate = date('F', $d);
        if ($curMonth !== $monthCurDate) {
            $curMonth = $monthCurDate;
            echo PHP_EOL;
            echo $curMonth . PHP_EOL;
        }

        //$curDate = date('Y-m-d-D', $d);
        $curDate = date('d', $d);
        $curDay = date('D', $d);
        
        if ($curDay === "Sat" || $curDay === "Sun") {
            echo "\033[34m$curDate \033[0m"; //синий - субботу или воскресенье
            continue;        
        }

        $workDay = ($counter === 1); // рабочий день подсветим красным, 2 выходных дня - зеленым
        if ($workDay) {
            echo "\033[31m$curDate \033[0m"; //красный
        } else {
            echo "\033[32m$curDate \033[0m"; //зелёный                
        }           
        
        if ($counter < 3) {
            $counter++;                
        } else {
            $counter = 1;                
        }
    }    
}

$year = 2023;
$month = 10;
$quantityMonths = 2;

printWorkDay($year, $month, $quantityMonths);