<?php
namespace App\services\sms;

/* START: SmsDriverInterface — contract for SMS transmission drivers */
interface SmsDriverInterface
{
    /* START: send — sends SMS to destination number */
    public function send(string $phone, string $message): bool;
    /* END: send */
}
/* END: SmsDriverInterface */
