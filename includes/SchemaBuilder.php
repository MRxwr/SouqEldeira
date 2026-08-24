<?php
class SchemaBuilder {
    private static function clean($value) {
        return trim(preg_replace('/\s+/u', ' ', strip_tags((string)$value)));
    }

    private static function truncate($value, $length = 160) {
        $value = self::clean($value);
        if ($value === '') {
            return '';
        }
        if (function_exists('mb_strlen') && function_exists('mb_substr')) {
            return mb_strlen($value, 'UTF-8') > $length
                ? rtrim(mb_substr($value, 0, $length - 1, 'UTF-8')) . '…'
                : $value;
        }
        return strlen($value) > $length
            ? rtrim(substr($value, 0, $length - 3)) . '...'
            : $value;
    }

    private static function firstValue(array $data, array $keys) {
        foreach ($keys as $key) {
            if (isset($data[$key]) && $data[$key] !== '' && $data[$key] !== null) {
                return $data[$key];
            }
        }
        return null;
    }

    private static function formatDate($value) {
        if (empty($value)) {
            return null;
        }
        try {
            $timezone = new DateTimeZone('Asia/Kuwait');
            $date = new DateTime((string)$value, $timezone);
            $date->setTimezone($timezone);
            return $date->format(DateTime::ATOM);
        } catch (Exception $e) {
            return $value;
        }
    }

    private static function currentUrl() {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'souqeldeira.com';
        $requestUri = rawurldecode($_SERVER['REQUEST_URI'] ?? '/');
        return $scheme . '://' . $host . $requestUri;
    }

    private static function baseUrl(array $context = []) {
        if (!empty($context['baseURL'])) {
            return rtrim($context['baseURL'], '/') . '/';
        }
        return 'https://souqeldeira.com/';
    }

    private static function localized($en, $ar) {
        if (function_exists('direction')) {
            return self::clean(direction($en, $ar));
        }
        return self::clean(!empty($ar) ? $ar : $en);
    }

    public static function organization($name, $url, array $extra = []) {
        return array_merge([
            '@type' => 'Organization',
            '@id' => rtrim($url, '/') . '/#organization',
            'name' => $name,
            'url' => $url
        ], $extra);
    }

