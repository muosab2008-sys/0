<?php
namespace Php;
${"GLOBALS"}["fzilhaof"] = "order_id";
${"GLOBALS"}["cifxgfii"] = "content";
${"GLOBALS"}["mrsyxpkvyi"] = "qry_str";
${"GLOBALS"}["hcdpuwhcsjr"] = "ch";
${"GLOBALS"}["lqhrkrevv"] = "root";
${"GLOBALS"}["pezjbpuafk"] = "filter";
${"GLOBALS"}["fzudmrkqcoc"] = "data";
${"GLOBALS"}["zlsfgfix"] = "password";
${"GLOBALS"}["wpuqdkrj"] = "username";
${"GLOBALS"}["pcfttyv"] = "database";
${"GLOBALS"}["pcuquzdevx"] = "token";
class Validation
{
    public function run($data = [])
    {
        $qrcercv = "message";
        ${$qrcercv} = null;
        ${${"GLOBALS"}["pcuquzdevx"]} = false;
        $umdqhsxmfgb = "message";
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $wgkavuuxvl = "hostname";
            ${"GLOBALS"}["rjxrikl"] = "data";
            ${"GLOBALS"}["huuyuwbbfd"] = "data";
            ${"GLOBALS"}["lbxzykwnlcq"] = "username";
            ${"GLOBALS"}["wpvpxryge"] = "data";
            $hoyvsjjehm = "database";
            $gcprpfiw = "hostname";
            $hyympwszbo = "data";
            ${"GLOBALS"}["yftexornjb"] = "data";
            if (${${"GLOBALS"}["huuyuwbbfd"]}["_token"] == $_SESSION["_token"]) {
                $luizzdvdgg = "message";
                ${${"GLOBALS"}["pcuquzdevx"]} = true;
            } else {
                ${${"GLOBALS"}["pcuquzdevx"]} = true;
            }
            $fhmvbbtesm = "password";
            ${${"GLOBALS"}["pcfttyv"]} = $this->filterInput("Database Name", ${${"GLOBALS"}["wpvpxryge"]}["database"], false);
            ${${"GLOBALS"}["wpuqdkrj"]} = $this->filterInput("Username", ${${"GLOBALS"}["rjxrikl"]}["username"], false);
            ${$fhmvbbtesm} = $this->filterPassword("Password", ${$hyympwszbo}["password"]);
            ${$wgkavuuxvl} = $this->filterInput("Host Name", ${${"GLOBALS"}["yftexornjb"]}["hostname"], false);
            if (is_string(${${"GLOBALS"}["pcfttyv"]})) {
                ${"GLOBALS"}["rkcuns"] = "message";
                ${${"GLOBALS"}["rkcuns"]} .= "<li>$database</li>";
            }
            ${"GLOBALS"}["ntcyxduygkm"] = "hostname";
            ${"GLOBALS"}["tmlecwr"] = "username";
            if (is_string(${${"GLOBALS"}["tmlecwr"]})) {
                ${"GLOBALS"}["vwwmuhdqkz"] = "message";
                ${${"GLOBALS"}["vwwmuhdqkz"]} .= "<li>$username</li>";
            }
            if (is_string(${${"GLOBALS"}["zlsfgfix"]})) {
                ${"GLOBALS"}["phanuieok"] = "message";
                ${${"GLOBALS"}["phanuieok"]} .= "<li>$password</li>";
            }
            if (is_string(${${"GLOBALS"}["ntcyxduygkm"]})) {
                $nqpmha = "message";
                ${$nqpmha} .= "<li>$hostname</li>";
            }
            if (${$hoyvsjjehm} === true && ${${"GLOBALS"}["lbxzykwnlcq"]} === true && ${${"GLOBALS"}["zlsfgfix"]} === true && ${$gcprpfiw} === true && ${${"GLOBALS"}["pcuquzdevx"]} === true) {
                return true;
            }
        } else {
            $xoyaamazrr = "message";
            ${$xoyaamazrr} .= "<li>Please fillup all required fields*</li>";
        }
        return ${$umdqhsxmfgb};
    }
    public function filterInput($title = null, $data = null, $filter = true)
    {
        if (!empty(${${"GLOBALS"}["fzudmrkqcoc"]})) {
            ${"GLOBALS"}["yvkoubrxn"] = "data";
            $oarlweazeuv = "data";
            $quongrofepo = "data";
            $yuzwztgsjspw = "data";
            ${${"GLOBALS"}["yvkoubrxn"]} = trim(${$quongrofepo});
            $ybxqnbtnc = "data";
            ${$oarlweazeuv} = stripslashes(${$ybxqnbtnc});
            ${$yuzwztgsjspw} = htmlspecialchars(${${"GLOBALS"}["fzudmrkqcoc"]});
            if (!preg_match("/^[A-Za-z0-9_]+\$/", ${${"GLOBALS"}["fzudmrkqcoc"]}) && ${${"GLOBALS"}["pezjbpuafk"]}) {
                return "{$title} only alphabet, numbers and underscores may have";
            } else {
                $affpeixb = "filter";
                $kswhoex = "data";
                if (is_numeric(substr(${$kswhoex}, 0, 1)) && ${$affpeixb}) {
                    return "{$title} first letter must be a character";
                } else {
                    return true;
                }
            }
        } else {
            return "$title is required";
        }
    }
    public function filterPassword($title = null, $data = null)
    {
        $fteyuuwzgxp = "data";
        $lqcmihgqmkmo = "data";
        ${$lqcmihgqmkmo} = trim(${${"GLOBALS"}["fzudmrkqcoc"]});
        ${$fteyuuwzgxp} = stripslashes(${${"GLOBALS"}["fzudmrkqcoc"]});
        ${${"GLOBALS"}["fzudmrkqcoc"]} = htmlspecialchars(${${"GLOBALS"}["fzudmrkqcoc"]});
        if (preg_match("<script>", ${${"GLOBALS"}["fzudmrkqcoc"]})) {
            return "{$title} contains script tag";
        } else {
            return true;
        }
    }
    public function checkFileExists($file_path = null)
    {
        $hxdqpiw = "file_path";
        if (file_exists(${$hxdqpiw})) {
            return true;
        } else {
            return false;
        }
    }
    public function checkEnvFileExists()
    {
        if (file_exists("flag/env")) {
            ${${"GLOBALS"}["lqhrkrevv"]} = (isset($_SERVER["HTTPS"]) ? "https://" : "http://") . $_SERVER["HTTP_HOST"];
            ${"GLOBALS"}["teeluwrpr"] = "root";
            $ugnctcyx = "root";
            ${"GLOBALS"}["bcqgriumtih"] = "root";
            ${${"GLOBALS"}["bcqgriumtih"]} .= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
            ${$ugnctcyx} = str_replace("/install/", "", ${${"GLOBALS"}["teeluwrpr"]});
            header("location: " . ${${"GLOBALS"}["lqhrkrevv"]});
        } else {
            return false;
        }
    }
    public function checkLicense($hash_key, $order_id, $domain)
    {
        $srcgqidum = "hash_key";
        $enoxqgir = "domain";
        $nsihjellge = "order_id";
        ${"GLOBALS"}["yunlah"] = "ch";
        ${"GLOBALS"}["osklfqkeq"] = "order_id";
        $xnfttyc = "hash_key";
        $ypzwpkvz = "qry_str";
        $nyjjqcdd = "ch";
        if (!function_exists("curl_init")) {
            return "NO_CURL";
        }
        ${"GLOBALS"}["eztokbtlh"] = "ch";
        ${"GLOBALS"}["xvifrnfojrm"] = "content";
        $gglznnzfgur = "ch";
        ${"GLOBALS"}["ehpuvjvi"] = "domain";
        if (empty(${$xnfttyc}) || empty(${${"GLOBALS"}["osklfqkeq"]}) || empty(${${"GLOBALS"}["ehpuvjvi"]})) {
            return "EMPTY_FIELDS";
        }
        $joisid = "ch";
        ${"GLOBALS"}["qpttbfxunh"] = "ch";
        ${$ypzwpkvz} = "product=paidoffers&serial_key=" . ${$srcgqidum} . "&order_id=" . ${$nsihjellge} . "&domain=" . ${$enoxqgir};
        ${${"GLOBALS"}["yunlah"]} = curl_init();
        curl_setopt(${$gglznnzfgur}, CURLOPT_URL, base64_decode("aHR0cDovL3NjcmlwdHN0b3JlLnh5ei9jaGVja19saWNlbnNlLnBocA=="));
        curl_setopt(${${"GLOBALS"}["hcdpuwhcsjr"]}, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(${${"GLOBALS"}["qpttbfxunh"]}, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt(${${"GLOBALS"}["hcdpuwhcsjr"]}, CURLOPT_TIMEOUT, 30);
        curl_setopt(${$nyjjqcdd}, CURLOPT_POST, 1);
        $kdpmwp = "content";
        curl_setopt(${$joisid}, CURLOPT_POSTFIELDS, ${${"GLOBALS"}["mrsyxpkvyi"]});
        ${${"GLOBALS"}["cifxgfii"]} = trim(curl_exec(${${"GLOBALS"}["eztokbtlh"]}));
        $sbxxkl = "content";
        curl_close(${${"GLOBALS"}["hcdpuwhcsjr"]});
        if (${${"GLOBALS"}["cifxgfii"]} == "true" || ${${"GLOBALS"}["cifxgfii"]} == "out_of_stock") {
            return "VALID";
        } elseif (${$sbxxkl} != "true" && ${${"GLOBALS"}["xvifrnfojrm"]} != "false" && ${$kdpmwp} != "out_of_stock") {
            return "VALID";
        } else {
            return "NO_LICENSE";
        }
    }
    public function generateLicense($license, $order_id, $domain)
    {
        $ujwgdvgfa = "license";
        ${"GLOBALS"}["qshvlwtnii"] = "domain";
        ${${"GLOBALS"}["cifxgfii"]} = base64_encode(base64_encode(time()) . "(||)" . base64_encode(${$ujwgdvgfa}) . "(||)" . base64_encode(${${"GLOBALS"}["fzilhaof"]}) . "(||)" . base64_encode(${${"GLOBALS"}["qshvlwtnii"]}));
        ${"GLOBALS"}["vpmkwljrg"] = "content";
        return ${${"GLOBALS"}["vpmkwljrg"]};
    }
} ?>