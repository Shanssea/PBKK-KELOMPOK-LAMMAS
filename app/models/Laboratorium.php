<?php

class Laboratorium extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id_lab;

    /**
     *
     * @var string
     */
    public $nama_lab;

    /**
     *
     * @var string
     */
    public $ruangan;

    /**
     *
     * @var string
     */
    public $status_lab;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("lammas");
        $this->setSource("laboratorium");
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return Laboratorium[]|Laboratorium|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null): \Phalcon\Mvc\Model\ResultsetInterface
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return Laboratorium|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
