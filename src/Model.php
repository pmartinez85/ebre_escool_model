<?php

namespace Scool\EbreEscoolModel;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Support\Str;
use Scool\EbreEscoolModel\Traits\Ebrescoolable;

class Model extends EloquentModel
{
    use Ebrescoolable;

    /**
     * Get the primary key for the model.
     *
     *
     */
    public function getKeyName()
    {
        return Str::snake(class_basename($this)) . '_' . $this->primaryKey;
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable()
    {
        if (isset($this->table)) {
            return $this->table;
        }

        return str_replace('\\', '', Str::snake(class_basename($this)));
    }
}
