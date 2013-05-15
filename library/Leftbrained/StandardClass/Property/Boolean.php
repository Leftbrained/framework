<?php
namespace Leftbrained\StandardClass\Property;

use Leftbrained\StandardClass\Options\Property as Options;
use DateTime;

class Boolean extends AbstractProperty
{

    protected function setOptions(Options\BooleanOptions $options)
    {
        parent::setOptions($options);
    }

    protected function castInternal($value)
    {
        if (is_bool($value)) {
            $bool = $value;
        } elseif (is_int($value) || (is_string($value) && ctype_digit($value))) {
            $bool = (boolean) $value;
        } elseif (is_string($value)) {
            switch (strtolower($value)) {
                case 'yes':
                case 'true':
                    $bool = true;
                    break;
                case 'no':
                case 'false':
                    $bool = false;
                    break;
                default:
                    $bool = (boolean) $value;
            }
        } else {
            $bool = (boolean) $value;
        }

        return $bool;
    }
}