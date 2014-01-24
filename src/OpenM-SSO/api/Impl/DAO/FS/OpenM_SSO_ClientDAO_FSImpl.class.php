<?php

Import::php("OpenM-SSO.api.Impl.DAO.FS.OpenM_SSO_DAO_FSImpl");
Import::php("OpenM-SSO.api.Impl.DAO.OpenM_SSO_ClientDAO");

/**
 * Description of OpenM_SSO_ClientDAO_FSImpl
 *
 * @package OpenM 
 * @subpackage OpenM\OpenM-SSO\api\Impl\DAO\FS
 * @author Gaël Saunier
 */
class OpenM_SSO_ClientDAO_FSImpl extends OpenM_SSO_DAO_FSImpl implements OpenM_SSO_ClientDAO {

    const CLIENT_DIR = "client";

    public function create($ip_hash, $install_user_id, $is_valid = false) {
        $time = time();
        $client = new Properties();
        $return = new HashtableString();
        $clientId = $this->sequenceClient->next();
        $return->put(self::IP_HASH, $ip_hash)->put(self::IS_VALID, ($is_valid) ? 1 : 0)
                ->put(self::INSTALLER_USER_ID, $install_user_id)
                ->put(self::TIME, $time)->put(self::ID, $clientId);
        $client->setAll($return);
        $client->save($this->root . "/" . self::CLIENT_DIR . "/" . OpenM_Crypto::md5($clientId));
        return $return;
    }

    public function removeOutOfDate(Delay $validity) {
        
    }

    public function remove($clientId) {
        unlink($this->root . "/" . self::CLIENT_DIR . "/" . OpenM_Crypto::md5($clientId));
    }

    public function getALL($notValidOnly = true) {
        
    }

    public function get($clientId) {
        $client = new Properties($this->root . "/" . self::CLIENT_DIR . "/" . OpenM_Crypto::md5($clientId));
        return $client->getAll();
    }

    public function getValidated($ip_hash) {
        
    }

    public function validate($clientId) {
        $client = new Properties($this->root . "/" . self::CLIENT_DIR . "/" . OpenM_Crypto::md5($clientId));
        $client->set(self::IS_VALID, 1);
        $client->save();
    }

}

?>