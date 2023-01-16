<?php
/**
 * Sube imagen a imgur
 * @param array $img los datos de la imagen a subir
 * @return mixed Link a la imagen, o null si error.
 */
function uploadToImgur($img) {
  // Client ID of Imgur App 
  $IMGUR_CLIENT_ID = "e8dc892dbdb80c6";
  // Source image 
  $fileName = basename($img["imgFile"]["name"]);
  $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
  $allowTypes = array('jpg', 'png', 'jpeg');
  if (!in_array($fileType, $allowTypes)) {
    return;
  }
  $image_source = file_get_contents($img['imgFile']['tmp_name']); 
  

  try {
    // Post image to Imgur via API 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://api.imgur.com/3/image');
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: Client-ID $IMGUR_CLIENT_ID"));
    curl_setopt($ch, CURLOPT_POSTFIELDS, array('image' => base64_encode($image_source)));
    $response = curl_exec($ch);
    curl_close($ch);
  } catch (Exception $e) {
    //throw $th;
    return;
  }

  if (!$response) {
    return;
  }
  // Decode API response to array 
  $responseArr = json_decode($response);

  return $responseArr->data->link;
}
