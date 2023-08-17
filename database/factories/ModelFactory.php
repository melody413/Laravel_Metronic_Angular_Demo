<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Page::class, function (Faker $faker, $attr) {
    return [
        'image' => $faker->image( storage_path('uploads/pages/'), 160, 160, null, false),
        'is_active' => $faker->boolean(),
        'deleted_at' => $faker->date()
    ];
});
$factory->define(App\Models\PageTrans::class, function (Faker $faker) {
    return [
        'title' => implode(' ', $faker->words(7)),
        'content' => $faker->text,
        'meta_title' => $faker->text,
        'meta_description' => $faker->text,
        'meta_keywords' => $faker->text,
    ];
});

$factory->define(App\Models\Faq::class, function (Faker $faker, $attr) {
    $faq = App\Models\Faq::inRandomOrder()->first();

    return [
        'is_active' => $faker->boolean(),
        'deleted_at' => $faker->date()
    ];
});
$factory->define(App\Models\FaqTrans::class, function (Faker $faker) {
    return [
        'title' => implode(' ', $faker->words(7)),
        'content' => $faker->text,
        'meta_title' => $faker->text,
        'meta_description' => $faker->text,
        'meta_keywords' => $faker->text,
    ];
});

$factory->define(App\Models\Country::class, function (Faker $faker, $attr) {
    return [
        'code' => $faker->countryCode ,
        'currency_code' => $faker->currencyCode ,
        'is_active' => $faker->boolean(),
    ];
});
$factory->define(App\Models\CountryTrans::class, function (Faker $faker) {
    return [
        'name' => $faker->country
    ];
});

$factory->define(App\Models\City::class, function (Faker $faker, $attr) {
    $country = \App\Models\Country::inRandomOrder()->first();

    return [
        'country_id' => $country->id,
        'is_active' => $faker->boolean(),
    ];
});
$factory->define(App\Models\CityTrans::class, function (Faker $faker) {
    return [
        'name' => $faker->city
    ];
});

$factory->define(App\Models\Area::class, function (Faker $faker, $attr) {
    $city = \App\Models\City::inRandomOrder()->first();
    return [
        'city_id' => $city->id,
        'is_active' => $faker->boolean(),
    ];
});
$factory->define(App\Models\AreaTrans::class, function (Faker $faker) {
    return [
        'name' => $faker->city
    ];
});

$factory->define(App\Models\Specialty::class, function (Faker $faker, $attr) {
    return [
        'is_active' => $faker->boolean(),
    ];
});
$factory->define(App\Models\SpecialtyTrans::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->text
    ];
});

$factory->define(App\Models\Pharmacy::class, function (Faker $faker, $attr) {
    $parentPharmacy = \App\Models\Pharmacy::inRandomOrder()->first();
    $parentId = isset($parentPharmacy->id)?$parentPharmacy->id :null ;

    $country = \App\Models\Country::where('is_active', 1)->inRandomOrder()->first();
    $city = \App\Models\City::where('is_active',1)->where('country_id', $country->id)->inRandomOrder()->first();
    $area = \App\Models\Area::where('is_active',1)->where('city_id', $city->id)->inRandomOrder()->first();

    return [
        'image' => $faker->image( public_path('uploads/pharmacies/'), 160, 160, null, false),
        'country_id' => $country->id ,
        'city_id' => $city->id,
        'area_id' => $area->id,
        'lat_lng' => $faker->latitude . ',' . $faker->longitude,
        'phone' => $faker->phoneNumber . '/' . $faker->phoneNumber,
        'parent_id' => $parentId,
        'is_active' => 1,
    ];
});
$factory->define(App\Models\PharmacyTrans::class, function (Faker $faker) {
    return [
        'name' => implode(' ', $faker->words(3)),
        'excerpt' => $faker->text,
        'description' => $faker->text,
        'address' => $faker->address,
    ];
});

$factory->define(App\Models\LabService::class, function (Faker $faker, $attr) {
    return [
    ];
});
$factory->define(App\Models\LabServiceTrans::class, function (Faker $faker) {
    return [
        'name' => implode(' ', $faker->words(2)),
    ];
});

$factory->define(App\Models\Lab::class, function (Faker $faker, $attr) {
    $parentLab = \App\Models\Lab::inRandomOrder()->first();
    $parentId = isset($parentLab->id)?$parentLab->id :null ;

    $country = \App\Models\Country::where('is_active', 1)->inRandomOrder()->first();
    $city = \App\Models\City::where('is_active',1)->where('country_id', $country->id)->inRandomOrder()->first();
    $area = \App\Models\Area::where('is_active',1)->where('city_id', $city->id)->inRandomOrder()->first();

    return [
        'image' => $faker->image( public_path('uploads/labs'), 160, 160, null, false),
        'country_id' => $country->id ,
        'city_id' => $city->id,
        'area_id' => $area->id,
        'lat_lng' => $faker->latitude . ',' . $faker->longitude,
        'phone' => $faker->phoneNumber . '/' . $faker->phoneNumber,
        'parent_id' => $parentId,
        'is_active' => $faker->boolean(),
    ];
});
$factory->define(App\Models\LabTrans::class, function (Faker $faker) {
    return [
        'name' => implode(' ', $faker->words(3)),
        'excerpt' => $faker->text,
        'description' => $faker->text,
        'address' => $faker->address,
    ];
});

$factory->define(App\Models\InsuranceCompany::class, function (Faker $faker, $attr) {
    $parentM= \App\Models\InsuranceCompany::inRandomOrder()->first();
    $parentId = isset($parentM->id)?$parentM->id :null ;

    $country = \App\Models\Country::where('is_active', 1)->inRandomOrder()->first();
    $city = \App\Models\City::where('is_active',1)->where('country_id', $country->id)->inRandomOrder()->first();
    $area = \App\Models\Area::where('is_active',1)->where('city_id', $city->id)->inRandomOrder()->first();

    return [
        'image' => $faker->image( public_path('uploads/insurance_companies/'), 160, 160, null, false),
        'country_id' => $country->id ,
        'city_id' => $city->id,
        'area_id' => $area->id,
        'lat_lng' => $faker->latitude . ',' . $faker->longitude,
        'phone' => $faker->phoneNumber . '/' . $faker->phoneNumber,
        'parent_id' => $parentId,
        'is_active' => $faker->boolean(),
    ];
});
$factory->define(App\Models\InsuranceCompanyTrans::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'excerpt' => $faker->text,
        'description' => $faker->text,
        'address' => $faker->address,
    ];
});

$factory->define(App\Models\Hospital::class, function (Faker $faker, $attr) {
    $parentM= \App\Models\InsuranceCompany::inRandomOrder()->first();
    $parentId = isset($parentM->id)?$parentM->id :null ;
    return [
        'image' => $faker->image( storage_path('uploads/hospitals/'), 160, 160, null, false),
        'lat_lng' => $faker->latitude . ',' . $faker->longitude,
        'phone' => $faker->phoneNumber . '/' . $faker->phoneNumber,
        'parent_id' => $parentId,
        'is_active' => $faker->boolean(),
    ];
});
$factory->define(App\Models\HospitalTrans::class, function (Faker $faker) {
    return [
        'name' => implode(' ', $faker->words(3)),
        'excerpt' => $faker->text,
        'description' => $faker->text,
        'address' => $faker->address,
    ];
});


