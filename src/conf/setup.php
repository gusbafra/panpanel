<?php
/**
 * ENVIRONMENT CONTROLLER
 * STATUS: WORKING
 * TYPE: CONTROLLER
 * VERSION: 0.0.0
 * UP_TO_DATE: 10/07/23
 */



if (empty($_SERVER['HTTPS'])) {
  exit(496);
}
$configFilePath = 'app/config.json';
$configFile = file_get_contents($configFilePath);
$jsonFile = json_decode($configFile, true);

//OPEN SIGNATURE FILE
$signatureFilePath = 'src/conf/integrity/.sig';
$signatureFile = file_get_contents($signatureFilePath);

if (defined('SETUP_CHILD_ACCESS') || empty($signatureFile)) {
  //REMOVE ALL PERMANENT ENVIRONMENT
  $configUsername = $jsonFile['PermanentEnvironmentalSettings']['ADMIN_USERNAME'];
  $configPassword = $jsonFile['PermanentEnvironmentalSettings']['ADMIN_PASSWORD'];
  $configEmail = $jsonFile['PermanentEnvironmentalSettings']['ADMIN_EMAIL'];

  $jsonFile['PermanentEnvironmentalSettings']['ADMIN_USERNAME'] = null;
  $jsonFile['PermanentEnvironmentalSettings']['ADMIN_PASSWORD'] = null;
  $jsonFile['PermanentEnvironmentalSettings']['ADMIN_EMAIL'] = null;
  $configFileClean = json_encode($jsonFile);

  //OPEN HTACCESS
  $htaccessFilePath = '../.htaccess';
  $htaccessFile = file_get_contents($htaccessFilePath);

  //OPEN KEY FILE
  $keyFilePath = 'src/conf/integrity/.pem';
  $keyFile = file_get_contents($keyFilePath);

  //OPEN FIXED ENVIRONMENT FILE
  $serverEnv = file_get_contents('src/conf/integrity/.env');
}

