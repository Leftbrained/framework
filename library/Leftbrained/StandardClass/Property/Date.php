<?php
namespace Leftbrained\StandardClass\Property;

use Leftbrained\StandardClass\Options\Property as Options;
use DateTime;

class Date extends AbstractProperty
{

    protected function setOptions(Options\DateOptions $options)
    {
        parent::setOptions($options);
    }

    protected function castInternal($value)
    {
        if ($value instanceof DateTime) {
            $dateTime = clone $value;
        } elseif (is_int($value) || (is_string($value) && ctype_digit($value))) {
            $dateTime = new DateTime();
            $dateTime->setTimestamp($value);
        } elseif (is_string($value)) {
            $dateTime = new DateTime($value);
        } elseif (is_array($value)) {
            $now = getdate();
            foreach (array(
                'year'   => 'year',
                'month'  => 'mon',
                'day'    => 'mday',
            ) as $key => $nowKey) {
                if (!isset($value[$key])) {
                    $value[$key] = $now[$nowKey];
                }
            }

            $dateTime = new DateTime();
            $dateTime->setDate($value['year'], $value['month'],  $value['day']);
        } else {
            $dateTime = new DateTime();
            $dateTime->setTimestamp((integer)$value);
        }
        $dateTime->setTime(0, 0, 0);

        return $dateTime;
    }
}