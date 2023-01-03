<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Morilog\Jalali\Jalalian;

class UsersBackup implements WithHeadings,FromCollection
{

    private $customers;

    public function __construct($customers)
    {
        $this->customers = $customers;
    }
    public function collection()
    {
        $customers= $this->customers->map(function ($customer) {
            return [
                $customer->id,
                $customer->fullname,
                $customer->mobile,
                $customer->email,
                $customer->birth_date ? Jalalian::forge($customer->birth_date) : 'وارد نشده',
                $customer->gender == 'male' ? 'آقا' : 'خانم',
            ];
        });
        return $customers;
    }

    public function headings(): array
    {
        return [
            'شناسه',
            'نام',
            'موبایل',
            'ایمیل',
            'تاریخ تولد',
            'جنسیت',
        ];
    }
}