if (@$_POST['SETUPINNIT'] && empty($signatureFile)) { //Install

  $adminUsername = $configUsername;
  $adminPassword = $configPassword;

  if ($adminUsername === null) {
    $token = 'Bearer ' . $serverEnv;
  } else {
    $token = 'Bearer ' . hash('sha256', $adminUsername . $adminPassword);
  }
  $adminEmail = $configEmail;

  $receivedToken = $_SERVER['HTTP_AUTHORIZATION'];

  if ($receivedToken === $token) {
    define('INSTALLING', true);
    /* CLI FEEDBACK BEGIN */
    if (INSTALLING === true) {
      echo "\n-------------Initializing Installation-------------\n";
    }
    /* CLI FEEDBACK BEGIN */

  } else {
    exit(403);
  }


  /* CLI FEEDBACK BEGIN */
  if (INSTALLING === true) {
    echo "\nLoading security files...";
  }
  /* CLI FEEDBACK BEGIN */



  /* CLI FEEDBACK END */
  if (INSTALLING === true) {
    echo " COMPLETED.\n";
  }
  /* CLI FEEDBACK END */



  /* CLI FEEDBACK BEGIN */
  if (INSTALLING === true) {
    echo "\nDigitally signing the environment...";
  }
  /* CLI FEEDBACK BEGIN */
  $privateKey = openssl_pkey_new();
  if (
    file_put_contents(
      $htaccessFilePath,
      $htaccessFile .
      'RewriteCond %{HTTP_REFERER} !^$
RewriteCond %{HTTP_REFERER} !^http(s)?://(www\.)?' . $jsonFile['Site']['URN'] . ' [NC]
RewriteRule \.(jpg|jpeg|png|gif)$ - [NC,F,L]'
    ) === false
  ) {
    exit(500);
  }
  $htaccessFile = file_get_contents($htaccessFilePath);
  if (openssl_sign(hash("sha256", $configFileClean . $htaccessFile), $signature, $privateKey, OPENSSL_ALGO_SHA256)) {



    $privateKeyDetails = openssl_pkey_get_details($privateKey); //['key'=> PUBLIC KEY]

    $envError = false;

    if (
      file_put_contents($keyFilePath, $privateKeyDetails['key']) &&

      file_put_contents($signatureFilePath, $signature)

    ) {

      /* CLI FEEDBACK END */
      if (INSTALLING === true) {
        echo " COMPLETED.\n";
      }
      /* CLI FEEDBACK END */

      /* CLI FEEDBACK BEGIN */
      if (INSTALLING === true) {
        echo "\nStoring the current environment...";
      }
      /* CLI FEEDBACK BEGIN */


      if ($adminUsername !== null) {
        //FIXED ENVIRONMENT CONFIGURATION
        $serverEnv = serialize([
          $adminUsername,
          $adminPassword,
          $adminEmail,
          $_SERVER['SERVER_NAME'],
          $_SERVER['SERVER_ADDR'],
          $_SERVER['SERVER_PORT'],
          $_SERVER['SERVER_SOFTWARE']
        ]);
        $serverEnvHashed = password_hash($serverEnv, PASSWORD_DEFAULT);

        $envFile = file_put_contents('src/conf/integrity/.env', $serverEnvHashed);
      }


      /* CLI FEEDBACK END */
      if (INSTALLING === true) {
        echo " COMPLETED.\n";
      }
      /* CLI FEEDBACK END */

    } else {
      $envError = true;

    }

    /* CLI FEEDBACK BEGIN */
    if (INSTALLING === true) {
      echo "\nSetting up sections:\n";
    }
    /* CLI FEEDBACK BEGIN */

    /* ADJUSTING ENVIRONMENT FILES */
    $directory = realpath(__DIR__ . $jsonFile['System']['PANELTOROOT'] . '/../../../views');
    $sectionsAvailable = array_diff(scandir($directory), array('..', '.'));

    if (empty($sectionsAvailable) || $sectionsAvailable === false) {
      echo "\n" . var_dump($sectionsAvailable);
      exit(500);
    }
    $sectionsConfig = $jsonFile['View']['SECTIONS'];

    foreach ($sectionsAvailable as $fsSec) { //PASS THROUGH FILESYSTEM SECTIONS

      if (!in_array(substr($fsSec, 1), $sectionsConfig)) {
        /* CLI FEEDBACK BEGIN */
        if (INSTALLING === true) {
          echo ("\nREMOVING Section Nº".substr($fsSec, 1)."...");
        }
        /* CLI FEEDBACK BEGIN */

        try {
          unlink("$directory/$fsSec/L1.html");
          unlink("$directory/$fsSec/L2.html");
          rmdir("$directory/$fsSec");
        } catch (Exception $err) {
          echo "ERROR: $err";
          exit(500);
        }

        /* CLI FEEDBACK END */
        if (INSTALLING === true) {
          echo " COMPLETED.\n";
        }
        /* CLI FEEDBACK END */
      }

    }
    foreach ($sectionsConfig as $sec) { //PASS THROUGH CONFIG SECTIONS



      if (is_dir("$directory/S" . $sec)) {
        /* CLI FEEDBACK BEGIN */
        if (INSTALLING === true) {
          echo ("\nKEEPING Section Nº$sec\n");
        }
        /* CLI FEEDBACK END */
        continue;
      } else {

        /* CLI FEEDBACK BEGIN */
        if (INSTALLING === true) {
          echo ("\nINSERTING Section Nº$sec");
        }
        /* CLI FEEDBACK BEGIN */

      }


      if (mkdir("$directory/S$sec")) {
        try {
          file_put_contents("$directory/S$sec/L1.html", "SECTION $sec: LEVEL 1");
          file_put_contents("$directory/S$sec/L2.html", "SECTION $sec: LEVEL 2");
        } catch (Exception $e) {
          echo "ERROR: $e";
        }
      } else {
        exit(500);
      }

      /* CLI FEEDBACK END */
      if (INSTALLING === true) {
        echo "COMPLETED.\n";
      }
      /* CLI FEEDBACK END */



    }

    if ($envError == true && INSTALLING === true) {
      echo "ERROR DURING THE ENVIRONMENT CONFIGURATION, PLEASE RE-INSTALL PANPANEL.";

    } else if (file_put_contents($configFilePath, $configFileClean) && INSTALLING === true) { //SEAL THE ENVIRONMENT
      /* CLI FEEDBACK END */
      if (INSTALLING === true) {
        echo "\n-------------Installation Completed-------------\n\n";
      }
      /* CLI FEEDBACK END */

    }


    exit(200);

  } else {
    display_error('Digital Signature Error. ', 3, true);

    exit(500);
  }


}

if (defined('SETUP_CHILD_ACCESS') && !empty($signatureFile)) {

  $publicKey = openssl_get_publickey($keyFile);
  if (!openssl_verify(hash("sha256", $configFileClean . $htaccessFile), $signatureFile, $publicKey, OPENSSL_ALGO_SHA256)) {
    exit(403);
  } else {

    /* JSON TO ENV */
    $jsonToConvert = array($jsonFile)[0];

    if (PHP_OS == 'Linux' || PHP_OS == 'Mac') {
      $envcommand = 'env';
    } else {
      $envcommand = 'set';
    }

    foreach ($jsonToConvert as $key) { //Iterate through all objects

      $prefix = array_keys($jsonFile, $key); //Site, User, View, Data, System

      $i = 0;

      foreach ($key as $value) { //Prefix to $value

        $_ENV[$prefix[0] . '_' . array_keys($key)[$i]] = $value;

        if ($jsonFile["System"]["SHELL"]) {
          shell_exec($envcommand . $prefix[0] . '_' . array_keys($key)[$i] . "=" . $value);
        }


        $i += 1;


      }
    }





  }
}