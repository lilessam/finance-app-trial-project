<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepository;
use Carbon\Carbon;
use Closure;

class Transactions extends Base implements TransactionRepository
{
    /**
     * Determines the model.
     *
     * @return mixed
     */
    public function model()
    {
        return Transaction::class;
    }

    /**
     * Get all entries.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function all(...$args)
    {
        return $this->model()::whereUserId($args[0])->orderBy('amount_date', 'desc')->get()->mapToGroups(function ($item) {
            return [Carbon::parse($item['amount_date'])->diffForHumans() => $item];
        })->mapWithKeys(function ($items, $key) {
            return [$key => ['total' => $items->sum('amount'), 'items' => $items]];
        });
    }

    /**
     * Get an entry by it's ID.
     *
     * @param int
     *
     * @return \App\Models\Transaction
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
     * @return \App\Models\Transaction
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
     * @return \App\Models\Transaction
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
