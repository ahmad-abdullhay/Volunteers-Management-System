<?php

namespace App\Repositories\Eloquent;

use App\Services\Facade\TranslationServiceFacade as TranslationService;
use App\Services\Facade\SearchServiceFacade as SearchService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Repositories\RepositoryInterface;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use function Spatie\MediaLibrary\MediaCollections\useDisk;
use Illuminate\Support\Str;

class BaseRepository implements RepositoryInterface
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
     * BaseRepository constructor.
     *
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $columns
     * @param array $relations
     * @param int $length
     * @param array $sortKeys
     * @param array $sortDir
     * @param array $filters
     * @param string|null $search
     * @return Collection
     */
    public function all(
        array $columns = ['*'],
        array $relations = [],
        int $length = 10,
        array $sortKeys = ['id'],
        array $sortDir = ['DESC'],
        array $filters = [],
        string $search = null,
        int $searchInRelation = 0
    )
    {
        $query = $this->model->query();

        $this->model->applyFilters($query, $filters);

        $data = $query
            ->select($columns)
            ->with($relations);

        $isSortable = ($sortKeys[0] !== 'id');

        if ($search != null) {

            if ($isSortable){
                if($searchInRelation){
                    $this->searchByLike($data, $search, $relations);
                }else{
                    $this->searchByLike($data, $search);
                }

            }else{
                if($searchInRelation){
                    $this->searchByFullText($data, $search, $relations);
                }else{
                    $this->searchByLike($data, $search);
                }
                //Checking if there's no sort keys sent with the request.
                //  => Emptying sort keys array in order to sort via Full text search |Score|
                $sortKeys = [];
            }
        }

        return $this->sortAndPaginate($data, $length, $sortKeys, $sortDir);
    }

    /**
     * Get all trashed models.
     *
     * @return Collection
     */
    public function allTrashed(): Collection
    {
        return $this->model->onlyTrashed()->get();
    }

    /**
     * Find model by id.
     *
     * @param int $modelId
     * @param array $columns
     * @param array $relations
     * @param array $appends
     * @return Model
     */
    public function findById(
        int $modelId,
        array $columns = ['*'],
        array $relations = [],
        array $appends = []
    ): ?Model {
        return $this->model->select($columns)->with($relations)->findOrFail($modelId)->append($appends);
    }

    /**
     * Find trashed model by id.
     *
     * @param int $modelId
     * @return Model
     */
    public function findTrashedById(int $modelId): ?Model
    {
        return $this->model->withTrashed()->findOrFail($modelId);
    }

    /**
     * Find only trashed model by id.
     *
     * @param int $modelId
     * @return Model
     */
    public function findOnlyTrashedById(int $modelId): ?Model
    {
        return $this->model->onlyTrashed()->findOrFail($modelId);
    }

    /**
     * Create a model.
     *
     * @param array $payload
     * @return Model
     */
    public function create(array $payload): ?Model
    {
        $payload = TranslationService::getAllTranslationKey($this->model->translatedAttributes ?? [], $payload);

        //Get Many To Many relations Data from Payload.
        $manyToManyRelationsData = $this->getModelRelations($payload);

        //Extract All Files Data From Payload (ex: images, videos, attachments).
        $files = $this->extractFilesData($payload);

        if (!$this->model->translatedAttributes){
            unset($payload['en']);
            unset($payload['ar']);
        }
        $relatedToCurrentUser = $this->model->relatedToCurrentUser;
        if ($this->model->relatedToCurrentUser)
            $payload[$relatedToCurrentUser] = auth()->id();

        $model = $this->model->create($payload);

        //Sync every(many to many) relation with its data from payload.
        foreach ($manyToManyRelationsData as $key => $value)
            $model->{$key}()->sync($value);


        //Assign Files Data To Current Model.
        if ($files)
            $this->assignFilesToModel($model, $files);

        return $model->fresh();
    }

    /**
     * Update existing model.
     *
     * @param int $modelId
     * @param array $payload
     */
    public function update(int $modelId, array $payload)
    {
        $model = $this->findById($modelId);

        $payload = TranslationService::getAllTranslationKey($this->model->translatedAttributes ?? [], $payload);

        //Get Many To Many relations Data from Payload.
        $manyToManyRelationsData = $this->getModelRelations($payload);

        //Extract All Files Data From Payload (ex: images, videos, attachments).
        $files = $this->extractFilesData($payload);

        if (!$this->model->translatedAttributes){
            unset($payload['en']);
            unset($payload['ar']);
        }

        $model->update($payload);

        //Sync every(many to many) relation with its data from payload.
        foreach ($manyToManyRelationsData as $key => $value)
            $model->{$key}()->sync($value);


        //Assign Files Data To Current Model.
        if ($files)
            $this->assignFilesToModel($model, $files);

        return $model->fresh();
    }

    /**
     * Delete model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function deleteById(int $modelId): bool
    {
        return $this->findById($modelId)->delete();
    }

    /**
     * Restore model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function restoreById(int $modelId): bool
    {
        return $this->findOnlyTrashedById($modelId)->restore();
    }

    /**
     * Permanently delete model by id.
     *
     * @param int $modelId
     * @return bool
     */
    public function permanentlyDeleteById(int $modelId): bool
    {
        return $this->findTrashedById($modelId)->forceDelete();
    }
    /**
     * Count all
     * @return mixed
     */
    public function countAll(){
        return $this->model->count();
    }

    /**
     * get all model by custom values
     * @param $column
     * @param $value
     * @return mixed
     */
    public function getBy($column, $value)
    {
        return $this->model->where($column, $value)->get();
    }

    /**
     * get all model by custom values
     * @param $column
     * @param $value
     * @return mixed
     */
    public function getElementBy($column, $value)
    {
        return $this->model->where($column, $value)->first();
    }

    /**
     * Create or update a model.
     *
     * @param array $payload
     * @return Model
     */
    public function updateOrCreate(array $payload): ?Model
    {
        $model = $this->model->updateOrCreate($payload);

        return $model->fresh();
    }


    public function sortAndPaginate($data, $length = 10, array $sortKeys = ['id'], array $sortDir = ['DESC'])
    {
        //Get Model Translated Attributes.
        $translatedAttributes = $this->model->translatedAttributes;

        //Get Model Attributes.
        $modelAttributes = $this->model->getColumns();

        foreach ($sortKeys as $key => $sortKey) {
            if (in_array($sortKey, $modelAttributes)){
                $data->orderBy($sortKey, $sortDir[$key] ?? 'ASC');
            }
            else if (in_array($sortKey, $translatedAttributes)){
                $data->orderByTranslation($sortKey, $sortDir[$key] ?? 'ASC');
            }
        }


        return $data->paginate($length);
    }

    public function search(&$query, $columns, $keyword) {
        $query->where($columns[0], "%{$keyword}%");
        array_shift($columns);
        foreach($columns as $column) {
            $query->orWhere($column, "%{$keyword}%");
        }
    }

    private function getModelRelations(&$payload)
    {
        //Get Model (Many To Many) Relation Names.
        $modelRelations = $this->model->getManyToManyRelations();

        $relations = [];

        foreach ($modelRelations as $relation){
            if (isset($payload[$relation])){
                //Assign Relations values from payload.
                $relations[$relation] = $payload[$relation];
                //Unset Payload relations data => No need them in storing the model.
                unset($payload[$relation]);
            }
        }
        return $relations;
    }

    private function extractFilesData(& $payload)
    {
        $files = $payload['files'] ?? [];

        if (isset($payload['files']))
            unset($payload['files']);

        return $files;
    }

    private function assignFilesToModel(Model $model, $files)
    {
        foreach ($model->media as $media) {
            $media->update([
                'model_type' => 'App\Models\TempMedia',
            ]);
        }
        if ($files)
            Media::whereIn('id', $files)->update([
                'model_id' => $model->id,
                'model_type' => get_class($model),
                'collection_name' => 'default'
            ]);
    }

    private function searchByLike(& $data, $search, $searchInRelations = [])
    {
        //Get Model Translated Attributes.
        $translatedAttributes = $this->model->translatedAttributes;

        //Get Model Searchable Attributes.
        $searchableAttributes = $this->model->getSearchableAttributes();

        $data->where(function ($query) use ($search, $searchableAttributes, $translatedAttributes) {
            $query->whereHas('translations', function ($query) use ($search, $translatedAttributes) {
                foreach ($translatedAttributes as $key => $attribute)
                    if ($key === 0)
                        $query->where($attribute, 'LIKE', "%{$search}%");
                    else
                        $query->orWhere($attribute, 'LIKE', "%{$search}%");
            });

            foreach ($searchableAttributes as $key => $attribute){
                if ($key === 0){
                    if(isset($translatedAttributes[0])){
                        $query->orWhere($attribute, 'LIKE', "%{$search}%");
                    }else{
                        $query->where($attribute, 'LIKE', "%{$search}%");
                    }
                }
                else{
                    $query->orWhere($attribute, 'LIKE', "%{$search}%");
                }
            }
        });


        if($searchInRelations){
            foreach($searchInRelations as $relation){
                $relation = ucfirst(Str::singular($relation));
                $relationModel = resolve("App\Models\\" . $relation);

                $relationModelSearchable = $relationModel->getSearchableAttributes();
                $relationModelTranslations = $relationModel->translatedAttributes;


                //search in model translated attributes
                if($relationModelTranslations){

                    $data->orWhereHas($relationModel->getTable(), function ($query) use ($search, $relationModelTranslations) {
                        $query->whereHas('translations', function ($query) use ($search, $relationModelTranslations) {
                            foreach ($relationModelTranslations as $key => $attribute)
                                if ($key === 0)
                                    $query
                                        ->where($attribute, 'LIKE', "%{$search}%");
                                else
                                    $query
                                        ->orWhere($attribute, 'LIKE', "%{$search}%");
                        });
                    });
                }

                //search in model attributes
                if($relationModelSearchable){
                    //Convert Model Attributes Array To a string delimited by (,) ex: (arr : [x, y, z]) => 'x,y,z'

                    $data->orWhereHas($relationModel->getTable(), function ($query) use ($search, $relationModelSearchable) {
                        foreach ($relationModelSearchable as $key => $attribute){
                            if ($key === 0)
                                $query
                                    ->where($attribute, 'LIKE', "%{$search}%");
                            else
                                $query
                                    ->orWhere($attribute, 'LIKE', "%{$search}%");
                        }
                    });
                }
            }
        }
    }

    private function searchByFullText(& $data, $search, $searchInRelations = [])
    {
        //Get Translated Attributes.
        $translatedAttributes = $this->model->translatedAttributes;

        //Get Model Searchable Attributes.
        $searchableAttributes = $this->model->getSearchableAttributes();

        //Convert Model Attributes Array To a string delimited by (,) ex: (arr : [x, y, z]) => 'x,y,z'
        $translatedAttributes = convertArrayToDelimitedString($translatedAttributes, ',');

        //Separate search string into tokens.
        $tokens = SearchService::convertToSeparatedTokens($search);

        //search in model translated attributes
        if($translatedAttributes){
            $data->whereHas('translations', function ($query) use ($tokens, $translatedAttributes) {
                $query
                    ->WhereRaw("MATCH({$translatedAttributes}) AGAINST(? IN BOOLEAN MODE) > 0", $tokens);
            });
        }

        //search in model attributes
        if($searchableAttributes){
            //Convert Model Attributes Array To a string delimited by (,) ex: (arr : [x, y, z]) => 'x,y,z'
            $searchableAttributes = convertArrayToDelimitedString($searchableAttributes, ',');

            $data->orWhereRaw("MATCH({$searchableAttributes}) AGAINST(? IN BOOLEAN MODE) > 0", $tokens);
        }

        //search in model relations
        if($searchInRelations){
            foreach($searchInRelations as $relation){
                $relation = ucfirst(Str::singular($relation));
                $relationModel = resolve("App\Models\\" . $relation);

                $relationModelSearchable = $relationModel->getSearchableAttributes();
                $relationModelTranslations = $relationModel->translatedAttributes;


                //search in model translated attributes
                if($relationModelTranslations){

                    $relationModelTranslations = convertArrayToDelimitedString($relationModelTranslations, ',');
                    $data->orWhereHas($relationModel->getTable(), function ($query) use ($tokens, $relationModelTranslations) {
                        $query->whereHas('translations', function ($query) use ($tokens, $relationModelTranslations) {
                            $query->WhereRaw("MATCH({$relationModelTranslations}) AGAINST(? IN BOOLEAN MODE) > 0", $tokens);
                        });
                    });
                }

                //search in model attributes
                if($relationModelSearchable){
                    //Convert Model Attributes Array To a string delimited by (,) ex: (arr : [x, y, z]) => 'x,y,z'
                    $relationModelSearchable = convertArrayToDelimitedString($relationModelSearchable, ',');

                    $data->orWhereHas($relationModel->getTable(), function ($query) use ($tokens, $relationModelSearchable) {
                        $query->WhereRaw("MATCH({$relationModelSearchable}) AGAINST(? IN BOOLEAN MODE) > 0", $tokens);
                    });
                }
            }
        }
    }
}
