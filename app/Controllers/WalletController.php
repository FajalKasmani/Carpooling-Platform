<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Wallet;
use App\Services\RazorpayService;

class WalletController extends Controller
{
    /**
     * Wallet page — balance + transaction history.
     * GET /wallet
     */
    public function index(): void
    {
        $model        = new Wallet();
        $balance      = $model->getBalance($this->userId());
        $transactions = $model->getTransactions($this->userId());

        $this->view('wallet/index', [
            'balance'      => $balance,
            'transactions' => $transactions,
            'flash'        => $this->getFlash(),
        ]);
    }

    /**
     * Recharge wallet.
     * POST /wallet/recharge
     */
    public function recharge(): void
    {
        $data   = $this->jsonBody();
        $amount = (float)($data['amount'] ?? 0);

        if ($amount <= 0) {
            $this->json(['success' => false, 'error' => 'Amount must be greater than 0'], 400);
        }

        $model      = new Wallet();
        $newBalance = $model->recharge($this->userId(), $amount, $data['reference'] ?? 'manual_recharge');

        $this->json([
            'success'     => true,
            'message'     => "₹{$amount} added successfully!",
            'new_balance' => $newBalance,
        ]);
    }

    /**
     * AJAX: Get wallet balance.
     * GET /api/wallet
     */
    public function apiBalance(): void
    {
        $model   = new Wallet();
        $balance = $model->getBalance($this->userId());
        $transactions = $model->getTransactions($this->userId(), 10);

        $this->json([
            'success'      => true,
            'balance'      => $balance,
            'transactions' => $transactions,
        ]);
    }
}
