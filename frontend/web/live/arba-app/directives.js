'use strict';

// Arba.Ae web application declaration
angular.module('arbaLiveApp')
    
/*********************************************
 *
 * Directive when repeat is done
 *
 ********************************************/
.directive('repeatDone', function() {
    return function(scope, element, attrs) {
        if (scope.$last) { // all are rendered
            scope.$eval(attrs.repeatDone);
        }
    }
})
    
/*********************************************
 *
 * Filter Allow HTML in view
 *
 ********************************************/
.filter('trustAsHtml', ['$sce', function($sce) {
    return $sce.trustAsHtml;
}])

/*********************************************
 *
 * Truncate HTML in view
 *
 ********************************************/
.filter('limitHtml', function() {
    return function(text, limit, ellipsis) {
        var _getClosedTagsString = function(_tagArray) {
            var _returnArray = [],
            _getTagType = function(_string) {
                return _string.replace(/<[\/]?([^>]*)>/,"$1");
            };

            angular.forEach(_tagArray,function(_tag,_i) {
                if(/<\//.test(_tag)) {
                    if(_i === 0) {
                        _returnArray.push(_tag);
                    } else if(_getTagType(_tag) !== _getTagType(_tagArray[_i - 1])) {
                        _returnArray.push(_tag);
                    }
                }
            });
            return _returnArray.join('');
        },
        _countNonHtmlCharToLimit = function(_text,_limit) {
            var _isMarkup = false,
            _isSpecialChar = false,
            _break = false,
            _underLimit = false,
            _totalText = 0,
            _totalChar = 0,
            _element,
            _return = {
                textCounter   : 0,
                offsetCounter : 0,
                setEllipsis   : false,
                overElementArray : []
            };
            angular.forEach(_text,function(_c) {
                _underLimit = _return.textCounter < _limit;
                if(_c === '<' && !_isMarkup && !_isSpecialChar) {
                    (!_underLimit) && (_element = '<');
                    _isMarkup = true;
                } else if(_c === '&' && !_isMarkup && !_isSpecialChar) {
                    _isSpecialChar = true;
                } else if(_isMarkup) {
                    //tracking html elements that are beyond the text limit
                    (!_underLimit) && (_element = _element + _c);
                    if(_c === '>') {
                        //push element in array if it is complete, and we are
                        //beyond text limit, to close any html that is unclosed
                        (!_underLimit) && (_return.overElementArray.push(_element));
                        _break = true;
                        _isMarkup = false;
                    }
                } else if(_c === ';' && _isSpecialChar) {
                    _isSpecialChar = false;
                    //count as one character
                    _return.textCounter++;
                    _break = true;
                }

                if(_underLimit) {
                    if(!_isMarkup && !_isSpecialChar && !_break) {
                        //counting number of characters in non html string
                        _return.textCounter++;
                    }
                    _return.offsetCounter++;
                } else {
                    _return.setEllipsis = true
                }
                _break = false;

            });

            //returns offset within html of number of non html characters found
            return _return;
        },
        _charToLimitOutput = _countNonHtmlCharToLimit(text.toString(),limit);
		
        return text.toString().substr(0, _charToLimitOutput.offsetCounter) +
            ellipsis + _getClosedTagsString(_charToLimitOutput.overElementArray);
    }
});