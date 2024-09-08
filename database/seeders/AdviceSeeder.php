<?php

namespace Database\Seeders;

use App\Models\Advice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Advice::insert(
            [
                [
                    'advice' => 'اهم الاسباب لمشكلة جلد الوزة',
                    'media' => '/images/videos/skin.mp4'
                ],
                [
                    'advice' => 'عوامل نفسية تسبب مشاكل في الاسنان',
                    'media' => '/images/videos/teeth.mp4'
                ],
                [
                    'advice' => 'علاجات الاسمرار حول منطقة الفم',
                    'media' => '/images/videos/mouth.mp4'
                ],
                [
                    'advice' => 'اخطاء تحنبيها اثناء جلسات الليزر',
                    'media' => '/images/videos/laser.mp4'
                ],
                [
                    'advice' => 'الكوكتيل الاقوى لعلاج مشاكل البشرة',
                    'media' => '/images/videos/coctail.mp4'
                ],
                [
                    'advice' => 'ليش البوتوكس ماعم يبفى مدة طويلة !!',
                    'media' => '/images/videos/botox.mp4'
                ],
                [
                    'advice' => 'تعليمات ما بعد ابرة النضارة',
                    'media' => '/images/videos/inject.mp4'
                ],
                [
                    'advice' => 'خرافة الاركيلة',
                    'media' => '/images/videos/shisha.mp4'
                ],
                [
                    'advice' => 'خرافة الماء الباردة',
                    'media' => '/images/videos/water.mp4'
                ],
                [
                    'advice' => 'inbody تعليمات لأفصل نتيجة لجهاز ',
                    'media' => '/images/videos/inbody.mp4'
                ],
            ]

        );
    }
}
