<?php
interface Listener {
    function handle(...$params): void;
}