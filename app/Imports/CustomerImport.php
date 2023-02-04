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
    private $product;
    private string $tag;

    public function __construct($product, $tag)
    {
        $this->product= $product;
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
            if (Str::length($phone) == 11 && $this->validatePhone($phone))
            {
                $customer = Customer::query()->whereMobile($phone)->first();
                if(!$customer){
                    $customer= Customer::query()->create([
                        'mobile'      =>  $phone,
                        'fullname'    =>  $row[1],
                    ]);
                }
//                && $customer->DoesNotHaveSalesCase()

                $HasNotCreatedAlready= SalesCase::query()
                    ->where('tag_id',  $this->tag)
                    ->where('customer_id',  $customer->id)
                    ->where('status_id', $firstStatus->id)
                    ->exists();

                if (!is_null($this->product) && count($this->product) > 0 &&  !$HasNotCreatedAlready){
                     $salesCase= SalesCase::query()->create([
                         'agent_id'     => null,
                         'customer_id'  => $customer->id,
                         'status_id'    => $firstStatus->id,
                         'tag_id'       => $this->tag,
                     ]);
                     $salesCase->products()->attach($this->product);
                }
            }
            $this->setToWrongList($row);
        }
    }


    private function validatePhone($phone): bool
    {
        return Str::of($phone)->startsWith('09');
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
