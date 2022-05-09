<?php

namespace App\Repositories;

use App\Models\CSV;
use App\Repositories\Contracts\CSVsRepository;
use Closure;

class CSVS extends Base implements CSVsRepository
{
    /**
     * Determines the model.
     *
     * @return mixed
     */
    public function model()
    {
        return CSV::class;
    }

    /**
     * Get all entries.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(...$args)
    {
        return $this->model()::all();
    }

    /**
     * Get an entry by it's ID.
     *
     * @param int
     *
     * @return \App\Models\CSV
     */
    public function get($id)
    {
        return $this->model()::find($id);
    }

    /**
     * Saves an entry.
     *
     * @param array
     *
     * @return \App\Models\CSV
     */
    public function store(array $data)
    {
        $model = $this->newInstance();
        $model->fill($data);
        $model->save();

        return $model;
    }

    /**
     * Updates an entry.
     *
     * @param int
     * @param array
     *
     * @return \App\Models\CSV
     */
    public function update($id, array $data)
    {
        $model = $this->model()::find($id);
        $model->fill($data);
        $model->save();

        return $model;
    }

    /**
     * Deletes entries.
     *
     * @param int|Closure
     *
     * @return int
     */
    public function delete($identifier)
    {
        if (is_callable($identifier)) {
            return $this->model()::where(function ($query) use ($identifier) {
                return $identifier($query);
            })->delete();
        }

        return $this->model()::destroy($identifier);
    }
}
