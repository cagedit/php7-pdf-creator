log('Begin script...');

function error(page)
{
    page.onResourceError = function(resourceError) {
        console.error(resourceError.url + ': ' + resourceError.errorString);
    };


    page.onLoadStarted = function() {
        var currentUrl = page.evaluate(function() {
            return window.location.href;
        });
        log(currentUrl);
    };

    page.onLoadFinished = function(status) {
        log('status' + status);
        log('E');
    };


    page.onError = function(msg, trace) {
        log('error' +  msg + trace);
    };

    page.onConsoleMessage = function(msg) {
        log(msg);
    };
}

function log(msg) {
    var fs = require('fs');

    var path = '/tmp/output.txt';

    msg = typeof msg === 'object' ? JSON.stringify(msg) : msg;

    fs.write(path, msg + "\n", 'a');
}

function phantomjs() {
    var _documents = [];
    var _paperSize;
    var _viewportSize;
    var _footer;

    log('starting');

    function getPage() {
        log('getting page');
        var page = require('webpage').create();

        error(page);

        return page;

    }

    function preparePage(page) {
        page.viewportSize = getViewportSize();

        var paperSize = getPaperSize();

        var footerContents = paperSize.footer.contents;
        log('footer content');
        log(footerContents);
        paperSize['footer']['contents'] = phantom.callback(function(pageNum, pageCount) {
            return footerContents.replace('pageNum', pageNum).replace('pageCount', pageCount);
        });

        page.paperSize = paperSize;

        return page;
    }

    function setPaperSize(paperSize) {
        _paperSize = paperSize;
        return this;
    }

    function getPaperSize() {
        return _paperSize;
    }

    function setViewportSize(viewportSize) {
        _viewportSize = viewportSize;
        return $this;
    }

    function getViewportSize() {
        return _viewportSize;
    }

    function setFooter(footer) {
        _footer = footer;
        return this;
    }

    function getFooter() {
        return _footer;
    }

    function setDocuments(documents) {
        _documents = documents;

        return this;
    }

    function addDocument(document) {
        log(document);
        _documents.push(document);
    }

    function getNextDocument() {

        return _documents.length ? _documents.pop() : false;
    }

    function print() {
        setTimeout(function() {
            printOne(getNextDocument())

        }, 100);
    }

    function printOne(file) {
        var page = getPage();

        page = preparePage(page);

        // page.paperSize = {
        //     width: '8.5in',
        //     height: '11in',
        //     footer: {
        //         height: "1cm",
        //         contents: phantom.callback(function(pageNum, numPages) {
        //             return "<h1>Footer <span style='float:right'>" + pageNum + " / " + numPages + "</span></h1>";
        //         })
        //     }
        // }


        page.onLoadFinished = function() {

            var nextDoc = getNextDocument()

            if (nextDoc) {
                printOne(nextDoc);
            } else {
                setTimeout(function() {
                    phantom.exit();
                }, 1000);
            }
        };


        log('opening file: ' + file);

        page.open(file, function start(status) {
            log('start fnc status: ' + status);
            page.render(file + '.pdf', {format: 'pdf', quality: '100'});
        });


    }

    return {
        getPage: getPage,
        setFooter: setFooter,
        getFooter: getFooter,
        setDocuments: setDocuments,
        getNextDocument: getNextDocument,
        setPaperSize: setPaperSize,
        setViewportSize: setViewportSize,
        addDocument: addDocument,
        print: print
    }
}


var phantomjs = phantomjs();
