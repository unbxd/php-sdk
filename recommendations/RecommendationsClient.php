<?php
/**
 * Client to call recommendations APIs.
 * Response is a map in the following format :
 * Success :
 * {
     "count": 1,
     "boxType": "CART_RECOMMEND",
     "Recommendations": [
         {
            "uniqueId": 3106,
            "title": "Slim Fit Flat Front Trousers",
            "brand": "Louis Philippe",
            "category": "Trousers & Chinos",
            "price": 1899
         }
     ]
   }
 *
 * Error :
 * {
     "count": 0,
     "error": {
        "code": 3005,
        "message": "Product Id not found"
     }
   }
 */

require_once('RecommenderService.php');

class RecommendationsClient{


    /**
     * Site Name
     */
    private $siteName;

    /**
     * Secret API KEY
     */
    private $apiKey;

    public function __construct($siteName, $apiKey){
        $this->siteName = $siteName;
        $this->apiKey = $apiKey;
    }

    /**
     * Fetches Personalized recommendations for a user
     * @param uid value of the 'unbxd.userId' cookie
     * @param ip ip address of the user (optional)
     * @return
     */

    public function getRecommendationsForYou($uid,$ip=''){
        return RecommenderService::getRecommendationsForYou($this->siteName,$this->apiKey,$uid,$ip);
    }

    /**
     * Fetches Recently Viewed products for a user
     * @param uid value of the 'unbxd.userId' cookie
     * @return
     */

    public function getRecentlyViewedProducts($uid){
        return RecommenderService::getRecentlyViewed($this->siteName,$this->apiKey, $uid);
    }


    /**
     * Fetches products similar to the given product
     * @param pid 'uniqueId' of the product
     * @param uid value of the 'unbxd.userId' cookie (optional)
     * @param ip ip address of the user (optional)
     * @return
     */

    public function getMoreLikeThese($pid,$uid='',$ip=''){
        return RecommenderService::getMoreLikeThese($this->siteName,$this->apiKey,$pid,$uid,$ip);
    }


    /**
     * Fetches products that people viewed who also viewed the given product
     * @param pid 'uniqueId' of the product
     * @param uid value of the 'unbxd.userId' cookie (optional)
     * @param ip ip address of the user (optional)
     * @return
     */

    public function getAlsoViewed($pid,$uid='',$ip=''){
        return RecommenderService::getTopSellers($this->siteName,$this->apiKey,$uid,$ip);
    }

    /**
     * Fetches top sellers for the given category on the website
     * @param categoryId Category Id
     * @param uid value of the 'unbxd.userId' cookie (optional)
     * @param ip ip address of the user (optional)
     * @return
     */


    public function getCategoryTopSellers($categoryId,$uid='',$ip=''){
        return RecommenderService::getCategoryTopSellers($this->siteName,$this->apiKey,$categoryId,$uid,$ip);
    }


    /**
     * Fetches top sellers for the given brand on the website
     * @param brandId Brand Id
     * @param uid value of the 'unbxd.userId' cookie (optional)
     * @param ip ip address of the user (optional)
     * @return
     */


    public function getBrandTopSellers($brandId,$uid='',$ip=''){
        return RecommenderService::getBrandTopSellers($this->siteName,$this->apiKey,$brandId,$uid,$ip);
    }


    /**
     * Fetches top sellers to be shown on the product description page (PDP)
     * @param pid 'uniqueId' of the product
     * @param uid value of the 'unbxd.userId' cookie (optional)
     * @param ip ip address of the user (optional)
     * @return
     */

    public function getPDPTopSellers($pid,$uid='',$ip=''){
        return RecommenderService::getPDPTopSellers($this->siteName,$this->apiKey,$pid,$uid,$ip);
    }

    /**
     * Fetches recommendations based on the user's cart
     * @param uid value of the 'unbxd.userId' cookie
     * @param ip ip address of the user (optional)
     * @return
     */

    public function getCartRecommendations($uid,$ip=''){
        return RecommenderService::getCartRecommendations($this->siteName,$this->apiKey,$uid,$ip);
    }

}
