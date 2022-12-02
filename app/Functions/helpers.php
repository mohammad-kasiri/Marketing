<?php

use App\Models\Province;
use Illuminate\Support\Arr;

function generatePhone() : string
{
    return '09' . Arr::random(['02', '10', '38', '35', '90', '22', '12', '15', '19']) . rand(1000000, 9999999);
}

function generateGender() : string
{
    return Arr::random(['male' , 'female']);
}

function generateCityId() : string
{
    return rand(Province::FIRST_CITY_ID , Province::LAST_CITY_ID);
}


function generateEmail() : string
{
    return \Illuminate\Support\Str::random(10) . '@' . 'gmail.com';
}

function iranOperators() : array
{
    return [
        //irancel
        "930" , "933" , "935" , "936" , "937" , "938" , "939" , "901" , "902" , "903" , "904" , "905", "941",
        //IR-MCI
        "910" , "911" , "912" , "913" , "914" , "915" , "916" , "917" , "918" , "919" , "990" , "991" , "992" , "993" , "994",
        //Rightel
        "920" , "921" , "922",
        //Taliya
        "932" ,
        //TeleKish
        "934" ,
        //Aptel
        "99910" , "99911" , "99913" ,
        //azartel
        "99914" ,
        //SamanTel
        "99999" , "99998" , "99997" , "99996" ,
        //LOTUSTEL
        "9990" ,
        //Shatel Mobile
        "99810" , "99811" , "99812" , "99814" , "99815" ,
        //ArianTel
        "9998" ];
}

