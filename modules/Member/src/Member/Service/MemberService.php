<?php

namespace Member\Service;

use Member\Controller\MemberController;

class MemberService
{
	/**
	 * @return array
	 */
	public static function getDownloadedProductsByUserId($userId) 
	{
		$downloadedProducts = [];
		$downloadedIds = get_user_meta($userId, MemberController::DOWNLOADED_PRODUCTS, true);
		foreach ($downloadedIds as $productId) {
			$downloadedProducts[] = \wc_get_product($productId);
		}
		return $downloadedProducts;
	}	
}