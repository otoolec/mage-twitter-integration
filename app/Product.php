<?php


class Product
{
    private $_name;
    private $_price;
    private $_url;

    public function __construct($data)
    {
        $this->_parseData($data);
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getPrice()
    {
        return $this->_price;
    }

    public function getUrl()
    {
        return $this->_url;
    }

    private function _parseData($data)
    {
        if (isset($data['product'])) {
            if (isset($data['product']['name'])) {
                $this->_name = $data['product']['name'];
            }
            if (isset($data['product']['formattedPrice'])) {
                $this->_price =  $data['product']['formattedPrice'];
            }
            if (isset($data['product']['url'])) {
                $this->_url = $data['product']['url'];
            }
        }
    }
}