<?php
/**
 * 
 * ENVIRONMENT RECONFIGURATION AUTHORIZATION
 * STATUS: WORKING
 * TYPE: CONTROLLER
 * VERSION: 0.0.0 
 * UP_TO_DATE: 10/07/23
 * 
 **/


if (PHP_SAPI === 'cli') {


    echo "\n\n\n\n***************************************************************\n";
    echo " ______ _______ _______ ______ _______ _______ _______ _____   \n";
    echo "|   __ \   _   |    |  |   __ \   _   |    |  |    ___|     |_ \n";
    echo "|    __/       |       |    __/       |       |    ___|       |\n";
    echo "|___|  |___|___|__|____|___|  |___|___|__|____|_______|_______|\n\n";
    echo "***************************************************************\n";
    echo "\n COMMAND LINE INTERFACE FOR INSTALLATION AND RECONFIGURATION \n\n";

    $try = 5;
    while ($try !== 0) {
        echo "\nADMIN USERNAME: ";

        $username = rtrim(fgets(STDIN));

        echo "\nADMIN PASSWORD (input hidden): ";

        system('stty -echo');
        $password = rtrim(fgets(STDIN));
        system('stty echo');


        echo "\n\nADMIN E-MAIL (input hidden): ";

        system('stty -echo');
        $email = rtrim(fgets(STDIN));
        system('stty echo');


        $originalServerEnv = file_get_contents('../src/conf/integrity/.env');
        $signature = file_get_contents('../src/conf/integrity/.pem');
        $configFile = json_decode(file_get_contents('config.json'));


        
        if (!empty($originalServerEnv)) { //Reconfiguration
            $servBearer = hash('sha256', $originalServerEnv);

            $servCh = curl_init('https://' . $configFile->Site->URN . '/utilities');
            curl_setopt($servCh, CURLOPT_POST, true);
            curl_setopt($servCh, CURLOPT_POSTFIELDS, ["SERVERSTART" => true, "SERVERSTART_FIRSTLAYER" => 'Y/_E?D8f,;6nZDO;m*U5!N}9*_D9}r"a9?Q)+12vu@Ul;U{b.+']);
            curl_setopt($servCh, CURLOPT_RETURNTRANSFER, true);
            /* AUTH */
            curl_setopt($servCh, CURLOPT_HEADER, 0);
            curl_setopt($servCh, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $servBearer));
            $servReturn = curl_exec($servCh);

            if ($servReturn !== false && curl_getinfo($servCh, CURLINFO_RESPONSE_CODE) === 200) {

                $serverData = unserialize($servReturn);
                curl_close($servCh);
            } else {
                echo "ERROR" . ': ' . curl_getinfo($servCh, CURLINFO_RESPONSE_CODE) . $servReturn;
                curl_close($servCh);
                echo "\n" . "CONNECTION TERMINATED.";
              
                exit(500);
            }
            $serverEnv = serialize([
                $username,
                $password,
                $email,
                $serverData[0],
                $serverData[1],
                $serverData[2],
                $serverData[3]
            ]);

            $auth = password_verify($serverEnv, $originalServerEnv);
        }else{
            $auth = 0;
        }

        /* INSTALLATION PROCESS */
        if (empty($signature)) {


            if (
                $configFile->PermanentEnvironmentalSettings->ADMIN_USERNAME == $username &&
                $configFile->PermanentEnvironmentalSettings->ADMIN_PASSWORD == $password ||
                $auth
            ) {


                echo "\n\nPRESS ANY KEY TO INITIALIZE THE PANPANEL INSTALLER\n";
                rtrim(fgets(STDIN));

                $bearer = ($auth) ? $originalServerEnv : hash('sha256', $username . $password);

                $ch = curl_init('https://' . $configFile->Site->URN);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, ["SETUPINNIT" => true]);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                /* AUTH */
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $bearer));
                $return = curl_exec($ch);

                if ($return !== false && curl_getinfo($ch, CURLINFO_RESPONSE_CODE) === 200) {
                    echo $return;
                    curl_close($ch);
                    exit(200);

                } else {
                    echo "ERROR" . ': ' . curl_getinfo($ch, CURLINFO_RESPONSE_CODE) . $return;
                    echo "\n" . "CONNECTION TERMINATED.";
                    curl_close($ch);
                    exit(500);
                }



            } else {

                echo "\n\nACCESS DENIED: " . $try . " TRIES LEFT\n";
                $try -= 1;
                sleep(2);
            }
            if ($try == 0) {

                echo "\n\nTOO MANY TRIES, THE SYSTEM HAS BEEN LOCKED. \n CONNECTION TERMINATED.\n\n";

                //ADICIONAR IDS

                exit(406);
            }

        }
  

          
       

        if ($auth) { //ENCRIPTED AUTHENTICATION

            echo "Access granted. Welcome back $username.\n";
            echo "PRESS ANY KEY TO START THE RECONFIGURATION PROCESS";

            rtrim(fgets(STDIN));

            /* CLI FEEDBACK BEGIN */
            echo "\n------------- Initializing unsealing  -------------\n";
            /* CLI FEEDBACK BEGIN */

            /* CLI FEEDBACK BEGIN */
            echo "\nRemoving digital signature...";
            /* CLI FEEDBACK BEGIN */

            $pemPath = "../src/conf/integrity/.pem";
            $sigPath = "../src/conf/integrity/.sig";

            if (file_put_contents($pemPath, '') !== false && file_put_contents($sigPath, '') !== false) {

                /* CLI FEEDBACK END */
                echo " Completed.\n\n";
                /* CLI FEEDBACK END */

            } else {
                echo " ERROR.";
                exit(400);
            }

            /* CLI FEEDBACK BEGIN */
            echo "\n------------- Reconfiguration allowed -------------\n";
            /* CLI FEEDBACK BEGIN */
            exit(200);



        } else {

            echo "\n\nACCESS DENIED: " . $try . " TRIES LEFT\n";
            $try -= 1;
            sleep(2);
        }
        if ($try == 0) {

            echo "\n\nTOO MANY TRIES, CONNECTION TERMINATED.\n\n";

            //ADICIONAR IDS

            exit(406);
        }

    }
} else {
    exit(404);
}