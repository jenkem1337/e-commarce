<?php

class NullShipping implements ShippingInterface, NullEntityInterface {
    
	/**
	 */
	function __construct() {
	}
	function changeShippingAddress($shippingAddress)
	{
		
	}
	/**
	 *
	 * @return mixed
	 */
	function getShippingType() {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function getPrice() {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function getShippingAddress() {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function getUuid() {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function getCreatedAt() {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function getUpdatedAt() {
	}
	
	/**
	 *
	 * @return mixed
	 */
	function isNull() :bool{
        return true;
	}
	/**
	 *
	 * @return mixed
	 */
	function changePrice($price) {
	}
	/**
	 *
	 * @param mixed $shippingAddress
	 *
	 * @return mixed
	 */
	function setShippingAddress($shippingAddress) {
	}
	function getShippingState(){}
	function getWhenWillFinish(){}
}