<?php


class RecommenderService{

    const host = 'apac-recommendations.unbxdapi.com';
    const baseUrl = 'http://apac-recommendations.unbxdapi.com/v1.0/';

    private static function getResponse($url){

        $response = file_get_contents($url);

        if(isset($response))
            return json_decode($response);

        return NULL;

    }

    public static function getRecommendationsForYou($siteName,$apiKey,$uid,$ip){
        $url = self::baseUrl.$apiKey.'/'.$siteName.'/recommend/'.$uid.'/?format=json';
        if(!empty($ip)){
            $url.='&ip='.$ip;
        }

        return self::getResponse($url);

    }

    public static function getRecentlyViewed($siteName,$apiKey,$uid){
        $url = self::baseUrl.$apiKey.'/'.$siteName.'/recently-viewed/'.$uid.'/?format=json';
        return self::getResponse($url);
    }

    public static function getMoreLikeThese($siteName, $apiKey, $pid, $uid, $ip){
        $url = self::baseUrl.$apiKey.'/'.$siteName.'/more-like-these/'.$pid.'/?format=json';
        if(!empty($ip)){
            $url.='&ip='.$ip;

        }
        if(!empty($uid)){
            $url.='&uid='.$uid;

        }
        return self::getResponse($url);
    }

    public static function getAlsoViewed($siteName, $apiKey, $pid, $uid, $ip){
        $url = self::baseUrl.$apiKey.'/'.$siteName.'/also-viewed/'.$pid.'/?format=json';
        if(!empty($ip)){
            $url.='&ip='.$ip;
        }
        if(!empty($uid)){
            $url.='&uid='.$uid;
        }
        return self::getResponse($url);
    }

    public static function getAlsoBought($siteName, $apiKey, $pid, $uid, $ip){
        $url = self::baseUrl.$apiKey.'/'.$siteName.'/also-bought/'.$pid.'/?format=json';
        if(!empty($ip)){
            $url.='&ip='.$ip;
        }
        if(!empty($uid)){
            $url.='&uid='.$uid;
        }
        return self::getResponse($url);
    }

    public static function getTopSellers($siteName, $apiKey, $uid, $ip){
        $url = self::baseUrl.$apiKey.'/'.$siteName.'/top-sellers/?format=json';
        if(!empty($ip)){
            $url.='&ip='.$ip;
        }
        if(!empty($uid)){
            $url.='&uid='.$uid;
        }
        return self::getResponse($url);
    }

    public static function getCategoryTopSellers($siteName, $apiKey, $categoryId, $uid, $ip){
        $url = self::baseUrl.$apiKey.'/'.$siteName.'/category-top-sellers/'.$categoryId.'/?format=json';
        if(!empty($ip)){
            $url.='&ip='.$ip;
        }
        if(!empty($uid)){
            $url.='&uid='.$uid;
        }
        return self::getResponse($url);
    }

    public static function getBrandTopSellers($siteName, $apiKey, $brandId, $uid, $ip){
        $url = self::baseUrl.$apiKey.'/'.$siteName.'/brand-top-sellers/'.$brandId.'/?format=json';
        if(!empty($ip)){
            $url.='&ip='.$ip;
        }
        if(!empty($uid)){
            $url.='&uid='.$uid;
        }
        return self::getResponse($url);
    }

    public static function getPDPTopSellers($siteName, $apiKey, $pid, $uid, $ip){
        $url = self::baseUrl.$apiKey.'/'.$siteName.'/pdp-top-sellers/'.$pid.'/?format=json';
        if(!empty($ip)){
            $url.='&ip='.$ip;
        }
        if(!empty($uid)){
            $url.='&uid='.$uid;
        }
        return self::getResponse($url);
    }

    public static function getCartRecommendations($siteName, $apiKey, $uid, $ip){
        $url = self::baseUrl.$apiKey.'/'.$siteName.'/cart-recommend/'.$uid.'/?format=json';
        if(!empty($ip)){
            $url.='&ip='.$ip;
        }
        return self::getResponse($url);


    }

}