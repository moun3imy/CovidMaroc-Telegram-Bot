<?php

function newMessage($coronaData, $first_name, $last_name, $is_cron_job_update)
{
    // Corona virus statistics in morocco
    $lastUpdate = $coronaData['last_update'];
    $recovered = $coronaData['recovered'];
    $active = $coronaData['active'];
    $deaths = $coronaData['deaths'];
    $cases = $coronaData['cases'];
    $clean = $coronaData['clean'];

    $plusOne = $cases + 1;
    $all_cases = $cases + $clean;

    $new_update = $is_cron_job_update ? "<b>🔥🔥🔥🔥 NEW UPDATE 🔥🔥🔥🔥</b>" : "";
    $to_user = "<b><i>$first_name $last_name</i></b>,\n";
    $head = "عافاك خليك فداركم, باش ما تكونـ(ـيـ)ـش نتـ(ـي/ـا) هـ(ـي)ـو الحالة رقم $plusOne 🙏🙏🙏";
    $body = "
    <code>Total Cases</code>           
    <b>$cases</b>
    
    <code>Active</code>         
    <b>$active</b>
    <code>Recovered</code>       
    <b>$recovered</b>
    <code>Deaths</code>                 
    <b>$deaths</b>
    ";
    $footer = "تم إجراء الفحوصات الطبية على $all_cases شخص مشكوك فيهم, من بينهم $cases شخص لي كانو بصح مصابين بفيروس كورونا, و $clean لي بقاو ما فيهم والو. من دوك $cases لي مراض $recovered الناس تشافاو و $deaths ماتو.. يعني فالأخير بقاو عندنا $active شخص مريض و باقي على قيد الحياة.\n";
    $last_update_date = "<i>Last update: $lastUpdate</i>";

    return join("\n", [
        $new_update,
        $to_user,
        $head,
        $body,
        $footer,
        $last_update_date
    ]);
}
