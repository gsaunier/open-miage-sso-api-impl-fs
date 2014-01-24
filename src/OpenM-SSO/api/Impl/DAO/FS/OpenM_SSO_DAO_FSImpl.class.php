<?php

Import::php("OpenM-Services.api.Impl.DAO.OpenM_DAO");
Import::php("OpenM-SSO.api.Impl.OpenM_SSOImpl");
Import::php("util.Properties");
Import::php("OpenM-DAO.DB.OpenM_DB_Sequence");

/**
 * Description of OpenM_SSO_DAO
 *
 * @package OpenM 
 * @subpackage OpenM\OpenM-SSO\api\Impl\DAO\FS 
 * @author Gaël Saunier
 */
abstract class OpenM_SSO_DAO_FSImpl {

    const CLIENT_SEQUENCE = "OpenM-SSO.sequence.client";
    const ROOT_PATH = "OpenM-SSO.root.path";

    protected $root;
    protected $sequenceClient;

    public function __construct() {
        if (self::$root !== null)
            return;

        $p = Properties::fromFile(OpenM_ServiceImpl::CONFIG_FILE_NAME);
        $p2 = Properties::fromFile($p->get(OpenM_SSOImpl::SPECIFIC_CONFIG_FILE_NAME));

        $this->sequenceClient = new OpenM_DB_Sequence($p2->get(self::CLIENT_SEQUENCE));
        $this->root = $p2->get(self::ROOT_PATH);
    }

}

?>