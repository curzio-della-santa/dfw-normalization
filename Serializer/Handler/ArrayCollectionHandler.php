<?php

namespace Application\Core\JMSSerializer\Serializer\Handler;

use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\ArrayCollectionHandler as JMSArrayCollectionHandler;

class ArrayCollectionHandler extends JMSArrayCollectionHandler
{
    public static function getSubscribingMethods()
    {
//        $methods = parent::getSubscribingMethods();
        $methods = array();
        $formats = array('php');
        $collectionTypes = array(
            'ArrayCollection',
            'Doctrine\Common\Collections\ArrayCollection',
            'Doctrine\ORM\PersistentCollection',
            'Doctrine\ODM\MongoDB\PersistentCollection',
            'Doctrine\ODM\PHPCR\PersistentCollection',
        );

        foreach ($collectionTypes as $type) {
            foreach ($formats as $format) {
                $methods[] = array(
                    'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                    'type' => $type,
                    'format' => $format,
                    'method' => 'serializeCollection',
                );

                $methods[] = array(
                    'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                    'type' => $type,
                    'format' => $format,
                    'method' => 'deserializeCollection',
                );
            }
        }

        return $methods;
    }
}
