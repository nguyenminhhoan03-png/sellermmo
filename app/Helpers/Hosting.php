<?php

/**
 * @author muabanwebsite.io.vn
 * @package HelperHosting
 *
 * @version 1.0.0
 */

use App\Models\WhmInfo;
// lay params cpanel
if (!function_exists('get_params_cpanel')) {
    function get_params_cpanel($id)
    {
        $whm_info_update = WhmInfo::find($id);
        $whm_link = checkIpOrHostname($whm_info_update->whm_host);

        $params = [
            'serverusername' => $whm_info_update->whm_user,
            'serverpassword' => $whm_info_update->whm_pass,
            'serverhttpprefix' => 'https',
            'serverport' => 2087,
            'serversecure' => true,
            'serveraccesshash' => '',
        ];

        if ($whm_link) {
            $params['serverip'] = $whm_info_update->whm_host;
            $params['serverhostname'] = null;
        } else {
            $params['serverip'] = null;
            $params['serverhostname'] = $whm_info_update->whm_host;
        }

        return $params;
    }
}
if (!function_exists('genRandomVal')) {
    function genRandomVal($length = 5)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
if (!function_exists('checkIpOrHostname')) {
    function checkIpOrHostname($input)
    {
        if (filter_var($input, FILTER_VALIDATE_IP)) {
            return true;
        } elseif (filter_var($input, FILTER_VALIDATE_DOMAIN, FILTER_FLAG_HOSTNAME)) {
            return false;
        } else {
            return false;
        }
    }
}
if (!function_exists('build_query_string')) {
    function build_query_string($data, $encoding = PHP_QUERY_RFC1738)
    {
        if ($encoding == PHP_QUERY_RFC1738 || $encoding == PHP_QUERY_RFC3986) {
            return http_build_query($data, "", "&", $encoding);
        }
        if (empty($data)) {
            return "";
        }
        $query = "";
        foreach ($data as $key => $value) {
            $query .= $key . "=" . $value . "&";
        }
        return substr($query, 0, -1);
    }
}
// chuyển đổi số tháng
if (!function_exists('checkYearOrMonth')) {
    function checkYearOrMonth($input)
    {
        if (!is_numeric($input) || $input <= 0) {
            return "Dữ liệu không hợp lệ. Vui lòng nhập số lớn hơn 0.";
        }

        if ($input > 12) {
            $years = floor($input / 12);
            return "{$years} năm";
        } else {
            return "{$input} tháng";
        }
    }
}
// chuyển đổi domain
if (!function_exists('extractDomain')) {
    function extractDomain($domain)
    {
        $dotPosition = strpos($domain, '.');
        if ($dotPosition !== false) {
            return substr($domain, 0, $dotPosition);
        } else {
            return $domain;
        }
    }
}
// check domain
if (!function_exists('isValidDomain')) {
    function isValidDomain($domain)
    {
        if (!empty($domain) && strpos($domain, '.') !== false) {
            return (filter_var('http://' . $domain, FILTER_VALIDATE_URL) !== false);
        }
        return false;
    }
}
// cpanel_curlrequest
if (!function_exists('cpanel_curlrequest')) {
    function cpanel_curlRequest($params, $apiCommand, $postVars, $stringsToMask = array())
    {
        $whmIP = $params["serverip"];
        $whmHostname = $params["serverhostname"];
        $whmUsername = $params["serverusername"];
        $whmPassword = $params["serverpassword"];
        $whmHttpPrefix = $params["serverhttpprefix"];
        $whmPort = $params["serverport"];
        $whmAccessHash = preg_replace("'(\r|\n)'", "", $params["serveraccesshash"]);
        $whmSSL = $params["serversecure"] ? true : false;
        $curlTimeout = array_key_exists("overrideTimeout", $params) ? $params["overrideTimeout"] : 400;

        if (!$whmIP && !$whmHostname) {
            return "You must provide either an IP or Hostname for the Server";
        }
        if (!$whmUsername) {
            return "WHM Username is missing for the selected server";
        }

        if ($whmAccessHash) {
            $authStr = "WHM " . $whmUsername . ":" . $whmAccessHash;
        } else {
            if ($whmPassword) {
                $authStr = "Basic " . base64_encode($whmUsername . ":" . $whmPassword);
            } else {
                return "You must provide either an API Token (Recommended) or Password for WHM for the selected server";
            }
        }

        if (substr($apiCommand, 0, 1) == "/") {
            $apiCommand = substr($apiCommand, 1);
        }

        $url = $whmHttpPrefix . "://" . ($whmIP ? $whmIP : $whmHostname) . ":" . $whmPort . "/" . $apiCommand;

        if (is_array($postVars)) {
            $requestString = build_query_string($postVars);
        } else {
            $requestString = $postVars ?: '';
        }
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER,0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch, CURLOPT_HEADER,0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: $authStr"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $requestString);
        curl_setopt($ch, CURLOPT_TIMEOUT, $curlTimeout);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            return "cURL Error: " . curl_error($ch);
        }

        curl_close($ch);

        return $response;
    }
}
// gửi request
if (!function_exists('cpanel_jsonRequest')) {
    function cpanel_jsonRequest($params, $apiCommand, $postVars, $stringsToMask = array())
    {
        $data = cpanel_curlrequest($params, $apiCommand, $postVars, $stringsToMask);

        if (!$data) {
            return "No Response from WHM API";
        }

        $decodedData = json_decode($data, true);

        if (is_null($decodedData) && json_last_error() !== JSON_ERROR_NONE) {
            return "JSON Decode Error: " . json_last_error_msg();
        }

        if (isset($decodedData["cpanelresult"]["error"])) {
            return $decodedData["cpanelresult"]["error"];
        }

        return $decodedData;
    }
}
// test login
if (!function_exists('cpanel_TestConnection')) {
    function cpanel_TestConnection($params)
    {
        $response = cpanel_jsonrequest($params, "/json-api/version", array());

        if (is_array($response) && isset($response["version"])) {
            return response()->json([
                'status'  => 200,
                'version' => $response["version"],
                'message' => 'Đã kết nối tới WHM',
            ], 200);
        }
        return response()->json([
            'status'  => 401,
            'message' => 'Không thể kết nối tới whm',
        ], 401);
    }
}
// API Tạo TOKEN WHM
if (!function_exists('cpanel_create_api_token')) {
    function cpanel_create_api_token(array $params)
    {
        $tokenName = "MUABANWEBSITE" . genRandomVal(10);
        $command = "/json-api/api_token_create";
        $postVars = array("api.version" => 1, "token_name" => $tokenName);
        $response = cpanel_jsonrequest($params, $command, $postVars);

        if ($response["metadata"]["result"] == 1) {
            return array("success" => true, "message" => $response["metadata"]["result"], "api_token" => $response["data"]["token"]);
        }

        return array("success" => false, "error" => $response["metadata"]["reason"]);
    }
}
// API lấy IP
if (!function_exists('cpanel_get_ip')) {
    function cpanel_get_ip($params, $vars)
    {
        $response = cpanel_jsonrequest($params, "/json-api/get_shared_ip", $vars);
        if ($response["metadata"]["result"] == 1) {
            return array("success" => true, "message" => $response["metadata"]["result"], "ip" => $response["data"]["ip"]);
        }
        return array("success" => false, "error" => $response["metadata"]["reason"]);
    }
}
// tạo phiên đăng nhập
if (!function_exists('cpanel_SingleSignOn')) {
    function cpanel_SingleSignOn($params, $user, $service, $app = "")
    {
        if (!$user) {
            return "Username is required for login.";
        }
        $vars = array("api.version" => "1", "user" => $user, "service" => $service);
        if ($app) {
            $vars["app"] = $app;
        }
        try {
            $response = cpanel_jsonrequest($params, "/json-api/create_user_session", $vars);
            $resultCode = isset($response["metadata"]["result"]) ? $response["metadata"]["result"] : 0;
            if ($resultCode == "1") {
                $redirURL = $response["data"]["url"];
                if (!$params["serversecure"]) {
                    $secureParts = array("https:", ":2087", ":2083", ":2096");
                    $insecureParts = array("http:", ":2086", ":2082", ":2095");
                    $redirURL = str_replace($secureParts, $insecureParts, $redirURL);
                }
                return array("success" => true, "redirectTo" => $redirURL);
            }
            if (isset($response["cpanelresult"]["data"]["reason"])) {
                return array("success" => false, "errorMsg" => "cPanel API Response: " . $response["cpanelresult"]["data"]["reason"]);
            }
            if (isset($response["metadata"]["reason"])) {
                return array("success" => false, "errorMsg" => "cPanel API Response: " . $response["metadata"]["reason"]);
            }
        } catch (Exception $e) {
            return array("success" => false, "errorMsg" => "Error: " . $e->getMessage());
        }
        return array("success" => false);
    }
}
// tổng số account
if (!function_exists('cpanel_GetUserCount')) {
    function cpanel_GetUserCount(array $params)
    {
        $command = "/json-api/listaccts";
        $postVars = array("want" => "user,owner");
        try {
            $response = cpanel_jsonrequest($params, $command, $postVars);
            if (isset($response) && is_array($response) && isset($response["status"]) && $response["status"] == 1) {
                $totalCount = count($response["acct"]);
                $ownedAccounts = 0;
                foreach ($response["acct"] as $userAccount) {
                    if ($userAccount["owner"] == $params["serverusername"] || $userAccount["owner"] == $userAccount["user"]) {
                        $ownedAccounts++;
                    }
                }
                return array("success" => true, "totalAccounts" => $totalCount, "ownedAccounts" => $ownedAccounts);
            } else {
                return array("success" => false, "totalAccounts" => 0, "ownedAccounts" => 0);
            }
        } catch (Exception $e) {
            return array("success" => false, "error" => $e->getMessage());
        }
    }
}
// Tạo Gói Host
if (!function_exists('cpanel_createHostingPackageAPI')) {
    function cpanel_createHostingPackageAPI($params, $vars)
    {

        $response = cpanel_jsonrequest($params, "/json-api/addpkg", $vars);
        if (isset($response['metadata']['result'])) {
            if ($response['metadata']['result'] == 1) {
                return array("success" => true, "message" => $response['metadata']['result']);
            } else {
                return array("success" => false, "message" => $response['metadata']['reason']);
            }
        } else {
            return array("success" => false, "message" => 'Không nhận được dữ liệu từ RSL!');
        }
    }
}
// Edit Gói Host
if (!function_exists('cpanel_editHostingPackageAPI')) {
    function cpanel_editHostingPackageAPI($params, $vars)
    {
        $response = cpanel_jsonrequest($params, "/json-api/editpkg", $vars);
        if (isset($response['metadata']['result'])) {
            if ($response['metadata']['result'] == 1) {
                return array("success" => true, "message" => $response['metadata']['result']);
            } else {
                return array("success" => false, "message" => $response['metadata']['reason']);
            }
        } else {
            return array("success" => false, "message" => 'Không nhận được dữ liệu từ RSL!');
        }
    }
}
// Xóa Gói Host
if (!function_exists('cpanel_deleteHostingPackageAPI')) {
    function cpanel_deleteHostingPackageAPI($params, $vars)
    {
        $response = cpanel_jsonrequest($params, "/json-api/killpkg", $vars);
        if (isset($response['metadata'])) {
            if ($response['metadata']['result'] == 1) {
                return array("success" => true, "message" => $response['metadata']['result']);
            } else {
                return array("success" => false, "message" => $response['metadata']['reason']);
            }
        } else {
            return array("success" => false, "message" => 'Không nhận được dữ liệu từ RSL!');
        }
    }
}
// Tạo Hosting
if (!function_exists('cpanel_CreateAccount')) {
    function cpanel_CreateAccount($params, $vars)
    {
        $response = cpanel_jsonrequest($params, "/json-api/createacct", $vars);
        if (isset($response['metadata'])) {
            if ($response['metadata']['result'] == 1) {
                return array("success" => true, "message" => $response['metadata']['result']);
            } else {
                return array("success" => false, "message" => $response['metadata']['reason']);
            }
        } else {
            return array("success" => false, "message" => 'Không nhận được dữ liệu từ RSL!');
        }
    }
}
// Check Domain Trên WHM
if (!function_exists('cpanel_CheckDomain')) {
    function cpanel_CheckDomain($params, $vars)
    {
        $response = cpanel_jsonrequest($params, "/json-api/get_domain_info", $vars);
        if (isset($response['metadata'])) {
            if (isset($response['data'])) {
                return array("success" => true, "message" => $response['data']);
            } else {
                return array("success" => false, "message" => $response['metadata']['reason']);
            }
        } else {
            return array("success" => false, "message" => 'Không nhận được dữ liệu từ RSL!');
        }
    }
}
// Get Disk
if (!function_exists('cpanel_DiskSpace')) {
    function cpanel_DiskSpace($params)
    {
        $response = cpanel_jsonrequest($params, "/execute/Quota/get_quota_info", array());
        if (isset($response['data'])) {
            if ($response['status'] == 1) {
                return array("success" => true, "message" => $response['data']);
            } else {
                return array("success" => false, "message" => $response['metadata']['reason']);
            }
        } else {
            return array("success" => false, "message" => 'Không nhận được dữ liệu từ RSL!');
        }
    }
}
// api check CPU,RAM,Number of Processes
if (!function_exists('cpanel_CheckSpace')) {
    function cpanel_CheckSpace($params)
    {
        $response = cpanel_jsonrequest($params, "/execute/ResourceUsage/get_usages", array());
        if (isset($response['data'])) {
            if ($response['status'] == 1) {
                return array("success" => true, "message" => $response['data']);
            } else {
                return array("success" => false, "message" => $response['metadata']['reason']);
            }
        } else {
            return array("success" => false, "message" => 'Không nhận được dữ liệu từ RSL!');
        }
    }
}
// hàm tìm dữ liệu
if (!function_exists('getUsageAndMaximumById')) {
    function getUsageAndMaximumById($data, $id)
    {
        if (!is_array($data)) {
            return null;
        }
        foreach ($data as $item) {
            if (is_array($item) && isset($item['id'], $item['usage'], $item['maximum']) && $item['id'] === $id) {
                return [
                    'usage' => $item['usage'],
                    'maximum' => $item['maximum']
                ];
            }
        }
        return null;
    }
}
// thay đổi tên miền chính
if (!function_exists('cpanel_ChangeDomain')) {
    function cpanel_ChangeDomain($params, $vars)
    {
        $response = cpanel_jsonrequest($params, "/json-api/modifyacct", $vars);
        if (isset($response['metadata'])) {
            if ($response['metadata']['result'] == 1) {
                return array("success" => true, "result" => $response['metadata']['result'], "message" => $response['metadata']['reason']);
            } else {
                return array("success" => false, "result" => 0, "message" => $response['metadata']['reason']);
            }
        } else {
            return array("success" => false, "message" => 'Không nhận được dữ liệu từ RSL!');
        }
    }
}
// khóa hosting
if (!function_exists('cpanel_SuspendAccount')) {
    function cpanel_SuspendAccount($params)
    {
        if (!$params["username"]) {
            return "Cannot perform action without accounts username";
        }
        if ($params["type"] == "reselleraccount") {
            $postVars = "api.version=1&user=" . urlencode($params["username"]) . "&reason=" . urlencode($params["suspendreason"]);
            $output = cpanel_jsonRequest($params, "/json-api/suspendreseller", $postVars);
        } else {
            $postVars = "api.version=1&user=" . urlencode($params["username"]) . "&reason=" . urlencode($params["suspendreason"]);
            $output = cpanel_jsonRequest($params, "/json-api/suspendacct", $postVars);
        }
        if (!is_array($output)) {
            return $output;
        }
        $metadata = isset($output["metadata"]) ? $output["metadata"] : array();
        $resultCode = isset($metadata["result"]) ? $metadata["result"] : 0;
        if ($resultCode == "1") {
            return array("success" => true, "message" => '1');
        }
        $ok = isset($metadata["reason"]) ? $metadata["reason"] : "An unknown error occurred";
        return array("success" => false, "message" => $ok);
    }
}
// mở khóa hosting
if (!function_exists('cpanel_UnsuspendAccount')) {
    function cpanel_UnsuspendAccount($params)
    {
        if (!$params["username"]) {
            return "Cannot perform action without accounts username";
        }
        if ($params["type"] == "reselleraccount") {
            $postVars = "api.version=1&user=" . urlencode($params["username"]);
            $output = cpanel_jsonRequest($params, "/json-api/unsuspendreseller", $postVars);
        } else {
            $postVars = "api.version=1&user=" . urlencode($params["username"]);
            $output = cpanel_jsonRequest($params, "/json-api/unsuspendacct", $postVars);
        }
        if (!is_array($output)) {
            return $output;
        }
        $metadata = isset($output["metadata"]) ? $output["metadata"] : array();
        $resultCode = isset($metadata["result"]) ? $metadata["result"] : 0;
        if ($resultCode == "1") {
            return array("success" => true, "message" => '1');
        }
        $ok = isset($metadata["reason"]) ? $metadata["reason"] : "An unknown error occurred";
        return array("success" => false, "message" => $ok);
    }
}
// xóa hosting
if (!function_exists('cpanel_DeleteAccount')) {
    function cpanel_DeleteAccount($params, $vars)
  {
    $response = cpanel_jsonrequest($params, "/json-api/removeacct", $vars);
    if (isset($response['metadata'])) {
        if ($response['metadata']['result'] == 1) {
            return array("success" => true, "message" => $response['metadata']['result']);
        } else {
            return array("success" => false, "message" => $response['metadata']['reason']);
        }
    } else {
        return array("success" => false, "message" => 'Không nhận được dữ liệu từ RSL!');
    }
  }
}
// change package
if (!function_exists('cpanel_ChangePackage')) {
  function cpanel_ChangePackage($params)
 {
    $output = cpanel_jsonRequest($params, "/json-api/listresellers", array("apiversion" => "1"));
    $rusernames = $output["reseller"] ?? [];
    if ($params["type"] == "reselleraccount") {
        if (!in_array($params["username"], $rusernames)) {
            $makeowner = $params["configoption24"] ? 1 : 0;
            $postVars = "user=" . $params["username"] . "&makeowner=" . $makeowner;
            $output = cpanel_jsonRequest($params, "/json-api/setupreseller", $postVars);
            if (!is_array($output)) {
                return $output;
            }
            if (!$output["result"][0]["status"]) {
                $error = $output["result"][0]["statusmsg"];
                if (!$error) {
                    $error = "An unknown error occurred";
                }
                return $error;
            }
        }
        if ($params["configoption21"]) {
            $postVars = "reseller=" . $params["username"] . "&acllist=" . urlencode($params["configoption21"]);
            $output = cpanel_jsonRequest($params, "/json-api/setacls", $postVars);
            if (!is_array($output)) {
                return $output;
            }
            if (!$output["result"][0]["status"]) {
                $error = $output["result"][0]["statusmsg"];
                if (!$error) {
                    $error = "An unknown error occurred";
                }
                return $error;
            }
        }
        $postVars = "user=" . $params["username"];
        if ($params["configoption16"]) {
            $postVars .= "&enable_resource_limits=1&diskspace_limit=" . urlencode($params["configoption17"]) . "&bandwidth_limit=" . urlencode($params["configoption18"]);
            if ($params["configoption19"]) {
                $postVars .= "&enable_overselling_diskspace=1";
            }
            if ($params["configoption20"]) {
                $postVars .= "&enable_overselling_bandwidth=1";
            }
        } else {
            $postVars .= "&enable_resource_limits=0";
        }
        if ($params["configoption15"]) {
            if ($params["configoption15"] == "unlimited") {
                $postVars .= "&enable_account_limit=1&account_limit=";
            } else {
                $postVars .= "&enable_account_limit=1&account_limit=" . urlencode($params["configoption15"]);
            }
        } else {
            $postVars .= "&enable_account_limit=0&account_limit=";
        }
        $output = cpanel_jsonRequest($params, "/json-api/setresellerlimits", $postVars);
        if (!is_array($output)) {
            return $output;
        }
        if (!$output["result"][0]["status"]) {
            $error = $output["result"][0]["statusmsg"];
            if (!$error) {
                $error = "An unknown error occurred";
            }
            return $error;
        }
    } else {
          if (in_array($params["username"], $rusernames)) {
            $postVars = "user=" . $params["username"];
            $output = cpanel_jsonRequest($params, "/json-api/unsetupreseller", $postVars);
            }
            $plan = $params["pkg"];
            $postVars = "user=" . $params["username"] . "&pkg=" . urlencode($plan);
            $output = cpanel_jsonRequest($params, "/json-api/changepackage", $postVars);
            if (!is_array($output)) {
                return $output;
            }
            if (!$output["result"][0]["status"]) {
                $error = $output["result"][0]["statusmsg"];
                if (!$error) {
                    $error = "An unknown error occurred";
                }
                return $error;
            }
    }
    return array("success" => true, "message" => 1);
}  
}
// change Password
if (!function_exists('cpanel_ChangePassword')) {
    function cpanel_ChangePassword($params)
    {
        $postVars = "user=" . $params["username"] . "&pass=" . urlencode($params["password"]);
        $response = cpanel_jsonRequest($params, "/json-api/passwd", $postVars);
        if (isset($response["passwd"])) {
            if ($response['passwd'][0]["status"] == 1) {
                return array("success" => true, "message" => $response['passwd'][0]["status"]);
            } else {
                return array("success" => false, "message" => $response['passwd'][0]["statusmsg"]);
            }
        } else {
            return array("success" => false, "message" => 'Không nhận được dữ liệu từ RSL!');
        }
    }
}
// block ip
if (!function_exists('cpanel_BlockIp')) {
    function cpanel_BlockIp($params)
    {
        $postVars = "ip=" . $params["ip"];
        $response = cpanel_jsonRequest($params, "/execute/BlockIP/add_ip", $postVars);
        if (isset($response["status"])) {
            if ($response["status"] == 1) {
                return array("success" => true, "message" => $response["status"]);
            } else {
                return array("success" => false, "message" => $response["messages"]);
            }
        } else {
            return array("success" => false, "message" => 'Không nhận được dữ liệu từ RSL!');
        }
    }
}
// mở khóa
if (!function_exists('cpanel_UnlBlockIp')) {
    function cpanel_UnlBlockIp($params)
    {
        $postVars = "ip=" . $params["ip"];
        $response = cpanel_jsonRequest($params, "/execute/BlockIP/remove_ip", $postVars);
        if (isset($response["status"])) {
            if ($response["status"] == 1) {
                return array("success" => true, "message" => $response["status"]);
            } else {
                return array("success" => false, "message" => $response["messages"]);
            }
        } else {
            return array("success" => false, "message" => 'Không nhận được dữ liệu từ RSL!');
        }
    }
}


