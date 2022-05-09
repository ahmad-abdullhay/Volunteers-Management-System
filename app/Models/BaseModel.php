<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;

class BaseModel extends Model
{
    //Define Translatable Columns.
    public $translatedAttributes  = [];

    //Define Array Filters.
    protected array $filterables = [];

    protected array $manyToManyRelations = [];

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

    public function applyFilters(Builder &$builder, $filters)
    {
        foreach ($this->filterables as $filter){
            //Resolving Filter.
            $filter = resolve($filter);

            //Applying Filter Functionality.
            $filter->apply($builder, $filters);
        }
    }
}
