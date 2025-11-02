<?php

namespace Database\Seeders;

use Botble\Base\Models\MetaBox as MetaBoxModel;
use Botble\Base\Supports\BaseSeeder;
use Botble\Language\Models\LanguageMeta;
use Botble\Page\Models\Page;
use Botble\Slug\Models\Slug;
use Collective\Html\HtmlFacade as Html;
use Illuminate\Support\Facades\DB;
use Botble\Slug\Facades\SlugHelper;
use Illuminate\Support\Str;

class PageSeeder extends BaseSeeder
{
    public function run(): void
    {
        $pages = [
            [
                'name' => 'Home',
                'content' =>
                    Html::tag(
                        'div',
                        '[about-banner title="Hello, I’m &lt;span&gt;Steven&lt;/span&gt;" subtitle="Welcome to my blog" text_muted="Travel Blogger., Content Writer., Food Guides" image="general/featured.png" newsletter_title="Don\'t miss out on the latest news about Travel tips, Hotels review, Food guide..." image="general/featured.png" show_newsletter_form="yes"][/about-banner]'
                    ) .
                    Html::tag('div', '[featured-posts title="Featured posts"][/featured-posts]') .
                    Html::tag('div', '[blog-categories-posts category_id="2"][/blog-categories-posts]') .
                    Html::tag(
                        'div',
                        '[categories-with-posts category_id_1="3" category_id_2="4" category_id_3="5"][/categories-with-posts]'
                    ) .
                    Html::tag('div', '[featured-categories title="Categories"][/featured-categories]')
                ,
                'template' => 'homepage',
            ],
            [
                'name' => 'Home 2',
                'content' =>
                    Html::tag('div', '[featured-posts-slider-full][/featured-posts-slider-full]') .
                    Html::tag('div', '[blog-categories-posts category_id="2"][/blog-categories-posts]') .
                    Html::tag(
                        'div',
                        '[categories-with-posts category_id_1="3" category_id_2="4" category_id_3="5"][/categories-with-posts]'
                    ) .
                    Html::tag('div', '[featured-categories title="Categories"][/featured-categories]')
                ,
                'template' => 'homepage',
            ],
            [
                'name' => 'Home 3',
                'content' =>
                    Html::tag('div', '[featured-posts-slider][/featured-posts-slider]') .
                    Html::tag('div', '[blog-categories-posts category_id="2"][/blog-categories-posts]') .
                    Html::tag(
                        'div',
                        '[categories-with-posts category_id_1="3" category_id_2="4" category_id_3="5"][/categories-with-posts]'
                    ) .
                    Html::tag('div', '[featured-categories title="Categories"][/featured-categories]')
                ,
                'template' => 'homepage',
            ],
            [
                'name' => 'Blog',
                'content' => '---',
                'template' => 'default',
            ],
            [
                'name' => 'Contact',
                'content' => Html::tag(
                    'p',
                    'Address: North Link Building, 10 Admiralty Street, 757695 Singapore'
                ) .
                    Html::tag('p', 'Hotline: 18006268') .
                    Html::tag('p', 'Email: contact@botble.com') .
                    Html::tag(
                        'p',
                        '[google-map]North Link Building, 10 Admiralty Street, 757695 Singapore[/google-map]'
                    ) .
                    Html::tag('p', 'For the fastest reply, please use the contact form below.') .
                    Html::tag('p', '[contact-form][/contact-form]'),
                'template' => 'default',
            ],
            [
                'name' => 'Cookie Policy',
                'content' => Html::tag('h3', 'EU Cookie Consent') .
                    Html::tag(
                        'p',
                        'To use this website we are using Cookies and collecting some Data. To be compliant with the EU GDPR we give you to choose if you allow us to use certain Cookies and to collect some Data.'
                    ) .
                    Html::tag('h4', 'Essential Data') .
                    Html::tag(
                        'p',
                        'The Essential Data is needed to run the Site you are visiting technically. You can not deactivate them.'
                    ) .
                    Html::tag(
                        'p',
                        '- Session Cookie: PHP uses a Cookie to identify user sessions. Without this Cookie the Website is not working.'
                    ) .
                    Html::tag(
                        'p',
                        '- XSRF-Token Cookie: Laravel automatically generates a CSRF "token" for each active user session managed by the application. This token is used to verify that the authenticated user is the one actually making the requests to the application.'
                    ),
                'template' => 'default',
            ],
            [
                'name' => 'Blog List layout',
                'content' => Html::tag('div', '[blog-list limit="12"][/blog-list]'),
                'template' => 'right-sidebar',
            ],
            [
                'name' => 'Blog Big layout',
                'content' => Html::tag('div', '[blog-big limit="12"][/blog-big]'),
                'template' => 'default',
            ],
            [
                'name' => 'Blog Grid layout',
                'content' => Html::tag('div', '[blog-big limit="12"][/blog-big]'),
                'template' => 'right-sidebar',
            ],
        ];

        Page::truncate();
        DB::table('pages_translations')->truncate();
        Slug::where('reference_type', Page::class)->delete();
        MetaBoxModel::where('reference_type', Page::class)->delete();
        LanguageMeta::where('reference_type', Page::class)->delete();

        foreach ($pages as $item) {
            $item['user_id'] = 1;
            $page = Page::create($item);

            Slug::create([
                'reference_type' => Page::class,
                'reference_id' => $page->id,
                'key' => Str::slug($page->name),
                'prefix' => SlugHelper::getPrefix(Page::class),
            ]);
        }

        $translations = [
            [
                'name' => 'Trang chủ',
                'content' =>
                    Html::tag(
                        'div',
                        '[about-banner title="Xin chào, Tôi là &lt;span&gt;Steven&lt;/span&gt;" subtitle="Chào mừng đến với blog của tôi" text_muted="Travel Blogger., Content Writer., Food Guides" image="general/featured.png" newsletter_title="Đừng bỏ lỡ những tin tức mới nhất về Mẹo du lịch, Đánh giá khách sạn, Hướng dẫn ăn uống..." image="general/featured.png" show_newsletter_form="yes"][/about-banner]'
                    ) .
                    Html::tag('div', '[featured-posts title="Bài viết nổi bật"][/featured-posts]') .
                    Html::tag('div', '[blog-categories-posts category_id="11"][/blog-categories-posts]') .
                    Html::tag('div', '[categories-with-posts category_id_1="12" category_id_2="13" category_id_3="14"][/categories-with-posts]') .
                    Html::tag('div', '[featured-categories title="Chuyên mục"][/featured-categories]')
                ,
            ],
            [
                'name' => 'Trang chủ 2',
                'content' =>
                    Html::tag('div', '[featured-posts-slider-full][/featured-posts-slider-full]') .
                    Html::tag('div', '[blog-categories-posts category_id="11"][/blog-categories-posts]') .
                    Html::tag('div', '[categories-with-posts category_id_1="12" category_id_2="13" category_id_3="14"][/categories-with-posts]') .
                    Html::tag('div', '[featured-categories title="Chuyên mục"][/featured-categories]')
                ,
            ],
            [
                'name' => 'Trang chủ 3',
                'content' =>
                    Html::tag('div', '[featured-posts-slider][/featured-posts-slider]') .
                    Html::tag('div', '[blog-categories-posts category_id="11"][/blog-categories-posts]') .
                    Html::tag('div', '[categories-with-posts category_id_1="12" category_id_2="13" category_id_3="14"][/categories-with-posts]') .
                    Html::tag('div', '[featured-categories title="Chuyên mục"][/featured-categories]')
                ,
            ],
            [
                'name' => 'Tin tức',
                'content' => '---',
            ],
            [
                'name' => 'Liên hệ',
                'content' => Html::tag(
                    'p',
                    'Địa chỉ: North Link Building, 10 Admiralty Street, 757695 Singapore'
                ) .
                    Html::tag('p', 'Đường dây nóng: 18006268') .
                    Html::tag('p', 'Email: contact@botble.com') .
                    Html::tag(
                        'p',
                        '[google-map]North Link Building, 10 Admiralty Street, 757695 Singapore[/google-map]'
                    ) .
                    Html::tag('p', 'Để được trả lời nhanh nhất, vui lòng sử dụng biểu mẫu liên hệ bên dưới.') .
                    Html::tag('p', '[contact-form][/contact-form]'),
            ],
            [
                'name' => 'Cookie Policy',
                'content' => Html::tag('h3', 'EU Cookie Consent') .
                    Html::tag(
                        'p',
                        'Để sử dụng trang web này, chúng tôi đang sử dụng Cookie và thu thập một số Dữ liệu. Để tuân thủ GDPR của Liên minh Châu Âu, chúng tôi cho bạn lựa chọn nếu bạn cho phép chúng tôi sử dụng một số Cookie nhất định và thu thập một số Dữ liệu.'
                    ) .
                    Html::tag('h4', 'Dữ liệu cần thiết') .
                    Html::tag(
                        'p',
                        'Dữ liệu cần thiết là cần thiết để chạy Trang web bạn đang truy cập về mặt kỹ thuật. Bạn không thể hủy kích hoạt chúng.'
                    ) .
                    Html::tag(
                        'p',
                        '- Session Cookie: PHP sử dụng Cookie để xác định phiên của người dùng. Nếu không có Cookie này, trang web sẽ không hoạt động.'
                    ) .
                    Html::tag(
                        'p',
                        '- XSRF-Token Cookie: Laravel tự động tạo "token" CSRF cho mỗi phiên người dùng đang hoạt động do ứng dụng quản lý. Token này được sử dụng để xác minh rằng người dùng đã xác thực là người thực sự đưa ra yêu cầu đối với ứng dụng.'
                    ),
            ],
            [
                'name' => 'Blog dạng danh sách',
                'content' => Html::tag('div', '[blog-list limit="12"][/blog-list]'),
            ],
            [
                'name' => 'Blog giao diện lớn',
                'content' => Html::tag('div', '[blog-big limit="12"][/blog-big]'),
            ],
            [
                'name' => 'Blog dạng lưới',
                'content' => Html::tag('div', '[blog-big limit="12"][/blog-big]'),
            ],
        ];

        foreach ($translations as $index => $item) {
            $item['lang_code'] = 'vi';
            $item['pages_id'] = $index + 1;

            DB::table('pages_translations')->insert($item);
        }
    }
}
