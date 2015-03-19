(function($, win, doc) {

    var _getCaretInfo = function(element){
        var res = {
            text: '',
            start: 0,
            end: 0
        };

        if (!element.value) {
            /* å€¤ãŒãªã„ã€ã‚‚ã—ãã¯ç©ºæ–‡å­—åˆ— */
            return res;
        }

        try {
            if (win.getSelection) {
                /* IE ä»¥å¤– */
                res.start = element.selectionStart;
                res.end = element.selectionEnd;
                res.text = element.value.slice(res.start, res.end);
            } else if (doc.selection) {
                /* for IE */
                element.focus();

                var range = doc.selection.createRange(),
                    range2 = doc.body.createTextRange(),
                    tmpLength;

                res.text = range.text;

                try {
                    range2.moveToElementText(element);
                    range2.setEndPoint('StartToStart', range);
                } catch (e) {
                    range2 = element.createTextRange();
                    range2.setEndPoint('StartToStart', range);
                }

                res.start = element.value.length - range2.text.length;
                res.end = res.start + range.text.length;
            }
        } catch (e) {
            /* ã‚ãã‚‰ã‚ã‚‹ */
        }

        return res;
    };

    /**
     * è¦ç´ ã«å¯¾ã™ã‚‹ã‚­ãƒ£ãƒ¬ãƒƒãƒˆæ“ä½œ
     * @type {Object}
     */
    var _CaretOperation = {
     
        getPos: function(element) {
            var tmp = _getCaretInfo(element);
            return {start: tmp.start, end: tmp.end};
        },

       
        setPos: function(element, toRange, caret) {
            caret = this._caretMode(caret);

            if (caret == 'start') {
                toRange.end = toRange.start;
            } else if (caret == 'end') {
                toRange.start = toRange.end;
            }

            element.focus();
            try {
                if (element.createTextRange) {
                    var range = element.createTextRange();

                    if (win.navigator.userAgent.toLowerCase().indexOf("msie") >= 0) {
                        toRange.start = element.value.substr(0, toRange.start).replace(/\r/g, '').length;
                        toRange.end = element.value.substr(0, toRange.end).replace(/\r/g, '').length;
                    }

                    range.collapse(true);
                    range.moveStart('character', toRange.start);
                    range.moveEnd('character', toRange.end - toRange.start);

                    range.select();
                } else if (element.setSelectionRange) {
                    element.setSelectionRange(toRange.start, toRange.end);
                }
            } catch (e) {
                /* ã‚ãã‚‰ã‚ã‚‹ */
            }
        },

       
        getText: function(element) {
            return _getCaretInfo(element).text;
        },

     
        _caretMode: function(caret) {
            caret = caret || "keep";
            if (caret == false) {
                caret = 'end';
            }

            switch (caret) {
                case 'keep':
                case 'start':
                case 'end':
                    break;

                default:
                    caret = 'keep';
            }

            return caret;
        },

       
        replace: function(element, text, caret) {
            var tmp = _getCaretInfo(element),
                orig = element.value,
                pos = $(element).scrollTop(),
                range = {start: tmp.start, end: tmp.start + text.length};

            element.value = orig.substr(0, tmp.start) + text + orig.substr(tmp.end);

            $(element).scrollTop(pos);
            this.setPos(element, range, caret);
        },

       
        insertBefore: function(element, text, caret) {
            var tmp = _getCaretInfo(element),
                orig = element.value,
                pos = $(element).scrollTop(),
                range = {start: tmp.start + text.length, end: tmp.end + text.length};

            element.value = orig.substr(0, tmp.start) + text + orig.substr(tmp.start);

            $(element).scrollTop(pos);
            this.setPos(element, range, caret);
        },

        insertAfter: function(element, text, caret) {
            var tmp = _getCaretInfo(element),
                orig = element.value,
                pos = $(element).scrollTop(),
                range = {start: tmp.start, end: tmp.end};

            element.value = orig.substr(0, tmp.end) + text + orig.substr(tmp.end);

            $(element).scrollTop(pos);
            this.setPos(element, range, caret);
        }
    };

    /* jQuery.selection ã‚’è¿½åŠ  */
    $.extend({
      
        selection: function(mode) {
            var getText = ((mode || 'text').toLowerCase() == 'text');

            try {
                if (win.getSelection) {
                    if (getText) {
                        // get text
                        return win.getSelection().toString();
                    } else {
                        // get html
                        var sel = win.getSelection(), range;

                        if (sel.getRangeAt) {
                            range = sel.getRangeAt(0);
                        } else {
                            range = doc.createRange();
                            range.setStart(sel.anchorNode, sel.anchorOffset);
                            range.setEnd(sel.focusNode, sel.focusOffset);
                        }

                        return $('<div></div>').append(range.cloneContents()).html();
                    }
                } else if (doc.selection) {
                    if (getText) {
                        // get text
                        return doc.selection.createRange().text;
                    } else {
                        // get html
                        return doc.selection.createRange().htmlText;
                    }
                }
            } catch (e) {
                /* ã‚ãã‚‰ã‚ã‚‹ */
            }

            return '';
        }
    });

    /* selection ã‚’è¿½åŠ  */
    $.fn.extend({
        selection: function(mode, opts) {
            opts = opts || {};

            switch (mode) {
               
                case 'getPos':
                    return _CaretOperation.getPos(this[0]);
                    break;

             
                case 'setPos':
                    return this.each(function() {
                        _CaretOperation.setPos(this, opts);
                    });
                    break;

               
                case 'replace':
                    return this.each(function() {
                        _CaretOperation.replace(this, opts.text, opts.caret);
                    });
                    break;

              
                case 'insert':
                    return this.each(function() {
                        if (opts.mode == 'before') {
                            _CaretOperation.insertBefore(this, opts.text, opts.caret);
                        } else {
                            _CaretOperation.insertAfter(this, opts.text, opts.caret);
                        }
                    });

                    break;
s
                case 'get':
                default:
                    return _CaretOperation.getText(this[0]);
                    break;
            }

            return this;
        }
    });
})(jQuery, window, window.document);

