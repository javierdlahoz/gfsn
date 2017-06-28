angular.module('gfsn', []).factory('MemberService', MemberService);

function MemberService($http) {
	var baseUrl = '/wp-json/gfsn-api/membership';
	var contentType = {'Content-Type': 'application/x-www-form-urlencoded'};

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
        data: jQuery.param(user),
        headers: contentType
      }).then(function (response) {
      	return callback(response.data);
      });
		},

		login: function(credentials, callback) {
			$http({
        url: baseUrl + '/login',
        method: "POST",
        data: jQuery.param(credentials),
        headers: contentType
      }).then(function (response) {
        return callback(response.data);
      });
		},

		getFilesFromProduct: function(productId, callback) {
			$http({
        url: baseUrl + '/files?product_id=' + productId,
        method: "GET"
      }).then(function (response) {
        return callback(response.data);
      });
		},

		resendEmail: function(nonce, callback) {
			$http({
        url: baseUrl + '/resend-email?_wpnonce=' + nonce,
        method: "GET"
      }).then(function (response) {
        return callback(response.data);
      });
		}
	}
}