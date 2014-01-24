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

    const ADMIN_DIR = "admin";

    public function create($user_id, $user_level) {
        $admin = new Properties();
        $admin->set(self::USER_ID, $user_id)->set(self::USER_LEVEL, $user_level);
        $admin->save($this->root . "/" . self::ADMIN_DIR . "/" . $user_id);
        return $admin->getAll();
    }

    public function remove($userId) {
        unlink($this->root . "/" . self::ADMIN_DIR . "/" . $userId);
    }

    public function get($userId = null) {
        if ($userId != null) {

            return;
        }
        else
            return;
    }

}

?>