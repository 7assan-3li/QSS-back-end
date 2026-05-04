<?php

namespace App\Services;

use App\Models\BankSystemAccount;

class BankSystemAccountService
{
    /**
     * Create a new bank system account.
     */
    public function create(array $data)
    {
        return BankSystemAccount::create($data);
    }

    /**
     * Update an existing bank system account.
     */
    public function update(BankSystemAccount $account, array $data)
    {
        return $account->update($data);
    }

    /**
     * Delete a bank system account.
     */
    public function delete(BankSystemAccount $account)
    {
        return $account->delete();
    }
}
