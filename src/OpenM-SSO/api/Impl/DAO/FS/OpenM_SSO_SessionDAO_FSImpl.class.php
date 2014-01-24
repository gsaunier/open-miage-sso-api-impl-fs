<?php

Import::php("OpenM-SSO.api.Impl.DAO.FS.OpenM_SSO_DAO_FSImpl");
Import::php("OpenM-SSO.api.Impl.DAO.OpenM_SSO_SessionDAO");

/**
 * Description of OpenM_SSO_SessionDAO_FSImpl
 *
 * @package OpenM 
 * @subpackage OpenM\OpenM-SSO\api\Impl\DAO\FS
 * @author Gaël Saunier
 */
class OpenM_SSO_SessionDAO_FSImpl extends OpenM_SSO_DAO_FSImpl implements OpenM_SSO_SessionDAO {

    public function create($ssid, $oid, $ip_hash, $ssoApiToken) {
        $time = time();
        self::$db->request(OpenM_FS::insert(self::SSO_TABLE_NAME, array(
                    self::SSID => $ssid,
                    self::BEGIN_TIME => $time,
                    self::OID => $oid,
                    self::IP_HASH => $ip_hash,
                    self::API_SSO_TOKEN => $ssoApiToken)));

        $return = new HashtableString();
        return $return->put(self::SSID, $ssid)->put(self::BEGIN_TIME, $time)
                        ->put(self::OID, $oid)->put(self::IP_HASH, $ip_hash)
                        ->put(self::API_SSO_TOKEN, $ssoApiToken);
    }

    public function removeOutOfDate(Delay $validity) {
        $now = new Date();
        $outOfDate = $now->less($validity);
        self::$db->request("DELETE FROM " . self::SSO_TABLE_NAME . " WHERE " . self::BEGIN_TIME . "<" . $outOfDate->getTime());
    }

    public function remove($ssid) {
        self::$db->request(OpenM_FS::delete(self::SSO_TABLE_NAME, array(self::SSID, $ssid)));
    }

    public function get($ssid) {
        return self::$db->request_fetch_HashtableString(OpenM_FS::select(self::SSO_TABLE_NAME, array(self::SSID => $ssid)));
    }

}

?>