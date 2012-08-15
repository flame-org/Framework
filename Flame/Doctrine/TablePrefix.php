<?php

namespace Flame\Doctrine;

use \Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class TablePrefix implements \Doctrine\Common\EventSubscriber
{

	/**
	 * @var string
	 */
	protected $prefix = '';

	/**
	 * @param $prefix
	 */
	public function __construct($prefix)
    {
        $this->prefix = (string) $prefix;
    }

	/**
	 * @return array
	 */
	public function getSubscribedEvents()
	{
		return array('loadClassMetadata');
	}

	/**
	 * @param \Doctrine\ORM\Event\LoadClassMetadataEventArgs $eventArgs
	 */
	public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $classMetadata = $eventArgs->getClassMetadata();
        $classMetadata->setPrimaryTable(array('name' => $this->prefix . $classMetadata->getTableName()));
	    foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
		    if ($mapping['type'] == \Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_MANY && isset($classMetadata->associationMappings[$fieldName]['joinTable']['name'])) {
			    $mappedTableName = $classMetadata->associationMappings[$fieldName]['joinTable']['name'];
			    $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->prefix . $mappedTableName;
		    }
	    }
    }

}