<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Http\Requests\TransactionUpdateRequest;
use App\Jobs\ProcessExcelImport;
use App\Repositories\Contracts\TransactionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TransactionsController extends Controller
{
    /**
     * @var \App\Repositories\Contracts\TransactionRepository
     */
    protected $transactionsRepository;

    /**
     * Make a new controller instance.
     */
    public function __construct(TransactionRepository $transactionsRepository)
    {
        $this->transactionsRepository = $transactionsRepository;
    }

    /**
     * Return transaction entries.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        return response()->json([
            'status' => true,
            'data' => $this->transactionsRepository->all(Auth::user()->id),
        ], 200);
    }

    /**
     * Store transaction entry.
     *
     * @param \App\Http\Requests\TransactionStoreReques $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TransactionStoreRequest $request)
    {
        $transaction = $this->transactionsRepository->store([
            'user_id' => Auth::user()->id,
            'label' => $request->label,
            'amount' => $request->amount,
            'amount_date' => $request->amount_date,
        ]);

        return response()->json([
            'status' => true,
            'data' => $transaction,
        ], 201);
    }

    /**
     * Update a transaction entry.
     *
     * @param \App\Http\Requests\TransactionUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(string $id, TransactionUpdateRequest $request)
    {
        $transaction = $this->transactionsRepository->update($id, array_merge([
                'user_id' => Auth::user()->id,
            ],
            $request->all()
        ));

        return response()->json([
            'status' => true,
            'data' => $transaction,
        ], 200);
    }

    /**
     * Delete an entry from database.
     *
     * @param string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->transactionsRepository->delete($id);

        return response()->json([
            'status' => true,
        ], 200);
    }

    /**
     * Import a CSV file.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request)
    {
        $path = $request->file('csv')->storeAs(
            'csvs', $request->user()->id.'.csv'
        );

        $rows = get_csv_rows_count(Storage::path($path));

        ProcessExcelImport::dispatch(
            $request->user()->id,
            $path,
            $rows
        );

        return response()->json([
            'status' => true,
            'data' => $rows,
        ], 200);
    }
}
