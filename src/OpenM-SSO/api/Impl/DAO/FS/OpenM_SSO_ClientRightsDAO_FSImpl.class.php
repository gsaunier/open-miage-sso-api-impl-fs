<?php

Import::php("OpenM-SSO.api.Impl.DAO.FS.OpenM_SSO_DAO_FSImpl");
Import::php("OpenM-SSO.api.Impl.DAO.OpenM_SSO_ClientRightsDAO");

/**
 * Description of OpenM_SSO_ClientRightsDAO_FSImpl
 *
 * @package OpenM 
 * @subpackage OpenM\OpenM-SSO\api\Impl\DAO\FS
 * @author Gaël Saunier
 */
class OpenM_SSO_ClientRightsDAO_FSImpl extends OpenM_SSO_DAO_FSImpl implements OpenM_SSO_ClientRightsDAO {

    public function create($clientId, $rights) {
        self::$db->request(OpenM_FS::insert(self::SSO_TABLE_NAME, array(
                    self::CLIENT_ID => $clientId,
                    self::RIGHTS => $rights
        )));

        $return = new HashtableString();
        return $return->put(self::CLIENT_ID, $clientId)->put(self::RIGHTS, $rights);
    }

    public function remove($rightId) {
        self::$db->request(OpenM_FS::delete(self::SSO_TABLE_NAME, array(self::ID, $rightId)));
    }

    public function get($clientId = null) {
        if ($clientId != null)
            return self::$db->request_HashtableString(OpenM_FS::select(self::SSO_TABLE_NAME, array(self::CLIENT_ID => $clientId)), self::ID);
        else
            return self::$db->request_HashtableString(OpenM_FS::select(self::SSO_TABLE_NAME), self::ID);
    }

    public function getFromClientIp($clientIp) {
        return self::$db->request_HashtableString(OpenM_FS::select($this->getTABLE(self::SSO_TABLE_NAME))
                        . " WHERE " . self::CLIENT_ID
                        . " IN ("
                        . OpenM_FS::select($this->getTABLE(OpenM_SSO_ClientDAO::SSO_TABLE_NAME), array(
                            OpenM_SSO_ClientDAO::IP_HASH => $clientIp
                                ), array(
                            OpenM_SSO_ClientDAO::ID
                        ))
                        . ") GROUP BY " . self::RIGHTS
                        , self::ID);
    }

}

?>