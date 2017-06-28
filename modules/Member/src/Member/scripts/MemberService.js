angular.module('gfsn', []).factory('MemberService', MemberService);

function MemberService($http) {
	return {
		test: function() {
			console.log('this is a test');
		}
	}
}