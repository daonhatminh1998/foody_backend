<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductDetailTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products =[
            // ['Pro_Id'=>'1','Pro_Name'=> 'Fresh Tomato','Pro_Price'=> '10.40','Pro_Avatar'=>'product-1.jpg','shortDes'=>'Good products','longDes'=>'Type here 1','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'2','Pro_Name'=> 'Cucumber','Pro_Price'=> '3000.40','Pro_Avatar'=>'product-2.jpg','shortDes'=>'Good products','longDes'=>'Type here 2','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'3','Pro_Name'=> 'Chilli','Pro_Price'=> '90.40','Pro_Avatar'=>'product-3.jpg','shortDes'=>'Good products','longDes'=>'Type here 3','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'1','Pro_Name'=> 'Strawberry','Pro_Price'=> '165.40','Pro_Avatar'=>'product-4.jpg','shortDes'=>'Good products','longDes'=>'Type here 4','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'2','Pro_Name'=> 'Cucumber','Pro_Price'=> '225.40','Pro_Avatar'=>'product-5.jpg','shortDes'=>'Good products','longDes'=>'Type here 5','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'3','Pro_Name'=> 'Persimmon','Pro_Price'=> '455.40','Pro_Avatar'=>'product-6.jpg','shortDes'=>'Good products','longDes'=>'Type here 6','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'1','Pro_Name'=> 'Potato','Pro_Price'=> '700.40','Pro_Avatar'=>'product-7.jpg','shortDes'=>'Good products','longDes'=>'Type here 7','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'2','Pro_Name'=> 'Banana','Pro_Price'=> '900.40','Pro_Avatar'=>'product-8.jpg','shortDes'=>'Good products','longDes'=>'Type here 8','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'3','Pro_Name'=> 'Tomato','Pro_Price'=> '1230.40','Pro_Avatar'=>'product-1.jpg','shortDes'=>'Good products','longDes'=>'Type here 9','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'1','Pro_Name'=> 'Fresh Tomato','Pro_Price'=> '10.40','Pro_Avatar'=>'product-1.jpg','shortDes'=>'Good products','longDes'=>'Type here 1','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'2','Pro_Name'=> 'Cucumber','Pro_Price'=> '3000.40','Pro_Avatar'=>'product-2.jpg','shortDes'=>'Good products','longDes'=>'Type here 2','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'3','Pro_Name'=> 'Chilli','Pro_Price'=> '90.40','Pro_Avatar'=>'product-3.jpg','shortDes'=>'Good products','longDes'=>'Type here 3','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'1','Pro_Name'=> 'Strawberry','Pro_Price'=> '165.40','Pro_Avatar'=>'product-4.jpg','shortDes'=>'Good products','longDes'=>'Type here 4','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'2','Pro_Name'=> 'Cucumber','Pro_Price'=> '225.40','Pro_Avatar'=>'product-5.jpg','shortDes'=>'Good products','longDes'=>'Type here 5','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'3','Pro_Name'=> 'Persimmon','Pro_Price'=> '455.40','Pro_Avatar'=>'product-6.jpg','shortDes'=>'Good products','longDes'=>'Type here 6','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'1','Pro_Name'=> 'Potato','Pro_Price'=> '700.40','Pro_Avatar'=>'product-7.jpg','shortDes'=>'Good products','longDes'=>'Type here 7','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'2','Pro_Name'=> 'Banana','Pro_Price'=> '900.40','Pro_Avatar'=>'product-8.jpg','shortDes'=>'Good products','longDes'=>'Type here 8','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'3','Pro_Name'=> 'Tomato','Pro_Price'=> '1230.40','Pro_Avatar'=>'product-1.jpg','shortDes'=>'Good products','longDes'=>'Type here 9','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'1','Pro_Name'=> 'Fresh Tomato','Pro_Price'=> '10.40','Pro_Avatar'=>'product-1.jpg','shortDes'=>'Good products','longDes'=>'Type here 1','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'2','Pro_Name'=> 'Cucumber','Pro_Price'=> '3000.40','Pro_Avatar'=>'product-2.jpg','shortDes'=>'Good products','longDes'=>'Type here 2','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'3','Pro_Name'=> 'Chilli','Pro_Price'=> '90.40','Pro_Avatar'=>'product-3.jpg','shortDes'=>'Good products','longDes'=>'Type here 3','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'1','Pro_Name'=> 'Strawberry','Pro_Price'=> '165.40','Pro_Avatar'=>'product-4.jpg','shortDes'=>'Good products','longDes'=>'Type here 4','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'2','Pro_Name'=> 'Cucumber','Pro_Price'=> '225.40','Pro_Avatar'=>'product-5.jpg','shortDes'=>'Good products','longDes'=>'Type here 5','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'3','Pro_Name'=> 'Persimmon','Pro_Price'=> '455.40','Pro_Avatar'=>'product-6.jpg','shortDes'=>'Good products','longDes'=>'Type here 6','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'1','Pro_Name'=> 'Potato','Pro_Price'=> '700.40','Pro_Avatar'=>'product-7.jpg','shortDes'=>'Good products','longDes'=>'Type here 7','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'2','Pro_Name'=> 'Banana','Pro_Price'=> '900.40','Pro_Avatar'=>'product-8.jpg','shortDes'=>'Good products','longDes'=>'Type here 8','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'3','Pro_Name'=> 'Tomato','Pro_Price'=> '1230.40','Pro_Avatar'=>'product-1.jpg','shortDes'=>'Good products','longDes'=>'Type here 9','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'1','Pro_Name'=> 'Fresh Tomato','Pro_Price'=> '10.40','Pro_Avatar'=>'product-1.jpg','shortDes'=>'Good products','longDes'=>'Type here 1','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'2','Pro_Name'=> 'Cucumber','Pro_Price'=> '3000.40','Pro_Avatar'=>'product-2.jpg','shortDes'=>'Good products','longDes'=>'Type here 2','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'3','Pro_Name'=> 'Chilli','Pro_Price'=> '90.40','Pro_Avatar'=>'product-3.jpg','shortDes'=>'Good products','longDes'=>'Type here 3','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'1','Pro_Name'=> 'Strawberry','Pro_Price'=> '165.40','Pro_Avatar'=>'product-4.jpg','shortDes'=>'Good products','longDes'=>'Type here 4','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'2','Pro_Name'=> 'Cucumber','Pro_Price'=> '225.40','Pro_Avatar'=>'product-5.jpg','shortDes'=>'Good products','longDes'=>'Type here 5','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'3','Pro_Name'=> 'Persimmon','Pro_Price'=> '455.40','Pro_Avatar'=>'product-6.jpg','shortDes'=>'Good products','longDes'=>'Type here 6','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'1','Pro_Name'=> 'Potato','Pro_Price'=> '700.40','Pro_Avatar'=>'product-7.jpg','shortDes'=>'Good products','longDes'=>'Type here 7','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'2','Pro_Name'=> 'Banana','Pro_Price'=> '900.40','Pro_Avatar'=>'product-8.jpg','shortDes'=>'Good products','longDes'=>'Type here 8','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'3','Pro_Name'=> 'Tomato','Pro_Price'=> '1230.40','Pro_Avatar'=>'product-1.jpg','shortDes'=>'Good products','longDes'=>'Type here 9','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'1','Pro_Name'=> 'Fresh Tomato','Pro_Price'=> '10.40','Pro_Avatar'=>'product-1.jpg','shortDes'=>'Good products','longDes'=>'Type here 1','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'2','Pro_Name'=> 'Cucumber','Pro_Price'=> '3000.40','Pro_Avatar'=>'product-2.jpg','shortDes'=>'Good products','longDes'=>'Type here 2','Pro_Unit'=>'Gram'],
            // ['Pro_Id'=>'3','Pro_Name'=> 'Chilli','Pro_Price'=> '90.40','Pro_Avatar'=>'product-3.jpg','shortDes'=>'Good products','longDes'=>'Type here 3','Pro_Unit'=>'Gram'],
            ['Pro_Id'=>'1','Pro_Name'=> 'Strawberry','Pro_Price'=> '165.40','Pro_Avatar'=>'product-4.jpg','shortDes'=>'Good products','longDes'=>'Type here 4','Pro_Unit'=>'Gram'],
            ['Pro_Id'=>'2','Pro_Name'=> 'Cucumber','Pro_Price'=> '225.40','Pro_Avatar'=>'product-5.jpg','shortDes'=>'Good products','longDes'=>'Type here 5','Pro_Unit'=>'Gram'],
            ['Pro_Id'=>'3','Pro_Name'=> 'Persimmon','Pro_Price'=> '455.40','Pro_Avatar'=>'product-6.jpg','shortDes'=>'Good products','longDes'=>'Type here 6','Pro_Unit'=>'Gram'],
            ['Pro_Id'=>'1','Pro_Name'=> 'Potato','Pro_Price'=> '700.40','Pro_Avatar'=>'product-7.jpg','shortDes'=>'Good products','longDes'=>'Type here 7','Pro_Unit'=>'Gram'],
            ['Pro_Id'=>'2','Pro_Name'=> 'Banana','Pro_Price'=> '900.40','Pro_Avatar'=>'product-8.jpg','shortDes'=>'Good products','longDes'=>'Type here 8','Pro_Unit'=>'Gram'],
            ['is_Published'=>false,'Pro_Id'=>'3','Pro_Name'=> 'Tomato','Pro_Price'=> '1230.40','Pro_Avatar'=>'product-1.jpg','shortDes'=>'<p><span style=\"background-color:hsl(0,0%,100%);color:hsl(0,0%,0%);font-size:16px;\">The fruit is variable in size, color, and firmness, but is usually elongated and curved, with soft flesh rich in starch covered with a rind, which may be green, yellow, red, purple, or brown when ripe. The fruits grow upward in clusters near the top of the plant.</span></p>','longDes'=>'<p><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.8);font-size:14px;\">Th???i gian giao h??ng d??? ki???n cho s???n ph???m n??y l?? t??? 7-9 ng??y&nbsp;</span></p><h2><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.8);font-size:14px;\">L??U ??:&nbsp;</span></h2><ul><li><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.8);font-size:14px;\">K??ch th?????c 38mm / 40mm/41mm trong size S, kho???ng 97 + 110mm, ph?? h???p v???i c??? tay 12,9-18,1cm&nbsp;</span></li><li><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.8);font-size:14px;\">K??ch th?????c 42mm / 44mm /45mm trong size S, kho???ng 97 + 110mm, ph?? h???p v???i c??? tay 12,9-18,1cm&nbsp;</span></li></ul><h2><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.8);font-size:16px;\"><strong>??i???m n???i b???t:&nbsp;</strong></span></h2><ul><li><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.8);font-size:14px;\">D??nh cho Watch Series SE 6 5 4 3 2 1, 38mm 40mm 42mm 44mm 44mm ; Series 7 41mm 45mm&nbsp;</span></li><li><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.8);font-size:14px;\">Ch???t li???u: Silicon cao c???p</span></li></ul><p><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.8);font-size:14px;\">&nbsp;</span><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.8);font-size:16px;\"><strong>L??u ??:</strong></span><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.8);font-size:14px;\"> T???t c??? m??u s???c ?????u c??n h??ng, n???u m??u s???c b???n mu???n kh??ng c?? trong ph??n lo???i h??ng h??a, vui l??ng ????? l???i ghi ch?? trong ????n h??ng c???a b???n&nbsp;</span></p><p><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.8);font-size:14px;\">L??u ??: Do c??i ?????t m??n h??nh v?? ??nh s??ng kh??c nhau, c?? th??? x???y ra kh??c bi???t v??? m??u s???c nh??? so v???i s???n ph???m th???t. Nh??ng ch??ng t??i ?????m b???o r???ng ki???u d??ng gi???ng v???i h??nh ???nh hi???n th???. C???m ??n v?? xin vui l??ng th??ng c???m cho ch??ng t??i.&nbsp;</span></p><p><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.8);font-size:14px;\">G??i h??ng bao g???m:&nbsp;</span></p><p><span style=\"background-color:rgb(255,255,255);color:rgba(0,0,0,0.8);font-size:14px;\">1 x D??y ??eo silicon (kh??ng bao g???m ?????ng h???)</span></p>','Pro_Unit'=>'Gram'],
        ];

        foreach($products as $row){
            DB::table('product_detail') -> insert($row);
        }
    }
}
