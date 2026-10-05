<?php
/* START: ApiFrontController — entry dispatcher for all /api/* requests */

require_once dirname(__DIR__) . '/bootstrap.php';
require_once dirname(__DIR__) . '/routes/api.php';

use App\core\Request;
use App\core\Router;

Router::dispatch(Request::method(), Request::uri());

/* END: ApiFrontController */
