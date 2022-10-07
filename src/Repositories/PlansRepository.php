<?php

namespace abenevaut\Paypal\Repositories;

use abenevaut\Paypal\Contracts\PaypalApiRepositoryAbstract;
use Illuminate\Support\Collection;

final class PlansRepository extends PaypalApiRepositoryAbstract
{
    public function all(): Collection
    {
        return $this
            ->request()
            ->get($this->makeUrl("/v1/billing/plans"))
            ->collect();
    }

    public function get(string $planId): Collection
    {
        return $this
            ->request()
            ->get($this->makeUrl("/v1/billing/plans/{$planId}"))
            ->collect();
    }

    public function create(array $params): Collection
    {
        return $this
            ->request()
            ->post($this->makeUrl("/v1/billing/plans"), [
                'product_id' => $params['product_id'],
                'name' => $params['name'],
                'billing_cycles' => [
                    [
                        'frequency' => [
                            'interval_unit' => $params['interval'],
                            'interval_count' => $params['interval_count'],
                        ],
                        'tenure_type' => 'REGULAR',
                        'sequence' => 1,
                        'total_cycles' => 0,
                        'pricing_scheme' => [
                            'fixed_price' => [
                                'value' => $params['amount'],
                                'currency_code' => 'EUR',
                            ],
                        ],
                    ],
                ],
                'payment_preferences' => [
                    'payment_failure_threshold' => 1,
                ],
                'taxes' => [
                    'percentage' => 20,
                ],
            ])
            ->collect();
    }
}
