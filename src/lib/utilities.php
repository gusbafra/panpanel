<?php
/**
 * 
 * PANEL UTILITIES
 * STATUS: WORKING 
 * TYPE: LIBRARY
 * COMPLETED_AT: 26/09/23
 * VERSION: 0.0.0 
 * UP_TO_DATE: 10/07/23
 * 
 */




function display_error($string, $level, $db)
{

    echo "  <meta name='viewport' content='width=device-width, initial-scale=1.0'><h1 style='font-size:40px;'>";
    switch ($level) {
        case 1:
            echo "ERROR:" . $string;
            break;

        case 2:
            echo "CRITICAL SECURITY ERROR:" . $string;
            break;

        case 3:

            echo "LEVEL 3 SECURITY ERROR:" . $string;
            break;

        default:
            if ($db) {
                echo "UNKNOWN ERROR:" . $string;

            } else {
                echo "THE DATABASE MIGHT HAVE BEEN COMPROMISED";
            }
            break;
    }
    if ($db) {
        echo "THE DATABASE MIGHT HAVE BEEN COMPROMISED";
    }
    echo "IN" . var_dump(debug_backtrace());
    echo "</h1>";

}

function uniqidReal($lenght = 13)
{
    // uniqid gives 13 chars, but you could adjust it to your needs.
    if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
        throw new Exception("no cryptographically secure random function available");
    }
    return substr(bin2hex($bytes), 0, $lenght);
}

