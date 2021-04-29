<?php

namespace denis909\yii;

use yii\db\Query;

trait RefreshAttributesTrait
{

    public function refreshAttributes(array $attributes)
    {
        $query = new Query;

        $tableName = key($query->getTablesUsedInFrom());
        
        $query->from($this->tableName());

        $pk = [];
                
        foreach ($this->getPrimaryKey(true) as $key => $value)
        {
            $pk[$tableName . '.' . $key] = $value;
        }
        
        $query->where($pk);

        $query->select($attributes);

        $record = $query->noCache()->one();

        $data = [];

        foreach($attributes as $attribute)
        {
            $this->$attribute = $record[$attribute];
        }
    }

}