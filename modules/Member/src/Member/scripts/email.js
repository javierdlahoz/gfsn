window.campaignId = '14740912';

function subscribeUser(user){
	var campaignId = window.campaignId;
	var response = _dcq.push(["identify", {
		email: user.email,
		first_name: user.first_name,
		last_name: user.last_name,
		tags: ["Customer"]
	}]);
	_dcq.push(["subscribe", { campaign_id: campaignId, fields: { email: user.email }}]);
}