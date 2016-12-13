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

    log('starting');

    function getPage() {
        return require('webpage').create();
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

        page.paperSize = getPaperSize();
        page.viewportSize = getViewportSize();

        log(_viewportSize);

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
        setDocuments: setDocuments,
        getNextDocument: getNextDocument,
        setPaperSize: setPaperSize,
        setViewportSize: setViewportSize,
        addDocument: addDocument,
        print: print
    }
}


var phantomjs = phantomjs();
