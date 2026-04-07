<?php ${"GLOBALS"}["actgcvpuf"] = "ua";
${"GLOBALS"}["mjkhdpxhgmjg"] = "encPassword";
${"GLOBALS"}["buebptu"] = "installAdmPass1";
${"GLOBALS"}["cmcsqsec"] = "installAdmPass2";
${"GLOBALS"}["wmpiorxvjy"] = "installAdmName";
${"GLOBALS"}["mtvysnojn"] = "site_location";
${"GLOBALS"}["eyftbyfggq"] = "site_email";
${"GLOBALS"}["hdjlibregjcq"] = "site_secure";
${"GLOBALS"}["kfisocrpb"] = "site_description";
${"GLOBALS"}["pebuurt"] = "site_title";
${"GLOBALS"}["ajjhdiuol"] = "site_name";
${"GLOBALS"}["jwojuretvlq"] = "config";
${"GLOBALS"}["nlrvfvulxq"] = "db";
${"GLOBALS"}["odsssyrod"] = "mn_oid";
${"GLOBALS"}["gtsveqo"] = "license_check";
${"GLOBALS"}["kvyeucasttw"] = "message";
${"GLOBALS"}["qgugvkskit"] = "mn_key";
${"GLOBALS"}["umkewvbzsn"] = "is_license";
$fvfkmcyuk = "is_license";
${"GLOBALS"}["pesmhguilngm"] = "token";
${"GLOBALS"}["pzjtklyp"] = "hash";
${"GLOBALS"}["fiugcrviy"] = "pass";
${"GLOBALS"}["mdxceqdf"] = "Validation";
${"GLOBALS"}["lprqgrybqx"] = "Requirements";
${"GLOBALS"}["vobmhmqcqves"] = "DbImport";
${"GLOBALS"}["hpgchjklqh"] = "dirname";
error_reporting(E_ALL);
ini_set("session.use_trans_sid", false);
ini_set("session.use_cookies", true);
ini_set("session.use_only_cookies", true);
${"GLOBALS"}["nsbguxwohvf"] = "https";
${${"GLOBALS"}["nsbguxwohvf"]} = false;
${"GLOBALS"}["lhflnjr"] = "FileWrite";
${"GLOBALS"}["ubigtsdvrpj"] = "https";
if (isset($_SERVER["HTTPS"]) and $_SERVER["HTTPS"] != "off")
    ${${"GLOBALS"}["ubigtsdvrpj"]} = true;
