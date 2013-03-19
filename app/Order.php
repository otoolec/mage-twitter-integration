<?php


class Order
{
    private $_firstName;
    private $_lastName;
    private $_amount;
    private $_currency;
    private $_id;

    public function __construct($data)
    {
        $this->_parseData($data);
    }

    public function getFirstName()
    {
        return $this->_firstName;
    }

    public function getLastName()
    {
        return $this->_lastName;
    }

    public function getAmount()
    {
        return $this->_amount;
    }

    public function getCurrency()
    {
        return $this->_currency;
    }

    public function getId()
    {
        return $this->_id;
    }

    private function _parseData($data)
    {
        if (isset($data['order'])) {
            if (isset( $data['order']['customer'])) {
                if (isset($data['order']['customer']['firstname'])) {
                    $this->_firstName = $data['order']['customer']['firstname'];
                }

                if (isset($data['order']['customer']['lastname'])) {
                    $this->_lastName =  $data['order']['customer']['lastname'];
                }
            }
            if (isset($data['order']['grand_total'])) {
                $this->_amount = $data['order']['grand_total'];
            }
            if (isset($data['order']['store_currency_code'])) {
                $this->_currency =  $data['order']['store_currency_code'];
            }
            if (isset($data['order']['increment_id'])) {
                $this->_id = $data['order']['increment_id'];
            }
        }
    }


}