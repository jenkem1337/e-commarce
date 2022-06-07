<?php

interface Command {
    function process($params= []);
}