${"GLOBALS"}["hwnjqojce"] = "is_license";
${"GLOBALS"}["psomtp"] = "https";
${"GLOBALS"}["xtuwlpbwsot"] = "dirname";
${${"GLOBALS"}["hpgchjklqh"]} = rtrim(dirname($_SERVER["PHP_SELF"]), "/") . "/";
session_name("ci_installer");
session_set_cookie_params(0, ${${"GLOBALS"}["xtuwlpbwsot"]}, $_SERVER["HTTP_HOST"], ${${"GLOBALS"}["psomtp"]}, true);
session_start();
${"GLOBALS"}["iwdljqd"] = "message";
$ifompxw = "is_license";
define("BASEPATH", true);
require_once __DIR__ . "/vendor/autoload.php";
use Php\Requirements;
$mqxwbxrl = "path";
use Php\Validation;
${"GLOBALS"}["thnneo"] = "is_license";
use Php\DbImport;
$xhnprgnqcsk = "is_license";
use Php\FileWrite;
${${"GLOBALS"}["lprqgrybqx"]} = new Requirements();
${${"GLOBALS"}["mdxceqdf"]} = new Validation();
${${"GLOBALS"}["vobmhmqcqves"]} = new DbImport();
${${"GLOBALS"}["lhflnjr"]} = new FileWrite();
if ($Validation->checkEnvFileExists() === true) {
    header("location: ../index.php");
}
$script_name = "PaidOffers";
${$mqxwbxrl} = ["sql_path" => "sql/install.sql", "sql_data_path" => "sql/data.sql", "template_path" => "php/Database.php", "output_path" => "../system/database.php",];
${${"GLOBALS"}["iwdljqd"]} = null;
function securePassword($pass)
{
    $jiicnrfyqgtu = "hash";
    ${"GLOBALS"}["oimfgfwe"] = "pass";
    ${$jiicnrfyqgtu} = md5(md5(sha1(${${"GLOBALS"}["oimfgfwe"]}) . sha1(md5(${${"GLOBALS"}["fiugcrviy"]}))));
    return ${${"GLOBALS"}["pzjtklyp"]};
}
if (empty($_SESSION["_token"])) {
    if (function_exists("mcrypt_create_iv")) {
        $_SESSION["_token"] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
    } else {
        $_SESSION["_token"] = bin2hex(openssl_random_pseudo_bytes(32));
    }
}
${${"GLOBALS"}["pesmhguilngm"]} = $_SESSION["_token"];
${$ifompxw} = isset($_SESSION["validLicense"]) ? true : true;
if (!${${"GLOBALS"}["umkewvbzsn"]} && isset($_GET["step3"]) || !${${"GLOBALS"}["umkewvbzsn"]} && isset($_GET["step4"]) || !${$xhnprgnqcsk} && isset($_GET["step5"]) || !${$fvfkmcyuk} && isset($_GET["complete"])) {
    header("location: index.php?step3");
    exit;
}
elseif (isset($_GET["step3"]) && ${${"GLOBALS"}["umkewvbzsn"]}) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if ($Validation->run($_POST) === true) {
            ${"GLOBALS"}["vguvxvwad"] = "path";
            if ($Validation->checkFileExists(${${"GLOBALS"}["vguvxvwad"]}["sql_path"]) == false) {
                ${${"GLOBALS"}["kvyeucasttw"]} .= "<li>install.sql file is not exists in sql/ directory!</li>";
            } else {
                ${"GLOBALS"}["kkgmrrcgxxi"] = "path";
                if ($FileWrite->databaseConfig(${${"GLOBALS"}["kkgmrrcgxxi"]}, $_POST) === false) {
                    ${${"GLOBALS"}["kvyeucasttw"]} .= "<li>The database file could not be written, ";
                    ${${"GLOBALS"}["kvyeucasttw"]} .= "please chmod ../system/database.php file to 777</li>";
                } elseif ($DbImport->createDatabase($_POST) === false) {
                    $qhsiniahdfl = "message";
                    $hwugnvy = "message";
                    ${$hwugnvy} .= "<li>The database could not be created, ";
                    ${$qhsiniahdfl} .= "please verify your settings.</li>";
                } elseif ($DbImport->createTables($_POST) === false) {
                    $frsxbywtt = "message";
                    ${$frsxbywtt} .= "<li>The database tables could not be created, ";
                    ${${"GLOBALS"}["kvyeucasttw"]} .= "please verify your settings.</li>";
                } else {
                    header("location: index.php?step4");
                }
            }
        } else {
            $hxkaway = "message";
            ${$hxkaway} = $Validation->run($_POST);
        }
    }
} elseif (isset($_GET["step4"]) && ${${"GLOBALS"}["hwnjqojce"]}) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $rkwixk = "config";
        $vrmllj = "config";
        $ocpvvpddyn = "site_location";
        $rgoclr = "config";
        require_once("../system/database.php");
        require_once("../system/libs/database/" . ${$vrmllj}["sql_extenstion"] . ".php");
        ${${"GLOBALS"}["nlrvfvulxq"]} = new MySQLConnection(${${"GLOBALS"}["jwojuretvlq"]}["sql_host"], ${${"GLOBALS"}["jwojuretvlq"]}["sql_username"], ${$rkwixk}["sql_password"], ${$rgoclr}["sql_database"]);
        $hgszfbbvu = "site_email";
        $db->Connect();
        ${${"GLOBALS"}["ajjhdiuol"]} = $db->EscapeString($_POST["site_name"]);
        ${${"GLOBALS"}["pebuurt"]} = $db->EscapeString($_POST["site_title"]);
        ${${"GLOBALS"}["kfisocrpb"]} = $db->EscapeString($_POST["site_description"]);
        ${$ocpvvpddyn} = $db->EscapeString($_POST["site_location"]);
        ${${"GLOBALS"}["hdjlibregjcq"]} = $db->EscapeString($_POST["site_secure"]);
        ${${"GLOBALS"}["eyftbyfggq"]} = $db->EscapeString($_POST["site_email"]);
        if (${${"GLOBALS"}["ajjhdiuol"]} != "" && ${${"GLOBALS"}["kfisocrpb"]} != "" && ${${"GLOBALS"}["mtvysnojn"]} != "" && ${${"GLOBALS"}["hdjlibregjcq"]} != "" && ${$hgszfbbvu} != "" && ${${"GLOBALS"}["pebuurt"]} != "") {
            $tmgdvzdidzq = "path";
            $wpdnjxfutdut = "config";
            $lfkcapji = "config";
            $sbdajlsx = "config";
            if ($Validation->checkFileExists(${$tmgdvzdidzq}["sql_data_path"]) == false) {
                $mkwryqenxbb = "message";
                ${$mkwryqenxbb} .= "<li>data.sql file is not exists in sql/ directory!</li>";
            } elseif ($DbImport->insertData(array("hostname" => ${$sbdajlsx}["sql_host"], "username" => ${$lfkcapji}["sql_username"], "database" => ${$wpdnjxfutdut}["sql_database"], "password" => ${${"GLOBALS"}["jwojuretvlq"]}["sql_password"])) === false) {
                $ngixfgpnre = "message";
                ${"GLOBALS"}["nkuavwg"] = "message";
                ${$ngixfgpnre} .= "<li>The data could not be inserted, ";
                ${${"GLOBALS"}["nkuavwg"]} .= "please verify your settings.</li>";
            } else {
                $cepihzekwh = "site_name";
                ${"GLOBALS"}["tqobawuh"] = "ua";
                ${"GLOBALS"}["yrpnvgeiyuw"] = "ua";
                $ajkjixqtqdu = "site_title";
                $rpajop = "site_location";
                ${"GLOBALS"}["ymrntd"] = "site_secure";
                ${${"GLOBALS"}["tqobawuh"]} = "INSERT INTO `site_config` (`config_name`, `config_value`) VALUES('analytics_id', ''),('coins_rate', '10000'),('cron_users', '0'),('def_lang', 'en'),('force_secure', '1'),('hold_days', '7'),('login_attempts', '3'),('login_wait_time', '10'),('mail_delivery_method', '0'),('mod_rewrite', '1'),('more_per_ip', '0'),('noreply_email', '" . ${${"GLOBALS"}["eyftbyfggq"]} . "'),('proxycheck', ''),('proxycheck_status', '0'),('recaptcha_pub', ''),('recaptcha_sec', ''),('ref_com', '10'),('reg_reqmail', '0'),('secure_url', '" . ${${"GLOBALS"}["ymrntd"]} . "'),('site_description', ''),('site_email', '" . ${${"GLOBALS"}["eyftbyfggq"]} . "'),('site_keywords', ''),('site_logo', '" . ${$cepihzekwh} . "'),('site_name', '" . ${$ajkjixqtqdu} . "'),('site_url', '" . ${$rpajop} . "'),('smtp_auth', '0'),('smtp_host', 'localhost'),('smtp_password', ''),('smtp_port', '25'),('smtp_username', '')";
                if ($db->query(${${"GLOBALS"}["yrpnvgeiyuw"]})) {
                    header("location: index.php?step5");
                } else {
                    ${"GLOBALS"}["dupnmbcc"] = "message";
                    ${${"GLOBALS"}["dupnmbcc"]} .= "<li>Update Failed! An error occurred while trying to update database.</li>";
                }
            }
        } else {
            ${"GLOBALS"}["jnbaxdi"] = "message";
            ${${"GLOBALS"}["jnbaxdi"]} .= "<li>Please complete all fields to continue.</li>";
        }
    }
} elseif (isset($_GET["step5"]) && ${${"GLOBALS"}["thnneo"]}) {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        ${"GLOBALS"}["ymrjqclsri"] = "installAdmPass1";
        require_once("../system/database.php");
        $krqgyhbhye = "config";
        ${"GLOBALS"}["bprugamkq"] = "db";
        ${"GLOBALS"}["tvetolfemjj"] = "config";
        ${"GLOBALS"}["lgeoiyvs"] = "installAdmMail";
        ${"GLOBALS"}["tnkytfipin"] = "config";
        $hbjcjz = "config";
        require_once("../system/libs/database/" . ${${"GLOBALS"}["jwojuretvlq"]}["sql_extenstion"] . ".php");
        ${${"GLOBALS"}["bprugamkq"]} = new MySQLConnection(${$krqgyhbhye}["sql_host"], ${${"GLOBALS"}["tvetolfemjj"]}["sql_username"], ${${"GLOBALS"}["tnkytfipin"]}["sql_password"], ${$hbjcjz}["sql_database"]);
        $db->Connect();
        ${${"GLOBALS"}["wmpiorxvjy"]} = $db->EscapeString($_POST["admname"]);
        ${${"GLOBALS"}["lgeoiyvs"]} = $db->EscapeString($_POST["admmail"]);
        $usjnkkcoakn = "installAdmMail";
        ${${"GLOBALS"}["ymrjqclsri"]} = $db->EscapeString($_POST["admpass1"]);
        ${${"GLOBALS"}["cmcsqsec"]} = $db->EscapeString($_POST["admpass2"]);
        if (${${"GLOBALS"}["buebptu"]} != ${${"GLOBALS"}["cmcsqsec"]}) {
            ${${"GLOBALS"}["kvyeucasttw"]} .= "Passwords does not match!";
        } elseif (${${"GLOBALS"}["wmpiorxvjy"]} != "" && ${$usjnkkcoakn} != "" && ${${"GLOBALS"}["buebptu"]} != "") {
            ${"GLOBALS"}["vobramlxcn"] = "installAdmPass1";
            ${"GLOBALS"}["xoodseyu"] = "installAdmName";
            ${"GLOBALS"}["onsqofopv"] = "encPassword";
            $mycmeio = "ua";
            ${"GLOBALS"}["qpujkeakfuh"] = "installAdmMail";
            ${${"GLOBALS"}["mjkhdpxhgmjg"]} = securePassword(${${"GLOBALS"}["vobramlxcn"]});
            ${$mycmeio} = "INSERT INTO `users` (`email`,`username`,`admin`,`reg_ip`,`password`,`reg_time`)VALUES('" . ${${"GLOBALS"}["qpujkeakfuh"]} . "', '" . ${${"GLOBALS"}["xoodseyu"]} . "',  '1', '" . $_SERVER["REMOTE_ADDR"] . "', '" . ${${"GLOBALS"}["onsqofopv"]} . "', '" . time() . "')";
            if ($db->query(${${"GLOBALS"}["actgcvpuf"]})) {
                header("location: index.php?complete");
            } else {
                ${"GLOBALS"}["pkvlrbdplq"] = "message";
                ${${"GLOBALS"}["pkvlrbdplq"]} .= "An Unknown error occured while adding the administrator.<br />Please try again or contact our support if the error prevails.";
            }
        } else {
            ${${"GLOBALS"}["kvyeucasttw"]} .= "Please complete all fields!";
        }
    }
} elseif (${${"GLOBALS"}["umkewvbzsn"]} && isset($_GET["complete"]) && $Validation->checkEnvFileExists() === true) {
    $FileWrite->createEnvFile();
    session_destroy();
} else {
    $Validation->checkEnvFileExists();
}
echo " \n<!DOCTYPE html>\n<html lang=\"en\">\n    <head> \n        <meta charset=\"utf-8\">\n        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">\n        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n        <link rel=\"icon\" type=\"image/png\" href=\"assets/img/favicon.png\" sizes=\"32x32\">\n\n        <title>";
echo $script_name;
echo " - Installation</title>\n        <link rel=\"stylesheet\" href=\"assets/css/bootstrap.min.css\">\n        <!-- custom css  -->\n        <link rel=\"stylesheet\" href=\"assets/css/style.css\"> \n\n        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->\n        <!--[if lt IE 9]>\n          <script src=\"https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js\"></script>\n          <script src=\"https://oss.maxcdn.com/respond/1.4.2/respond.min.js\"></script>\n        <![endif]-->\n    </head>\n    <body>\n        <div class=\"container\"> \n            <div class=\"row\"> \n                <div class=\"col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1\"> \n                <div class=\"row\">\n                    <div class=\"app_title\"> \n                        <h1><img src=\"assets/img/icon.png\" alt=\"logo\"> ";
echo $script_name;
echo " Installation</h1>\n                    </div>\n\t\t\t\t\t";
if (isset($_GET["step1"]) || (!isset($_GET["step1"]) && !isset($_GET["step3"]) && !isset($_GET["step4"]) && !isset($_GET["step5"]) && !isset($_GET["complete"]))) {
    echo "                    <div class=\"app_content\">\n                        <div class=\"row\">\n                            <div class=\"col-sm-12\">\n                                    <h3 class=\"title text-center\">Directory permissions & requirements</h3>\n                                    <!-- display requirements -->\n                                    ";
    echo $Requirements->directoriesAndPermission();
    echo "                                    ";
    echo $Requirements->server();
    echo "\n                                <div class=\"divider\"></div>\n                                <a href=\"index.php?step3\" class=\"cbtn pull-right\">Next</a>\n                            </div>\n                        </div>\n                    </div>\n                ";
}

