<?php

use Illuminate\Support\Facades\Config;





function cdn($asset ){



    //Check if we added cdn's to the config file

    if( !Config::get('app.cdn') )

        return asset( $asset );



    //Get file name & cdn's

    $cdns = Config::get('app.cdn');

    $assetName = basename( $asset );

    //remove any query string for matching

    $assetName = explode("?", $assetName);

    $assetName = $assetName[0];



    //Find the correct cdn to use

    foreach( $cdns as $cdn => $types ) {

        if( preg_match('/^.*\.(' . $types . ')$/i', $assetName) )

            return cdnPath($cdn, $asset);

    }



    //If we couldnt match a cdn, use the last in the list.

    end($cdns);

    return cdnPath( key( $cdns ) , $asset);



}



function cdnPath($cdn, $asset) {

    return  "//" . rtrim($cdn, "/") . "/" . ltrim( $asset, "/");

}

function categoryImage($image)
{
    $parentUrl = env('PARENT_URL');

    return $parentUrl . '/public/images/category/' . $image;
}

function productImage($image)
{
    $parentUrl = env('PARENT_URL');

    return $parentUrl . '/public/images/product/' . $image;
}

function logo($image)
{
    $parentUrl = env('PARENT_URL');

    return $parentUrl . '/public/logo/' . $image;
}

?>
