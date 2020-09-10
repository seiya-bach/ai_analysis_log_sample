<?php

/**
 * ai_analysis_logModel table model class.
 */
class ai_analysis_logModel
{
  public function dbconnector()
  {
    try {
      $config = parse_ini_file('./config.ini');
      $dsn = $config['db'] . ':dbname=' . $config['dbname'] . ';host=' . $config['host'] . ';charset=utf8';
      $user = $config['mysql_user'];
      $password = $config['mysql_password'];

      $option = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
      );
      return new PDO($dsn, $user, $password, $option);
    } catch (PDOException $e) {
      throw $e;
    }
  }

  public function insertAiAnalysisLog($image_path, $aiAnalysisLogData)
  {
    try {
      $db = $this->dbconnector();

      $statement = $db->prepare("INSERT INTO ai_analysis_log(image_path, success, message, class, confidence, request_timestamp, response_timestamp)"
        . " VALUES (:image_path, :success, :message, :class, :confidence, :request_timestamp, :response_timestamp)");

      $success    = ($aiAnalysisLogData['success']) ? 'true' : 'false';
      $class      = isset($aiAnalysisLogData["estimated_data"]['class']) ? $aiAnalysisLogData["estimated_data"]['class'] : null;
      $confidence = isset($aiAnalysisLogData["estimated_data"]['confidence']) ? $aiAnalysisLogData["estimated_data"]['confidence'] : null;
      $timestamp  = time();
      $statement->bindParam(':image_path',         $image_path, PDO::PARAM_STR);
      $statement->bindParam(':success',            $success, PDO::PARAM_STR);
      $statement->bindParam(':message',            $aiAnalysisLogData['message'], PDO::PARAM_STR);
      $statement->bindParam(':class',              $class, PDO::PARAM_INT);
      $statement->bindParam(':confidence',         $confidence, PDO::PARAM_STR);
      $statement->bindParam(':request_timestamp',  $timestamp, PDO::PARAM_INT);
      $statement->bindParam(':response_timestamp', $timestamp, PDO::PARAM_INT);

      $statement->execute();
    } catch (PDOException $e) {
      throw $e;
    }

    return;
  }
}
