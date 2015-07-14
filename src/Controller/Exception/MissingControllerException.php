<?php

namespace GintonicCMS\Controller\Exception;

use Cake\Core\Exception\Exception;

/**
 * Used when a controller cannot be found.
 *
 */
class MissingControllerException extends Exception
{

    protected $_messageTemplate = 'Controller class %s could not be found.';
}
