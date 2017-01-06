/* Helper functions */
// Vanila JS only

// Storage Functionality
var storageData = {
    // Saves data in a cookie and localStorage
    storageName: "user_data",  // cookie/key name to store data
    cookie: { // if set to false instead of object will not use cookie
      expiry: 63072000000, // 1000ms*60sec*60min*24hr*365d*2y = Cookie will be stored for 2 years
      topDomain: true // will save cookie at the top level i.e will save cookie at .domain.com for sub.domain.com
    }
};
// Function that saves data in a cookie
function setCookie(data) {
    var expiry = new Date(new Date().getTime() + storageData.cookie.expiry);
    var hostname = document.location.hostname;
    if (storageData.cookie.topDomain === true) {
        hostname = hostname.split(".").slice(-1 * 2).join(".");
    }
    document.cookie = storageData.storageName + '=' + data + ';domain=' + hostname + '; path=/; expires=' + expiry.toGMTString() + ';';
}
// Function that returns cookie data or null if cookie is not found
function readCookie() {
    var cookieName = encodeURIComponent(storageData.storageName) + '=';
    var cookieStart = document.cookie.indexOf(cookieName);
    var cookieValue = null;
    if (cookieStart > -1) {
        var cookieEnd = document.cookie.indexOf(';', cookieStart);
        if (cookieEnd === -1) {
            cookieEnd = document.cookie.length;
        }
        cookieValue = decodeURIComponent(document.cookie.substring(cookieStart + cookieName.length, cookieEnd));
    }
    return cookieValue;
}
// Function that detects whether localStorage is both supported and available
function storageAvailable(type) {
    try {
        var storage = window[type];
        var x = '__storage_test__';
        storage.setItem(x, x);
        storage.removeItem(x);
        return true;
    } catch(e) { return false; }
}
// Function that returns local storage data
function readLocalStorage(){
    var data = null;
    if (typeof localStorage !== "undefined" && storageAvailable('localStorage')) {
        // localStorage is allowed
        data = localStorage.getItem(storageData.storageName);
    }
    return data;
}
// Function that sets local storage data
function setLocalStorage(data){
    if (typeof localStorage !== "undefined" && storageAvailable('localStorage')) {
        // localStorage is allowed
        localStorage.setItem(storageData.storageName, data);
        return true; // success
    }
    return null; // error
}
// Returns compound data from both cookie and localStorage
function getStorageData() {
    var cookeData = readCookie();
    var storageData = readLocalStorage();
    var data = null;
    var tempStorage = null;
    if( storageData !== null ){
        // data is in data storage
        data = JSON.parse(storageData);
        if ( cookeData !== null ){
            // data in cookie as well, check for discrepiancies and return combined
            tempStorage = JSON.parse(cookeData);
            Object.keys(tempStorage).forEach(function(key){
                if (tempStorage.hasOwnProperty(key)) {
                    if (data[key] === undefined) {
                        data[key] = tempStorage[key];
                    }
                }
            });
        }
    }else if ( cookeData !== null ) {
        // data is only in cookie
        data = JSON.parse(cookeData);
    }
    // no data in storage or cookie
    return data;
}
// Updates one object with another
// To use run updateObject(objectToBeUpdated, objectWithUpdateData)
function updateObject(obj, newObj) {
	Object.keys(newObj).forEach(function(key){
		var item = newObj[key];
		if (typeof item == "object" && obj[key]!==undefined){
			updateObject(obj[key], item);
		}else{
			obj[key] = item;
		}
	});
    return obj;
}
// Saves data in the storage, can be the whole data set or a specific item
function setStorageData(data) {
    var currentStorage = getStorageData();
    var noError = true;
    if (currentStorage !== null){
        // There is data in storage - update exisiting data with new values
        data = updateObject(currentStorage, data);
    }
    data = JSON.stringify(data);
    // Try to save data and return "Success" message if successful
    if(setLocalStorage(data) === null){ noError = "Can't save to localStorage";}
    if(storageData.cookie !== false){
        setCookie(data);
        if(readCookie() === null){
            if(noError !== true){
                noError = "Can't save to both cookie and localStorage";
            }
        }
    }
    if(noError === true){
        return "Success";
    }else{
        return noError; //return error message
    }
}

// Return shade of white or blcak based on what background color is being passed to function
function getContrastYIQ(hexcolor, type){
    if(!hexcolor){
        hexcolor = "#000000";
    }
    hexcolor = hexcolor.replace('#','');
	var r = parseInt(hexcolor.substr(0,2),16);
	var g = parseInt(hexcolor.substr(2,2),16);
	var b = parseInt(hexcolor.substr(4,2),16);
	var yiq = ((r*299)+(g*587)+(b*114))/1000; // 51,51, 153
    switch (type) {
        case "projectH":
            return (yiq >= 128) ? '#222' : '#FFF';
            break;
        case "projectB":
            return (yiq >= 128) ? '#222' : '#FFF';
            break;
        default:
            return (yiq >= 128) ? 'white' : 'black';
    }
}

// Adds getParameterByName(parameterName) function that can be called on any string to return
// value of url parameter called parameterName
if(!String.prototype.getParameterByName){
    String.prototype.getParameterByName = function (parameterName) {
        var regex = new RegExp("[?&]" + parameterName.replace(/[\[\]]/ig, "\\$&") + "(=([^&#]*)|&|#|$)");
        var results = regex.exec(this);
        if (!results) return null;
        if (!results[2]) return null;
        return decodeURIComponent(results[2].replace(/\+/ig, " "));
    }
}

if(!String.prototype.toHHMM){
    String.prototype.toHHMM = function (separator) {
        var sec_num = parseInt(this, 10); // don't forget the second param
        var hours   = Math.floor(sec_num / 3600);
        var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
        if (hours   < 10) {hours   = "0"+hours;}
        if (minutes < 10) {minutes = "0"+minutes;}
        return hours+separator+minutes;
    }
}

// Speed up calls to hasOwnProperty
var hasOwnProperty = Object.prototype.hasOwnProperty;

function isEmpty(obj) {

    // null and undefined are "empty"
    if (obj == null) return true;

    // Assume if it has a length property with a non-zero value
    // that that property is correct.
    if (obj.length > 0)    return false;
    if (obj.length === 0)  return true;

    // If it isn't an object at this point
    // it is empty, but it can't be anything *but* empty
    // Is it empty?  Depends on your application.
    if (typeof obj !== "object") return true;

    // Otherwise, does it have any properties of its own?
    // Note that this doesn't handle
    // toString and valueOf enumeration bugs in IE < 9
    for (var key in obj) {
        if (hasOwnProperty.call(obj, key)) return false;
    }

    return true;
}
