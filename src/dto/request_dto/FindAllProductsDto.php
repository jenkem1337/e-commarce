<?php

class FindAllProductsDto {
    function __construct(
        private $filter
    ){}
    function getFilters(): array {
        return $this->filter;
    }
}