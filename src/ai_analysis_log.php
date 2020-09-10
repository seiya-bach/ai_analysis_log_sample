<?php

/**
 * AiAnalysisLog class.
 */
class AiAnalysisLog
{
  public function setaianalysislog($image_path)
  {
    $config = parse_ini_file('./config.ini');
    $url = $config['api_url'];
    $requestParams = array('image_path' => $image_path);

    try {
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL,  $url);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $requestParams);
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($curl, CURLOPT_TIMEOUT, 10);
      $response = curl_exec($curl);
      $info     = curl_getinfo($curl);
      $errNo    = curl_errno($curl);
      $error    = curl_error($curl);
      curl_close($curl);

      if ($errNo !== CURLE_OK || $info['http_code'] !== 200) {
        echo 'Error: ' . $error;
        return;
      }

      if (!isset($response) || empty($response)) {
        echo 'Error: Response is null.';
        return;
      }

      $aiAnalysisLogData = json_decode($response, true);

      require_once './ai_analysis_logModel.php';
      $ai_analysis_logModel = new ai_analysis_logModel();
      $ai_analysis_logModel->insertAiAnalysisLog($image_path, $aiAnalysisLogData);
    } catch (Exception $e) {
      echo 'Error: ' . $e->getMessage();
      return;
    }

    echo 'Success!';
    return;
  }
}
if ($argc < 2) {
  echo "Error: Require image path.";
  return;
}
if (!file_exists($argv[1])) {
  echo "Error: File not exists.";
  return;
}
if (false == exif_imagetype($argv[1])) {
  echo "Error: Not image file.";
  return;
}

$aiAnalysisLogObj = new AiAnalysisLog();
$aiAnalysisLogObj->setaianalysislog($argv[1]);
