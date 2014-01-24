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

    const API_SESSION_DIR = "api_session";

    public function create($ssid, $api_url, $api_ssid, $validity) {
        $time = time() + $validity;
        $apiSession = new Properties();
        $return = new HashtableString();
        $return->put(self::API_SSID, $api_ssid)->put(self::END_TIME, $time)
                ->put(self::API_PATH, $api_url)
                ->put(self::SSID, $ssid);
        $apiSession->setAll($return);
        $apiSession->save($this->root . "/" . self::API_SESSION_DIR . "/" . $ssid . "_" . OpenM_Crypto::md5($api_url));
        return $return;
    }

    public function removeOutOfDate() {
        
    }

    public function get($ssid, $api_url) {
        $apiSession = new Properties($this->root . "/" . self::API_SESSION_DIR . "/" . $ssid . "_" . OpenM_Crypto::md5($api_url));
        return $apiSession->getAll();
    }

}

?>