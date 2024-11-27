<?
class CheckoutStateNotSuitableException extends BaseException {
    function __construct($message="", $code = 400, Throwable|null $previous = null){
        parent::__construct("Checkout state must be created, you can not get");
    }
}