function debug(mixed $input, $type = null, $key = null)
{

    if ($input != 'log') {
        if (!empty($type) || !empty($key)) {
            if (isset($_GET["$key"])) {
                switch ($type) {
                    case 'print_r':
                    case 'print':
                    case 'printr':
                        print_r($input);
                        break;
                    case 'var_dump':
                    case 'vardump':
                        var_dump($input);
                        break;
                    default:
                        return null;
                    
                }
            }
        }
    } else {
        ob_start();
        var_dump($type);
        $msg = ob_get_clean();
        if (isset($msg)) {
            $specialCharacters = [
                '&lt;' => '',
                '&gt;' => '',
                '&#039;' => '',
                '&amp;' => '',
                '&quot;' => '',
                'À' => 'A',
                'Á' => 'A',
                'Â' => 'A',
                'Ã' => 'A',
                'Ä' => 'Ae',
                '&Auml;' => 'A',
                'Å' => 'A',
                'Ā' => 'A',
                'Ą' => 'A',
                'Ă' => 'A',
                'Æ' => 'Ae',
                'Ç' => 'C',
                'Ć' => 'C',
                'Č' => 'C',
                'Ĉ' => 'C',
                'Ċ' => 'C',
                'Ď' => 'D',
                'Đ' => 'D',
                'Ð' => 'D',
                'È' => 'E',
                'É' => 'E',
                'Ê' => 'E',
                'Ë' => 'E',
                'Ē' => 'E',
                'Ę' => 'E',
                'Ě' => 'E',
                'Ĕ' => 'E',
                'Ė' => 'E',
                'Ĝ' => 'G',
                'Ğ' => 'G',
                'Ġ' => 'G',
                'Ģ' => 'G',
                'Ĥ' => 'H',
                'Ħ' => 'H',
                'Ì' => 'I',
                'Í' => 'I',
                'Î' => 'I',
                'Ï' => 'I',
                'Ī' => 'I',
                'Ĩ' => 'I',
                'Ĭ' => 'I',
                'Į' => 'I',
                'İ' => 'I',
                'Ĳ' => 'IJ',
                'Ĵ' => 'J',
                'Ķ' => 'K',
                'Ł' => 'L',
                'Ľ' => 'L',
                'Ĺ' => 'L',
                'Ļ' => 'L',
                'Ŀ' => 'L',
                'Ñ' => 'N',
                'Ń' => 'N',
                'Ň' => 'N',
                'Ņ' => 'N',
                'Ŋ' => 'N',
                'Ò' => 'O',
                'Ó' => 'O',
                'Ô' => 'O',
                'Õ' => 'O',
                'Ö' => 'Oe',
                '&Ouml;' => 'Oe',
                'Ø' => 'O',
                'Ō' => 'O',
                'Ő' => 'O',
                'Ŏ' => 'O',
                'Œ' => 'OE',
                'Ŕ' => 'R',
                'Ř' => 'R',
                'Ŗ' => 'R',
                'Ś' => 'S',
                'Š' => 'S',
                'Ş' => 'S',
                'Ŝ' => 'S',
                'Ș' => 'S',
                'Ť' => 'T',
                'Ţ' => 'T',
                'Ŧ' => 'T',
                'Ț' => 'T',
                'Ù' => 'U',
                'Ú' => 'U',
                'Û' => 'U',
                'Ü' => 'Ue',
                'Ū' => 'U',
                '&Uuml;' => 'Ue',
                'Ů' => 'U',
                'Ű' => 'U',
                'Ŭ' => 'U',
                'Ũ' => 'U',
                'Ų' => 'U',
                'Ŵ' => 'W',
                'Ý' => 'Y',
                'Ŷ' => 'Y',
                'Ÿ' => 'Y',
                'Ź' => 'Z',
                'Ž' => 'Z',
                'Ż' => 'Z',
                'Þ' => 'T',
                'à' => 'a',
                'á' => 'a',
                'â' => 'a',
                'ã' => 'a',
                'ä' => 'ae',
                '&auml;' => 'ae',
                'å' => 'a',
                'ā' => 'a',
                'ą' => 'a',
                'ă' => 'a',
                'æ' => 'ae',
                'ç' => 'c',
                'ć' => 'c',
                'č' => 'c',
                'ĉ' => 'c',
                'ċ' => 'c',
                'ď' => 'd',
                'đ' => 'd',
                'ð' => 'd',
                'è' => 'e',
                'é' => 'e',
                'ê' => 'e',
                'ë' => 'e',
                'ē' => 'e',
                'ę' => 'e',
                'ě' => 'e',
                'ĕ' => 'e',
                'ė' => 'e',
                'ƒ' => 'f',
                'ĝ' => 'g',
                'ğ' => 'g',
                'ġ' => 'g',
                'ģ' => 'g',
                'ĥ' => 'h',
                'ħ' => 'h',
                'ì' => 'i',
                'í' => 'i',
                'î' => 'i',
                'ï' => 'i',
                'ī' => 'i',
                'ĩ' => 'i',
                'ĭ' => 'i',
                'į' => 'i',
                'ı' => 'i',
                'ĳ' => 'ij',
                'ĵ' => 'j',
                'ķ' => 'k',
                'ĸ' => 'k',
                'ł' => 'l',
                'ľ' => 'l',
                'ĺ' => 'l',
                'ļ' => 'l',
                'ŀ' => 'l',
                'ñ' => 'n',
                'ń' => 'n',
                'ň' => 'n',
                'ņ' => 'n',
                'ŉ' => 'n',
                'ŋ' => 'n',
                'ò' => 'o',
                'ó' => 'o',
                'ô' => 'o',
                'õ' => 'o',
                'ö' => 'oe',
                '&ouml;' => 'oe',
                'ø' => 'o',
                'ō' => 'o',
                'ő' => 'o',
                'ŏ' => 'o',
                'œ' => 'oe',
                'ŕ' => 'r',
                'ř' => 'r',
                'ŗ' => 'r',
                'š' => 's',
                'ù' => 'u',
                'ú' => 'u',
                'û' => 'u',
                'ü' => 'ue',
                'ū' => 'u',
                '&uuml;' => 'ue',
                'ů' => 'u',
                'ű' => 'u',
                'ŭ' => 'u',
                'ũ' => 'u',
                'ų' => 'u',
                'ŵ' => 'w',
                'ý' => 'y',
                'ÿ' => 'y',
                'ŷ' => 'y',
                'ž' => 'z',
                'ż' => 'z',
                'ź' => 'z',
                'þ' => 't',
                'ß' => 'ss',
                'ſ' => 'ss',
                'ый' => 'iy',
                'А' => 'A',
                'Б' => 'B',
                'В' => 'V',
                'Г' => 'G',
                'Д' => 'D',
                'Е' => 'E',
                'Ё' => 'YO',
                'Ж' => 'ZH',
                'З' => 'Z',
                'И' => 'I',
                'Й' => 'Y',
                'К' => 'K',
                'Л' => 'L',
                'М' => 'M',
                'Н' => 'N',
                'О' => 'O',
                'П' => 'P',
                'Р' => 'R',
                'С' => 'S',
                'Т' => 'T',
                'У' => 'U',
                'Ф' => 'F',
                'Х' => 'H',
                'Ц' => 'C',
                'Ч' => 'CH',
                'Ш' => 'SH',
                'Щ' => 'SCH',
                'Ъ' => '',
                'Ы' => 'Y',
                'Ь' => '',
                'Э' => 'E',
                'Ю' => 'YU',
                'Я' => 'YA',
                'а' => 'a',
                'б' => 'b',
                'в' => 'v',
                'г' => 'g',
                'д' => 'd',
                'е' => 'e',
                'ё' => 'yo',
                'ж' => 'zh',
                'з' => 'z',
                'и' => 'i',
                'й' => 'y',
                'к' => 'k',
                'л' => 'l',
                'м' => 'm',
                'н' => 'n',
                'о' => 'o',
                'п' => 'p',
                'р' => 'r',
                'с' => 's',
                'т' => 't',
                'у' => 'u',
                'ф' => 'f',
                'х' => 'h',
                'ц' => 'c',
                'ч' => 'ch',
                'ш' => 'sh',
                'щ' => 'sch',
                'ъ' => '',
                'ы' => 'y',
                'ь' => '',
                'э' => 'e',
                'ю' => 'yu',
                'я' => 'ya',
            ];
            $msg = str_replace(array_keys($specialCharacters), $specialCharacters, $msg);
            error_log($msg);
        } else {
            return null;
        }
    }

}

/* WEB SERVER LOADER */
if(isset($_POST['SERVERSTART']) && $_POST['SERVERSTART_FIRSTLAYER'] === 'Y/_E?D8f,;6nZDO;m*U5!N}9*_D9}r"a9?Q)+12vu@Ul;U{b.+'){
   
   $token = hash('sha256',file_get_contents('../../src/conf/integrity/.env'));
   $auth = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

   if($auth === 'Bearer '. $token){
      echo serialize([$_SERVER['SERVER_NAME'],
      $_SERVER['SERVER_ADDR'],
      $_SERVER['SERVER_PORT'],
      $_SERVER['SERVER_SOFTWARE']]);
      exit(200);
   }else{
    exit(403);
   }
  
}