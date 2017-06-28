angular.module('gfsn', []).factory('MemberService', MemberService);

function MemberService($http) {
	var baseUrl = '/wp-json/gfsn-api/membership';
	return {
		
		isLoggedIn: function(nonce, callback) {
			$http({
        url: baseUrl + '/logged-in?_wpnonce=' + nonce,
        method: "GET"
      }).then(function (response) {
        return callback(response.data);
      });
		},

		createUser: function(user, callback) {
			$http({
        url: baseUrl,
        method: "POST",
        data: angular.element.param(user),
        headers: getContentTypes().form
      }).then(function (response) {
        return callBack(response.data);
      });
		},

		login: function(credentials, callback) {
			$http({
        url: baseUrl + '/login',
        method: "POST",
        data: angular.element.param(credentials),
        headers: getContentTypes().form
      }).then(function (response) {
        return callBack(response.data);
      });
		},

		getFilesFromProduct: function(productId, callback) {
			$http({
        url: baseUrl + '/files?product_id=' + productId,
        method: "GET"
      }).then(function (response) {
        return callback(response.data);
      });
		}
	}
}