    public static function website($name, $url, $searchUrl) {
        return [
            '@type' => 'WebSite',
            '@id' => rtrim($url, '/') . '/#website',
            'name' => $name,
            'url' => $url,
            'publisher' => ['@id' => rtrim($url, '/') . '/#organization'],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => $searchUrl . '{search_term_string}'
                ],
                'query-input' => 'required name=search_term_string'
            ]
        ];
    }

    public static function breadcrumb($items) {
        $list = [];
        foreach ($items as $key => $item) {
            $entry = [
                '@type' => 'ListItem',
                'position' => $key + 1,
                'name' => self::clean($item['name'] ?? '')
            ];
            if (!empty($item['url'])) {
                $entry['item'] = $item['url'];
            }
            $list[] = $entry;
        }
        return [
            '@type' => 'BreadcrumbList',
            'itemListElement' => $list
        ];
    }

    public static function realEstateListing($data) {
        return array_merge(['@type' => 'RealEstateListing'], $data);
    }

    public static function offer($data) {
        return array_merge(['@type' => 'Offer'], $data);
    }

    public static function demand($data) {
        return array_merge(['@type' => 'Demand'], $data);
    }

    public static function article($data) {
        return array_merge(['@type' => 'NewsArticle'], $data);
    }

    public static function faq($questions) {
        $items = [];
        foreach ($questions as $q) {
            $question = self::clean($q['question'] ?? '');
            $answer = self::clean($q['answer'] ?? '');
            if ($question === '' || $answer === '') {
                continue;
            }
            $items[] = [
                '@type' => 'Question',
                'name' => $question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $answer
                ]
            ];
        }
        return [
            '@type' => 'FAQPage',
            'mainEntity' => $items
        ];
    }

    public static function itemList($items) {
        return [
            '@type' => 'ItemList',
            'numberOfItems' => count($items),
            'itemListElement' => $items
        ];
    }

    public static function collection($items, array $data = []) {
        return array_merge([
            '@type' => 'CollectionPage',
            'mainEntity' => self::itemList($items)
        ], $data);
    }

    public static function agent($data) {
        return array_merge(['@type' => 'RealEstateAgent'], $data);
    }

    public static function render($schemas) {
        $schemas = array_values(array_filter($schemas, function ($schema) {
            return is_array($schema) && !empty($schema);
        }));
        if (!$schemas) {
            return;
        }
        echo '<script type="application/ld+json">' . json_encode([
            '@context' => 'https://schema.org',
            '@graph' => $schemas
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . '</script>';
    }

    public static function renderForPage($view, array $context = []) {
        $view = $view ?: 'Home';
        $base = self::baseUrl($context);
        $siteName = self::localized('Souq Al Deirah', 'سوق الديرة');
        $currentUrl = self::currentUrl();
        $homeUrl = rtrim($base, '/') . '/';
        $schemas = [];

        if ($view === 'Home') {
            $schemas[] = self::organization($siteName, $homeUrl, [
                'logo' => $base . 'assets/img/logo-1.png',
                'email' => 'info@souqeldeira.com',
                'telephone' => '22281412',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressCountry' => 'KW'
                ]
            ]);
            $schemas[] = self::website($siteName, $homeUrl, $base . 'search?query=');
        }

        if ($view === 'AdView' && !empty($context['ad'][0])) {
            $ad = $context['ad'][0];
            $title = self::localized($ad['enTitle'] ?? '', $ad['arTitle'] ?? '');
            $description = self::localized($ad['enDetails'] ?? '', $ad['arDetails'] ?? '');
            $area = !empty($context['area'][0]) ? $context['area'][0] : null;
            $category = !empty($context['category'][0]) ? $context['category'][0] : null;
            $categoryName = $category ? self::localized($category['enTitle'] ?? '', $category['arTitle'] ?? '') : '';
            $images = !empty($context['images']) ? $context['images'] : [];
            if (!$images && function_exists('selectDB') && !empty($ad['id'])) {
                $images = selectDB('images', "`productId` = '" . (int)$ad['id'] . "'");
            }
            $image = !empty($images[0]['imageurl']) ? $base . 'logos/' . $images[0]['imageurl'] : $base . 'assets/img/logo-1.png';

            $listing = [
                '@id' => $currentUrl . '#listing',
                'name' => $title,
                'description' => $description,
                'url' => $currentUrl,
                'image' => $image
            ];
            if ($area) {
                $listing['address'] = [
                    '@type' => 'PostalAddress',
                    'addressLocality' => self::localized($area['enTitle'] ?? '', $area['arTitle'] ?? ''),
                    'addressCountry' => 'KW'
                ];
            }
            $schemas[] = self::realEstateListing($listing);

            $transaction = [
                '@id' => $currentUrl . '#transaction',
                'url' => $currentUrl,
                'itemOffered' => ['@id' => $currentUrl . '#listing']
            ];
            if (isset($ad['price']) && $ad['price'] !== '') {
                $transaction['price'] = (string)$ad['price'];
                $transaction['priceCurrency'] = 'KWD';
            }
            $isDemand = preg_match('/طلب|wanted|request|demand/iu', $categoryName) === 1;
            $schemas[] = $isDemand ? self::demand($transaction) : self::offer($transaction);
            $schemas[] = self::breadcrumb([
                ['name' => self::localized('Home', 'الرئيسية'), 'url' => $homeUrl],
                ['name' => $categoryName ?: self::localized('Properties', 'العقارات'), 'url' => !empty($ad['categoryId']) ? $base . 'search/type=' . $ad['categoryId'] : $base . 'search'],
                ['name' => $title, 'url' => $currentUrl]
            ]);
        }

        if ($view === 'NewsView' && !empty($context['news'][0])) {
            $news = $context['news'][0];
            $title = self::localized($news['enTitle'] ?? '', $news['arTitle'] ?? '');
            $fullDescription = self::localized($news['enDetails'] ?? '', $news['arDetails'] ?? '');
            $description = self::truncate($fullDescription, 160);

            $published = self::formatDate(self::firstValue($news, [
                'datePublished', 'publishedAt', 'published_at', 'publishDate', 'publish_date',
                'createdAt', 'created_at', 'created', 'date'
            ]));
            $modified = self::formatDate(self::firstValue($news, [
                'dateModified', 'updatedAt', 'updated_at', 'modifiedAt', 'modified_at',
                'updated', 'modified'
            ]));
            if (!$modified) {
                $modified = $published;
            }

            $article = [
                '@id' => $currentUrl . '#article',
                'headline' => $title,
                'description' => $description,
                'url' => $currentUrl,
                'mainEntityOfPage' => $currentUrl,
                'image' => !empty($news['imageurl']) ? $base . 'logos/' . $news['imageurl'] : $base . 'assets/img/logo-1.png',
                'author' => [
                    '@type' => 'Organization',
                    'name' => $siteName,
                    'url' => $homeUrl
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => $siteName,
                    'url' => $homeUrl,
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => $base . 'assets/img/logo-1.png'
                    ]
                ]
            ];
            if ($published) {
                $article['datePublished'] = $published;
            }
            if ($modified) {
                $article['dateModified'] = $modified;
            }

            $schemas[] = self::article($article);
            $schemas[] = self::breadcrumb([
                ['name' => self::localized('Home', 'الرئيسية'), 'url' => $homeUrl],
                ['name' => self::localized('News', 'الأخبار'), 'url' => $base . 'news-list/1'],
                ['name' => $title, 'url' => $currentUrl]
            ]);

            $faqRows = [];
            if (function_exists('selectDB')) {
                $faqRows = selectDB('faq', "`id` != '0' AND `status` = '0' ORDER BY `rank` ASC LIMIT 5");
            }
            $faqQuestions = [];
            if ($faqRows) {
                foreach ($faqRows as $row) {
                    $faqQuestions[] = [
                        'question' => self::localized($row['enQuestion'] ?? '', $row['arQuestion'] ?? ''),
                        'answer' => self::localized($row['enAnswer'] ?? '', $row['arAnswer'] ?? '')
                    ];
                }
            }
            if ($faqQuestions) {
                $schemas[] = self::faq($faqQuestions);
            }
        }

        if ($view === 'Search') {
            $items = [];
            $ads = !empty($context['ads']) && is_array($context['ads']) ? $context['ads'] : [];
            foreach ($ads as $i => $ad) {
                $title = self::localized($ad['enTitle'] ?? '', $ad['arTitle'] ?? '');
                $items[] = [
                    '@type' => 'ListItem',
                    'position' => $i + 1,
                    'name' => $title,
                    'url' => $base . 'ad-view/' . ($ad['id'] ?? '') . '/' . (function_exists('slug') ? slug($title) : '')
                ];
            }
            $categoryTitle = self::clean($context['categoryTitle'] ?? self::localized('Search Results', 'نتائج البحث'));
            $schemas[] = self::collection($items, [
                'name' => $categoryTitle,
                'url' => $currentUrl
            ]);
            $schemas[] = self::breadcrumb([
                ['name' => self::localized('Home', 'الرئيسية'), 'url' => $homeUrl],
                ['name' => $categoryTitle, 'url' => $currentUrl]
            ]);
        }

        if ($view === 'OfficeView' && !empty($context['offices'][0])) {
            $office = $context['offices'][0];
            $agent = [
                '@id' => $currentUrl . '#agent',
                'name' => self::localized($office['enTitle'] ?? '', $office['arTitle'] ?? ''),
                'url' => $currentUrl,
                'description' => self::localized($office['enDetails'] ?? '', $office['arDetails'] ?? ''),
                'image' => !empty($office['logo']) ? $base . 'logos/' . $office['logo'] : $base . 'assets/img/logo-1.png',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressCountry' => 'KW'
                ]
            ];
            if (!empty($office['mobile'])) {
                $agent['telephone'] = $office['mobile'];
            }
            if (!empty($office['email'])) {
                $agent['email'] = $office['email'];
            }
            if (!empty($office['url'])) {
                $agent['sameAs'] = [$office['url']];
            }
            $schemas[] = self::agent($agent);
        }

        if ($view === 'Offices') {
            $items = [];
            $offices = !empty($context['offices']) && is_array($context['offices']) ? $context['offices'] : [];
            foreach ($offices as $i => $office) {
                $name = self::localized($office['enTitle'] ?? '', $office['arTitle'] ?? '');
                $items[] = [
                    '@type' => 'ListItem',
                    'position' => $i + 1,
                    'name' => $name,
                    'url' => $base . 'office-view/' . ($office['id'] ?? '') . '/' . (function_exists('slug') ? slug($name) : '')
                ];
            }
            $schemas[] = self::collection($items, [
                'name' => self::localized('Real Estate Offices in Kuwait', 'المكاتب العقارية في الكويت'),
                'url' => $currentUrl
            ]);
        }

        if ($view === 'FAQ') {
            $faqRows = !empty($context['faq']) && is_array($context['faq']) ? $context['faq'] : [];
            if (!$faqRows && function_exists('selectDB')) {
                $faqRows = selectDB('faq', "`id` != '0' AND `status` = '0' ORDER BY `rank` ASC");
            }
            $questions = [];
            foreach ($faqRows as $row) {
                $questions[] = [
                    'question' => self::localized($row['enQuestion'] ?? '', $row['arQuestion'] ?? ''),
                    'answer' => self::localized($row['enAnswer'] ?? '', $row['arAnswer'] ?? '')
                ];
            }
            if ($questions) {
                $schemas[] = self::faq($questions);
            }
        }

        self::render($schemas);
    }
}
