<?php
namespace App\Interfaces;

interface OtpInterface
{
    public function sendOtp(string $username)  :?string;
}
