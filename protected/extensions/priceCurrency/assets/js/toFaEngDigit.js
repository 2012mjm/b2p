/*
 * English digit to persian
 * Copyright(C) 2009 by Amin Akbari [ http://eAmin.me ]
 * Licensed under the MIT Style License [http://www.opensource.org/licenses/mit-license.php]
 *
 */

String.prototype.toFaDigit = function() {
    return this.replace(/\d+/g, function(digit) {
        var ret = '';
        for (var i = 0, len = digit.length; i < len; i++) {
            ret += String.fromCharCode(digit.charCodeAt(i) + 1728);
        }
 
        return ret;
    });
};

String.prototype.toEnDigit = function() {
    return this.replace(/[\u06F0-\u06F9]+/g, function(digit) {
        var ret = '';
        for (var i = 0, len = digit.length; i < len; i++) {
            ret += String.fromCharCode(digit.charCodeAt(i) - 1728);
        }
 
        return ret;
    });
};