storage = $.localStorage;
//storage = $.sessionStorage;

var CWMCommon = {
	SHA1 : function(data) {
		return CryptoJS.SHA1(data);
	},
	GetUid : function()
	{
		return storage.get('uid');
	},
	GetUidHashHex : function(data) {
		var uidHash = CryptoJS.SHA1(data);
        var uidHashHex   = CryptoJS.enc.Hex.stringify(uidHash);
        return uidHashHex;
	},
	GetPasswordHashHex : function(password) {
		var hash = CryptoJS.SHA1(password);
      	var hashHex   = CryptoJS.enc.Hex.stringify(hash);
      	return hashHex;
	},
	GetIsLoggedIn : function(onSuccess, onFailure) {
		if(storage.get('uid') !== null) {
			if(onSuccess !== null)
				onSuccess();
		}
		else {
			if(onFailure !== null)
				onFailure();
		}
		return storage.get('uid');
	},
	SignIn : function(data) { // data: uid, email, isNew
		storage.set('uid', data['uid']);//CWMCommon.GetUidHashHex(data));
        storage.set('email', data['email']);
        storage.set('isFirstTime', data['isFirstTime']);
	},
	SignOut : function(redirectUrl) {
		storage.remove('uid');
		storage.remove('email');
        storage.remove('isFirstTime');
		window.location = redirectUrl;
	}
}