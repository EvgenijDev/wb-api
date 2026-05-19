<?php

namespace App\Services;

use App\Models\Income;
use App\Models\Order;
use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Support\Facades\Http;

class WbApiService
{
   private string $baseUrl = 'http://109.73.206.144:6969';

   private string $apiKey = 'E6kUTYrYwZq2tN4QEtyzsbEBk3ie';

   public function import(
      string $entity,
      ?string $dateFrom = null,
      ?string $dateTo = null
   ): void {

      $page = 1;

      do {

         $query = [
            'page' => $page,
            'limit' => 500,
            'key' => $this->apiKey,
         ];

         if ($dateFrom) {
            $query['dateFrom'] = $dateFrom;
         }

         if ($dateTo) {
            $query['dateTo'] = $dateTo;
         }

         $response = Http::timeout(30)
            ->retry(3, 1000)
            ->get(
               $this->baseUrl . '/api/' . $entity,
               $query
            );

         if (!$response->successful()) {
            throw new \Exception(
               'API request failed: ' . $response->body()
            );
         }

         $responseData = $response->json();

         $data = $responseData['data'] ?? [];

         foreach ($data as $item) {

            $this->saveEntity($entity, $item);
         }

         $page++;
      } while (!empty($data));
   }

   private function saveEntity(
      string $entity,
      array $data
   ): void {

      switch ($entity) {

         case 'orders':

            Order::updateOrCreate(
               ['g_number' => $data['g_number']],
               $data
            );

            break;

         case 'sales':

            Sale::updateOrCreate(
               ['g_number' => $data['g_number']],
               $data
            );

            break;

         case 'stocks':

            Stock::updateOrCreate(
               [
                  'supplier_article' => $data['supplier_article'],
                  'warehouse_name' => $data['warehouse_name'],
               ],
               [
                  'date' => $data['date'] ?? null,
                  'last_change_date' => $data['last_change_date'] ?? null,
                  'quantity' => $data['quantity'] ?? 0,
                  'is_supply' => $data['is_supply'] ?? false,
                  'is_realization' => $data['is_realization'] ?? false,
                  'quantity_full' => $data['quantity_full'] ?? 0,
                  'in_way_to_client' => $data['in_way_to_client'] ?? 0,
                  'in_way_from_client' => $data['in_way_from_client'] ?? 0,
                  'price' => $data['price'] ?? 0,
                  'discount' => $data['discount'] ?? 0,
               ]
            );

            break;

         case 'incomes':

            Income::updateOrCreate(
               ['income_id' => $data['income_id']],
               $data
            );

            break;

         default:

            throw new \Exception(
               'Unknown entity: ' . $entity
            );
      }
   }
}