if (isset($_GET["step3"])) {
    ${"GLOBALS"}["pupsgd"] = "message";
    echo "                    <div class=\"app_content\">\n                        <div class=\"row\">\n                            <div class=\"col-sm-12\">\n                                <h3 class=\"title text-center margin\">Please fill with your MySQL database info.</h3>\n\t\t\t\t\t\t\t\t<form method=\"post\" class=\"form\">\n\t\t\t\t\t\t\t\t   ";
    ${"GLOBALS"}["igbtwpjj"] = "token";
    if (!empty(${${"GLOBALS"}["pupsgd"]})) {
        echo "<div class=\"alert alert-danger\"><ul>$message</ul></div>";
    }
    echo "                                    <input type=\"hidden\" name=\"_token\" value=\"";
    echo (!empty(${${"GLOBALS"}["igbtwpjj"]}) ? ${${"GLOBALS"}["pesmhguilngm"]} : null);
    echo "\"/>\n                                    <div class=\"form-group\">\n                                        <label for=\"database\">Database Name </label>\n                                        <input type=\"text\" name=\"database\" class=\"form-control\" id=\"database\" placeholder=\"Database Name\" value=\"";
    echo (!empty($_POST["database"]) ? $_POST["database"] : null);
    echo "\">\n                                    </div> \n                                    <div class=\"form-group\">\n                                        <label for=\"username\">Username </label>\n                                        <input type=\"text\" name=\"username\" class=\"form-control\" id=\"username\" placeholder=\"Username\" value=\"";
    echo (!empty($_POST["username"]) ? $_POST["username"] : null);
    echo "\">\n                                    </div> \n                                    <div class=\"form-group\">\n                                        <label for=\"password\">Password </label>\n                                        <input type=\"text\" name=\"password\" class=\"form-control\" id=\"password\" placeholder=\"Password\" value=\"";
    echo (!empty($_POST["password"]) ? $_POST["password"] : null);
    echo "\">\n                                    </div>\n                                    <div class=\"form-group\">\n                                        <label for=\"hostname\">Host Name </label>\n                                        <input type=\"text\" name=\"hostname\" class=\"form-control\" id=\"hostname\" placeholder=\"Host Name\"  value=\"";
    echo (!empty($_POST["hostname"]) ? $_POST["hostname"] : "localhost");
    echo "\">\n                                    </div>  \n                                    <button type=\"submit\" class=\"cbtn pull-right\">Next</button>\n\t\t\t\t\t\t\t\t\t<div class=\"clear\"></div>\n                                </form>\n\n                            </div>\n                        </div>\n                    </div>\n                ";
}
if (isset($_GET["step4"])) {
    ${"GLOBALS"}["yhmhnvh"] = "message";
    ${"GLOBALS"}["qsiyvbkefv"] = "token";
    echo "                    <div class=\"app_content\">\n                        <div class=\"row\">\n                            <div class=\"col-sm-12\">\n                                <h3 class=\"title text-center margin\">Please provide some info about your website.</h3>\n                                <form method=\"post\" class=\"form\">\n\t\t\t\t\t\t\t\t   ";
    if (!empty(${${"GLOBALS"}["yhmhnvh"]})) {
        echo "<div class=\"alert alert-danger\"><ul>$message</ul></div>";
    }
    echo "                                    <input type=\"hidden\" name=\"_token\" value=\"";
    echo (!empty(${${"GLOBALS"}["qsiyvbkefv"]}) ? ${${"GLOBALS"}["pesmhguilngm"]} : null);
    echo "\"/>\n                                    <div class=\"form-group\">\n                                        <label for=\"site_name\">Site Name </label>\n                                        <input type=\"text\" name=\"site_name\" class=\"form-control\" id=\"site_name\" placeholder=\"PaidOffers\" value=\"";
    echo (!empty($_POST["site_name"]) ? $_POST["site_name"] : null);
    echo "\">\n                                    </div> \n                                    <div class=\"form-group\">\n                                        <label for=\"site_name\">Site Title </label>\n                                        <input type=\"text\" name=\"site_title\" class=\"form-control\" id=\"site_title\" placeholder=\"PaidOffers - Earn FREE Cash!\" value=\"";
    echo (!empty($_POST["site_title"]) ? $_POST["site_title"] : null);
    echo "\">\n                                    </div> \n                                    <div class=\"form-group\">\n                                        <label for=\"site_description\">Site Description </label>\n                                        <input type=\"text\" name=\"site_description\" class=\"form-control\" id=\"site_description\" placeholder=\"Earn cash with this amazing website!\" value=\"";
    echo (!empty($_POST["site_description"]) ? $_POST["site_description"] : null);
    echo "\">\n                                    </div>\n                                    <div class=\"form-group\">\n                                        <label for=\"site_location\">Site URL </label>\n                                        <input type=\"text\" name=\"site_location\" class=\"form-control\" id=\"site_location\" placeholder=\"http://mysite.com\"  value=\"";
    echo (!empty($_POST["site_location"]) ? $_POST["site_location"] : "http://" . $_SERVER["HTTP_HOST"]);
    echo "\">\n                                    </div>\n                                    <div class=\"form-group\">\n                                        <label for=\"site_secure\">Secure URL </label>\n                                        <input type=\"text\" name=\"site_secure\" class=\"form-control\" id=\"site_secure\" placeholder=\"https://mysite.com\"  value=\"";
    echo (!empty($_POST["site_secure"]) ? $_POST["site_secure"] : "https://" . $_SERVER["HTTP_HOST"]);
    echo "\">\n                                    </div>\n                                    <div class=\"form-group\">\n                                        <label for=\"site_email\">Contact Email </label>\n                                        <input type=\"text\" name=\"site_email\" class=\"form-control\" id=\"site_email\" placeholder=\"contact@";
    echo $_SERVER["HTTP_HOST"];
    echo "\" value=\"";
    echo (!empty($_POST["site_email"]) ? $_POST["site_email"] : null);
    echo "\">\n                                    </div>\n                                    <button type=\"submit\" class=\"cbtn pull-right\">Next</button>\n\t\t\t\t\t\t\t\t\t<div class=\"clear\"></div>\n                                </form>\n                            </div>\n                        </div>\n                    </div>\n                ";
}
if (isset($_GET["step5"])) {
    ${"GLOBALS"}["vmiwneewvvb"] = "token";
    $odnvatbjwgej = "token";
    $fqkwmjhly = "message";
    echo "                    <div class=\"app_content\">\n                        <div class=\"row\">\n                            <div class=\"col-sm-12\">\n                                <h3 class=\"title text-center margin\">Please create an administrator account.</h3>\n                                <form method=\"post\" class=\"form\">\n\t\t\t\t\t\t\t\t   ";
    if (!empty(${$fqkwmjhly})) {
        echo "<div class=\"alert alert-danger\"><ul>$message</ul></div>";
    }
    echo "                                    <input type=\"hidden\" name=\"_token\" value=\"";
    echo (!empty(${$odnvatbjwgej}) ? ${${"GLOBALS"}["vmiwneewvvb"]} : null);
    echo "\"/>\n                                    <div class=\"form-group\">\n                                        <label for=\"admname\">Admin Username </label>\n                                        <input type=\"text\" name=\"admname\" class=\"form-control\" id=\"admname\" placeholder=\"Admin\" value=\"";
    echo (!empty($_POST["admname"]) ? $_POST["admname"] : null);
    echo "\">\n                                    </div> \n                                    <div class=\"form-group\">\n                                        <label for=\"admmail\">Admin Email </label>\n                                        <input type=\"text\" name=\"admmail\" class=\"form-control\" id=\"admmail\" placeholder=\"email@domain.com\" value=\"";
    echo (!empty($_POST["admmail"]) ? $_POST["admmail"] : null);
    echo "\">\n                                    </div>\n                                    <div class=\"form-group\">\n                                        <label for=\"admpass1\">Admin Password </label>\n                                        <input type=\"password\" name=\"admpass1\" class=\"form-control\" id=\"admpass1\" placeholder=\"fDH#5@\">\n                                    </div> \n                                    <div class=\"form-group\">\n                                        <label for=\"admpass2\">Repeat Password </label>\n                                        <input type=\"password\" name=\"admpass2\" class=\"form-control\" id=\"admpass2\" placeholder=\"fDH#5@\">\n                                    </div> \n                                    <button type=\"submit\" class=\"cbtn pull-right\">Next</button>\n\t\t\t\t\t\t\t\t\t<div class=\"clear\"></div>\n                                </form>\n                            </div>\n                        </div>\n                    </div>\n                ";
}
if (isset($_GET["complete"])) {
    echo "                    <div class=\"app_content\">\n                        <div class=\"row\">\n                            <div class=\"col-sm-12\">\n                                <h3 class=\"title text-center margin\">Installation complete</h3> \n                                \n                                <div class=\"alert alert-success\">\n                                    <strong>";
    echo $script_name;
    echo " was successfully installed!</strong>\n                                </div>\n\n                                <div class=\"divider\"></div>\n\n                                <h3 class=\"text-center\" id=\"btn-before\">&nbsp;</h3>\n                                <div class=\"text-center hide\" id=\"btn-complete\">\n                                    <a href=\"../index.php\" class=\"btn cbtn\">Click to launch your website</a>\n                                </div>\n\n                            </div>\n                        </div>\n                    </div> \n\t\t\t\t\t";
}
echo "                    <div class=\"app_footer\"> \n                        <h3>All rights reserved &copy; <a href=\"https://scriptstore.xyz\" target=\"_blank\">ScriptStore.xyz</a></h3>\n                    </div>\n                </div>\n                </div>\n            </div>\n        </div> \n\n        <script type=\"text/javascript\" src=\"assets/js/jquery.min.js\"></script>\n        <script type=\"text/javascript\">\n        \$(document).ready(function() {\n\n            var wait = 6000; //5 second\n\n            var time = 5;\n            setInterval(function(){\n             \$(\"#btn-before\").html(\"You need to wait \"+time+\" second before you can proceed\");\n             time--;\n            }, 1000);\n\n            setTimeout(function() {\n                \$(\"#btn-before\").addClass('hide');\n                \$(\"#btn-complete\").removeClass('hide');\n            }, wait);\n\n        });\n        </script>\n    </body>\n</html>\n"; ?>