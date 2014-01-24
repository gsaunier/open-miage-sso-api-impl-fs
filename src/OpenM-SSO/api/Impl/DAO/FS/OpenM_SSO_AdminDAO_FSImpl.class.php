<?php

Import::php("OpenM-SSO.api.Impl.DAO.FS.OpenM_SSO_DAO_FSImpl");
Import::php("OpenM-SSO.api.Impl.DAO.OpenM_SSO_AdminDAO");

/**
 * Description of OpenM_SSO_AdminDAO_FSImpl
 *
 * @package OpenM 
 * @subpackage OpenM\OpenM-SSO\api\Impl\DAO\FS
 * @author Gaël Saunier
 */
class OpenM_SSO_AdminDAO_FSImpl extends OpenM_SSO_DAO_FSImpl implements OpenM_SSO_AdminDAO {

    public function create($user_id, $user_level) {
        self::$db->request(OpenM_FS::insert(self::SSO_TABLE_NAME, array(
                    self::USER_ID => $user_id,
                    self::USER_LEVEL => $user_level
                )));

        $return = new HashtableString();
        return $return->put(self::USER_ID, $user_id)->put(self::USER_LEVEL, $user_level);
    }

    public function remove($userId) {
        self::$db->request(OpenM_FS::delete(self::SSO_TABLE_NAME, array(self::USER_ID, $userId)));
    }

    public function get($userId = null) {
        if ($userId != null) {
            $array = array(self::USER_ID => $userId);
            return self::$db->request_HashtableString(OpenM_FS::select(self::SSO_TABLE_NAME, $array),self::USER_ID);
        }
        else
            return self::$db->request_HashtableString(OpenM_FS::select(self::SSO_TABLE_NAME),self::USER_ID);
    }

}

?>