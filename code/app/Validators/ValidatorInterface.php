<?php


namespace App\Validators;


interface ValidatorInterface
{
    public function getErrorMessage() : string;

    public function setTasks(array $tasks) : void;

    public function validate() : bool;
}
