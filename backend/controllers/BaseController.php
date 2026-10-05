<?php
namespace App\controllers;

use App\core\Response;
use App\core\Request;
use App\core\Csrf;

/* START: BaseController — shared controller logic and helpers */
abstract class BaseController
{
    /* START: validateCsrf — validates request CSRF header or returns 419 error */
    protected function validateCsrf(): void
    {
        $token = Request::header('X-CSRF-Token') ?? Request::json('csrf_token');
        if (!Csrf::verify($token)) {
            Response::error('Page session expired or CSRF token mismatch. Please refresh.', null, 419);
        }
    }
    /* END: validateCsrf */

    /* START: validate — checks required fields and returns errors array */
    protected function validate(array $data, array $rules): ?array
    {
        $errors = [];
        foreach ($rules as $field => $ruleList) {
            $value = $data[$field] ?? null;
            $rulesArray = is_array($ruleList) ? $ruleList : explode('|', $ruleList);

            foreach ($rulesArray as $rule) {
                if ($rule === 'required' && ($value === null || $value === '')) {
                    $errors[$field][] = "The {$field} field is required.";
                }
            }
        }

        return empty($errors) ? null : $errors;
    }
    /* END: validate */
}
/* END: BaseController */
