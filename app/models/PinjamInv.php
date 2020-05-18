<?php

class PinjamInv extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_pinv;

    /**
     *
     * @var integer
     */
    public $id_user;

    /**
     *
     * @var integer
     */
    public $id_inv;

    /**
     *
     * @var integer
     */
    public $id_lab;

    /**
     *
     * @var string
     */
    public $tanggal;

    /**
     *
     * @var string
     */
    public $keperluan;

        /**
     *
     * @var string
     */
    public $STATUS;


    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lammas");
        $this->setSource("permohonan_inventaris");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return PinjamInv[]|PinjamInv|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return PinjamInv|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
