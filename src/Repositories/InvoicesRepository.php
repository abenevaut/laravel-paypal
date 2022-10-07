<?php

namespace abenevaut\Paypal\Repositories;

use abenevaut\Paypal\Contracts\PaypalApiRepositoryAbstract;
use Illuminate\Support\Collection;

final class InvoicesRepository extends PaypalApiRepositoryAbstract
{
    public function get(string $recipientEmail): Collection
    {
        return $this
            ->request()
            ->post($this->makeUrl("/v2/invoicing/search-invoices"), [
                'recipient_email' => $recipientEmail,
            ])
            ->collect();
    }
}
