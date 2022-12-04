<?php

namespace App\Imports;

use App\Functions\Phone;
use App\Models\Customer;
use App\Models\SalesCase;
use App\Models\SalesCaseStatus;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToCollection;

class CustomerImport implements ToCollection
{
    private array $wrongList= [];
    private $products;
    private string $tag;

    public function __construct($products, $tag)
    {
        $this->products= $products;
        $this->tag = $tag;
    }

    public function collection(Collection $rows)
    {
        $wrongList=[];
        $firstStatus= SalesCaseStatus::query()->where('is_first_step', true)->first();
        foreach ($rows as $row)
        {

            $phone =Phone::convertPersianNumbersToEnglish($row[0]);
            if (Str::length($phone) == 10) $phone= $this->format10thCharacterNumber($phone);
            if (Str::length($phone) == 13) $phone= $this->format13thCharacterNumber($phone);
            if (Str::length($phone) == 11 || $this->validatePhone($phone))
            {
                $customer = Customer::query()->whereMobile($phone)->first();
                if(!$customer){
                    $customer= Customer::query()->create([
                        'mobile'      =>  $phone,
                        'fullname'    =>  $row[1],
                    ]);
                }
//                && $customer->DoesNotHaveSalesCase()
                if (!is_null($this->products) && count($this->products) > 0 && $customer->DoesNotHaveSalesCase()){
                     $salesCase= SalesCase::query()->create([
                         'agent_id'     => null,
                         'customer_id'  => $customer->id,
                         'status_id'    => $firstStatus->id,
                         'tag_id'       => $this->tag,
                     ]);
                     $salesCase->products()->attach($this->products);
                }
            }
            $this->setToWrongList($row);
        }
    }


    private function validatePhone($phone): bool
    {
        $validOperator= false;
        foreach (iranOperators() as $operator) {
            if (Str::of($phone)->startsWith($operator)){
                $validOperator = true;
                break;
            }
        }
        return $validOperator;
    }
    private function format10thCharacterNumber($phone){
        return  "0" . $phone;
    }

    private function format13thCharacterNumber($phone)
    {
        return  Str::replace('+98', '0', $phone);
    }

    private function setToWrongList($row){
        array_push($this->wrongList , $row);
    }
}
