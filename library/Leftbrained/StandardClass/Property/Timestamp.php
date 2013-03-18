<?php
namespace Leftbrained\StandardClass\Property;

use Leftbrained\StandardClass\Options\Property as Options;
use DateTime;

class Timestamp extends AbstractProperty
{

    protected function setOptions(Options\TimestampOptions $options)
    {
        parent::setOptions($options);
    }

    protected function castInternal($value)
    {
        if ($value instanceof DateTime) {
            return $value;
        }

        if (is_int($value) || (is_string($value) && ctype_digit($value))) {
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
                'hour'   => 'hours',
                'minute' => 'minutes',
                'second' => 'seconds',
            ) as $key => $nowKey) {
                if (!isset($value[$key])) {
                    $value[$key] = $now[$nowKey];
                }
            }

            $dateTime = new DateTime();
            $dateTime->setDate($value['year'], $value['month'],  $value['day']);
            $dateTime->setTime($value['hour'], $value['minute'], $value['second']);
        } else {
            $dateTime = new DateTime();
            $dateTime->setTimestamp((integer)$value);
        }

        return $dateTime;
    }
}