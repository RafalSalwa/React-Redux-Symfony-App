<?php

namespace App\Exception;

use App\Exception\Contracts\AuthenticationExceptionInterface;
use Exception;

class AuthenticationException extends Exception implements AuthenticationExceptionInterface
{

}
