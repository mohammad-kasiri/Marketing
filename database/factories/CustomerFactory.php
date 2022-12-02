<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    public function definition()
    {
        $gender = Arr::random(['male', 'female']);
        $email = Arr::random([$this->faker->unique()->safeEmail(), null]);
        return [
            'first_name'                => $this->getFirstName($gender),
            'last_name'                 => $this->getRandomLastName(),
            'mobile'                    => $this->getUniqePhoneNumber(),
            'email'                     => $email,
            'birth_date'                =>  $this->faker->dateTimeBetween('-30 years', '-5 years', 'Asia/Tehran'),
            'gender'                    => $gender,
            'city_id'                   => rand(Province::FIRST_CITY_ID, Province::LAST_CITY_ID),
            'possibility_of_purchase'   => rand(1,99),
            'description'               => Arr::random([null, $this->faker->text(500)]),
            'status'                    => 'created',
        ];
    }

    private function getFirstName(string $gender = 'male'): string
    {
        return $gender == 'male'
            ? $this->getRandomMaleFirstName()
            : $this->getRandomFemaleFirstName();
    }


    private function getRandomMaleFirstName(): string
    {
        $maleNames = ['رضا', 'سجاد', 'شایان', 'دانیال', 'افشین', 'فربد', 'مصطفی', 'مهرداد', 'حامد', 'سپهر', 'محمد', 'علی', 'محمد رضا', 'حسین', 'فرید', 'امیر', 'علیرضا'];
        return Arr::random($maleNames);
    }

    /**
     * * @param null
     * @return string Female First Name
     */
    private function getRandomFemaleFirstName(): string
    {
        $femaleNames = ['یاسمین', 'مینا', 'درسا', 'فاطمه', 'مهدیه', 'الهه', 'سارا', 'نگار', 'نگین', 'راحله', 'سمانه', 'شیما', 'مهسا', 'هدیه', 'هلما', 'حمیرا'];
        return Arr::random($femaleNames);
    }

    /**
     * @param null
     * @return string LastName
     */
    private function getRandomLastName(): string
    {
        $lastNames = ['رضاپور', 'ابراهیمی', 'مرادی', 'میبدی', 'طاهری', 'موسوی', 'پناهی', 'آذری', 'قاضیان', 'شمسی', 'فلاح', 'محمدی', 'ترکاشوند', 'فتحیان', 'تبریزی', 'خراسانی', 'گودرزی', 'شریفی', 'شهبازی', 'حاتمی', 'نعمتی', 'کاظم زاده', 'علیپور', 'رضایی', 'کریمی', 'رحمانی', 'تاجیک', 'حیدری', 'خسروی', 'جهانی'];
        return Arr::random($lastNames);
    }

    /**
     * @return string
     */
    private function getUniqePhoneNumber(): string
    {
        $phone = generatePhone();
        $is_unique = Customer::query()->where('mobile', '=', $phone)->exists();
        return $is_unique == false
            ? $phone
            : $this->getUniqePhoneNumber();
    }

    private function getEmailVerificationDate(null|string $email): ?\DateTime
    {
        if (is_null($email)) return null;
        return $this->faker->dateTimeBetween('-1 years', 'now', 'Asia/Tehran');
    }
}
