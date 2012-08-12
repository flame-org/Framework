<?php

namespace Flame\Doctrine;
use \Doctrine\ORM\Event\LoadClassMetadataEventArgs;

class TablePrefix implements \Doctrine\Common\EventSubscriber
{
    protected $prefix = '';

    public function __construct($prefix)
    {
        $this->prefix = (string) $prefix;
    }

	public function getSubscribedEvents()
	{
		return array('loadClassMetadata');
	}

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