<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
use App\Http\Requests\TransactionUpdateRequest;
use App\Repositories\Contracts\TransactionRepository;
use Illuminate\Support\Facades\Auth;

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
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $this->transactionsRepository->delete($id);

        return response()->json([
            'status' => true,
        ], 200);
    }
}
