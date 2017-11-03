window.campaignId = '14740912';

function getTagsForDrip(removeLocalStorage = false) {
    var tags = ['Customer'];
    var tag = localStorage.getItem('tag');

    if (tag) {
        tags = ['Customer', tag];
        if (removeLocalStorage) {
            localStorage.removeItem('tag');
        }
    }
    return tags;
}

function subscribeUser(user) {
    var campaignId = window.campaignId;
    var response = _dcq.push(["identify", {
        email: user.email,
        tags: getTagsForDrip(true)
    }]);
    _dcq.push(["subscribe", {campaign_id: campaignId, fields: {email: user.email}}]);
}

function updateSubscriberOnDrip(user) {
    var campaignId = window.campaignId;
    var response = _dcq.push(["identify", {
        email: user.email,
        first_name: user.first_name,
        last_name: user.last_name
    }]);
    _dcq.push(["subscribe", {campaign_id: campaignId, fields: {email: user.email}}]);   
}

function subscribeEmailToDrip(email) {
    var campaignId = window.campaignId;
    var response = _dcq.push(["identify", {
        email: email,
        tags: getTagsForDrip()
    }]);
    _dcq.push(["subscribe", {campaign_id: campaignId, fields: {email: email}}]);
}

function subscribeFreeShareRecipient(email) {
    _dcq.push(["identify", {
        email: email,
        tags: getTagsForDrip()
    }]);
    _dcq.push(["subscribe", {campaign_id: '391939991', fields: {email: email}}]);
}