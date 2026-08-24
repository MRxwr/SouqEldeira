<?php
class SchemaBuilder {
    public static function organization($name, $url) {
        return [
            '@type'=>'Organization',
            'name'=>$name,
            'url'=>$url
        ];
    }

    public static function website($name, $url, $searchUrl) {
        return [
            '@type'=>'WebSite',
            'name'=>$name,
            'url'=>$url,
            'potentialAction'=>[
                '@type'=>'SearchAction',
                'target'=>$searchUrl.'{search_term_string}',
                'query-input'=>'required name=search_term_string'
            ]
        ];
    }

    public static function breadcrumb($items) {
        $list=[];
        foreach($items as $key=>$item){
            $list[]=[
                '@type'=>'ListItem',
                'position'=>$key+1,
                'name'=>$item['name'],
                'item'=>$item['url'] ?? null
            ];
        }
        return [
            '@type'=>'BreadcrumbList',
            'itemListElement'=>$list
        ];
    }

    public static function realEstateListing($data) {
        return array_merge([
            '@type'=>'RealEstateListing'
        ],$data);
    }

    public static function offer($data) {
        return array_merge(['@type'=>'Offer'],$data);
    }

    public static function demand($data) {
        return array_merge(['@type'=>'Demand'],$data);
    }

    public static function article($data) {
        return array_merge(['@type'=>'NewsArticle'],$data);
    }

    public static function faq($questions) {
        $items=[];
        foreach($questions as $q){
            $items[]=[
                '@type'=>'Question',
                'name'=>$q['question'],
                'acceptedAnswer'=>[
                    '@type'=>'Answer',
                    'text'=>$q['answer']
                ]
            ];
        }
        return [
            '@type'=>'FAQPage',
            'mainEntity'=>$items
        ];
    }

    public static function collection($items) {
        return [
            '@type'=>'CollectionPage',
            'mainEntity'=>[
                '@type'=>'ItemList',
                'itemListElement'=>$items
            ]
        ];
    }

    public static function agent($data) {
        return array_merge(['@type'=>'RealEstateAgent'],$data);
    }

    public static function render($schemas) {
        echo '<script type="application/ld+json">'.json_encode([
            '@context'=>'https://schema.org',
            '@graph'=>$schemas
        ],JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES).'</script>';
    }
}
