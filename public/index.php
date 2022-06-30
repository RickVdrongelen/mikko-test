<?php
// Require the app object, and let the object handle the request
require '../vendor/autoload.php';

require '../bootstrap/app.php';
require '../app/services/web/request.php';

use Bootstrap\App;
use App\Services\Web\Request;


App::handle(Request::capture());