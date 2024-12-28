<?php

$filePath = 'data.txt';
$string = file_get_contents($filePath);

$start = 'd="__NEXT_DATA__" type="application/json">';
$end = '</script><script type="text/javascript"  src="/Kb6XsLiKBWKM_QsCGZkR/uQO9zzJbO7VbGa/fXI2UUA/ak/sQUiUiSG4B"></script></body></html>';

// Find the position of the start and end strings
$startPos = strpos($string, $start);
$endPos = strpos($string, $end);

// Ensure that the start and end positions are valid
if ($startPos !== false && $endPos !== false) {
    // Adjust the position to exclude the start string itself
    $startPos += strlen($start);
    
    // Extract the substring between start and end
    $substring = substr($string, $startPos, $endPos - $startPos);
    
    // echo $substring;
} else {
    echo "Start or end string not found!";
}


$data = json_decode($substring,true);



$filePath = 'index.html';
$content = file_get_contents($filePath);


// echo "<pre>";
// print_r($data);
// print_r($data['props']['pageProps']['results']['results']['Catalogue']['res']);
// exit;



$business = $data['props']['pageProps']['results']['results']['name'];
$filename = str_replace(' ', '-', $business);
$description = $data['props']['pageProps']['results']['results']['seo_dt']['desc'];
$mobile_number = null;
$email_id = null;
$insta_id = null;
$whats_app_no = null;
$YouTubeLink = 'https://www.youtube.com/@thearstudioRahuri';
$bAddress = $data['props']['pageProps']['results']['results']['address'];
$complat = $data['props']['pageProps']['results']['results']['complat'];
$complong = $data['props']['pageProps']['results']['results']['complong'];


if($complat!=''){
    $your_location = $complat.','.$complong;
}else{
    $your_location = $bAddress;
}

// $servicesArray = [
//    'Event Photography' => "Capture Every Moment From weddings to corporate events, we specialize in immortalizing unforgettable moments with high-quality photos that tell a story.",
//    'Portrait Photography' => "Personalized & Professional Portraits Whether it’s a family portrait, corporate headshot, or lifestyle session, our portraits reflect your true essence with creativity and precision.",
//    'Product Photography ' => "Showcase Your Products with Precision Perfect for e-commerce and commercial use, we provide crisp, detailed images to highlight your products in the best light.",
// ];

$servicesArray = $data['props']['pageProps']['results']['results']['bd_detailshow']['catarray'];





// $galleryArray = [
//     'https://lh3.googleusercontent.com/p/AF1QipMhsR-dfkFoixpB10Bzrbmh5YTkNDUzwgt2CVGs=s680-w680-h510' => "Baby Shoot",
//     'https://lh3.googleusercontent.com/p/AF1QipN6E2bHiO12-fodFVv3156QuAE_GFF0X2fTc18r=s680-w680-h510' => "Baby Shoot",
//     'https://lh3.googleusercontent.com/p/AF1QipPOwC_uA4pmGPTcsD6ESkD1fBYjfQs1s25Q3SKR=s680-w680-h510' => "Pre Wedding shoot",
//     'https://lh3.googleusercontent.com/p/AF1QipPnbdoFN6q3hAN7kKFIdBOxJob4y9io18Tj6WXp=s680-w680-h510' => "Maternity shoot",
//     'https://lh3.googleusercontent.com/p/AF1QipMF2qwJsw_4WNyiVVcalTE9R3_uvm91wJjVPJjS=s680-w680-h510' => "Maternity shoot",
//     'https://lh3.googleusercontent.com/p/AF1QipOSctDEsmz0WkY2Fw1kFKyfcc5p8RsXnSHLQBvv=s680-w680-h510' => "Maternity shoot",
//     'https://lh3.googleusercontent.com/p/AF1QipPNpuSjgKkJAI_gsnYnc6EnwTzM5GjgV-uv-ug7=s680-w680-h510' => "Maternity shoot",
//     'https://lh3.googleusercontent.com/p/AF1QipMXVscsT5NjSy3dTVUxx3DavXXVnwt1ItW_Kw8j=s680-w680-h510' => "Maternity shoot",
// ];

$galleryArray = $data['props']['pageProps']['results']['results']['Catalogue']['res'];
// https://images.jdmagicbox.com/v2/


$allGalleryHTML = '';
foreach ($galleryArray as $io => $row) {
    // Constructing HTML for each io in the gallery


    $desc = isset($servicesArray[$io]['catname']) ? $servicesArray[$io]['catname'] : $business;
    $img = 'https://images.jdmagicbox.com/'.$row['io'];

    $galleryHTML = '
    <div class="flex flex-col gap-3">
        <a href="#">
            <div class="relative aspect-video rounded-lg overflow-hidden">
                <img alt="' . htmlspecialchars($desc) . '" loading="lazy" decoding="async" data-nimg="fill"
                     class="object-cover"
                     style="position: absolute; height: 100%; width: 100%; left: 0; top: 0; right: 0; bottom: 0; color: transparent;"
                     sizes="100vw"
                     srcset="' . htmlspecialchars($img) . ' 640w, ' . htmlspecialchars($img) . ' 750w, ' . htmlspecialchars($img) . ' 828w, ' . htmlspecialchars($img) . ' 1080w, ' . htmlspecialchars($img) . ' 1200w, ' . htmlspecialchars($img) . ' 1920w, ' . htmlspecialchars($img) . ' 2048w, ' . htmlspecialchars($img) . ' 3840w"
                     src="' . htmlspecialchars($img) . '" />
                <div class="progress-bar">
                    <div class="h-full bg-btnHighlight" style="width: 90%;"></div>
                </div>
            </div>
        </a>
        <div class="grid gap-2 px-2">
            <div class="text-highlight font-bold">' . htmlspecialchars($desc) . '</div>
            <br><br>
        </div>
    </div>';

    $allGalleryHTML .= $galleryHTML;
}




$allServicesHTML = '';
foreach($servicesArray as $catname => $row){
    // Constructing HTML for each service
    $desc = null;
    $serviceHTML = '
    <div class="flex-1 flex flex-col gap-4 bg-cardPrimary p-4 rounded-md shadow-lg">
        <div class="font-medium text-lg tracking-wider">' . htmlspecialchars($row['catname']) . '</div>
        <div class="flex flex-wrap gap-2">
            ' . htmlspecialchars($desc) . '
        </div>
    </div>';

    $allServicesHTML .= $serviceHTML;
}



$modifiedContent = str_replace("description", $description, $content);
$modifiedContent = str_replace("business", $business, $modifiedContent);
$modifiedContent = str_replace("mobile_number", $mobile_number, $modifiedContent);
$modifiedContent = str_replace("email_id", $email_id, $modifiedContent);
$modifiedContent = str_replace("insta_id", $insta_id, $modifiedContent);
$modifiedContent = str_replace("whats_app_no", $whats_app_no, $modifiedContent);
$modifiedContent = str_replace("allServicesHTML", $allServicesHTML, $modifiedContent);
$modifiedContent = str_replace("allGalleryHTML", $allGalleryHTML, $modifiedContent);
$modifiedContent = str_replace("bAddress", $bAddress, $modifiedContent);
$modifiedContent = str_replace("YouTubeLink", $YouTubeLink, $modifiedContent);
$modifiedContent = str_replace("your_location", $your_location, $modifiedContent);


$newFilePath = "$filename".'.html'; // New file path
file_put_contents($newFilePath, $modifiedContent);
echo "File has been modified and saved as $newFilePath";
?>
