<?
class ItemQuantityMuchMoreThanActualQuantityException extends DomainException {
    function __construct(string $message = "", int $code = 0, Throwable $previous = null){
        parent::__construct("Order item quantity much more than actual stock quantity", 400);
    }
}