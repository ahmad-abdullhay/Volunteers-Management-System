<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class BaseModel extends Model
{
    //Define Translatable Columns.
    public $translatedAttributes  = [];

    protected $manyToManyRelations = [];

    //Get All Many to Many relations.
    public function getManyToManyRelations()
    {
        return $this->manyToManyRelations;
    }

    //Returns True If Given Column exists in Model DB Schema.
    public function hasColumn($column)
    {
        return $this
            ->getConnection()
            ->getSchemaBuilder()
            ->hasColumn($this->getTable(),$column);
    }
    //Define Model Searchable Attributes.
    protected $searchableAttributes = [];

    //Get All  Searchable attributes.
    public function getSearchableAttributes()
    {
        return $this->searchableAttributes;
    }

    public function getColumns()
    {
        return Schema::getColumnListing($this->getTable());
    }
}
