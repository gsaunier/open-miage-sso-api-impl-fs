<?php

Import::php("OpenM-SSO.api.Impl.DAO.FS.OpenM_SSO_DAO_FSImpl");
Import::php("OpenM-SSO.api.Impl.DAO.OpenM_SSO_APISessionDAO");

/**
 * Description of OpenM_SSO_APISessionDAO_FSImpl
 *
 * @package OpenM 
 * @subpackage OpenM\OpenM-SSO\api\Impl\DAO\FS
 * @author Gaël Saunier
 */
class OpenM_SSO_APISessionDAO_FSImpl extends OpenM_SSO_DAO_FSImpl implements OpenM_SSO_APISessionDAO {

    public function create($ssid, $api_url, $api_ssid, $validity) {
        $time = time() + $validity;
        self::$db->request(OpenM_FS::insert(self::SSO_TABLE_NAME, array(
                    self::SSID => $ssid,
                    self::API_PATH => $api_url,
                    self::API_SSID => $api_ssid,
                    self::END_TIME => $time
        )));

        $return = new HashtableString();
        return $return->put(self::API_SSID, $api_ssid)->put(self::END_TIME, $time)
                        ->put(self::API_PATH, $api_url)
                        ->put(self::SSID, $ssid);
    }

    public function removeOutOfDate() {
        $now = new Date();
        self::$db->request("DELETE FROM " . self::SSO_TABLE_NAME . " WHERE " . self::END_TIME . "<" . $now->getTime());
    }

    public function remove($ssid, $api_url = null) {
        $array = array(self::API_PATH, $api_url);
        if ($api_url != null)
            $array[self::SSID] = $ssid;
        self::$db->request(OpenM_FS::delete(self::SSO_TABLE_NAME, $array));
    }

    public function get($ssid, $api_url) {
        return self::$db->request_fetch_HashtableString(OpenM_FS::select(self::SSO_TABLE_NAME, array(
                            self::API_PATH => $api_url,
                            self::SSID => $ssid
        )));
    }

}

?>