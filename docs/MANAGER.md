## Creating your own credit line amount manager

The bundle comes with a very basic class, `DbCustomerCreditLineManager`, that handles the credit line amount for the
customer via a custom property on the customer table.

If you want to implement a custom manager logic, maybe one that finds the amount via an api call, you could create your
own manager and have it implement the `CustomerCreditLineManagerInterface` which have two public methods
```
    public function getCreditLineAmount(Customer $customer): float;
    public function subtractCreditLineAmount(Customer $customer, float $amount): bool;
```
Then you would inject your own implementation on the `CreditLineViewFactory` and that should be all.

