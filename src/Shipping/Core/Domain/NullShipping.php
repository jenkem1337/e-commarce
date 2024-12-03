<?php

class NullShipping implements ShippingInterface, NullEntityInterface {
    
	/**
	 */
	function __construct() {
	}
	function setStatusToCanceled(){}
	function isDelivered(){}
	function setStateToDelivered(){}
	function setStatusToDispatched(){}
	function changeShippingAddress($shippingAddress)
	{
		
	}
	function getPrice() {
	}
	function getShippingType(): Type {return new Type(ShippingType::FREE , 0);}
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
	function getAddressCountry(){}
	function getAddressDistrict(){}
	function getAddressOwnerName(){}
	function getAddressOwnerSurname(){}
	function getAddressProvince(){}
	function getAddressTitle(){}
	function getAddressZipCode(){}
	function getFullAddress(){}
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