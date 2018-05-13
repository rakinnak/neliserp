#!/bin/sh

model="City"
singular="city"
plural="cities"

cat database/migrations/2018_01_01_150000_create_provinces_table.php    \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > database/migrations/2018_01_01_150000_create_${plural}_table.php 

cat database/seeds/ProvinceSeeder.php                                   \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > database/seeds/${model}Seeder.php                                

cat database/factories/ProvinceFactory.php                              \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > database/factories/${model}Factory.php                           

cat app/Filters/ProvinceFilter.php                                      \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > app/Filters/${model}Filter.php                                   

cat app/Policies/ProvincePolicy.php                                     \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > app/Policies/${model}Policy.php                                  

cat app/Http/Resources/ProvinceResource.php                             \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > app/Http/Resources/${model}Resource.php                          

cat app/Http/Requests/ProvinceRequest.php                               \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > app/Http/Requests/${model}Request.php                            

cat app/Http/Controllers/ProvinceController.php                         \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > app/Http/Controllers/${model}Controller.php                      

cat app/Http/Controllers/Api/ProvinceApi.php                            \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > app/Http/Controllers/Api/${model}Api.php                         

cat app/Province.php                                                    \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > app/${model}.php                                                 
cat tests/Feature/ProvinceApiTest.php                                   \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > tests/Feature/${model}ApiTest.php                                

mkdir -p resources/views/${plural}

cat resources/views/provinces/form.blade.php                            \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > resources/views/${plural}/form.blade.php                         

cat resources/views/provinces/index.blade.php                           \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > resources/views/${plural}/index.blade.php                        

cat resources/views/provinces/delete.blade.php                          \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > resources/views/${plural}/delete.blade.php                       

cat resources/views/provinces/edit.blade.php                            \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > resources/views/${plural}/edit.blade.php                         

cat resources/views/provinces/create.blade.php                          \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > resources/views/${plural}/create.blade.php                       

cat resources/views/provinces/show.blade.php                            \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > resources/views/${plural}/show.blade.php                         

mkdir -p resources/assets/js/components/${plural}

cat resources/assets/js/components/provinces/ProvinceDelete.vue         \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > resources/assets/js/components/${plural}/${model}Delete.vue      

cat resources/assets/js/components/provinces/ProvinceEdit.vue           \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > resources/assets/js/components/${plural}/${model}Edit.vue        

cat resources/assets/js/components/provinces/ProvinceShow.vue           \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > resources/assets/js/components/${plural}/${model}Show.vue        

cat resources/assets/js/components/provinces/ProvinceCreate.vue         \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > resources/assets/js/components/${plural}/${model}Create.vue      

cat resources/assets/js/components/provinces/ProvinceIndex.vue          \
    | sed "s/provinces/${plural}/g;s/Province/${model}/g;s/province/${singular}/g" \
    > resources/assets/js/components/${plural}/${model}Index.vue       
